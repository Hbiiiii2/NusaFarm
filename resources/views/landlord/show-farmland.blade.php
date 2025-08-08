@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-blue-50 pb-24">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('landlord.farmlands') }}" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div class="bg-green-100 rounded-full p-2">
                        <i class="fas fa-map-marker-alt text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Detail Lahan</h1>
                        <p class="text-sm text-gray-600">{{ $farmland->location }}</p>
                    </div>
                </div>
                <a href="{{ route('landlord.farmlands.edit', $farmland) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Lahan
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Land Information -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Lahan</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-gray-600">Lokasi</label>
                            <p class="text-gray-900">{{ $farmland->location }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Luas</label>
                            <p class="text-gray-900">{{ $farmland->size }} hektar</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Harga Sewa</label>
                            <p class="text-gray-900">Rp {{ number_format($farmland->rental_price) }}/bulan</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Status</label>
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                @if($farmland->status === 'verified') bg-green-100 text-green-800
                                @elseif($farmland->status === 'pending_verification') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800 @endif">
                                @if($farmland->status === 'verified') Terverifikasi
                                @elseif($farmland->status === 'pending_verification') Menunggu Verifikasi
                                @else {{ $farmland->status }} @endif
                            </span>
                        </div>
                        @if($farmland->crop_type)
                        <div>
                            <label class="text-sm font-medium text-gray-600">Jenis Tanaman</label>
                            <p class="text-gray-900">{{ $farmland->crop_type }}</p>
                        </div>
                        @endif
                    </div>
                    
                    @if($farmland->description)
                    <div class="mt-4">
                        <label class="text-sm font-medium text-gray-600">Deskripsi</label>
                        <p class="text-gray-900 mt-1">{{ $farmland->description }}</p>
                    </div>
                    @endif
                </div>

                <!-- Projects on this land -->
                <div class="bg-white rounded-lg shadow p-6 mt-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Proyek di Lahan Ini</h2>
                    @if($farmland->projects->count() > 0)
                        <div class="space-y-4">
                            @foreach($farmland->projects as $project)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="font-semibold text-gray-900">{{ $project->title }}</h3>
                                    <span class="px-2 py-1 rounded-full text-xs font-medium
                                        @if($project->status === 'active') bg-green-100 text-green-800
                                        @elseif($project->status === 'planning') bg-blue-100 text-blue-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ $project->status }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 mb-2">{{ $project->description }}</p>
                                <div class="flex items-center justify-between text-sm">
                                    <span>Manager: {{ $project->manager->name ?? 'Belum ditentukan' }}</span>
                                    <span class="font-semibold text-green-600">{{ $project->expected_roi }}% ROI</span>
                                </div>
                                <div class="flex items-center justify-between text-sm text-gray-500 mt-1">
                                    <span>{{ $project->start_date->format('d M Y') }} - {{ $project->end_date->format('d M Y') }}</span>
                                    <span>Total Investasi: Rp {{ number_format($project->investments->where('status', 'confirmed')->sum('amount')) }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-project-diagram text-gray-400 text-3xl mb-4"></i>
                            <p class="text-gray-500">Belum ada proyek di lahan ini</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Recent Activity -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Aktivitas Terbaru</h3>
                    @if($recentReports->count() > 0)
                        <div class="space-y-3">
                            @foreach($recentReports as $report)
                            <div class="border-l-4 border-green-500 pl-3">
                                <p class="text-sm text-gray-900">{{ Str::limit($report->activity_description, 60) }}</p>
                                <p class="text-xs text-gray-500 mt-1">
                                    oleh {{ $report->user->name }} • {{ $report->created_at->diffForHumans() }}
                                </p>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-sm">Belum ada aktivitas</p>
                    @endif
                </div>

                <!-- Quick Stats -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Total Proyek</span>
                            <span class="font-semibold">{{ $farmland->projects->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Proyek Aktif</span>
                            <span class="font-semibold text-green-600">{{ $farmland->projects->where('status', 'active')->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Total Investasi</span>
                            <span class="font-semibold text-blue-600">
                                Rp {{ number_format($farmland->projects->sum(function($project) { 
                                    return $project->investments->where('status', 'confirmed')->sum('amount'); 
                                })) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 