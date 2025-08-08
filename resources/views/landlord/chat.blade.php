@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-blue-50 pb-24">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <div class="bg-purple-100 rounded-full p-2">
                        <i class="fas fa-comments text-purple-600 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Komunikasi</h1>
                        <p class="text-sm text-gray-600">Chat dengan Manajer, Logistik, Petani & Admin</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Chat Users List -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Kontak</h2>
                    <p class="text-sm text-gray-600">Pilih kontak untuk memulai chat</p>
                </div>
                <div class="p-4">
                    @if($chatUsers->count() > 0)
                        <div class="space-y-2">
                            @foreach($chatUsers->groupBy('role') as $role => $users)
                            <div class="mb-4">
                                <h3 class="text-sm font-semibold text-gray-600 mb-2 capitalize">
                                    @if($role === 'manajer_lapangan') Manajer Lapangan
                                    @elseif($role === 'logistik') Tim Logistik
                                    @elseif($role === 'petani') Petani
                                    @elseif($role === 'admin') Administrator
                                    @else {{ $role }} @endif
                                </h3>
                                @foreach($users as $user)
                                <div class="flex items-center p-3 hover:bg-gray-50 rounded-lg cursor-pointer border border-transparent hover:border-gray-200 transition-colors"
                                     onclick="selectUser({{ $user->id }}, '{{ $user->name }}', '{{ $user->role }}')">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3
                                        @if($user->role === 'manajer_lapangan') bg-purple-100
                                        @elseif($user->role === 'logistik') bg-blue-100
                                        @elseif($user->role === 'petani') bg-green-100
                                        @elseif($user->role === 'admin') bg-red-100
                                        @else bg-gray-100 @endif">
                                        <span class="font-semibold
                                            @if($user->role === 'manajer_lapangan') text-purple-600
                                            @elseif($user->role === 'logistik') text-blue-600
                                            @elseif($user->role === 'petani') text-green-600
                                            @elseif($user->role === 'admin') text-red-600
                                            @else text-gray-600 @endif">
                                            {{ substr($user->name, 0, 2) }}
                                        </span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-900">{{ $user->name }}</p>
                                        <p class="text-sm text-gray-500 capitalize">
                                            @if($user->role === 'manajer_lapangan') Manajer Lapangan
                                            @else {{ str_replace('_', ' ', $user->role) }} @endif
                                        </p>
                                    </div>
                                    @if($conversations->has($user->id))
                                    <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-users text-gray-400 text-3xl mb-4"></i>
                            <p class="text-gray-500">Tidak ada kontak tersedia</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Chat Area -->
            <div class="lg:col-span-2 bg-white rounded-lg shadow">
                <div id="chat-header" class="px-6 py-4 border-b border-gray-200 hidden">
                    <div class="flex items-center">
                        <div id="selected-user-avatar" class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center mr-3">
                            <span id="selected-user-initial" class="font-semibold text-gray-600"></span>
                        </div>
                        <div>
                            <h3 id="selected-user-name" class="font-semibold text-gray-900"></h3>
                            <p id="selected-user-role" class="text-sm text-gray-500"></p>
                        </div>
                    </div>
                </div>
                
                <div id="chat-messages" class="h-96 p-6 overflow-y-auto hidden">
                    <!-- Messages will be loaded here -->
                </div>
                
                <div id="chat-form-container" class="p-6 border-t border-gray-200 hidden">
                    <form id="chat-form" action="{{ route('landlord.chat.send') }}" method="POST">
                        @csrf
                        <input type="hidden" id="receiver_id" name="receiver_id">
                        <div class="flex items-end space-x-3">
                            <div class="flex-1">
                                <textarea name="message" id="message" rows="2" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 resize-none"
                                    placeholder="Ketik pesan Anda..."></textarea>
                            </div>
                            <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition-colors">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Default State -->
                <div id="default-chat-state" class="flex items-center justify-center h-96">
                    <div class="text-center">
                        <i class="fas fa-comments text-gray-400 text-4xl mb-4"></i>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Pilih Kontak</h3>
                        <p class="text-gray-500">Pilih kontak dari daftar sebelah kiri untuk memulai percakapan</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Conversations -->
        @if($conversations->count() > 0)
        <div class="mt-8 bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Percakapan Terbaru</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($conversations->take(5) as $userId => $messages)
                    @php
                        $lastMessage = $messages->first();
                        $otherUser = $lastMessage->sender_id === auth()->id() ? $lastMessage->receiver : $lastMessage->sender;
                    @endphp
                    <div class="flex items-center p-4 hover:bg-gray-50 rounded-lg cursor-pointer"
                         onclick="selectUser({{ $otherUser->id }}, '{{ $otherUser->name }}', '{{ $otherUser->role }}')">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mr-4">
                            <span class="font-semibold text-gray-600">{{ substr($otherUser->name, 0, 2) }}</span>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-1">
                                <h4 class="font-semibold text-gray-900">{{ $otherUser->name }}</h4>
                                <span class="text-sm text-gray-500">{{ $lastMessage->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-gray-600">{{ Str::limit($lastMessage->message, 50) }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
let selectedUserId = null;

function selectUser(userId, userName, userRole) {
    selectedUserId = userId;
    
    // Update header
    document.getElementById('selected-user-name').textContent = userName;
    document.getElementById('selected-user-role').textContent = formatRole(userRole);
    document.getElementById('selected-user-initial').textContent = userName.substring(0, 2);
    document.getElementById('receiver_id').value = userId;
    
    // Update avatar color based on role
    const avatar = document.getElementById('selected-user-avatar');
    avatar.className = 'w-10 h-10 rounded-full flex items-center justify-center mr-3 ' + getAvatarColor(userRole);
    
    // Show chat interface
    document.getElementById('default-chat-state').classList.add('hidden');
    document.getElementById('chat-header').classList.remove('hidden');
    document.getElementById('chat-messages').classList.remove('hidden');
    document.getElementById('chat-form-container').classList.remove('hidden');
    
    // Load messages (you can implement AJAX loading here)
    loadMessages(userId);
}

function formatRole(role) {
    const roleMap = {
        'manajer_lapangan': 'Manajer Lapangan',
        'logistik': 'Tim Logistik',
        'petani': 'Petani',
        'admin': 'Administrator'
    };
    return roleMap[role] || role;
}

function getAvatarColor(role) {
    const colorMap = {
        'manajer_lapangan': 'bg-purple-100',
        'logistik': 'bg-blue-100',
        'petani': 'bg-green-100',
        'admin': 'bg-red-100'
    };
    return colorMap[role] || 'bg-gray-100';
}

function loadMessages(userId) {
    // This is a placeholder - you can implement AJAX message loading here
    const messagesContainer = document.getElementById('chat-messages');
    messagesContainer.innerHTML = '<div class="text-center text-gray-500 py-8">Memuat percakapan...</div>';
}

// Handle form submission
document.getElementById('chat-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('message').value = '';
            loadMessages(selectedUserId);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
</script>
@endsection