@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-green-100 to-green-200 py-4 px-2 flex flex-col items-center pb-24">
        <div class="w-full max-w-5xl px-3 sm:px-6 space-y-5 md:space-y-6">
            <!-- Greeting & Level -->
            <div class="bg-gradient-to-r from-green-400 to-green-600 rounded-2xl shadow-lg p-4 md:p-6 text-white relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-base sm:text-lg font-semibold mb-1 line-clamp-1"><span id="greeting-text">Halo</span>, {{ auth()->user()->name }}! <i class="fas fa-user"></i></div>
                        <div class="text-[11px] sm:text-xs opacity-80">Level {{ auth()->user()->level }} Investor <span class="ml-2 text-yellow-200 font-bold">#{{ auth()->user()->id }}</span></div>
                    </div>
                    <div class="flex flex-col items-center">
                        <span class="text-[11px] sm:text-xs">Level</span>
                        <span class="text-2xl sm:text-3xl font-extrabold leading-none">{{ auth()->user()->level }}</span>
                    </div>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        try {
                            var hour = new Date().getHours();
                            var greet = 'Halo';
                            if (hour >= 5 && hour < 11) greet = 'Selamat pagi';
                            else if (hour >= 11 && hour < 15) greet = 'Selamat siang';
                            else if (hour >= 15 && hour < 18) greet = 'Selamat sore';
                            else greet = 'Selamat malam';
                            var el = document.getElementById('greeting-text');
                            if (el) el.textContent = greet;
                        } catch (e) {}
                    });
                </script>
                <div class="mt-4">
                    @php
                        $currentLevelXp = (auth()->user()->level - 1) * 100;
                        $nextLevelXp = auth()->user()->level * 100;
                        $xpProgress = auth()->user()->xp - $currentLevelXp;
                        $xpNeeded = $nextLevelXp - $currentLevelXp;
                        $progressPercentage = ($xpProgress / $xpNeeded) * 100;
                    @endphp
                    <div class="flex items-center justify-between text-[11px] sm:text-xs mb-1">
                        <span>Level {{ auth()->user()->level }}</span>
                        <span>{{ auth()->user()->xp }}/{{ $nextLevelXp }} XP</span>
                    </div>
                    <div class="w-full bg-white/30 rounded-full h-2.5">
                        <div class="bg-yellow-300 h-2.5 rounded-full transition-all duration-300"
                            style="width: {{ $progressPercentage }}%"></div>
                    </div>
                    <div class="flex items-center justify-between mt-1">
                        <span class="text-[11px] sm:text-xs text-yellow-100">{{ $nextLevelXp - auth()->user()->xp }} XP to Level
                            {{ auth()->user()->level + 1 }}</span>
                        <span class="flex items-center text-[11px] sm:text-xs text-yellow-100 font-bold"><i class="fas fa-star text-yellow-300 mr-1"></i> {{ auth()->user()->xp }} XP</span>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 md:gap-4">
                <div class="bg-white rounded-xl shadow p-3 md:p-4 flex flex-col items-center">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mb-2">
                        <i class="fas fa-wallet text-green-600 text-xl"></i>
                    </div>
                    <div class="text-[11px] sm:text-xs text-gray-500">Wallet</div>
                    <div class="text-base sm:text-lg font-bold text-gray-900">Rp {{ number_format(auth()->user()->wallet_balance) }}
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow p-3 md:p-4 flex flex-col items-center">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mb-2">
                        <i class="fas fa-chart-line text-blue-600 text-xl"></i>
                    </div>
                    <div class="text-[11px] sm:text-xs text-gray-500">Total Investasi</div>
                    <div class="text-base sm:text-lg font-bold text-gray-900">Rp
                        {{ number_format(auth()->user()->investments()->where('status', 'confirmed')->sum('amount')) }}
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow p-3 md:p-4 flex flex-col items-center">
                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mb-2">
                        <i class="fas fa-star text-purple-600 text-xl"></i>
                    </div>
                    <div class="text-[11px] sm:text-xs text-gray-500">XP</div>
                    <div class="text-base sm:text-lg font-bold text-gray-900">{{ auth()->user()->xp }}</div>
                </div>
                <div class="bg-white rounded-xl shadow p-3 md:p-4 flex flex-col items-center">
                    <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center mb-2">
                        <i class="fas fa-trophy text-orange-600 text-xl"></i>
                    </div>
                    <div class="text-[11px] sm:text-xs text-gray-500">Level</div>
                    <div class="text-base sm:text-lg font-bold text-gray-900">{{ auth()->user()->level }}</div>
                </div>
            </div>

            <!-- Missions/Quests Card -->
            <div class="bg-purple-50 rounded-xl shadow p-3 md:p-4">
                <div class="flex items-center justify-between mb-1.5 md:mb-2">
                    <div class="font-semibold text-purple-700 text-sm sm:text-base flex items-center"><i class="fas fa-tasks mr-2"></i> Complete a Quest to earn <span class="ml-1 font-bold">+10 XP!</span></div>
                    <a href="{{ route('gamification.missions') }}" class="text-purple-600 text-xs font-bold hover:underline">View Quests</a>
                </div>
                <div class="text-[11px] sm:text-xs text-purple-500">Level up to unlock premium features</div>
            </div>

            <!-- Portfolio Overview -->
            <div class="bg-white rounded-xl shadow p-4">
                <div class="flex items-center justify-between mb-1.5 md:mb-2">
                    <div class="font-semibold text-green-700 text-sm sm:text-base flex items-center"><i class="fas fa-briefcase mr-2"></i> Portfolio Overview</div>
                    <span class="text-[11px] sm:text-xs text-green-500 font-bold">+5% this month</span>
                </div>
                <div class="grid grid-cols-2 gap-3 md:gap-4 mt-1.5">
                    <div class="bg-green-50 rounded-lg p-3 flex flex-col items-center">
                        <div class="text-[11px] sm:text-xs text-gray-500">Total Portfolio Value</div>
                        <div class="text-base sm:text-lg font-bold text-green-700">Rp
                            {{ number_format(auth()->user()->investments()->where('status', 'confirmed')->sum('amount')) }}
                        </div>
                    </div>
                    <div class="bg-green-50 rounded-lg p-3 flex flex-col items-center">
                        <div class="text-[11px] sm:text-xs text-gray-500">Active Farm Units</div>
                        <div class="text-base sm:text-lg font-bold text-green-700">4</div>
                    </div>
                </div>
                <div class="flex justify-between text-[11px] sm:text-xs text-gray-500 mt-1.5">
                    <span>Earnings: <span class="text-green-600 font-bold">Rp 3.240</span></span>
                    <span>Harvest: <span class="text-green-600 font-bold">12</span></span>
                </div>
            </div>

            <!-- Minigame: Water Plant -->
            <div class="bg-green-50 rounded-xl shadow p-3 md:p-4 flex flex-col items-center mb-2">
                <div class="flex items-center space-x-3 mb-1.5">
                    <div id="plant-anim"
                        class="w-14 h-14 md:w-16 md:h-16 bg-green-200 rounded-full flex items-center justify-center shadow relative overflow-hidden transition-transform duration-300">
                        <!-- SVG Plant -->
                        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 md:w-12 md:h-12">
                            <ellipse cx="24" cy="40" rx="12" ry="4" fill="#A7F3D0" />
                            <path d="M24 40V20" stroke="#059669" stroke-width="3" stroke-linecap="round" />
                            <path d="M24 20C24 12 34 10 38 18" stroke="#34D399" stroke-width="3" stroke-linecap="round" />
                            <path d="M24 20C24 12 14 10 10 18" stroke="#34D399" stroke-width="3" stroke-linecap="round" />
                            <circle cx="24" cy="18" r="3" fill="#34D399" />
                        </svg>
                        <!-- Water drop anim -->
                        <div id="water-drop"
                            class="absolute left-1/2 top-2 -translate-x-1/2 opacity-0 transition-all duration-500">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M9 2C9 2 3 8.5 3 12C3 15.0376 5.46243 17 9 17C12.5376 17 15 15.0376 15 12C15 8.5 9 2 9 2Z"
                                    fill="#38BDF8" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-bold text-green-700 text-sm md:text-base">Minigame: Siram Tanaman</span>
                        <span class="text-[11px] sm:text-xs text-gray-500">Dapatkan XP setiap menyiram!</span>
                    </div>
                </div>
                @php
                    $last = auth()->user()->last_watered_at;
                    $now = now();
                    $cooldown = 5 * 60; // 5 menit
                    $canWater = !$last || $now->diffInSeconds($last) >= $cooldown;
                    $wait = $canWater ? 0 : $cooldown - $now->diffInSeconds($last);
                @endphp
                <form method="POST" action="{{ route('gamification.water-plant') }}" class="w-full flex flex-col items-center" id="water-form">
                    @csrf
                    <button type="submit" id="water-btn"
                        class="w-full bg-blue-500 text-white rounded-lg py-3 font-bold shadow-lg hover:bg-blue-600 transition text-sm md:text-base disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center space-x-2"
                        @if (!$canWater) disabled @endif>
                        <i class="fas fa-tint mr-2 animate-bounce" id="water-icon"></i>
                        <span id="water-btn-text">
                            @if ($canWater)
                                Siram Tanaman
                            @else
                                Tunggu (<span id="cooldown-timer">{{ gmdate('i:s', $wait) }}</span>)
                            @endif
                        </span>
                    </button>
                </form>
                <div class="text-[11px] sm:text-xs text-gray-400 mt-2">Reward: <span class="text-green-600 font-bold">+5 XP</span> setiap
                    5 menit</div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var canWater = @json($canWater);
                    var wait = @json($wait);
                    if (!canWater) {
                        var timer = wait;
                        var timerEl = document.getElementById('cooldown-timer');
                        var btn = document.getElementById('water-btn');
                        var btnText = document.getElementById('water-btn-text');
                        var interval = setInterval(function() {
                            if (timer > 0) {
                                timer--;
                                var min = String(Math.floor(timer / 60)).padStart(2, '0');
                                var sec = String(timer % 60).padStart(2, '0');
                                timerEl.textContent = min + ':' + sec;
                            }
                            if (timer <= 0) {
                                clearInterval(interval);
                                btn.disabled = false;
                                btn.classList.remove('opacity-50', 'cursor-not-allowed');
                                btnText.textContent = 'Siram Tanaman';
                            }
                        }, 1000);
                    }
                    // Animasi air saat submit
                    var form = document.getElementById('water-form');
                    form && form.addEventListener('submit', function(e) {
                        var drop = document.getElementById('water-drop');
                        drop.classList.remove('opacity-0');
                        drop.classList.add('opacity-100');
                        drop.style.top = '32px';
                        setTimeout(function() {
                            drop.classList.add('opacity-0');
                            drop.classList.remove('opacity-100');
                            drop.style.top = '8px';
                        }, 700);
                    });
                });
            </script>

            <!-- Minigame: Collect Sunlight -->
            <div class="bg-yellow-50 rounded-xl shadow p-3 md:p-4 flex flex-col items-center mb-4">
                <div class="flex items-center space-x-3 mb-1.5">
                    <div id="sun-anim"
                        class="w-14 h-14 md:w-16 md:h-16 bg-yellow-200 rounded-full flex items-center justify-center shadow relative overflow-hidden">
                        <!-- Sun icon -->
                        <svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 md:w-12 md:h-12">
                            <circle cx="24" cy="24" r="10" fill="#FBBF24"></circle>
                            <g stroke="#F59E0B" stroke-width="3" stroke-linecap="round">
                                <line x1="24" y1="3" x2="24" y2="11" />
                                <line x1="24" y1="37" x2="24" y2="45" />
                                <line x1="3" y1="24" x2="11" y2="24" />
                                <line x1="37" y1="24" x2="45" y2="24" />
                                <line x1="8" y1="8" x2="13" y2="13" />
                                <line x1="35" y1="35" x2="40" y2="40" />
                                <line x1="8" y1="40" x2="13" y2="35" />
                                <line x1="35" y1="13" x2="40" y2="8" />
                            </g>
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-bold text-yellow-700 text-sm md:text-base">Minigame: Kumpulkan Sinar</span>
                        <span class="text-[11px] sm:text-xs text-gray-500">Ambil sinar matahari untuk +3 XP!</span>
                    </div>
                </div>
                @php
                    $cacheKey = 'user:' . auth()->id() . ':last_sunlight';
                    $lastSun = \Illuminate\Support\Facades\Cache::get($cacheKey);
                    $now = now();
                    $sunCooldown = 3 * 60; // 3 menit
                    $canCollectSun = !$lastSun || $now->diffInSeconds($lastSun) >= $sunCooldown;
                    $sunWait = $canCollectSun ? 0 : $sunCooldown - $now->diffInSeconds($lastSun);
                @endphp
                <form method="POST" action="{{ route('gamification.collect-sunlight') }}" class="w-full flex flex-col items-center" id="sun-form">
                    @csrf
                    <button type="submit" id="sun-btn"
                        class="w-full bg-yellow-500 text-white rounded-lg py-3 font-bold shadow-lg hover:bg-yellow-600 transition text-sm md:text-base disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center space-x-2"
                        @if(!$canCollectSun) disabled @endif>
                        <i class="fas fa-sun mr-2" id="sun-icon"></i>
                        <span id="sun-btn-text">
                            @if ($canCollectSun)
                                Kumpulkan Sinar
                            @else
                                Tunggu (<span id="sun-cooldown">{{ gmdate('i:s', $sunWait) }}</span>)
                            @endif
                        </span>
                    </button>
                </form>
                <div class="text-[11px] sm:text-xs text-gray-400 mt-2">Reward: <span class="text-yellow-700 font-bold">+3 XP</span> setiap 3 menit</div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var sunCan = @json($canCollectSun);
                    var sunWait = @json($sunWait);
                    if (!sunCan) {
                        var t = sunWait;
                        var el = document.getElementById('sun-cooldown');
                        var btn = document.getElementById('sun-btn');
                        var txt = document.getElementById('sun-btn-text');
                        var iv = setInterval(function() {
                            if (t > 0) {
                                t--;
                                var m = String(Math.floor(t / 60)).padStart(2, '0');
                                var s = String(t % 60).padStart(2, '0');
                                el.textContent = m + ':' + s;
                            }
                            if (t <= 0) {
                                clearInterval(iv);
                                btn.disabled = false;
                                btn.classList.remove('opacity-50', 'cursor-not-allowed');
                                txt.textContent = 'Kumpulkan Sinar';
                            }
                        }, 1000);
                    }
                    // Simple pulse anim on click
                    var sform = document.getElementById('sun-form');
                    sform && sform.addEventListener('submit', function() {
                        var sun = document.getElementById('sun-anim');
                        sun.classList.add('scale-110');
                        setTimeout(function(){ sun.classList.remove('scale-110'); }, 400);
                    });
                });
            </script>

            <!-- Quick Actions -->
            <div class="grid grid-cols-2 gap-3 md:gap-4">
                <a href="{{ route('wallet.topup') }}"
                    class="bg-green-500 text-white rounded-xl shadow flex flex-col items-center py-3 md:py-4 hover:bg-green-600 transition">
                    <i class="fas fa-plus text-xl md:text-2xl mb-1"></i>
                    <span class="font-bold text-sm md:text-base">Top Up</span>
                </a>
                <a href="{{ route('investments.create', 1) }}"
                    class="bg-blue-500 text-white rounded-xl shadow flex flex-col items-center py-3 md:py-4 hover:bg-blue-600 transition">
                    <i class="fas fa-chart-line text-xl md:text-2xl mb-1"></i>
                    <span class="font-bold text-sm md:text-base">Investasi</span>
                </a>
            </div>

            <!-- Featured Opportunities -->
            <div class="bg-yellow-50 rounded-xl shadow p-3 md:p-4">
                <div class="flex items-center justify-between mb-1.5 md:mb-2">
                    <div class="font-semibold text-yellow-700 text-sm sm:text-base flex items-center"><i class="fas fa-seedling mr-2"></i> Featured Opportunities</div>
                    <a href="{{ route('projects.index') }}" class="text-yellow-600 text-xs font-bold hover:underline">Browse All</a>
                </div>
                <div class="space-y-2.5 md:space-y-3">
                    @foreach (\App\Models\Project::with(['farmland', 'manager'])->where(function($q){$q->where('status','active')->orWhere('status','planning');})->limit(3)->get() as $project)
                        <a href="{{ route('projects.show', $project->farmland) }}" class="bg-white rounded-lg p-3 flex items-center justify-between shadow-sm hover:shadow transition">
                            <div class="flex items-center space-x-3 min-w-0">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-seedling text-green-600"></i>
                                </div>
                                <div class="min-w-0">
                                    <div class="font-semibold text-gray-900 text-sm sm:text-base truncate">{{ $project->title }}</div>
                                    <div class="text-[11px] sm:text-xs text-gray-500 truncate">{{ $project->farmland->location }} • {{ $project->start_date->diffInMonths($project->end_date) }} months</div>
                                </div>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <div class="inline-flex items-center px-2 py-0.5 rounded-full bg-green-50 text-green-700 text-[10px] sm:text-xs font-semibold">{{ $project->expected_roi }}% ROI</div>
                                <div class="text-[10px] sm:text-xs text-gray-400 mt-1">Min. invest: Rp {{ number_format(optional($project->farmland)->minimum_investment_amount ?? 0) }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="bg-white rounded-xl shadow p-3 md:p-4">
                <div class="font-semibold text-gray-900 text-sm sm:text-base mb-2 flex items-center"><i class="fas fa-history mr-2"></i> Recent Activities</div>
                <div class="space-y-2.5 md:space-y-3">
                    @foreach (auth()->user()->walletTransactions()->latest()->limit(5)->get() as $transaction)
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-7 h-7 md:w-8 md:h-8 rounded-full flex items-center justify-center
                        @if ($transaction->type == 'topup') bg-green-100 @elseif($transaction->type == 'investment') bg-blue-100 @else bg-gray-100 @endif">
                                <i
                                    class="fas @if ($transaction->type == 'topup') fa-plus @elseif($transaction->type == 'investment') fa-chart-line @else fa-minus @endif
                            @if ($transaction->type == 'topup') text-green-600 @elseif($transaction->type == 'investment') text-blue-600 @else text-gray-600 @endif text-[11px] md:text-sm"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm md:text-base font-medium text-gray-900 truncate">{{ $transaction->description }}</p>
                                <p class="text-[11px] sm:text-xs text-gray-500 truncate">{{ $transaction->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="text-right whitespace-nowrap">
                                <p class="text-sm font-semibold @if ($transaction->amount > 0) text-green-600 @else text-red-600 @endif">
                                    @if ($transaction->amount > 0)
                                        +
                                    @endif Rp {{ number_format(abs($transaction->amount)) }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Bottom Navigation (Mobile) -->
            <div class="fixed bottom-0 left-0 right-0 z-50 bg-white border-t shadow-lg flex justify-around py-2 md:hidden">
                <a href="{{ route('dashboard') }}" class="flex flex-col items-center text-green-600 font-bold">
                    <i class="fas fa-home text-xl"></i>
                    <span class="text-xs">Home</span>
                </a>
                <a href="{{ route('projects.index') }}"
                    class="flex flex-col items-center text-gray-500 hover:text-green-600">
                    <i class="fas fa-seedling text-xl"></i>
                    <span class="text-xs">Browse</span>
                </a>
                <a href="{{ route('gamification.missions') }}"
                    class="flex flex-col items-center text-gray-500 hover:text-green-600">
                    <i class="fas fa-tasks text-xl"></i>
                    <span class="text-xs">Quests</span>
                </a>
                <a href="{{ route('wallet.index') }}"
                    class="flex flex-col items-center text-gray-500 hover:text-green-600">
                    <i class="fas fa-wallet text-xl"></i>
                    <span class="text-xs">Wallet</span>
                </a>
            </div>
        </div>
    </div>
@endsection

