@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-blue-50 pb-24">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <div class="bg-blue-100 rounded-full p-2">
                        <i class="fas fa-file-alt text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Dokumen Legalitas</h1>
                        <p class="text-sm text-gray-600">Kelola dokumen sertifikat dan peta lahan</p>
                    </div>
                </div>
                <a href="{{ route('landlord.farmlands.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Lahan
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @if($farmlands->count() > 0)
            <div class="space-y-6">
                @foreach($farmlands as $farmland)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $farmland->location }}</h3>
                                <div class="flex items-center space-x-4 text-sm text-gray-600">
                                    <span><i class="fas fa-ruler-combined mr-1"></i>{{ $farmland->size }} hektar</span>
                                    <span><i class="fas fa-dollar-sign mr-1"></i>Rp {{ number_format($farmland->rental_price) }}/bulan</span>
                                    @if($farmland->crop_type)
                                    <span><i class="fas fa-seedling mr-1"></i>{{ $farmland->crop_type }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                    @if($farmland->status === 'verified') bg-green-100 text-green-800
                                    @elseif($farmland->status === 'pending_verification') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    @if($farmland->status === 'verified') Terverifikasi
                                    @elseif($farmland->status === 'pending_verification') Menunggu Verifikasi
                                    @else {{ $farmland->status }} @endif
                                </span>
                                <a href="{{ route('landlord.farmlands.edit', $farmland) }}" 
                                   class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Documents Section -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Certificate Document -->
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="font-semibold text-gray-900 flex items-center">
                                        <i class="fas fa-certificate text-blue-600 mr-2"></i>
                                        Sertifikat Lahan
                                    </h4>
                                    @if($farmland->certificate_path)
                                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full">
                                        <i class="fas fa-check mr-1"></i>
                                        Tersedia
                                    </span>
                                    @else
                                    <span class="bg-red-100 text-red-800 text-xs font-medium px-2 py-1 rounded-full">
                                        <i class="fas fa-times mr-1"></i>
                                        Belum Upload
                                    </span>
                                    @endif
                                </div>

                                @if($farmland->certificate_path)
                                <div class="bg-green-50 rounded-lg p-4 mb-3">
                                    <div class="flex items-center">
                                        <i class="fas fa-file-pdf text-red-600 text-2xl mr-3"></i>
                                        <div class="flex-1">
                                            <p class="font-medium text-gray-900">Sertifikat</p>
                                            <p class="text-sm text-gray-600">Dokumen legalitas lahan</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <a href="{{ Storage::url($farmland->certificate_path) }}" target="_blank"
                                       class="flex-1 bg-blue-600 text-white text-center py-2 px-3 rounded-lg hover:bg-blue-700 transition-colors text-sm">
                                        <i class="fas fa-eye mr-1"></i>
                                        Lihat
                                    </a>
                                    <a href="{{ Storage::url($farmland->certificate_path) }}" download
                                       class="flex-1 bg-gray-600 text-white text-center py-2 px-3 rounded-lg hover:bg-gray-700 transition-colors text-sm">
                                        <i class="fas fa-download mr-1"></i>
                                        Download
                                    </a>
                                </div>
                                @else
                                <div class="bg-gray-50 rounded-lg p-4 mb-3 text-center">
                                    <i class="fas fa-upload text-gray-400 text-3xl mb-2"></i>
                                    <p class="text-gray-600 text-sm">Belum ada sertifikat</p>
                                </div>
                                <a href="{{ route('landlord.farmlands.edit', $farmland) }}"
                                   class="w-full bg-green-600 text-white text-center py-2 px-3 rounded-lg hover:bg-green-700 transition-colors text-sm block">
                                    <i class="fas fa-plus mr-1"></i>
                                    Upload Sertifikat
                                </a>
                                @endif
                            </div>

                            <!-- Location Map -->
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="font-semibold text-gray-900 flex items-center">
                                        <i class="fas fa-map text-green-600 mr-2"></i>
                                        Peta Lokasi
                                    </h4>
                                    @if($farmland->map_path)
                                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full">
                                        <i class="fas fa-check mr-1"></i>
                                        Tersedia
                                    </span>
                                    @else
                                    <span class="bg-red-100 text-red-800 text-xs font-medium px-2 py-1 rounded-full">
                                        <i class="fas fa-times mr-1"></i>
                                        Belum Upload
                                    </span>
                                    @endif
                                </div>

                                @if($farmland->map_path)
                                <div class="bg-green-50 rounded-lg p-4 mb-3">
                                    <div class="flex items-center">
                                        <i class="fas fa-map-marked-alt text-green-600 text-2xl mr-3"></i>
                                        <div class="flex-1">
                                            <p class="font-medium text-gray-900">Peta Lokasi</p>
                                            <p class="text-sm text-gray-600">Denah dan lokasi lahan</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <a href="{{ Storage::url($farmland->map_path) }}" target="_blank"
                                       class="flex-1 bg-green-600 text-white text-center py-2 px-3 rounded-lg hover:bg-green-700 transition-colors text-sm">
                                        <i class="fas fa-eye mr-1"></i>
                                        Lihat
                                    </a>
                                    <a href="{{ Storage::url($farmland->map_path) }}" download
                                       class="flex-1 bg-gray-600 text-white text-center py-2 px-3 rounded-lg hover:bg-gray-700 transition-colors text-sm">
                                        <i class="fas fa-download mr-1"></i>
                                        Download
                                    </a>
                                </div>
                                @else
                                <div class="bg-gray-50 rounded-lg p-4 mb-3 text-center">
                                    <i class="fas fa-upload text-gray-400 text-3xl mb-2"></i>
                                    <p class="text-gray-600 text-sm">Belum ada peta lokasi</p>
                                </div>
                                <a href="{{ route('landlord.farmlands.edit', $farmland) }}"
                                   class="w-full bg-green-600 text-white text-center py-2 px-3 rounded-lg hover:bg-green-700 transition-colors text-sm block">
                                    <i class="fas fa-plus mr-1"></i>
                                    Upload Peta
                                </a>
                                @endif
                            </div>
                        </div>

                        <!-- Document Status Info -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-gray-600">
                                    <span class="font-medium">Status Dokumen:</span>
                                    @php
                                        $docCount = 0;
                                        if($farmland->certificate_path) $docCount++;
                                        if($farmland->map_path) $docCount++;
                                        $completeness = ($docCount / 2) * 100;
                                    @endphp
                                    <span class="ml-2 {{ $completeness == 100 ? 'text-green-600 font-semibold' : 'text-yellow-600' }}">
                                        {{ $completeness }}% Lengkap ({{ $docCount }}/2 dokumen)
                                    </span>
                                </div>
                                @if($completeness < 100)
                                <div class="text-sm">
                                    <a href="{{ route('landlord.farmlands.edit', $farmland) }}" 
                                       class="text-blue-600 hover:text-blue-800 font-medium">
                                        <i class="fas fa-upload mr-1"></i>
                                        Lengkapi Dokumen
                                    </a>
                                </div>
                                @else
                                <div class="text-sm text-green-600 font-medium">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Dokumen Lengkap
                                </div>
                                @endif
                            </div>
                            
                            <!-- Progress Bar -->
                            <div class="mt-2">
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full transition-all duration-300" 
                                         style="width: {{ $completeness }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <div class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-file-alt text-blue-600 text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Dokumen</h3>
                <p class="text-gray-500 mb-6">Daftarkan lahan terlebih dahulu untuk mengelola dokumen legalitas.</p>
                <a href="{{ route('landlord.farmlands.create') }}" class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Daftarkan Lahan Pertama
                </a>
            </div>
        @endif

        <!-- Document Guidelines -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-blue-900 mb-4">
                <i class="fas fa-info-circle mr-2"></i>
                Panduan Dokumen
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="font-semibold text-blue-800 mb-2">Sertifikat Lahan</h4>
                    <ul class="text-sm text-blue-700 space-y-1">
                        <li>• Sertifikat Hak Milik (SHM) atau Sertifikat Hak Guna Bangunan (SHGB)</li>
                        <li>• Format: PDF, JPG, atau PNG</li>
                        <li>• Ukuran maksimal: 5MB</li>
                        <li>• Pastikan dokumen jelas dan terbaca</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-blue-800 mb-2">Peta Lokasi</h4>
                    <ul class="text-sm text-blue-700 space-y-1">
                        <li>• Peta dari Google Maps atau peta resmi</li>
                        <li>• Menunjukkan batas-batas lahan dengan jelas</li>
                        <li>• Format: PDF, JPG, atau PNG</li>
                        <li>• Ukuran maksimal: 5MB</li>
                    </ul>
                </div>
            </div>
            <div class="mt-4 p-4 bg-blue-100 rounded-lg">
                <p class="text-sm text-blue-800">
                    <i class="fas fa-lightbulb mr-2"></i>
                    <strong>Tips:</strong> Dokumen yang lengkap dan jelas akan mempercepat proses verifikasi lahan oleh tim admin. 
                    Lahan yang terverifikasi akan lebih menarik bagi investor dan petani.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection