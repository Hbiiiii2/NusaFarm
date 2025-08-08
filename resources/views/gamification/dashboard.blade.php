@extends('layouts.app')

@section('title', 'Gamifikasi')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gamifikasi</h1>
            <p class="text-gray-600">Tingkatkan level dan kumpulkan badge</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('gamification.missions') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 flex items-center space-x-2">
                <i class="fas fa-tasks"></i>
                <span>Misi Harian</span>
            </a>
            <a href="{{ route('gamification.leaderboard') }}" class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 flex items-center space-x-2">
                <i class="fas fa-trophy"></i>
                <span>Leaderboard</span>
            </a>
        </div>
    </div>

    <!-- Level Progress -->
    <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl shadow-lg p-8 text-white">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-semibold mb-2">Level {{ $user->level }}</h2>
                <p class="text-4xl font-bold">{{ $user->xp }} XP</p>
                <p class="text-purple-100 mt-2">{{ $xpProgress }} / {{ $xpNeeded }} XP menuju Level {{ $user->level + 1 }}</p>
            </div>
            <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <i class="fas fa-star text-3xl"></i>
            </div>
        </div>
        
        <!-- Progress Bar -->
        <div class="mt-6">
            <div class="w-full bg-white bg-opacity-20 rounded-full h-3">
                <div class="bg-white h-3 rounded-full" style="width: {{ $progressPercentage }}%"></div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Investasi</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $user->investments()->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-chart-line text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Badge Diraih</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $badges->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-medal text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Misi Selesai</p>
                    <p class="text-2xl font-bold text-gray-900">12</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Ranking</p>
                    <p class="text-2xl font-bold text-gray-900">#{{ rand(1, 50) }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-trophy text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Earned Badges -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-900">Badge Diraih</h2>
                    <a href="{{ route('gamification.badges') }}" class="text-purple-600 hover:text-purple-700 text-sm font-medium">Lihat Semua</a>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @forelse($badges as $badge)
                    <div class="text-center p-4 border rounded-lg hover:shadow-md transition-shadow">
                        <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-medal text-purple-600 text-2xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 text-sm">{{ $badge->name }}</h3>
                        <p class="text-xs text-gray-500 mt-1">{{ $badge->description }}</p>
                    </div>
                    @empty
                    <div class="col-span-full text-center py-8">
                        <i class="fas fa-medal text-gray-400 text-4xl mb-4"></i>
                        <p class="text-gray-500">Belum ada badge yang diraih</p>
                        <p class="text-sm text-gray-400 mt-2">Selesaikan misi untuk mendapatkan badge</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Available Badges & Quick Actions -->
        <div class="space-y-6">
            <!-- Available Badges -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Badge Tersedia</h2>
                <div class="space-y-3">
                    @forelse($availableBadges->take(3) as $badge)
                    <div class="flex items-center space-x-3 p-3 border rounded-lg">
                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-medal text-gray-400 text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-900 text-sm">{{ $badge->name }}</p>
                            <p class="text-xs text-gray-500">{{ $badge->description }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-sm text-gray-500">Semua badge sudah diraih!</p>
                    @endforelse
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Aksi Cepat</h2>
                <div class="space-y-3">
                    <a href="{{ route('gamification.missions') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-purple-50 transition-colors">
                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-tasks text-purple-600"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Misi Harian</p>
                            <p class="text-sm text-gray-500">Selesaikan misi untuk XP</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('investments.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-50 transition-colors">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-chart-line text-blue-600"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Investasi</p>
                            <p class="text-sm text-gray-500">Dapatkan XP dari investasi</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('gamification.leaderboard') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-orange-50 transition-colors">
                        <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-trophy text-orange-600"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Leaderboard</p>
                            <p class="text-sm text-gray-500">Lihat ranking pemain</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 