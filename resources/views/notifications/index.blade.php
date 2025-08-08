@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-xl p-6 mb-8 border border-gray-100">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
                <div class="flex items-center space-x-4">
                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-full p-3">
                        <i class="fas fa-bell text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                            Pusat Notifikasi
                        </h1>
                        <p class="text-gray-600 text-sm sm:text-base">
                            @php $unreadCount = $notifications->where('read_at', null)->count(); @endphp
                            @if($unreadCount > 0)
                                {{ $unreadCount }} notifikasi belum dibaca
                            @else
                                Semua notifikasi sudah dibaca
                            @endif
                        </p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    @if($unreadCount > 0)
                    <form action="{{ route('notifications.mark-all-read') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="group bg-gradient-to-r from-green-500 to-green-600 text-white px-4 py-2.5 rounded-xl hover:from-green-600 hover:to-green-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                            <i class="fas fa-check-double mr-2 group-hover:rotate-12 transition-transform"></i>
                            <span class="hidden sm:inline">Tandai Semua Dibaca</span>
                            <span class="sm:hidden">Tandai Semua</span>
                        </button>
                    </form>
                    @endif
                    <div class="bg-gradient-to-r from-blue-100 to-purple-100 rounded-xl px-4 py-2.5">
                        <span class="text-sm font-semibold text-gray-700">
                            {{ $notifications->total() }} Total
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notifications List -->
        <div class="space-y-6">
            @forelse($notifications as $notification)
            <div class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-[1.02] border border-gray-100
                @if(!$notification->read_at) ring-2 ring-blue-200 ring-opacity-50 @else opacity-90 hover:opacity-100 @endif">
                
                @if(!$notification->read_at)
                <!-- Unread indicator -->
                <div class="absolute -top-1 -right-1 w-4 h-4 bg-gradient-to-r from-red-500 to-pink-500 rounded-full animate-pulse"></div>
                @endif
                
                <div class="p-6">
                    <div class="flex items-start space-x-4">
                        <!-- Enhanced Notification Icon -->
                        <div class="flex-shrink-0 relative">
                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center shadow-lg transform group-hover:rotate-6 transition-transform duration-300
                                @if(str_contains(strtolower($notification->title), 'level up')) bg-gradient-to-br from-purple-400 to-purple-600
                                @elseif(str_contains(strtolower($notification->title), 'badge')) bg-gradient-to-br from-yellow-400 to-orange-500
                                @elseif(str_contains(strtolower($notification->title), 'investasi')) bg-gradient-to-br from-green-400 to-green-600
                                @elseif(str_contains(strtolower($notification->title), 'selamat')) bg-gradient-to-br from-blue-400 to-blue-600
                                @else bg-gradient-to-br from-gray-400 to-gray-600 @endif">
                                <i class="fas 
                                    @if(str_contains(strtolower($notification->title), 'level up')) fa-crown text-white
                                    @elseif(str_contains(strtolower($notification->title), 'badge')) fa-trophy text-white
                                    @elseif(str_contains(strtolower($notification->title), 'investasi')) fa-seedling text-white
                                    @elseif(str_contains(strtolower($notification->title), 'selamat')) fa-party-horn text-white
                                    @else fa-bell text-white @endif
                                    text-xl">
                                </i>
                            </div>
                            @if(!$notification->read_at)
                            <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-500 rounded-full border-2 border-white flex items-center justify-center">
                                <i class="fas fa-exclamation text-white text-xs"></i>
                            </div>
                            @endif
                        </div>

                        <!-- Enhanced Notification Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-col sm:flex-row sm:items-start justify-between mb-3">
                                <h3 class="text-lg font-bold text-gray-900 mb-1 sm:mb-0
                                    @if(!$notification->read_at) text-blue-900 @endif">
                                    {{ $notification->title }}
                                </h3>
                                <div class="flex items-center space-x-2 flex-shrink-0">
                                    @if(!$notification->read_at)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gradient-to-r from-red-500 to-pink-500 text-white animate-pulse">
                                        <i class="fas fa-circle text-xs mr-1"></i>
                                        Baru
                                    </span>
                                    @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                        <i class="fas fa-check-circle text-green-500 mr-1"></i>
                                        Dibaca
                                    </span>
                                    @endif
                                    <span class="text-sm text-gray-500 bg-gray-50 px-2 py-1 rounded-lg">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                            
                            <p class="text-gray-700 mb-4 leading-relaxed">{{ $notification->message }}</p>
                            
                            <!-- Enhanced Action Buttons -->
                            <div class="flex flex-wrap items-center gap-3">
                                @if(!$notification->read_at)
                                <form action="{{ route('notifications.read', $notification) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="group inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-sm font-medium rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                                        <i class="fas fa-check mr-2 group-hover:rotate-12 transition-transform"></i>
                                        Tandai Dibaca
                                    </button>
                                </form>
                                @endif
                                
                                <!-- Enhanced Contextual Actions -->
                                @if(str_contains(strtolower($notification->title), 'investasi'))
                                <a href="{{ route('investments.index') }}" class="group inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 text-white text-sm font-medium rounded-xl hover:from-green-600 hover:to-green-700 transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                                    <i class="fas fa-chart-line mr-2 group-hover:bounce transition-transform"></i>
                                    Lihat Investasi
                                </a>
                                @elseif(str_contains(strtolower($notification->title), 'badge'))
                                <a href="{{ route('gamification.badges') }}" class="group inline-flex items-center px-4 py-2 bg-gradient-to-r from-yellow-500 to-orange-500 text-white text-sm font-medium rounded-xl hover:from-yellow-600 hover:to-orange-600 transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                                    <i class="fas fa-trophy mr-2 group-hover:bounce transition-transform"></i>
                                    Lihat Badge
                                </a>
                                @elseif(str_contains(strtolower($notification->title), 'level up'))
                                <a href="{{ route('gamification.dashboard') }}" class="group inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-500 to-purple-600 text-white text-sm font-medium rounded-xl hover:from-purple-600 hover:to-purple-700 transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                                    <i class="fas fa-crown mr-2 group-hover:bounce transition-transform"></i>
                                    Lihat Progress
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Bottom accent line -->
                <div class="h-1 bg-gradient-to-r 
                    @if(str_contains(strtolower($notification->title), 'level up')) from-purple-400 to-purple-600
                    @elseif(str_contains(strtolower($notification->title), 'badge')) from-yellow-400 to-orange-500
                    @elseif(str_contains(strtolower($notification->title), 'investasi')) from-green-400 to-green-600
                    @elseif(str_contains(strtolower($notification->title), 'selamat')) from-blue-400 to-blue-600
                    @else from-gray-400 to-gray-600 @endif
                    rounded-b-2xl"></div>
            </div>
            @empty
            <!-- Enhanced Empty State -->
            <div class="bg-white rounded-2xl shadow-xl p-12 text-center border border-gray-100">
                <div class="relative mx-auto mb-8">
                    <div class="w-32 h-32 bg-gradient-to-br from-blue-100 to-purple-100 rounded-full flex items-center justify-center mx-auto shadow-lg">
                        <i class="fas fa-bell-slash text-gray-400 text-4xl"></i>
                    </div>
                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full flex items-center justify-center animate-bounce">
                        <i class="fas fa-sparkles text-white text-sm"></i>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Kotak Masuk Kosong!</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto leading-relaxed">
                    Belum ada notifikasi untuk saat ini. Mulai beraktivitas untuk mendapatkan notifikasi menarik!
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('investments.index') }}" class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl hover:from-green-600 hover:to-green-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <i class="fas fa-seedling mr-2 group-hover:rotate-12 transition-transform"></i>
                        Mulai Investasi
                    </a>
                    <a href="{{ route('gamification.missions') }}" class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <i class="fas fa-tasks mr-2 group-hover:bounce transition-transform"></i>
                        Lihat Misi
                    </a>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Enhanced Pagination -->
        @if($notifications->hasPages())
        <div class="flex justify-center mt-8">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4">
                {{ $notifications->links() }}
            </div>
        </div>
        @endif

        <!-- Enhanced Notification Stats -->
        @if($notifications->count() > 0)
        <div class="mt-8 bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
            <div class="text-center mb-6">
                <h3 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-2">
                    Statistik Notifikasi
                </h3>
                <p class="text-gray-600">Ringkasan aktivitas notifikasi Anda</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gradient-to-br from-red-50 to-pink-50 rounded-2xl p-6 text-center border border-red-100">
                    <div class="w-16 h-16 bg-gradient-to-r from-red-500 to-pink-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <i class="fas fa-exclamation-circle text-white text-2xl"></i>
                    </div>
                    <div class="text-3xl font-bold text-red-600 mb-2">{{ $notifications->where('read_at', null)->count() }}</div>
                    <div class="text-sm font-medium text-gray-700">Belum Dibaca</div>
                </div>
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-6 text-center border border-green-100">
                    <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-emerald-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <i class="fas fa-check-circle text-white text-2xl"></i>
                    </div>
                    <div class="text-3xl font-bold text-green-600 mb-2">{{ $notifications->where('read_at', '!=', null)->count() }}</div>
                    <div class="text-sm font-medium text-gray-700">Sudah Dibaca</div>
                </div>
                <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-2xl p-6 text-center border border-purple-100">
                    <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <i class="fas fa-bell text-white text-2xl"></i>
                    </div>
                    <div class="text-3xl font-bold text-purple-600 mb-2">{{ $notifications->count() }}</div>
                    <div class="text-sm font-medium text-gray-700">Total Notifikasi</div>
                </div>
            </div>
            
            <!-- Progress Bar -->
            @php 
                $readPercentage = $notifications->count() > 0 ? ($notifications->where('read_at', '!=', null)->count() / $notifications->count()) * 100 : 0;
            @endphp
            <div class="mt-6 pt-6 border-t border-gray-200">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-gray-700">Progress Membaca</span>
                    <span class="text-sm font-bold text-gray-900">{{ number_format($readPercentage, 1) }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-gradient-to-r from-green-500 to-emerald-500 h-3 rounded-full transition-all duration-500" 
                         style="width: {{ $readPercentage }}%"></div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
@keyframes bounce {
    0%, 20%, 53%, 80%, 100% {
        transform: translate3d(0,0,0);
    }
    40%, 43% {
        transform: translate3d(0,-8px,0);
    }
    70% {
        transform: translate3d(0,-4px,0);
    }
    90% {
        transform: translate3d(0,-2px,0);
    }
}

.group:hover .group-hover\:bounce {
    animation: bounce 1s infinite;
}
</style>
@endsection 