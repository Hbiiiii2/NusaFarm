<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'NusaFarm') - Platform Investasi Pertanian</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom Styles -->
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .progress-bar {
            background: linear-gradient(90deg, #10B981 0%, #059669 100%);
        }
    </style>

    @stack('styles')
</head>

<body class="min-h-screen w-full bg-gradient-to-br from-green-100 to-green-200">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        @if(auth()->check())
                            @if(auth()->user()->role === 'petani')
                                <a href="{{ route('petani.dashboard') }}" class="flex items-center">
                                    <i class="fas fa-seedling text-green-600 text-2xl mr-2"></i>
                                    <span class="text-xl font-bold text-gray-900">NusaFarm</span>
                                </a>
                            @elseif(auth()->user()->role === 'manajer_lapangan')
                                <a href="{{ route('manajer.dashboard') }}" class="flex items-center">
                                    <i class="fas fa-seedling text-green-600 text-2xl mr-2"></i>
                                    <span class="text-xl font-bold text-gray-900">NusaFarm</span>
                                </a>
                            @elseif(auth()->user()->role === 'logistik')
                                <a href="{{ route('logistik.dashboard') }}" class="flex items-center">
                                    <i class="fas fa-seedling text-green-600 text-2xl mr-2"></i>
                                    <span class="text-xl font-bold text-gray-900">NusaFarm</span>
                                </a>
                            @elseif(auth()->user()->role === 'penyedia_pupuk')
                                <a href="{{ route('pupuk.dashboard') }}" class="flex items-center">
                                    <i class="fas fa-seedling text-green-600 text-2xl mr-2"></i>
                                    <span class="text-xl font-bold text-gray-900">NusaFarm</span>
                                </a>
                            @elseif(auth()->user()->role === 'pedagang_pasar')
                                <a href="{{ route('pedagang.dashboard') }}" class="flex items-center">
                                    <i class="fas fa-seedling text-green-600 text-2xl mr-2"></i>
                                    <span class="text-xl font-bold text-gray-900">NusaFarm</span>
                                </a>
                            @elseif(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                                    <i class="fas fa-seedling text-green-600 text-2xl mr-2"></i>
                                    <span class="text-xl font-bold text-gray-900">NusaFarm</span>
                                </a>
                            @elseif(auth()->user()->role === 'landlord')
                                <a href="{{ route('landlord.dashboard') }}" class="flex items-center">
                                    <i class="fas fa-seedling text-green-600 text-2xl mr-2"></i>
                                    <span class="text-xl font-bold text-gray-900">NusaFarm</span>
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}" class="flex items-center">
                                    <i class="fas fa-seedling text-green-600 text-2xl mr-2"></i>
                                    <span class="text-xl font-bold text-gray-900">NusaFarm</span>
                                </a>
                            @endif
                        @else
                            <a href="{{ route('dashboard') }}" class="flex items-center">
                                <i class="fas fa-seedling text-green-600 text-2xl mr-2"></i>
                                <span class="text-xl font-bold text-gray-900">NusaFarm</span>
                            </a>
                        @endif
                    </div>
                </div>
                @if (auth()->check())
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <a href="{{ route('notifications.index') }}"
                            class="relative p-2 text-gray-600 hover:text-gray-900">
                            <i class="fas fa-bell text-lg"></i>
                            @if (auth()->user()->notifications()->unread()->count() > 0)
                                <span
                                    class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                    {{ auth()->user()->notifications()->unread()->count() }}
                                </span>
                            @endif
                        </a>
                        <!-- User Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="flex items-center space-x-2 text-gray-700 hover:text-gray-900">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                    <span
                                        class="text-white font-semibold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                                <span class="hidden md:block">{{ auth()->user()->name }}</span>
                                <i class="fas fa-chevron-down text-sm"></i>
                            </button>
                            <!-- Dropdown Menu -->
                            <div x-show="open" @click.away="open = false"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                @if(auth()->user()->role === 'petani')
                                    <a href="{{ route('petani.dashboard') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-home mr-2"></i> Dashboard
                                    </a>
                                    <a href="{{ route('petani.daily-reports') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-clipboard-list mr-2"></i> Laporan Harian
                                    </a>
                                    <a href="{{ route('petani.supply-requests') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-boxes mr-2"></i> Permintaan Barang
                                    </a>
                                    <a href="{{ route('petani.chat') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-comments mr-2"></i> Chat
                                    </a>
                                @elseif(auth()->user()->role === 'manajer_lapangan')
                                    <a href="{{ route('manajer.dashboard') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-home mr-2"></i> Dashboard
                                    </a>
                                    <a href="{{ route('manajer.farmlands') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-map-marker-alt mr-2"></i> Kelola Lahan
                                    </a>
                                    <a href="{{ route('manajer.reports') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-chart-bar mr-2"></i> Laporan
                                    </a>
                                    <a href="{{ route('manajer.supply-requests') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-boxes mr-2"></i> Permintaan Barang
                                    </a>
                                    <a href="{{ route('manajer.chat') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-comments mr-2"></i> Chat
                                    </a>
                                @elseif(auth()->user()->role === 'logistik')
                                    <a href="{{ route('logistik.dashboard') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-home mr-2"></i> Dashboard
                                    </a>
                                    <a href="{{ route('logistik.deliveries') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-truck mr-2"></i> Pengiriman
                                    </a>
                                    <a href="{{ route('logistik.chat') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-comments mr-2"></i> Chat
                                    </a>
                                @elseif(auth()->user()->role === 'penyedia_pupuk')
                                    <a href="{{ route('pupuk.dashboard') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-home mr-2"></i> Dashboard
                                    </a>
                                    <a href="{{ route('pupuk.orders') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-seedling mr-2"></i> Pesanan Pupuk
                                    </a>
                                    <a href="{{ route('pupuk.chat') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-comments mr-2"></i> Chat
                                    </a>
                                @elseif(auth()->user()->role === 'pedagang_pasar')
                                    <a href="{{ route('pedagang.dashboard') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-home mr-2"></i> Dashboard
                                    </a>
                                    <a href="{{ route('pedagang.orders') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-store mr-2"></i> Pesanan Pasar
                                    </a>
                                    <a href="{{ route('pedagang.chat') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-comments mr-2"></i> Chat
                                    </a>
                                @elseif(auth()->user()->role === 'landlord')
                                    <a href="{{ route('landlord.dashboard') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-home mr-2"></i> Dashboard
                                    </a>
                                    <a href="{{ route('landlord.farmlands') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-map-marker-alt mr-2"></i> Kelola Lahan
                                    </a>
                                    <a href="{{ route('landlord.progress-reports') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-chart-line mr-2"></i> Progress Pertanian
                                    </a>
                                    <a href="{{ route('landlord.collaboration-history') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-handshake mr-2"></i> Riwayat Kerjasama
                                    </a>
                                    <a href="{{ route('landlord.documents') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-file-alt mr-2"></i> Dokumen
                                    </a>
                                    <a href="{{ route('landlord.chat') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-comments mr-2"></i> Chat
                                    </a>
                                @elseif(auth()->user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-home mr-2"></i> Dashboard
                                    </a>
                                    <a href="{{ route('admin.users') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-users mr-2"></i> Users
                                    </a>
                                    <a href="{{ route('admin.projects') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-project-diagram mr-2"></i> Projects
                                    </a>
                                    <a href="{{ route('admin.reports') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-chart-bar mr-2"></i> Reports
                                    </a>
                                @else
                                    <a href="{{ route('dashboard') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-home mr-2"></i> Dashboard
                                    </a>
                                    <a href="{{ route('wallet.index') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-wallet mr-2"></i> Wallet
                                    </a>
                                    <a href="{{ route('investments.portfolio') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-chart-pie mr-2"></i> Portfolio
                                    </a>
                                @endif
                                <div class="border-t border-gray-100"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </nav>
    <!-- Main Content -->
    <div class="flex w-full">
        <!-- Content Area (tanpa sidebar) -->
        <div class="flex-1 p-0 w-full pb-20 md:pb-0"> <!-- Tambah pb-20 agar tidak tertutup bottom nav -->
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif
            @yield('content')
        </div>
        
        <!-- Bottom Navigation based on role -->
        @if(auth()->check())
            @if(auth()->user()->role === 'petani')
                <div class="fixed bottom-0 left-0 right-0 z-50 bg-white border-t shadow-lg flex justify-around py-2 md:hidden">
                    <a href="{{ route('petani.dashboard') }}" class="flex flex-col items-center {{ request()->routeIs('petani.dashboard') ? 'text-green-600 font-bold' : 'text-gray-500' }}">
                        <i class="fas fa-home text-xl"></i>
                        <span class="text-xs">Dashboard</span>
                    </a>
                    <a href="{{ route('petani.daily-reports') }}" class="flex flex-col items-center {{ request()->routeIs('petani.daily-reports*') ? 'text-green-600 font-bold' : 'text-gray-500' }}">
                        <i class="fas fa-clipboard-list text-xl"></i>
                        <span class="text-xs">Laporan</span>
                    </a>
                    <a href="{{ route('petani.supply-requests') }}" class="flex flex-col items-center {{ request()->routeIs('petani.supply-requests*') ? 'text-green-600 font-bold' : 'text-gray-500' }}">
                        <i class="fas fa-boxes text-xl"></i>
                        <span class="text-xs">Permintaan</span>
                    </a>
                    <a href="{{ route('petani.chat') }}" class="flex flex-col items-center {{ request()->routeIs('petani.chat*') ? 'text-green-600 font-bold' : 'text-gray-500' }}">
                        <i class="fas fa-comments text-xl"></i>
                        <span class="text-xs">Chat</span>
                    </a>
                </div>
            @elseif(auth()->user()->role === 'manajer_lapangan')
                <div class="fixed bottom-0 left-0 right-0 z-50 bg-white border-t shadow-lg flex justify-around py-2 md:hidden">
                    <a href="{{ route('manajer.dashboard') }}" class="flex flex-col items-center {{ request()->routeIs('manajer.dashboard') ? 'text-green-600 font-bold' : 'text-gray-500' }}">
                        <i class="fas fa-home text-xl"></i>
                        <span class="text-xs">Dashboard</span>
                    </a>
                    <a href="{{ route('manajer.farmlands') }}" class="flex flex-col items-center {{ request()->routeIs('manajer.farmlands*') ? 'text-green-600 font-bold' : 'text-gray-500' }}">
                        <i class="fas fa-map-marker-alt text-xl"></i>
                        <span class="text-xs">Lahan</span>
                    </a>
                    <a href="{{ route('manajer.reports') }}" class="flex flex-col items-center {{ request()->routeIs('manajer.reports*') ? 'text-green-600 font-bold' : 'text-gray-500' }}">
                        <i class="fas fa-chart-bar text-xl"></i>
                        <span class="text-xs">Laporan</span>
                    </a>
                    <a href="{{ route('manajer.chat') }}" class="flex flex-col items-center {{ request()->routeIs('manajer.chat*') ? 'text-green-600 font-bold' : 'text-gray-500' }}">
                        <i class="fas fa-comments text-xl"></i>
                        <span class="text-xs">Chat</span>
                    </a>
                </div>
            @elseif(auth()->user()->role === 'logistik')
                <div class="fixed bottom-0 left-0 right-0 z-50 bg-white border-t shadow-lg flex justify-around py-2 md:hidden">
                    <a href="{{ route('logistik.dashboard') }}" class="flex flex-col items-center {{ request()->routeIs('logistik.dashboard') ? 'text-green-600 font-bold' : 'text-gray-500' }}">
                        <i class="fas fa-home text-xl"></i>
                        <span class="text-xs">Dashboard</span>
                    </a>
                    <a href="{{ route('logistik.deliveries') }}" class="flex flex-col items-center {{ request()->routeIs('logistik.deliveries*') ? 'text-green-600 font-bold' : 'text-gray-500' }}">
                        <i class="fas fa-truck text-xl"></i>
                        <span class="text-xs">Pengiriman</span>
                    </a>
                    <a href="{{ route('logistik.chat') }}" class="flex flex-col items-center {{ request()->routeIs('logistik.chat*') ? 'text-green-600 font-bold' : 'text-gray-500' }}">
                        <i class="fas fa-comments text-xl"></i>
                        <span class="text-xs">Chat</span>
                    </a>
                </div>
            @elseif(auth()->user()->role === 'penyedia_pupuk')
                <div class="fixed bottom-0 left-0 right-0 z-50 bg-white border-t shadow-lg flex justify-around py-2 md:hidden">
                    <a href="{{ route('pupuk.dashboard') }}" class="flex flex-col items-center {{ request()->routeIs('pupuk.dashboard') ? 'text-green-600 font-bold' : 'text-gray-500' }}">
                        <i class="fas fa-home text-xl"></i>
                        <span class="text-xs">Dashboard</span>
                    </a>
                    <a href="{{ route('pupuk.orders') }}" class="flex flex-col items-center {{ request()->routeIs('pupuk.orders*') ? 'text-green-600 font-bold' : 'text-gray-500' }}">
                        <i class="fas fa-seedling text-xl"></i>
                        <span class="text-xs">Pesanan</span>
                    </a>
                    <a href="{{ route('pupuk.chat') }}" class="flex flex-col items-center {{ request()->routeIs('pupuk.chat*') ? 'text-green-600 font-bold' : 'text-gray-500' }}">
                        <i class="fas fa-comments text-xl"></i>
                        <span class="text-xs">Chat</span>
                    </a>
                </div>
            @elseif(auth()->user()->role === 'pedagang_pasar')
                <div class="fixed bottom-0 left-0 right-0 z-50 bg-white border-t shadow-lg flex justify-around py-2 md:hidden">
                    <a href="{{ route('pedagang.dashboard') }}" class="flex flex-col items-center {{ request()->routeIs('pedagang.dashboard') ? 'text-green-600 font-bold' : 'text-gray-500' }}">
                        <i class="fas fa-home text-xl"></i>
                        <span class="text-xs">Dashboard</span>
                    </a>
                    <a href="{{ route('pedagang.orders') }}" class="flex flex-col items-center {{ request()->routeIs('pedagang.orders*') ? 'text-green-600 font-bold' : 'text-gray-500' }}">
                        <i class="fas fa-store text-xl"></i>
                        <span class="text-xs">Pesanan</span>
                    </a>
                    <a href="{{ route('pedagang.chat') }}" class="flex flex-col items-center {{ request()->routeIs('pedagang.chat*') ? 'text-green-600 font-bold' : 'text-gray-500' }}">
                        <i class="fas fa-comments text-xl"></i>
                        <span class="text-xs">Chat</span>
                    </a>
                </div>
            @elseif(auth()->user()->role === 'admin')
                <div class="fixed bottom-0 left-0 right-0 z-50 bg-white border-t shadow-lg flex justify-around py-2 md:hidden">
                    <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center {{ request()->routeIs('admin.dashboard') ? 'text-green-600 font-bold' : 'text-gray-500' }}">
                        <i class="fas fa-home text-xl"></i>
                        <span class="text-xs">Dashboard</span>
                    </a>
                    <a href="{{ route('admin.users') }}" class="flex flex-col items-center {{ request()->routeIs('admin.users*') ? 'text-green-600 font-bold' : 'text-gray-500' }}">
                        <i class="fas fa-users text-xl"></i>
                        <span class="text-xs">Users</span>
                    </a>
                    <a href="{{ route('admin.projects') }}" class="flex flex-col items-center {{ request()->routeIs('admin.projects*') ? 'text-green-600 font-bold' : 'text-gray-500' }}">
                        <i class="fas fa-project-diagram text-xl"></i>
                        <span class="text-xs">Projects</span>
                    </a>
                    <a href="{{ route('admin.reports') }}" class="flex flex-col items-center {{ request()->routeIs('admin.reports*') ? 'text-green-600 font-bold' : 'text-gray-500' }}">
                        <i class="fas fa-chart-bar text-xl"></i>
                        <span class="text-xs">Reports</span>
                    </a>
                </div>
            @else
                <!-- Default bottom navigation for investors -->
                <div class="fixed bottom-0 left-0 right-0 z-50 bg-white border-t shadow-lg flex justify-around py-2 md:hidden">
                    <a href="{{ route('dashboard') }}" class="flex flex-col items-center {{ request()->routeIs('dashboard') ? 'text-green-600 font-bold' : 'text-gray-500' }}">
                        <i class="fas fa-home text-xl"></i>
                        <span class="text-xs">Home</span>
                    </a>
                    <a href="{{ route('projects.index') }}" class="flex flex-col items-center {{ request()->routeIs('projects.*') ? 'text-green-600 font-bold' : 'text-gray-500' }}">
                        <i class="fas fa-seedling text-xl"></i>
                        <span class="text-xs">Browse</span>
                    </a>
                    <a href="{{ route('gamification.missions') }}" class="flex flex-col items-center {{ request()->routeIs('gamification.missions') ? 'text-green-600 font-bold' : 'text-gray-500' }}">
                        <i class="fas fa-tasks text-xl"></i>
                        <span class="text-xs">Quests</span>
                    </a>
                    <a href="{{ route('wallet.index') }}" class="flex flex-col items-center {{ request()->routeIs('wallet.*') ? 'text-green-600 font-bold' : 'text-gray-500' }}">
                        <i class="fas fa-wallet text-xl"></i>
                        <span class="text-xs">Wallet</span>
                    </a>
                </div>
            @endif
        @endif
    </div>

    <!-- Global Loader -->
    <div id="global-loader" class="fixed inset-0 z-[9999] bg-black bg-opacity-30 flex items-center justify-center hidden">
        <div class="w-16 h-16 border-4 border-green-400 border-t-transparent rounded-full animate-spin"></div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('form.with-loader').forEach(function(form) {
            form.addEventListener('submit', function() {
                document.getElementById('global-loader').classList.remove('hidden');
            });
        });
    });
    </script>

    <!-- Alpine.js for dropdown functionality -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    @stack('scripts')
</body>

</html>
