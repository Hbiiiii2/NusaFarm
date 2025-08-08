<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Logistic;
use App\Models\Project;
use App\Models\ChatMessage;
use App\Models\User;

class LogistikController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:logistik');
    }

    public function dashboard()
    {
        $user = auth()->user();
        
        // Get deliveries handled by this user
        $deliveries = $user->handledLogistics()->with('project')->latest()->take(10)->get();
        
        // Get pending deliveries
        $pendingDeliveries = $user->handledLogistics()->where('status', 'pending')->with('project')->count();
        
        // Get in-transit deliveries
        $inTransitDeliveries = $user->handledLogistics()->where('status', 'in_transit')->with('project')->count();
        
        // Get delivered count
        $deliveredCount = $user->handledLogistics()->where('status', 'delivered')->count();
        
        // Get unread messages
        $unreadMessages = $user->receivedMessages()->where('is_read', false)->count();
        
        return view('logistik.dashboard', compact('deliveries', 'pendingDeliveries', 'inTransitDeliveries', 'deliveredCount', 'unreadMessages'));
    }

    public function deliveries()
    {
        $user = auth()->user();
        $deliveries = $user->handledLogistics()->with('project')->latest()->paginate(15);
        
        return view('logistik.deliveries', compact('deliveries'));
    }

    public function createDelivery()
    {
        $projects = Project::where('status', 'active')->get();
        return view('logistik.create-delivery', compact('projects'));
    }

    public function storeDelivery(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'delivery_type' => 'required|string',
            'delivery_date' => 'required|date|after_or_equal:today',
        ]);

        $data = $request->all();
        $data['logistics_user_id'] = auth()->id();

        Logistic::create($data);

        return redirect()->route('logistik.deliveries')->with('success', 'Pengiriman berhasil dibuat!');
    }

    public function updateDeliveryStatus(Request $request, Logistic $logistic)
    {
        $request->validate([
            'status' => 'required|in:pending,in_transit,delivered',
        ]);

        $logistic->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status pengiriman berhasil diperbarui!');
    }

    public function chat()
    {
        $user = auth()->user();
        
        // Get users that logistik can chat with (petani, manajer, penyedia pupuk)
        $chatUsers = User::whereIn('role', ['petani', 'manajer_lapangan', 'penyedia_pupuk'])
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
        
        return view('logistik.chat', compact('chatUsers', 'conversations'));
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
