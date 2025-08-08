@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-blue-50 pb-24">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <div class="bg-yellow-100 rounded-full p-2">
                        <i class="fas fa-chart-line text-yellow-600 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Progress Pertanian</h1>
                        <p class="text-sm text-gray-600">Pantau aktivitas pertanian di lahan milik Anda</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        {{ $reports->total() }} Total Laporan
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @if($reports->count() > 0)
            <div class="space-y-6">
                @foreach($reports as $report)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-start space-x-4">
                                <div class="bg-green-100 rounded-full p-3">
                                    <i class="fas fa-clipboard-list text-green-600 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $report->project->title }}</h3>
                                    <p class="text-sm text-gray-600">{{ $report->project->farmland->location }}</p>
                                    <div class="flex items-center mt-1">
                                        <span class="text-sm text-gray-500">Oleh: {{ $report->user->name }}</span>
                                        <span class="mx-2 text-gray-300">•</span>
                                        <span class="text-sm text-gray-500">{{ $report->created_at->format('d M Y H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col items-end space-y-2">
                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                    @if($report->status === 'approved') bg-green-100 text-green-800
                                    @elseif($report->status === 'rejected') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    @if($report->status === 'approved') Disetujui
                                    @elseif($report->status === 'rejected') Ditolak
                                    @else Menunggu Review @endif
                                </span>
                                <span class="text-xs text-gray-500">{{ $report->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <!-- Activity Description -->
                        <div class="mb-4">
                            <h4 class="text-sm font-semibold text-gray-700 mb-2">Deskripsi Aktivitas:</h4>
                            <p class="text-gray-700 leading-relaxed">{{ $report->activity_description }}</p>
                        </div>

                        <!-- Additional Information -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            @if($report->weather_condition)
                            <div class="bg-blue-50 rounded-lg p-3">
                                <div class="flex items-center">
                                    <i class="fas fa-cloud-sun text-blue-600 mr-2"></i>
                                    <div>
                                        <p class="text-xs text-gray-600">Cuaca</p>
                                        <p class="text-sm font-semibold text-gray-900 capitalize">{{ $report->weather_condition }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($report->plant_condition)
                            <div class="bg-green-50 rounded-lg p-3">
                                <div class="flex items-center">
                                    <i class="fas fa-seedling text-green-600 mr-2"></i>
                                    <div>
                                        <p class="text-xs text-gray-600">Kondisi Tanaman</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ Str::limit($report->plant_condition, 30) }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($report->pest_issues)
                            <div class="bg-red-50 rounded-lg p-3">
                                <div class="flex items-center">
                                    <i class="fas fa-bug text-red-600 mr-2"></i>
                                    <div>
                                        <p class="text-xs text-gray-600">Masalah Hama</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ Str::limit($report->pest_issues, 30) }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Media Files -->
                        @if($report->photo_path || $report->video_path)
                        <div class="border-t border-gray-200 pt-4">
                            <h4 class="text-sm font-semibold text-gray-700 mb-3">Media Dokumentasi:</h4>
                            <div class="flex items-center space-x-4">
                                @if($report->photo_path)
                                <a href="{{ Storage::url($report->photo_path) }}" target="_blank" 
                                   class="inline-flex items-center px-3 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors">
                                    <i class="fas fa-image mr-2"></i>
                                    <span class="text-sm">Lihat Foto</span>
                                </a>
                                @endif
                                @if($report->video_path)
                                <a href="{{ Storage::url($report->video_path) }}" target="_blank" 
                                   class="inline-flex items-center px-3 py-2 bg-purple-100 text-purple-700 rounded-lg hover:bg-purple-200 transition-colors">
                                    <i class="fas fa-video mr-2"></i>
                                    <span class="text-sm">Lihat Video</span>
                                </a>
                                @endif
                            </div>
                        </div>
                        @endif

                        <!-- Project Progress Indicator -->
                        <div class="border-t border-gray-200 pt-4 mt-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="text-sm text-gray-600">
                                        <span class="font-medium">Proyek:</span> {{ $report->project->title }}
                                    </div>
                                    <div class="text-sm text-gray-600">
                                        <span class="font-medium">Status:</span> 
                                        <span class="capitalize">{{ $report->project->status }}</span>
                                    </div>
                                </div>
                                <div class="text-sm text-gray-500">
                                    Periode: {{ $report->project->start_date->format('M Y') }} - {{ $report->project->end_date->format('M Y') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($reports->hasPages())
            <div class="mt-8 flex justify-center">
                <div class="bg-white rounded-lg shadow border border-gray-200 p-4">
                    {{ $reports->links() }}
                </div>
            </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <div class="w-24 h-24 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-chart-line text-yellow-600 text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Laporan Progress</h3>
                <p class="text-gray-500 mb-6">Laporan progress akan muncul ketika petani mulai bekerja di lahan Anda.</p>
                <div class="space-y-3">
                    <a href="{{ route('landlord.farmlands') }}" class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        Kelola Lahan
                    </a>
                    <a href="{{ route('projects.index') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors ml-3">
                        <i class="fas fa-project-diagram mr-2"></i>
                        Lihat Proyek
                    </a>
                </div>
            </div>
        @endif

        <!-- Summary Statistics -->
        @if($reports->count() > 0)
        <div class="mt-8 bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Progress</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600">{{ $reports->where('status', 'approved')->count() }}</div>
                    <div class="text-sm text-gray-500">Laporan Disetujui</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-yellow-600">{{ $reports->where('status', 'pending')->count() }}</div>
                    <div class="text-sm text-gray-500">Menunggu Review</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-red-600">{{ $reports->where('status', 'rejected')->count() }}</div>
                    <div class="text-sm text-gray-500">Ditolak</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600">{{ $reports->count() }}</div>
                    <div class="text-sm text-gray-500">Total Laporan</div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection