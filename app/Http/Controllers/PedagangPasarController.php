<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MarketOrder;
use App\Models\Project;
use App\Models\ChatMessage;
use App\Models\User;

class PedagangPasarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:pedagang_pasar');
    }

    public function dashboard()
    {
        $user = auth()->user();
        
        // Get orders made by this user
        $orders = $user->marketOrders()->with('project')->latest()->take(10)->get();
        
        // Get pending orders
        $pendingOrders = $user->marketOrders()->where('status', 'pending')->count();
        
        // Get confirmed orders
        $confirmedOrders = $user->marketOrders()->where('status', 'confirmed')->count();
        
        // Get ready orders
        $readyOrders = $user->marketOrders()->where('status', 'ready')->count();
        
        // Get delivered orders
        $deliveredOrders = $user->marketOrders()->where('status', 'delivered')->count();
        
        // Get unread messages
        $unreadMessages = $user->receivedMessages()->where('is_read', false)->count();
        
        return view('pedagang.dashboard', compact('orders', 'pendingOrders', 'confirmedOrders', 'readyOrders', 'deliveredOrders', 'unreadMessages'));
    }

    public function orders()
    {
        $user = auth()->user();
        $orders = $user->marketOrders()->with('project')->latest()->paginate(15);
        
        return view('pedagang.orders', compact('orders'));
    }

    public function createOrder()
    {
        $projects = Project::where('status', 'active')->get();
        return view('pedagang.create-order', compact('projects'));
    }

    public function storeOrder(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'product_name' => 'required|string',
            'description' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'unit' => 'required|string',
            'price_per_unit' => 'required|numeric|min:0',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();
        $data['total_price'] = $data['quantity'] * $data['price_per_unit'];

        MarketOrder::create($data);

        return redirect()->route('pedagang.orders')->with('success', 'Pesanan pasar berhasil dibuat!');
    }

    public function confirmReceived(Request $request, MarketOrder $order)
    {
        $request->validate([
            'feedback' => 'nullable|string',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);

        $order->update([
            'status' => 'received',
            'received_at' => now(),
            'feedback' => $request->feedback,
            'rating' => $request->rating,
        ]);

        return back()->with('success', 'Pesanan berhasil dikonfirmasi diterima!');
    }

    public function chat()
    {
        $user = auth()->user();
        
        // Get users that pedagang pasar can chat with (manajer, logistik)
        $chatUsers = User::whereIn('role', ['manajer_lapangan', 'logistik'])
            ->where('id', '!=', $user->id)
            ->get();
        
        // Get recent conversations
        $conversations = $user->sentMessages()
            ->orWhere('receiver_id', $user->id)
            ->with(['sender', 'receiver'])
            ->latest()
            ->get()
            ->groupBy(function($message) use ($user) {
                return $message->sender_id == $user->id ? $message->receiver_id : $message->sender_id;
            });
        
        return view('pedagang.chat', compact('chatUsers', 'conversations'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
            'project_id' => 'nullable|exists:projects,id',
        ]);

        ChatMessage::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'project_id' => $request->project_id,
            'message' => $request->message,
            'message_type' => 'text',
        ]);

        return back()->with('success', 'Pesan berhasil dikirim!');
    }
}
