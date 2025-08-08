@extends('layouts.app')

@section('title', 'Investasi')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Investasi</h1>
            <p class="text-gray-600">Pilih proyek pertanian yang ingin Anda investasikan</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('investments.portfolio') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center space-x-2">
                <i class="fas fa-chart-pie"></i>
                <span>Portfolio</span>
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex flex-wrap gap-4">
            <div class="flex items-center space-x-2">
                <label class="text-sm font-medium text-gray-700">Status:</label>
                <select class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    <option value="">Semua Status</option>
                    <option value="active">Aktif</option>
                    <option value="planning">Perencanaan</option>
                </select>
            </div>
            
            <div class="flex items-center space-x-2">
                <label class="text-sm font-medium text-gray-700">ROI:</label>
                <select class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    <option value="">Semua ROI</option>
                    <option value="low">15-20%</option>
                    <option value="medium">20-30%</option>
                    <option value="high">30%+</option>
                </select>
            </div>
            
            <div class="flex items-center space-x-2">
                <label class="text-sm font-medium text-gray-700">Durasi:</label>
                <select class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    <option value="">Semua Durasi</option>
                    <option value="short">3-6 bulan</option>
                    <option value="medium">6-12 bulan</option>
                    <option value="long">12+ bulan</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Projects Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($projects as $project)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
            <!-- Project Image Placeholder -->
            <div class="h-48 bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center">
                <i class="fas fa-seedling text-white text-4xl"></i>
            </div>
            
            <!-- Project Info -->
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">{{ $project->title }}</h3>
                        <p class="text-sm text-gray-600 mt-1">
                            @if($project->farmland && $project->farmland->location)
                                {{ $project->farmland->location }}
                            @else
                                Lokasi belum ditentukan
                            @endif
                        </p>
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-bold text-green-600">{{ $project->expected_roi }}%</div>
                        <div class="text-sm text-gray-500">ROI</div>
                    </div>
                </div>
                
                <p class="text-gray-600 text-sm mb-4">{{ Str::limit($project->description, 100) }}</p>
                
                <!-- Project Details -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="text-center">
                        <div class="text-lg font-semibold text-gray-900">
                            @if($project->farmland && $project->farmland->size)
                                {{ $project->farmland->size }} ha
                            @else
                                -
                            @endif
                        </div>
                        <div class="text-xs text-gray-500">Luas Lahan</div>
                    </div>
                    <div class="text-center">
                        <div class="text-lg font-semibold text-gray-900">
                            @if($project->start_date && $project->end_date)
                                {{ $project->start_date->diffInMonths($project->end_date) }} bulan
                            @else
                                -
                            @endif
                        </div>
                        <div class="text-xs text-gray-500">Durasi</div>
                    </div>
                </div>
                
                <!-- Progress Bar -->
                <div class="mb-4">
                    <div class="flex justify-between text-xs text-gray-500 mb-1">
                        <span>Progress</span>
                        <span>{{ $project->status == 'active' ? 'Sedang Berjalan' : 'Perencanaan' }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        @php
                            $progress = $project->status == 'active' ? 60 : 20;
                        @endphp
                        <div class="bg-green-600 h-2 rounded-full" style="width: {{ $progress }}%"></div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex space-x-2">
                    <a href="{{ route('projects.show', $project) }}" class="flex-1 bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-center hover:bg-gray-200 transition-colors">
                        Detail
                    </a>
                    <a href="{{ route('investments.create', $project) }}" class="flex-1 bg-green-600 text-white px-4 py-2 rounded-lg text-center hover:bg-green-700 transition-colors">
                        Investasi
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($projects->hasPages())
    <div class="flex justify-center">
        {{ $projects->links() }}
    </div>
    @endif
</div>
@endsection 