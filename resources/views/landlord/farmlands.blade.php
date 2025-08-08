@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-blue-50 pb-24">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <div class="bg-green-100 rounded-full p-2">
                        <i class="fas fa-map-marker-alt text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Kelola Lahan</h1>
                        <p class="text-sm text-gray-600">Verifikasi dan kelola data lahan milik Anda</p>
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
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($farmlands as $farmland)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $farmland->location }}</h3>
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                @if($farmland->status === 'verified') bg-green-100 text-green-800
                                @elseif($farmland->status === 'pending_verification') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800 @endif">
                                @if($farmland->status === 'verified') Terverifikasi
                                @elseif($farmland->status === 'pending_verification') Menunggu Verifikasi
                                @else {{ $farmland->status }} @endif
                            </span>
                        </div>
                        
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-ruler-combined w-4 mr-2"></i>
                                {{ $farmland->size }} hektar
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-dollar-sign w-4 mr-2"></i>
                                Rp {{ number_format($farmland->rental_price) }} / bulan
                            </div>
                            @if($farmland->crop_type)
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-seedling w-4 mr-2"></i>
                                {{ $farmland->crop_type }}
                            </div>
                            @endif
                        </div>

                        @if($farmland->description)
                        <p class="text-sm text-gray-600 mb-4">{{ Str::limit($farmland->description, 100) }}</p>
                        @endif

                        <!-- Projects Info -->
                        <div class="mb-4">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">Proyek Aktif:</span>
                                <span class="font-semibold text-blue-600">{{ $farmland->projects->where('status', 'active')->count() }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">Total Investasi:</span>
                                <span class="font-semibold text-green-600">
                                    Rp {{ number_format($farmland->investments->where('status', 'confirmed')->sum('amount')) }}
                                </span>
                            </div>
                        </div>

                        <!-- Documents Status -->
                        <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                            <div class="text-xs text-gray-600 mb-2">Dokumen:</div>
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center">
                                    <i class="fas fa-certificate text-xs mr-1 {{ $farmland->certificate_path ? 'text-green-600' : 'text-gray-400' }}"></i>
                                    <span class="text-xs {{ $farmland->certificate_path ? 'text-green-600' : 'text-gray-400' }}">Sertifikat</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-map text-xs mr-1 {{ $farmland->map_path ? 'text-green-600' : 'text-gray-400' }}"></i>
                                    <span class="text-xs {{ $farmland->map_path ? 'text-green-600' : 'text-gray-400' }}">Peta</span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('landlord.farmlands.show', $farmland) }}" class="flex-1 bg-blue-600 text-white text-center py-2 px-3 rounded-lg hover:bg-blue-700 transition-colors text-sm">
                                <i class="fas fa-eye mr-1"></i>
                                Detail
                            </a>
                            <a href="{{ route('landlord.farmlands.edit', $farmland) }}" class="flex-1 bg-gray-600 text-white text-center py-2 px-3 rounded-lg hover:bg-gray-700 transition-colors text-sm">
                                <i class="fas fa-edit mr-1"></i>
                                Edit
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($farmlands->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $farmlands->links() }}
            </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-map-marker-alt text-green-600 text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Lahan Terdaftar</h3>
                <p class="text-gray-500 mb-6">Mulai dengan mendaftarkan lahan pertama Anda untuk mendapatkan investor dan petani.</p>
                <a href="{{ route('landlord.farmlands.create') }}" class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Daftarkan Lahan Pertama
                </a>
            </div>
        @endif
    </div>
</div>
@endsection