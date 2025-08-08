<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatMessage;
use App\Models\User;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        
        // Get users that current user can chat with based on role
        $chatUsers = $this->getChatUsers($user);
        
        // Get recent conversations
        $conversations = $user->sentMessages()
            ->orWhere('receiver_id', $user->id)
            ->with(['sender', 'receiver'])
            ->latest()
            ->get()
            ->groupBy(function($message) use ($user) {
                return $message->sender_id == $user->id ? $message->receiver_id : $message->sender_id;
            });
        
        return view('chat.index', compact('chatUsers', 'conversations'));
    }

    public function conversation(User $user)
    {
        $currentUser = auth()->user();
        
        // Get messages between current user and selected user
        $messages = ChatMessage::where(function($query) use ($currentUser, $user) {
            $query->where('sender_id', $currentUser->id)
                  ->where('receiver_id', $user->id);
        })->orWhere(function($query) use ($currentUser, $user) {
            $query->where('sender_id', $user->id)
                  ->where('receiver_id', $currentUser->id);
        })->with(['sender', 'receiver'])->orderBy('created_at', 'asc')->get();
        
        // Mark messages as read
        $messages->where('receiver_id', $currentUser->id)->each(function($message) {
            $message->update(['is_read' => true, 'read_at' => now()]);
        });
        
        return view('chat.conversation', compact('messages', 'user'));
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

    private function getChatUsers($user)
    {
        switch ($user->role) {
            case 'petani':
                return User::whereIn('role', ['manajer_lapangan', 'logistik', 'penyedia_pupuk'])
                    ->where('id', '!=', $user->id)
                    ->get();
            
            case 'manajer_lapangan':
                return User::whereIn('role', ['petani', 'logistik', 'penyedia_pupuk', 'admin'])
                    ->where('id', '!=', $user->id)
                    ->get();
            
            case 'logistik':
                return User::whereIn('role', ['petani', 'manajer_lapangan', 'penyedia_pupuk'])
                    ->where('id', '!=', $user->id)
                    ->get();
            
            case 'penyedia_pupuk':
                return User::whereIn('role', ['petani', 'manajer_lapangan', 'logistik'])
                    ->where('id', '!=', $user->id)
                    ->get();
            
            case 'pedagang_pasar':
                return User::whereIn('role', ['manajer_lapangan', 'logistik'])
                    ->where('id', '!=', $user->id)
                    ->get();
            
            case 'admin':
                return User::where('role', '!=', 'admin')
                    ->where('id', '!=', $user->id)
                    ->get();
            
            default:
                return collect();
        }
    }
}
