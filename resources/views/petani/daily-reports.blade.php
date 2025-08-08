@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-green-100 pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('petani.dashboard') }}" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-arrow-left text-xl"></i>
                        </a>
                        <div>
                            <h1 class="text-xl font-bold text-gray-900">Laporan Harian</h1>
                            <p class="text-sm text-gray-600">Riwayat laporan kegiatan harian Anda</p>
                        </div>
                    </div>
                    <a href="{{ route('petani.daily-reports.create') }}" 
                        class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Buat Laporan Baru
                    </a>
                </div>
            </div>
        </div>

        <!-- Reports List -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Daftar Laporan</h2>
            </div>
            <div class="p-6">
                @if($reports->count() > 0)
                    <div class="space-y-4">
                        @foreach($reports as $report)
                        <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3 mb-3">
                                        <div class="bg-green-100 rounded-full p-2">
                                            <i class="fas fa-clipboard-list text-green-600"></i>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900">{{ $report->project->title ?? 'Proyek' }}</h3>
                                            <p class="text-sm text-gray-600">{{ $report->created_at->format('d M Y H:i') }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <p class="text-gray-700">{{ $report->activity_description }}</p>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                        @if($report->weather_condition)
                                        <div class="flex items-center space-x-2">
                                            <i class="fas fa-cloud text-blue-500"></i>
                                            <span class="text-sm text-gray-600">Cuaca: {{ ucfirst($report->weather_condition) }}</span>
                                        </div>
                                        @endif
                                        
                                        @if($report->plant_condition)
                                        <div class="flex items-center space-x-2">
                                            <i class="fas fa-seedling text-green-500"></i>
                                            <span class="text-sm text-gray-600">Tanaman: {{ Str::limit($report->plant_condition, 30) }}</span>
                                        </div>
                                        @endif
                                        
                                        @if($report->pest_issues)
                                        <div class="flex items-center space-x-2">
                                            <i class="fas fa-bug text-red-500"></i>
                                            <span class="text-sm text-gray-600">Hama: {{ Str::limit($report->pest_issues, 30) }}</span>
                                        </div>
                                        @endif
                                    </div>
                                    
                                    @if($report->photo_path || $report->video_path)
                                    <div class="flex space-x-2 mb-4">
                                        @if($report->photo_path)
                                        <div class="flex items-center space-x-2">
                                            <i class="fas fa-image text-blue-500"></i>
                                            <span class="text-sm text-gray-600">Foto tersedia</span>
                                        </div>
                                        @endif
                                        
                                        @if($report->video_path)
                                        <div class="flex items-center space-x-2">
                                            <i class="fas fa-video text-purple-500"></i>
                                            <span class="text-sm text-gray-600">Video tersedia</span>
                                        </div>
                                        @endif
                                    </div>
                                    @endif
                                    
                                    @if($report->manager_notes)
                                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                                        <div class="flex">
                                            <i class="fas fa-comment text-yellow-400 mt-1 mr-3"></i>
                                            <div>
                                                <p class="text-sm font-medium text-yellow-800">Catatan Manajer:</p>
                                                <p class="text-sm text-yellow-700 mt-1">{{ $report->manager_notes }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                
                                <div class="ml-4">
                                    @if($report->status === 'approved')
                                        <span class="bg-green-100 text-green-800 text-xs font-medium px-3 py-1 rounded-full">
                                            <i class="fas fa-check mr-1"></i>Disetujui
                                        </span>
                                    @elseif($report->status === 'rejected')
                                        <span class="bg-red-100 text-red-800 text-xs font-medium px-3 py-1 rounded-full">
                                            <i class="fas fa-times mr-1"></i>Ditolak
                                        </span>
                                    @else
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-3 py-1 rounded-full">
                                            <i class="fas fa-clock mr-1"></i>Pending
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $reports->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-clipboard-list text-gray-400 text-5xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada laporan</h3>
                        <p class="text-gray-500 mb-6">Mulai dokumentasikan kegiatan harian Anda</p>
                        <a href="{{ route('petani.daily-reports.create') }}" 
                            class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>
                            Buat Laporan Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 