@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-blue-50 pb-24">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <div class="bg-green-100 rounded-full p-2">
                        <i class="fas fa-home text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Dashboard Pemilik Lahan</h1>
                        <p class="text-sm text-gray-600">Selamat datang, {{ auth()->user()->name }}!</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        Level {{ auth()->user()->level }}
                    </span>
                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        {{ auth()->user()->xp }} XP
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="bg-green-100 rounded-full p-2 mr-3">
                        <i class="fas fa-map-marker-alt text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Lahan</p>
                        <p class="text-lg font-bold text-gray-900">{{ $farmlands->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="bg-blue-100 rounded-full p-2 mr-3">
                        <i class="fas fa-project-diagram text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Proyek Aktif</p>
                        <p class="text-lg font-bold text-gray-900">{{ $activeProjects->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="bg-yellow-100 rounded-full p-2 mr-3">
                        <i class="fas fa-dollar-sign text-yellow-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Investasi</p>
                        <p class="text-lg font-bold text-gray-900">Rp {{ number_format($totalInvestments) }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="bg-purple-100 rounded-full p-2 mr-3">
                        <i class="fas fa-comments text-purple-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Pesan Baru</p>
                        <p class="text-lg font-bold text-gray-900">{{ $unreadMessages }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Aksi Cepat</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="{{ route('landlord.farmlands.create') }}" class="flex flex-col items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                        <i class="fas fa-plus text-green-600 text-2xl mb-2"></i>
                        <span class="text-sm font-medium text-gray-900">Tambah Lahan</span>
                    </a>
                    
                    <a href="{{ route('landlord.farmlands') }}" class="flex flex-col items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                        <i class="fas fa-list text-blue-600 text-2xl mb-2"></i>
                        <span class="text-sm font-medium text-gray-900">Kelola Lahan</span>
                    </a>
                    
                    <a href="{{ route('landlord.progress-reports') }}" class="flex flex-col items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors">
                        <i class="fas fa-chart-line text-yellow-600 text-2xl mb-2"></i>
                        <span class="text-sm font-medium text-gray-900">Laporan Progress</span>
                    </a>
                    
                    <a href="{{ route('landlord.chat') }}" class="flex flex-col items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                        <i class="fas fa-comments text-purple-600 text-2xl mb-2"></i>
                        <span class="text-sm font-medium text-gray-900">Chat</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Collaboration Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Kolaborasi</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-user-friends text-blue-600 mr-3"></i>
                            <span class="text-gray-700">Petani Bekerja Sama</span>
                        </div>
                        <span class="font-bold text-blue-600">{{ $uniqueFarmers }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-chart-line text-green-600 mr-3"></i>
                            <span class="text-gray-700">Investor Aktif</span>
                        </div>
                        <span class="font-bold text-green-600">{{ $uniqueInvestors }}</span>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('landlord.collaboration-history') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        Lihat Riwayat Lengkap →
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Lahan</h3>
                <div class="space-y-3">
                    @php
                        $verifiedLands = $farmlands->where('status', 'verified')->count();
                        $pendingLands = $farmlands->where('status', 'pending_verification')->count();
                        $activeLands = $farmlands->filter(function($farmland) {
                            return $farmland->projects->where('status', 'active')->count() > 0;
                        })->count();
                    @endphp
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700">Terverifikasi</span>
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm font-medium">{{ $verifiedLands }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700">Menunggu Verifikasi</span>
                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-sm font-medium">{{ $pendingLands }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700">Sedang Produktif</span>
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm font-medium">{{ $activeLands }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Projects -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Proyek Aktif di Lahan Anda</h2>
            </div>
            <div class="p-6">
                @if($activeProjects->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($activeProjects->take(4) as $project)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-semibold text-gray-900">{{ $project->title }}</h4>
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium">
                                    {{ $project->status }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 mb-2">{{ $project->farmland->location }}</p>
                            <div class="flex items-center text-xs text-gray-500">
                                <i class="fas fa-calendar mr-1"></i>
                                {{ $project->start_date->format('d M Y') }} - {{ $project->end_date->format('d M Y') }}
                            </div>
                            <div class="mt-2 flex items-center justify-between">
                                <span class="text-sm text-gray-600">Manager: {{ $project->manager->name ?? 'Belum ditentukan' }}</span>
                                <span class="text-sm font-semibold text-green-600">{{ $project->expected_roi }}% ROI</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @if($activeProjects->count() > 4)
                        <div class="mt-4 text-center">
                            <a href="{{ route('landlord.farmlands') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Lihat Semua Proyek →
                            </a>
                        </div>
                    @endif
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-project-diagram text-gray-400 text-4xl mb-4"></i>
                        <p class="text-gray-500">Belum ada proyek aktif di lahan Anda</p>
                        <a href="{{ route('landlord.farmlands.create') }}" class="mt-2 inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700">
                            Tambah Lahan Baru
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Reports -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Laporan Terbaru dari Petani</h2>
            </div>
            <div class="p-6">
                @if($recentReports->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentReports as $report)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="bg-blue-100 rounded-full p-2">
                                    <i class="fas fa-clipboard-list text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $report->project->title }}</p>
                                    <p class="text-sm text-gray-600">{{ Str::limit($report->activity_description, 50) }}</p>
                                    <p class="text-xs text-gray-500">oleh {{ $report->user->name }} • {{ $report->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                @if($report->status === 'approved')
                                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                        Disetujui
                                    </span>
                                @elseif($report->status === 'rejected')
                                    <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                        Ditolak
                                    </span>
                                @else
                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                        Pending
                                    </span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-4 text-center">
                        <a href="{{ route('landlord.progress-reports') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Lihat Semua Laporan →
                        </a>
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-clipboard-list text-gray-400 text-4xl mb-4"></i>
                        <p class="text-gray-500">Belum ada laporan dari petani</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection