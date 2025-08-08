@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-yellow-50 via-white to-orange-50 pb-24">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <div class="bg-green-100 rounded-full p-2">
                        <i class="fas fa-comments text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Manajer Chat</h1>
                        <p class="text-sm text-gray-600">Komunikasi dengan petani dan tim</p>
                    </div>
                </div>
                <a href="{{ route('manajer.dashboard') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Users List -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Users</h3>
                    </div>
                    <div class="p-4">
                        <div class="space-y-2">
                            @forelse($chatUsers as $user)
                            <div class="flex items-center p-3 rounded-lg hover:bg-gray-50 cursor-pointer" 
                                 onclick="selectUser({{ $user->id }}, '{{ $user->name }}', '{{ $user->role }}')">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                        <i class="fas fa-user text-blue-600"></i>
                                    </div>
                                </div>
                                <div class="ml-3 flex-1">
                                    <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</p>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-8">
                                <i class="fas fa-users text-gray-400 text-4xl mb-4"></i>
                                <p class="text-gray-500">No users available</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chat Area -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">
                            <span id="selectedUserName">Select a user to start chatting</span>
                        </h3>
                    </div>
                    
                    <!-- Messages Area -->
                    <div id="messagesArea" class="h-96 overflow-y-auto p-4 bg-gray-50">
                        <div class="text-center py-8">
                            <i class="fas fa-comments text-gray-400 text-4xl mb-4"></i>
                            <p class="text-gray-500">Select a user to view messages</p>
                        </div>
                    </div>
                    
                    <!-- Message Input -->
                    <div class="px-6 py-4 border-t border-gray-200">
                        <form id="messageForm" class="flex space-x-3" style="display: none;">
                            @csrf
                            <input type="hidden" id="receiverId" name="receiver_id">
                            <input type="text" id="messageInput" name="message" 
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                   placeholder="Type your message...">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Conversations -->
        <div class="mt-6">
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Conversations</h3>
                </div>
                <div class="p-6">
                    @if($conversations->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($conversations as $userId => $messages)
                                @php
                                    $otherUser = $messages->first()->sender_id == auth()->id() 
                                        ? $messages->first()->receiver 
                                        : $messages->first()->sender;
                                    $lastMessage = $messages->first();
                                @endphp
                                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 cursor-pointer"
                                     onclick="selectUser({{ $otherUser->id }}, '{{ $otherUser->name }}', '{{ $otherUser->role }}')">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                <i class="fas fa-user text-blue-600"></i>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900">{{ $otherUser->name }}</p>
                                            <p class="text-xs text-gray-500">{{ ucfirst(str_replace('_', ' ', $otherUser->role)) }}</p>
                                            <p class="text-xs text-gray-400 truncate">{{ Str::limit($lastMessage->message, 30) }}</p>
                                            <p class="text-xs text-gray-400">{{ $lastMessage->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-comments text-gray-400 text-4xl mb-4"></i>
                            <p class="text-gray-500">No recent conversations</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let selectedUserId = null;

function selectUser(userId, userName, userRole) {
    selectedUserId = userId;
    document.getElementById('selectedUserName').textContent = `${userName} (${userRole})`;
    document.getElementById('receiverId').value = userId;
    document.getElementById('messageForm').style.display = 'flex';
    
    // Load messages for this user
    loadMessages(userId);
}

function loadMessages(userId) {
    // In a real app, you'd fetch messages via AJAX
    const messagesArea = document.getElementById('messagesArea');
    messagesArea.innerHTML = `
        <div class="space-y-4">
            <div class="text-center py-8">
                <i class="fas fa-spinner fa-spin text-gray-400 text-2xl mb-4"></i>
                <p class="text-gray-500">Loading messages...</p>
            </div>
        </div>
    `;
    
    // Simulate loading messages
    setTimeout(() => {
        messagesArea.innerHTML = `
            <div class="space-y-4">
                <div class="flex justify-end">
                    <div class="bg-blue-600 text-white px-4 py-2 rounded-lg max-w-xs">
                        <p class="text-sm">Hello! How can I help you today?</p>
                        <p class="text-xs text-blue-200 mt-1">Just now</p>
                    </div>
                </div>
                <div class="flex justify-start">
                    <div class="bg-gray-200 text-gray-900 px-4 py-2 rounded-lg max-w-xs">
                        <p class="text-sm">Hi manager, I have a question about the project.</p>
                        <p class="text-xs text-gray-500 mt-1">2 minutes ago</p>
                    </div>
                </div>
            </div>
        `;
    }, 1000);
}

// Handle message form submission
document.getElementById('messageForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const messageInput = document.getElementById('messageInput');
    const message = messageInput.value.trim();
    
    if (message && selectedUserId) {
        // In a real app, you'd send the message via AJAX
        const messagesArea = document.getElementById('messagesArea');
        const newMessage = `
            <div class="flex justify-end">
                <div class="bg-blue-600 text-white px-4 py-2 rounded-lg max-w-xs">
                    <p class="text-sm">${message}</p>
                    <p class="text-xs text-blue-200 mt-1">Just now</p>
                </div>
            </div>
        `;
        
        messagesArea.insertAdjacentHTML('beforeend', newMessage);
        messagesArea.scrollTop = messagesArea.scrollHeight;
        messageInput.value = '';
        
        // Show success message
        alert('Message sent successfully!');
    }
});
</script>
@endsection 