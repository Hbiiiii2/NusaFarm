<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FertilizerOrder;
use App\Models\Project;
use App\Models\ChatMessage;
use App\Models\User;

class PenyediaPupukController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:penyedia_pupuk');
    }

    public function dashboard()
    {
        $user = auth()->user();
        
        // Get orders handled by this user
        $orders = $user->fertilizerOrders()->with('project')->latest()->take(10)->get();
        
        // Get pending orders
        $pendingOrders = $user->fertilizerOrders()->where('status', 'pending')->count();
        
        // Get processed orders
        $processedOrders = $user->fertilizerOrders()->where('status', 'processed')->count();
        
        // Get ready orders
        $readyOrders = $user->fertilizerOrders()->where('status', 'ready')->count();
        
        // Get delivered orders
        $deliveredOrders = $user->fertilizerOrders()->where('status', 'delivered')->count();
        
        // Get unread messages
        $unreadMessages = $user->receivedMessages()->where('is_read', false)->count();
        
        return view('pupuk.dashboard', compact('orders', 'pendingOrders', 'processedOrders', 'readyOrders', 'deliveredOrders', 'unreadMessages'));
    }

    public function orders()
    {
        $user = auth()->user();
        $orders = $user->fertilizerOrders()->with('project')->latest()->paginate(15);
        
        return view('pupuk.orders', compact('orders'));
    }

    public function createOrder()
    {
        $projects = Project::where('status', 'active')->get();
        return view('pupuk.create-order', compact('projects'));
    }

    public function storeOrder(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'fertilizer_name' => 'required|string',
            'description' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'unit' => 'required|string',
            'price_per_unit' => 'required|numeric|min:0',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();
        $data['total_price'] = $data['quantity'] * $data['price_per_unit'];

        FertilizerOrder::create($data);

        return redirect()->route('pupuk.orders')->with('success', 'Pesanan pupuk berhasil dibuat!');
    }

    public function updateOrderStatus(Request $request, FertilizerOrder $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processed,ready,shipped,delivered',
        ]);

        $status = $request->status;
        $updateData = ['status' => $status];

        // Update timestamps based on status
        switch ($status) {
            case 'processed':
                $updateData['processed_at'] = now();
                break;
            case 'ready':
                $updateData['ready_at'] = now();
                break;
            case 'shipped':
                $updateData['shipped_at'] = now();
                break;
            case 'delivered':
                $updateData['delivered_at'] = now();
                break;
        }

        $order->update($updateData);

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }

    public function chat()
    {
        $user = auth()->user();
        
        // Get users that penyedia pupuk can chat with (petani, manajer, logistik)
        $chatUsers = User::whereIn('role', ['petani', 'manajer_lapangan', 'logistik'])
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
        
        return view('pupuk.chat', compact('chatUsers', 'conversations'));
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
