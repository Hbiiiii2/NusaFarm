@extends('layouts.app')

@section('title', 'Leaderboard')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Leaderboard</h1>
            <p class="text-gray-600">Lihat peringkat pengguna berdasarkan XP dan level</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('gamification.dashboard') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 flex items-center space-x-2">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- User Position -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Posisi Anda</h2>
        
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center">
                <span class="text-white font-bold text-xl">#{{ $userPosition }}</span>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-gray-900">{{ auth()->user()->name }}</h3>
                <p class="text-sm text-gray-600">Level {{ auth()->user()->level }} • {{ number_format(auth()->user()->xp) }} XP</p>
            </div>
            <div class="text-right">
                <div class="text-2xl font-bold text-green-600">{{ number_format(auth()->user()->xp) }}</div>
                <div class="text-sm text-gray-500">Total XP</div>
            </div>
        </div>
    </div>

    <!-- Leaderboard Tabs -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex space-x-4 mb-6">
            <button class="tab-btn px-4 py-2 rounded-lg font-medium transition-colors active" data-tab="xp">
                <i class="fas fa-star mr-2"></i>
                XP Leaderboard
            </button>
            <button class="tab-btn px-4 py-2 rounded-lg font-medium transition-colors" data-tab="level">
                <i class="fas fa-trophy mr-2"></i>
                Level Leaderboard
            </button>
            <button class="tab-btn px-4 py-2 rounded-lg font-medium transition-colors" data-tab="investment">
                <i class="fas fa-chart-line mr-2"></i>
                Investment Leaderboard
            </button>
        </div>

        <!-- XP Leaderboard -->
        <div id="xp-tab" class="tab-content">
            <div class="space-y-4">
                @foreach($topUsersByXp as $index => $user)
                <div class="flex items-center space-x-4 p-4 border rounded-lg hover:shadow-md transition-shadow
                    @if($user->id === auth()->id()) bg-green-50 border-green-200 @endif">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center font-bold text-white
                        @if($index === 0) bg-yellow-500
                        @elseif($index === 1) bg-gray-400
                        @elseif($index === 2) bg-orange-500
                        @else bg-blue-500 @endif">
                        @if($index === 0)
                            <i class="fas fa-crown text-lg"></i>
                        @elseif($index === 1)
                            <i class="fas fa-medal text-lg"></i>
                        @elseif($index === 2)
                            <i class="fas fa-award text-lg"></i>
                        @else
                            {{ $index + 1 }}
                        @endif
                    </div>
                    
                    <div class="flex-1">
                        <div class="flex items-center space-x-2">
                            <h3 class="font-semibold text-gray-900">{{ $user->name }}</h3>
                            @if($user->id === auth()->id())
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Anda
                                </span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-600">Level {{ $user->level }} • {{ $user->role }}</p>
                    </div>
                    
                    <div class="text-right">
                        <div class="text-lg font-bold text-gray-900">{{ number_format($user->xp) }}</div>
                        <div class="text-sm text-gray-500">XP</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Level Leaderboard -->
        <div id="level-tab" class="tab-content hidden">
            <div class="space-y-4">
                @foreach($topUsersByLevel as $index => $user)
                <div class="flex items-center space-x-4 p-4 border rounded-lg hover:shadow-md transition-shadow
                    @if($user->id === auth()->id()) bg-green-50 border-green-200 @endif">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center font-bold text-white
                        @if($index === 0) bg-yellow-500
                        @elseif($index === 1) bg-gray-400
                        @elseif($index === 2) bg-orange-500
                        @else bg-blue-500 @endif">
                        @if($index === 0)
                            <i class="fas fa-crown text-lg"></i>
                        @elseif($index === 1)
                            <i class="fas fa-medal text-lg"></i>
                        @elseif($index === 2)
                            <i class="fas fa-award text-lg"></i>
                        @else
                            {{ $index + 1 }}
                        @endif
                    </div>
                    
                    <div class="flex-1">
                        <div class="flex items-center space-x-2">
                            <h3 class="font-semibold text-gray-900">{{ $user->name }}</h3>
                            @if($user->id === auth()->id())
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Anda
                                </span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-600">{{ number_format($user->xp) }} XP • {{ $user->role }}</p>
                    </div>
                    
                    <div class="text-right">
                        <div class="text-lg font-bold text-gray-900">Level {{ $user->level }}</div>
                        <div class="text-sm text-gray-500">Level</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Investment Leaderboard -->
        <div id="investment-tab" class="tab-content hidden">
            <div class="space-y-4">
                @foreach($topUsersByInvestment as $index => $user)
                <div class="flex items-center space-x-4 p-4 border rounded-lg hover:shadow-md transition-shadow
                    @if($user->id === auth()->id()) bg-green-50 border-green-200 @endif">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center font-bold text-white
                        @if($index === 0) bg-yellow-500
                        @elseif($index === 1) bg-gray-400
                        @elseif($index === 2) bg-orange-500
                        @else bg-blue-500 @endif">
                        @if($index === 0)
                            <i class="fas fa-crown text-lg"></i>
                        @elseif($index === 1)
                            <i class="fas fa-medal text-lg"></i>
                        @elseif($index === 2)
                            <i class="fas fa-award text-lg"></i>
                        @else
                            {{ $index + 1 }}
                        @endif
                    </div>
                    
                    <div class="flex-1">
                        <div class="flex items-center space-x-2">
                            <h3 class="font-semibold text-gray-900">{{ $user->name }}</h3>
                            @if($user->id === auth()->id())
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Anda
                                </span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-600">Level {{ $user->level }} • {{ $user->role }}</p>
                    </div>
                    
                    <div class="text-right">
                        <div class="text-lg font-bold text-gray-900">Rp {{ number_format($user->total_investment) }}</div>
                        <div class="text-sm text-gray-500">Total Investasi</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Rata-rata XP</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($averageXp) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-chart-bar text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Rata-rata Level</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($averageLevel, 1) }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-layer-group text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Pengguna</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($totalUsers) }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-users text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Weekly Winners -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Pemenang Minggu Ini</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center">
                <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-crown text-white text-3xl"></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-1">Pemenang XP</h3>
                <p class="text-sm text-gray-600">{{ $weeklyXpWinner->name ?? 'Belum ada data' }}</p>
                <p class="text-xs text-gray-500">{{ number_format($weeklyXpWinner->xp ?? 0) }} XP</p>
            </div>
            
            <div class="text-center">
                <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-gray-400 to-gray-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-medal text-white text-3xl"></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-1">Pemenang Level</h3>
                <p class="text-sm text-gray-600">{{ $weeklyLevelWinner->name ?? 'Belum ada data' }}</p>
                <p class="text-xs text-gray-500">Level {{ $weeklyLevelWinner->level ?? 0 }}</p>
            </div>
            
            <div class="text-center">
                <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-chart-line text-white text-3xl"></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-1">Investor Terbaik</h3>
                <p class="text-sm text-gray-600">{{ $weeklyInvestmentWinner->name ?? 'Belum ada data' }}</p>
                <p class="text-xs text-gray-500">Rp {{ number_format($weeklyInvestmentWinner->total_investment ?? 0) }}</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const targetTab = this.dataset.tab;
            
            // Remove active class from all buttons
            tabBtns.forEach(b => b.classList.remove('active', 'bg-green-600', 'text-white'));
            tabBtns.forEach(b => b.classList.add('bg-gray-100', 'text-gray-700'));
            
            // Add active class to clicked button
            this.classList.remove('bg-gray-100', 'text-gray-700');
            this.classList.add('active', 'bg-green-600', 'text-white');
            
            // Hide all tab contents
            tabContents.forEach(content => content.classList.add('hidden'));
            
            // Show target tab content
            document.getElementById(targetTab + '-tab').classList.remove('hidden');
        });
    });
});
</script>
@endpush
@endsection 