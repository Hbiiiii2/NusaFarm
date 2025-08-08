@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-green-100 pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('petani.dashboard') }}" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-arrow-left text-xl"></i>
                        </a>
                        <div>
                            <h1 class="text-xl font-bold text-gray-900">Chat</h1>
                            <p class="text-sm text-gray-600">Komunikasi dengan tim pertanian</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Chat Users List -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Tim Pertanian</h2>
                    </div>
                    <div class="p-4">
                        <div class="space-y-2">
                            @foreach($chatUsers as $user)
                            <div class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors" 
                                 onclick="selectUser({{ $user->id }}, '{{ $user->name }}', '{{ $user->role }}')">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-gray-600"></i>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500">
                                        @if($user->role === 'manajer_lapangan')
                                            <i class="fas fa-user-tie text-blue-500 mr-1"></i>Manajer Lapangan
                                        @elseif($user->role === 'logistik')
                                            <i class="fas fa-truck text-green-500 mr-1"></i>Logistik
                                        @elseif($user->role === 'penyedia_pupuk')
                                            <i class="fas fa-seedling text-orange-500 mr-1"></i>Penyedia Pupuk
                                        @endif
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chat Messages -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div id="selected-user-info" class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-gray-600 text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Pilih pengguna untuk memulai chat</p>
                                    <p class="text-xs text-gray-500">Klik nama di sidebar untuk memulai percakapan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="h-96 flex flex-col">
                        <!-- Messages Area -->
                        <div id="messages-area" class="flex-1 p-4 overflow-y-auto">
                            <div class="text-center py-8">
                                <i class="fas fa-comments text-gray-400 text-4xl mb-4"></i>
                                <p class="text-gray-500">Pilih pengguna untuk memulai percakapan</p>
                            </div>
                        </div>
                        
                        <!-- Message Input -->
                        <div class="border-t border-gray-200 p-4">
                            <form id="message-form" class="flex space-x-2" style="display: none;">
                                @csrf
                                <input type="hidden" id="receiver_id" name="receiver_id">
                                <input type="text" id="message-input" name="message" 
                                    class="flex-1 rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                    placeholder="Ketik pesan..." required>
                                <button type="submit" 
                                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let selectedUserId = null;
let selectedUserName = '';

function selectUser(userId, userName, userRole) {
    selectedUserId = userId;
    selectedUserName = userName;
    
    // Update selected user info
    const userInfo = document.getElementById('selected-user-info');
    userInfo.innerHTML = `
        <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
            <i class="fas fa-user text-gray-600 text-sm"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-900">${userName}</p>
            <p class="text-xs text-gray-500">${getRoleDisplay(userRole)}</p>
        </div>
    `;
    
    // Show message form
    document.getElementById('message-form').style.display = 'flex';
    document.getElementById('receiver_id').value = userId;
    document.getElementById('message-input').focus();
    
    // Load messages (you can implement AJAX here)
    loadMessages(userId);
}

function getRoleDisplay(role) {
    switch(role) {
        case 'manajer_lapangan':
            return 'Manajer Lapangan';
        case 'logistik':
            return 'Logistik';
        case 'penyedia_pupuk':
            return 'Penyedia Pupuk';
        default:
            return role;
    }
}

function loadMessages(userId) {
    // Implement AJAX to load messages
    const messagesArea = document.getElementById('messages-area');
    messagesArea.innerHTML = `
        <div class="text-center py-8">
            <i class="fas fa-spinner fa-spin text-gray-400 text-2xl mb-4"></i>
            <p class="text-gray-500">Memuat pesan...</p>
        </div>
    `;
    
    // You can implement AJAX call here to load actual messages
    // For now, we'll show a placeholder
    setTimeout(() => {
        messagesArea.innerHTML = `
            <div class="space-y-4">
                <div class="text-center py-4">
                    <p class="text-sm text-gray-500">Mulai percakapan dengan ${selectedUserName}</p>
                </div>
            </div>
        `;
    }, 1000);
}

// Handle message form submission
document.getElementById('message-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const messageInput = document.getElementById('message-input');
    const message = messageInput.value.trim();
    
    if (message && selectedUserId) {
        // Add message to UI immediately
        const messagesArea = document.getElementById('messages-area');
        const messageElement = document.createElement('div');
        messageElement.className = 'flex justify-end mb-4';
        messageElement.innerHTML = `
            <div class="bg-green-500 text-white rounded-lg px-4 py-2 max-w-xs">
                <p class="text-sm">${message}</p>
                <p class="text-xs opacity-75 mt-1">${new Date().toLocaleTimeString()}</p>
            </div>
        `;
        messagesArea.appendChild(messageElement);
        
        // Clear input
        messageInput.value = '';
        
        // Scroll to bottom
        messagesArea.scrollTop = messagesArea.scrollHeight;
        
        // You can implement AJAX to send message to server here
        // For now, we'll just show it in UI
    }
});

// Auto-resize textarea
document.getElementById('message-input').addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = this.scrollHeight + 'px';
});
</script>
@endsection 