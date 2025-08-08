@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-green-100 pb-24">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <div class="bg-green-100 rounded-full p-2">
                        <i class="fas fa-seedling text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Dashboard Petani</h1>
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
                    <div class="bg-blue-100 rounded-full p-2 mr-3">
                        <i class="fas fa-clipboard-list text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Laporan Hari Ini</p>
                        <p class="text-lg font-bold text-gray-900">{{ $recentReports->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="bg-yellow-100 rounded-full p-2 mr-3">
                        <i class="fas fa-boxes text-yellow-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Permintaan Pending</p>
                        <p class="text-lg font-bold text-gray-900">{{ $pendingRequests->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="bg-green-100 rounded-full p-2 mr-3">
                        <i class="fas fa-project-diagram text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Proyek Aktif</p>
                        <p class="text-lg font-bold text-gray-900">{{ $projects->count() }}</p>
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
                    <a href="{{ route('petani.daily-reports.create') }}" class="flex flex-col items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                        <i class="fas fa-clipboard-list text-green-600 text-2xl mb-2"></i>
                        <span class="text-sm font-medium text-gray-900">Buat Laporan</span>
                    </a>
                    
                    <a href="{{ route('petani.supply-requests.create') }}" class="flex flex-col items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                        <i class="fas fa-boxes text-blue-600 text-2xl mb-2"></i>
                        <span class="text-sm font-medium text-gray-900">Permintaan Barang</span>
                    </a>
                    
                    <a href="{{ route('petani.chat') }}" class="flex flex-col items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                        <i class="fas fa-comments text-purple-600 text-2xl mb-2"></i>
                        <span class="text-sm font-medium text-gray-900">Chat</span>
                    </a>
                    
                    <a href="{{ route('petani.daily-reports') }}" class="flex flex-col items-center p-4 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors">
                        <i class="fas fa-history text-orange-600 text-2xl mb-2"></i>
                        <span class="text-sm font-medium text-gray-900">Riwayat Laporan</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Reports -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Laporan Terbaru</h2>
            </div>
            <div class="p-6">
                @if($recentReports->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentReports as $report)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="bg-green-100 rounded-full p-2">
                                    <i class="fas fa-clipboard-list text-green-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $report->project->title ?? 'Proyek' }}</p>
                                    <p class="text-sm text-gray-600">{{ Str::limit($report->activity_description, 50) }}</p>
                                    <p class="text-xs text-gray-500">{{ $report->created_at->format('d M Y H:i') }}</p>
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
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-clipboard-list text-gray-400 text-4xl mb-4"></i>
                        <p class="text-gray-500">Belum ada laporan harian</p>
                        <a href="{{ route('petani.daily-reports.create') }}" class="mt-2 inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700">
                            Buat Laporan Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Pending Requests -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Permintaan Pending</h2>
            </div>
            <div class="p-6">
                @if($pendingRequests->count() > 0)
                    <div class="space-y-4">
                        @foreach($pendingRequests as $request)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="bg-blue-100 rounded-full p-2">
                                    <i class="fas fa-boxes text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $request->item_name }}</p>
                                    <p class="text-sm text-gray-600">{{ $request->quantity }} {{ $request->unit }}</p>
                                    <p class="text-xs text-gray-500">{{ $request->created_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                @if($request->priority === 'urgent')
                                    <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                        Urgent
                                    </span>
                                @elseif($request->priority === 'high')
                                    <span class="bg-orange-100 text-orange-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                        High
                                    </span>
                                @else
                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                        Normal
                                    </span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-boxes text-gray-400 text-4xl mb-4"></i>
                        <p class="text-gray-500">Tidak ada permintaan pending</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 