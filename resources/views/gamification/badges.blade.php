@extends('layouts.app')

@section('title', 'Badges')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Badges</h1>
            <p class="text-gray-600">Kumpulkan badges untuk menunjukkan prestasi Anda</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('gamification.dashboard') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 flex items-center space-x-2">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- Badge Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Badges Diterima</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $earnedBadgesCount }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-trophy text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Badges</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalBadgesCount }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-medal text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Progress</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $progressPercentage }}%</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-percentage text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Earned Badges -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Badges Diterima</h2>
        
        @if($earnedBadges->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($earnedBadges as $badge)
            <div class="border rounded-lg p-6 text-center hover:shadow-md transition-shadow">
                <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-trophy text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $badge->name }}</h3>
                <p class="text-sm text-gray-600 mb-3">{{ $badge->description }}</p>
                <div class="text-xs text-gray-500">
                    Diterima pada {{ $badge->pivot->created_at->format('d M Y') }}
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12">
            <i class="fas fa-trophy text-gray-400 text-6xl mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Badges</h3>
            <p class="text-gray-500 mb-4">Mulai beraktivitas untuk mendapatkan badges pertama Anda.</p>
            <a href="{{ route('gamification.missions') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors">
                Mulai Misi
            </a>
        </div>
        @endif
    </div>

    <!-- Available Badges -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Badges Tersedia</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- First Steps Badge -->
            <div class="border rounded-lg p-6 text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-shoe-prints text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">First Steps</h3>
                <p class="text-sm text-gray-600 mb-3">Bergabung dengan NusaFarm untuk pertama kali</p>
                <div class="text-xs text-gray-500">
                    @if($hasFirstStepsBadge)
                        <span class="text-green-600 font-medium">✓ Diterima</span>
                    @else
                        <span class="text-yellow-600 font-medium">Belum Diterima</span>
                    @endif
                </div>
            </div>

            <!-- Investment Badge -->
            <div class="border rounded-lg p-6 text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-chart-line text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Investor</h3>
                <p class="text-sm text-gray-600 mb-3">Lakukan investasi pertama Anda</p>
                <div class="text-xs text-gray-500">
                    @if($hasInvestmentBadge)
                        <span class="text-green-600 font-medium">✓ Diterima</span>
                    @else
                        <span class="text-yellow-600 font-medium">Belum Diterima</span>
                    @endif
                </div>
            </div>

            <!-- Level Badges -->
            <div class="border rounded-lg p-6 text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-star text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Level 5</h3>
                <p class="text-sm text-gray-600 mb-3">Capai level 5 untuk mendapatkan badge ini</p>
                <div class="text-xs text-gray-500">
                    @if($hasLevel5Badge)
                        <span class="text-green-600 font-medium">✓ Diterima</span>
                    @else
                        <span class="text-yellow-600 font-medium">Level {{ auth()->user()->level }}/5</span>
                    @endif
                </div>
            </div>

            <div class="border rounded-lg p-6 text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-crown text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Level 10</h3>
                <p class="text-sm text-gray-600 mb-3">Capai level 10 untuk mendapatkan badge ini</p>
                <div class="text-xs text-gray-500">
                    @if($hasLevel10Badge)
                        <span class="text-green-600 font-medium">✓ Diterima</span>
                    @else
                        <span class="text-yellow-600 font-medium">Level {{ auth()->user()->level }}/10</span>
                    @endif
                </div>
            </div>

            <!-- Streak Badge -->
            <div class="border rounded-lg p-6 text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-red-400 to-red-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-fire text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Streak Master</h3>
                <p class="text-sm text-gray-600 mb-3">Login 7 hari berturut-turut</p>
                <div class="text-xs text-gray-500">
                    @if($hasStreakBadge)
                        <span class="text-green-600 font-medium">✓ Diterima</span>
                    @else
                        <span class="text-yellow-600 font-medium">Belum Diterima</span>
                    @endif
                </div>
            </div>

            <!-- Top-up Badge -->
            <div class="border rounded-lg p-6 text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-plus text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Top-up Master</h3>
                <p class="text-sm text-gray-600 mb-3">Top-up wallet sebanyak 5 kali</p>
                <div class="text-xs text-gray-500">
                    @if($hasTopupBadge)
                        <span class="text-green-600 font-medium">✓ Diterima</span>
                    @else
                        <span class="text-yellow-600 font-medium">Belum Diterima</span>
                    @endif
                </div>
            </div>

            <!-- Investment Amount Badge -->
            <div class="border rounded-lg p-6 text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-coins text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Big Investor</h3>
                <p class="text-sm text-gray-600 mb-3">Investasi total mencapai Rp 1.000.000</p>
                <div class="text-xs text-gray-500">
                    @if($hasBigInvestmentBadge)
                        <span class="text-green-600 font-medium">✓ Diterima</span>
                    @else
                        <span class="text-yellow-600 font-medium">Belum Diterima</span>
                    @endif
                </div>
            </div>

            <!-- Social Badge -->
            <div class="border rounded-lg p-6 text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-pink-400 to-pink-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-share-alt text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Social Butterfly</h3>
                <p class="text-sm text-gray-600 mb-3">Bagikan aplikasi ke 10 teman</p>
                <div class="text-xs text-gray-500">
                    @if($hasSocialBadge)
                        <span class="text-green-600 font-medium">✓ Diterima</span>
                    @else
                        <span class="text-yellow-600 font-medium">Belum Diterima</span>
                    @endif
                </div>
            </div>

            <!-- Completion Badge -->
            <div class="border rounded-lg p-6 text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-gray-400 to-gray-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-check-circle text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Completionist</h3>
                <p class="text-sm text-gray-600 mb-3">Selesaikan semua misi harian</p>
                <div class="text-xs text-gray-500">
                    @if($hasCompletionBadge)
                        <span class="text-green-600 font-medium">✓ Diterima</span>
                    @else
                        <span class="text-yellow-600 font-medium">Belum Diterima</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Badge Progress -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Progress Badges</h2>
        
        <div class="space-y-4">
            <div>
                <div class="flex justify-between text-sm text-gray-600 mb-1">
                    <span>Level Badges</span>
                    <span>{{ $levelBadgesEarned }}/3</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    @php
                        $levelProgress = $levelBadgesEarned / 3 * 100;
                    @endphp
                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $levelProgress }}%"></div>
                </div>
            </div>
            
            <div>
                <div class="flex justify-between text-sm text-gray-600 mb-1">
                    <span>Activity Badges</span>
                    <span>{{ $activityBadgesEarned }}/4</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    @php
                        $activityProgress = $activityBadgesEarned / 4 * 100;
                    @endphp
                    <div class="bg-green-600 h-2 rounded-full" style="width: {{ $activityProgress }}%"></div>
                </div>
            </div>
            
            <div>
                <div class="flex justify-between text-sm text-gray-600 mb-1">
                    <span>Special Badges</span>
                    <span>{{ $specialBadgesEarned }}/2</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    @php
                        $specialProgress = $specialBadgesEarned / 2 * 100;
                    @endphp
                    <div class="bg-purple-600 h-2 rounded-full" style="width: {{ $specialProgress }}%"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 