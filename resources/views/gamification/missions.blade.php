@extends('layouts.app')

@section('title', 'Misi Harian')

@section('content')
<div class="min-h-screen bg-green-50 py-2 px-1 flex flex-col items-center">
    <div class="w-full max-w-md space-y-4">
        <!-- Header -->
        <div class="mb-2">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-green-700 tracking-tight mb-1 flex items-center">
                <svg class="w-7 h-7 mr-2" fill="none" viewBox="0 0 24 24"><path d="M12 2v20M2 12h20" stroke="#22c55e" stroke-width="2" stroke-linecap="round"/></svg>
                Misi Harian
            </h1>
            <p class="text-green-500 text-sm font-medium">Selesaikan misi seru setiap hari & dapatkan XP!</p>
        </div>
        <!-- Progress Card -->
        <div class="bg-white rounded-3xl shadow-xl p-5 mb-2">
            <div class="flex items-center justify-between mb-2">
                <h2 class="text-lg font-bold text-gray-900">Progress Hari Ini</h2>
                <span class="text-xs text-gray-400">{{ now()->format('d M Y') }}</span>
            </div>
            <div class="flex items-center justify-between mb-1">
                <span class="text-gray-500 text-sm">Misi Selesai</span>
                <span class="text-gray-900 font-bold text-base">{{ $completedMissions }}/{{ $totalMissions }}</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-4 mb-2 overflow-hidden">
                @php $progressPercentage = $totalMissions > 0 ? ($completedMissions / $totalMissions) * 100 : 0; @endphp
                <div class="bg-gradient-to-r from-green-400 to-blue-400 h-4 rounded-full transition-all duration-500" style="width: {{ $progressPercentage }}%"></div>
            </div>
            <div class="flex items-center justify-between text-xs">
                <span class="text-gray-400">XP Diterima</span>
                <span class="text-green-600 font-bold text-lg">{{ $totalXpEarned }}</span>
            </div>
        </div>
        <!-- Missions List -->
        <div class="space-y-4 mb-8">
            <!-- Investment Mission -->
            <div class="bg-white rounded-3xl shadow-xl p-4 flex items-center space-x-3 relative overflow-hidden mb-4">
                <div class="relative flex-shrink-0">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-blue-200 rounded-full flex items-center justify-center shadow-lg">
                        <!-- Custom SVG icon -->
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24"><rect x="3" y="12" width="4" height="8" rx="2" fill="#fff"/><rect x="9" y="8" width="4" height="12" rx="2" fill="#fff"/><rect x="15" y="4" width="4" height="16" rx="2" fill="#fff"/></svg>
                    </div>
                    <span class="absolute -top-2 -right-2 px-2 py-0.5 rounded-full text-[10px] font-bold shadow @if($investmentMissionCompleted) bg-green-500 text-white @else bg-yellow-400 text-white @endif">
                        @if($investmentMissionCompleted) Selesai @else Belum @endif
                    </span>
                </div>
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-blue-700 font-bold text-base">Investasi Pertama</span>
                        <span class="text-xs font-bold text-green-600 flex items-center"><i class="fas fa-bolt mr-1"></i>+50 XP</span>
                    </div>
                    <span class="text-gray-500 text-xs block mb-1">Investasi pertama Anda untuk reward</span>
                    <div class="w-full bg-gray-200 rounded-full h-3 mb-1 overflow-hidden">
                        @php $progress = min(100, $investmentCount * 100); @endphp
                        <div class="bg-gradient-to-r from-blue-400 to-green-400 h-3 rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
                    </div>
                    <div class="flex items-center justify-between text-xs mb-1">
                        <span class="text-gray-400">Progress</span>
                        <span class="font-bold text-gray-700">{{ $investmentCount }}/1</span>
                    </div>
                    @if(!$investmentMissionCompleted)
                    <form action="{{ route('gamification.complete-mission') }}" method="POST" class="w-full mt-1 with-loader">
                        @csrf
                        <input type="hidden" name="mission_type" value="investment">
                        <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-green-400 text-white py-2 rounded-xl font-bold shadow hover:from-blue-600 hover:to-green-500 transition flex items-center justify-center text-base">
                            <i class="fas fa-gift mr-2"></i> Klaim Reward
                        </button>
                    </form>
                    @else
                    <div class="p-2 bg-green-100 rounded-lg w-full text-center text-green-700 font-bold flex items-center justify-center">
                        <i class="fas fa-check-circle mr-1"></i> Misi Selesai!
                    </div>
                    @endif
                </div>
            </div>
            <!-- Login Mission -->
            <div class="bg-white rounded-3xl shadow-xl p-4 flex items-center space-x-3 relative overflow-hidden mb-4">
                <div class="relative flex-shrink-0">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-400 to-green-200 rounded-full flex items-center justify-center shadow-lg">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24"><path d="M12 2v20M2 12h20" stroke="#22c55e" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <span class="absolute -top-2 -right-2 px-2 py-0.5 rounded-full text-[10px] font-bold shadow @if($loginMissionCompleted) bg-green-500 text-white @else bg-yellow-400 text-white @endif">
                        @if($loginMissionCompleted) Selesai @else Belum @endif
                    </span>
                </div>
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-green-700 font-bold text-base">Login Harian</span>
                        <span class="text-xs font-bold text-green-600 flex items-center"><i class="fas fa-bolt mr-1"></i>+10 XP</span>
                    </div>
                    <span class="text-gray-500 text-xs block mb-1">Login ke aplikasi untuk reward harian</span>
                    <div class="w-full bg-gray-200 rounded-full h-3 mb-1 overflow-hidden">
                        @php $progress = min(100, $loginCount * 100); @endphp
                        <div class="bg-gradient-to-r from-green-400 to-green-300 h-3 rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
                    </div>
                    <div class="flex items-center justify-between text-xs mb-1">
                        <span class="text-gray-400">Progress</span>
                        <span class="font-bold text-gray-700">{{ $loginCount }}/1</span>
                    </div>
                    @if(!$loginMissionCompleted)
                    <form action="{{ route('gamification.complete-mission') }}" method="POST" class="w-full mt-1 with-loader">
                        @csrf
                        <input type="hidden" name="mission_type" value="login">
                        <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-green-400 text-white py-2 rounded-xl font-bold shadow hover:from-green-600 hover:to-green-500 transition flex items-center justify-center text-base">
                            <i class="fas fa-gift mr-2"></i> Klaim Reward
                        </button>
                    </form>
                    @else
                    <div class="p-2 bg-green-100 rounded-lg w-full text-center text-green-700 font-bold flex items-center justify-center">
                        <i class="fas fa-check-circle mr-1"></i> Misi Selesai!
                    </div>
                    @endif
                </div>
            </div>
            <!-- Top-up Mission -->
            <div class="bg-white rounded-3xl shadow-xl p-4 flex items-center space-x-3 relative overflow-hidden mb-4">
                <div class="relative flex-shrink-0">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-400 to-purple-200 rounded-full flex items-center justify-center shadow-lg">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24"><path d="M12 2v20M2 12h20" stroke="#22c55e" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <span class="absolute -top-2 -right-2 px-2 py-0.5 rounded-full text-[10px] font-bold shadow @if($topupMissionCompleted) bg-green-500 text-white @else bg-yellow-400 text-white @endif">
                        @if($topupMissionCompleted) Selesai @else Belum @endif
                    </span>
                </div>
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-purple-700 font-bold text-base">Top-up Wallet</span>
                        <span class="text-xs font-bold text-green-600 flex items-center"><i class="fas fa-bolt mr-1"></i>+25 XP</span>
                    </div>
                    <span class="text-gray-500 text-xs block mb-1">Top-up wallet untuk reward</span>
                    <div class="w-full bg-gray-200 rounded-full h-3 mb-1 overflow-hidden">
                        @php $progress = min(100, $topupCount * 100); @endphp
                        <div class="bg-gradient-to-r from-purple-400 to-green-400 h-3 rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
                    </div>
                    <div class="flex items-center justify-between text-xs mb-1">
                        <span class="text-gray-400">Progress</span>
                        <span class="font-bold text-gray-700">{{ $topupCount }}/1</span>
                    </div>
                    @if(!$topupMissionCompleted)
                    <form action="{{ route('gamification.complete-mission') }}" method="POST" class="w-full mt-1 with-loader">
                        @csrf
                        <input type="hidden" name="mission_type" value="topup">
                        <button type="submit" class="w-full bg-gradient-to-r from-purple-500 to-green-400 text-white py-2 rounded-xl font-bold shadow hover:from-purple-600 hover:to-green-500 transition flex items-center justify-center text-base">
                            <i class="fas fa-gift mr-2"></i> Klaim Reward
                        </button>
                    </form>
                    @else
                    <div class="p-2 bg-green-100 rounded-lg w-full text-center text-green-700 font-bold flex items-center justify-center">
                        <i class="fas fa-check-circle mr-1"></i> Misi Selesai!
                    </div>
                    @endif
                </div>
            </div>
            <!-- Share Mission -->
            <div class="bg-white rounded-3xl shadow-xl p-4 flex items-center space-x-3 relative overflow-hidden mb-4">
                <div class="relative flex-shrink-0">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-400 to-orange-200 rounded-full flex items-center justify-center shadow-lg">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24"><path d="M12 2v20M2 12h20" stroke="#22c55e" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <span class="absolute -top-2 -right-2 px-2 py-0.5 rounded-full text-[10px] font-bold shadow @if($shareMissionCompleted) bg-green-500 text-white @else bg-yellow-400 text-white @endif">
                        @if($shareMissionCompleted) Selesai @else Belum @endif
                    </span>
                </div>
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-orange-700 font-bold text-base">Bagikan Aplikasi</span>
                        <span class="text-xs font-bold text-green-600 flex items-center"><i class="fas fa-bolt mr-1"></i>+30 XP</span>
                    </div>
                    <span class="text-gray-500 text-xs block mb-1">Bagikan NusaFarm ke teman Anda</span>
                    <div class="w-full bg-gray-200 rounded-full h-3 mb-1 overflow-hidden">
                        @php $progress = min(100, $shareCount * 100); @endphp
                        <div class="bg-gradient-to-r from-orange-400 to-green-400 h-3 rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
                    </div>
                    <div class="flex items-center justify-between text-xs mb-1">
                        <span class="text-gray-400">Progress</span>
                        <span class="font-bold text-gray-700">{{ $shareCount }}/1</span>
                    </div>
                    @if(!$shareMissionCompleted)
                    <div class="mt-2 space-y-2 w-full">
                        <button class="w-full bg-orange-500 text-white py-2 rounded-xl font-bold shadow hover:bg-orange-600 transition flex items-center justify-center text-base">
                            <i class="fab fa-whatsapp mr-2"></i> Bagikan via WhatsApp
                        </button>
                        <button class="w-full bg-blue-500 text-white py-2 rounded-xl font-bold shadow hover:bg-blue-600 transition flex items-center justify-center text-base">
                            <i class="fab fa-facebook mr-2"></i> Bagikan via Facebook
                        </button>
                    </div>
                    @else
                    <div class="p-2 bg-green-100 rounded-lg w-full text-center text-green-700 font-bold flex items-center justify-center">
                        <i class="fas fa-check-circle mr-1"></i> Misi Selesai!
                    </div>
                    @endif
                </div>
            </div>
            <!-- Profile Mission -->
            <div class="bg-white rounded-3xl shadow-xl p-4 flex items-center space-x-3 relative overflow-hidden mb-4">
                <div class="relative flex-shrink-0">
                    <div class="w-14 h-14 bg-gradient-to-br from-indigo-400 to-indigo-200 rounded-full flex items-center justify-center shadow-lg">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24"><path d="M12 2v20M2 12h20" stroke="#22c55e" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <span class="absolute -top-2 -right-2 px-2 py-0.5 rounded-full text-[10px] font-bold shadow @if($profileMissionCompleted) bg-green-500 text-white @else bg-yellow-400 text-white @endif">
                        @if($profileMissionCompleted) Selesai @else Belum @endif
                    </span>
                </div>
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-indigo-700 font-bold text-base">Lengkapi Profil</span>
                        <span class="text-xs font-bold text-green-600 flex items-center"><i class="fas fa-bolt mr-1"></i>+20 XP</span>
                    </div>
                    <span class="text-gray-500 text-xs block mb-1">Lengkapi informasi profil Anda</span>
                    <div class="w-full bg-gray-200 rounded-full h-3 mb-1 overflow-hidden">
                        @php $progress = $profileComplete ? 100 : 0; @endphp
                        <div class="bg-gradient-to-r from-indigo-400 to-green-400 h-3 rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
                    </div>
                    <div class="flex items-center justify-between text-xs mb-1">
                        <span class="text-gray-400">Progress</span>
                        <span class="font-bold text-gray-700">{{ $profileComplete ? 1 : 0 }}/1</span>
                    </div>
                    @if(!$profileMissionCompleted)
                    <a href="#" class="mt-2 block w-full bg-gradient-to-r from-indigo-500 to-green-400 text-white py-2 rounded-xl font-bold shadow hover:from-indigo-600 hover:to-green-500 transition text-center flex items-center justify-center text-base">
                        <i class="fas fa-edit mr-2"></i> Lengkapi Profil
                    </a>
                    @else
                    <div class="p-2 bg-green-100 rounded-lg w-full text-center text-green-700 font-bold flex items-center justify-center">
                        <i class="fas fa-check-circle mr-1"></i> Misi Selesai!
                    </div>
                    @endif
                </div>
            </div>
            <!-- Streak Mission -->
            <div class="bg-white rounded-3xl shadow-xl p-4 flex items-center space-x-3 relative overflow-hidden mb-4">
                <div class="relative flex-shrink-0">
                    <div class="w-14 h-14 bg-gradient-to-br from-red-400 to-red-200 rounded-full flex items-center justify-center shadow-lg">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24"><path d="M12 2v20M2 12h20" stroke="#22c55e" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <span class="absolute -top-2 -right-2 px-2 py-0.5 rounded-full text-[10px] font-bold shadow @if($streakMissionCompleted) bg-green-500 text-white @else bg-yellow-400 text-white @endif">
                        @if($streakMissionCompleted) Selesai @else Belum @endif
                    </span>
                </div>
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-red-700 font-bold text-base">Login Streak</span>
                        <span class="text-xs font-bold text-green-600 flex items-center"><i class="fas fa-bolt mr-1"></i>+100 XP</span>
                    </div>
                    <span class="text-gray-500 text-xs block mb-1">Login 3 hari berturut-turut</span>
                    <div class="w-full bg-gray-200 rounded-full h-3 mb-1 overflow-hidden">
                        @php $progress = min(100, ($loginStreak/3)*100); @endphp
                        <div class="bg-gradient-to-r from-red-400 to-green-400 h-3 rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
                    </div>
                    <div class="flex items-center justify-between text-xs mb-1">
                        <span class="text-gray-400">Progress</span>
                        <span class="font-bold text-gray-700">{{ $loginStreak }}/3</span>
                    </div>
                    @if(!$streakMissionCompleted)
                    <div class="p-2 bg-yellow-100 rounded-lg w-full text-center text-yellow-700 font-bold flex items-center justify-center">
                        <i class="fas fa-clock mr-1"></i> Sedang Berlangsung
                    </div>
                    @else
                    <div class="p-2 bg-green-100 rounded-lg w-full text-center text-green-700 font-bold flex items-center justify-center">
                        <i class="fas fa-check-circle mr-1"></i> Misi Selesai!
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- Weekly Challenges -->
        <div class="bg-white rounded-3xl shadow-xl p-5 mt-8">
            <h2 class="text-lg font-bold text-purple-700 mb-3 flex items-center"><i class="fas fa-trophy mr-2"></i> Tantangan Mingguan</h2>
            <div class="grid grid-cols-1 gap-4">
                <div class="bg-purple-50 rounded-xl p-4 flex flex-col mb-2">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-bold text-purple-700">Investasi Terbesar</span>
                        <span class="text-xs text-gray-500">Minggu Ini</span>
                    </div>
                    <span class="text-gray-500 text-xs mb-2">Lakukan investasi terbesar minggu ini</span>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-gray-400">Reward</span>
                        <span class="font-bold text-green-600">+200 XP</span>
                    </div>
                </div>
                <div class="bg-purple-50 rounded-xl p-4 flex flex-col">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-bold text-purple-700">Aktivitas Terbanyak</span>
                        <span class="text-xs text-gray-500">Minggu Ini</span>
                    </div>
                    <span class="text-gray-500 text-xs mb-2">Lakukan aktivitas terbanyak minggu ini</span>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-gray-400">Reward</span>
                        <span class="font-bold text-green-600">+150 XP</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 