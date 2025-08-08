@extends('layouts.app')

@section('title', 'Portfolio')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-green-100 pb-24">
    <div class="max-w-5xl mx-auto px-3 sm:px-6 lg:px-8 py-4 space-y-5">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Portfolio Investasi</h1>
                <p class="text-gray-600 text-sm sm:text-base">Kelola dan pantau investasi Anda</p>
            </div>
            <div class="flex sm:justify-end">
                <a href="{{ route('investments.index') }}" class="w-full sm:w-auto justify-center bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 flex items-center space-x-2">
                    <i class="fas fa-plus"></i>
                    <span>Investasi Baru</span>
                </a>
            </div>
        </div>

        <!-- Portfolio Summary -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-6">
            <div class="bg-white rounded-xl shadow p-4 md:p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm font-medium text-gray-600">Total Investasi</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-900">Rp {{ number_format($totalInvested) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-chart-line text-blue-600 text-xl"></i>
                </div>
            </div>
            </div>

            <div class="bg-white rounded-xl shadow p-4 md:p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm font-medium text-gray-600">Potensi Return</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-900">Rp {{ number_format($totalPotentialReturn) }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-chart-pie text-green-600 text-xl"></i>
                </div>
            </div>
            </div>

            <div class="bg-white rounded-xl shadow p-4 md:p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm font-medium text-gray-600">Total Proyek</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-900">{{ $investments->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-seedling text-purple-600 text-xl"></i>
                </div>
            </div>
            </div>

            <div class="bg-white rounded-xl shadow p-4 md:p-6 border-l-4 border-orange-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm font-medium text-gray-600">Rata-rata ROI</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-900">{{ number_format($averageRoi ?? 0, 1) }}%</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-percentage text-orange-600 text-xl"></i>
                </div>
            </div>
            </div>
        </div>

        <!-- Investment List -->
        <div class="bg-white rounded-xl shadow p-4 md:p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4 md:mb-6">
                <h2 class="text-lg md:text-xl font-semibold text-gray-900">Riwayat Investasi</h2>
                <div class="flex space-x-2">
                    <select class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        <option value="">Semua Status</option>
                        <option value="confirmed">Dikonfirmasi</option>
                        <option value="pending">Menunggu</option>
                        <option value="refunded">Dikembalikan</option>
                    </select>
                </div>
            </div>

            <div class="space-y-3 md:space-y-4">
            @forelse($investments as $investment)
            <div class="border rounded-lg p-4 md:p-5 hover:shadow-md transition-shadow">
                <a href="{{ route('investments.show', $investment) }}" class="block">
                    <div class="flex items-start justify-between">
                        <div class="pr-3">
                            <div class="flex items-center gap-2 mb-1.5">
                                <h3 class="text-base md:text-lg font-semibold text-gray-900 line-clamp-1">{{ $investment->farmland->location }}</h3>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] md:text-xs font-medium 
                                    @if($investment->status == 'confirmed') bg-green-100 text-green-800 
                                    @elseif($investment->status == 'pending') bg-yellow-100 text-yellow-800 
                                    @else bg-red-100 text-red-800 @endif">
                                    @if($investment->status == 'confirmed') Dikonfirmasi
                                    @elseif($investment->status == 'pending') Menunggu
                                    @else Dikembalikan @endif
                                </span>
                            </div>
                            <p class="text-xs md:text-sm text-gray-600 mb-3">{{ $investment->farmland->crop_type ?? 'Mixed Crops' }}</p>
                        </div>
                        <i class="fas fa-chevron-right text-gray-300 mt-1"></i>
                    </div>

                    <div class="grid grid-cols-2 gap-3 md:grid-cols-4 md:gap-4 text-xs md:text-sm">
                        <div>
                            <span class="text-gray-500">Investasi</span>
                            <div class="font-semibold text-gray-900">Rp {{ number_format($investment->amount) }}</div>
                        </div>
                        <div>
                            <span class="text-gray-500">ROI</span>
                            @php
                                $months = $investment->farmland->investment_period_months ?? 12;
                                $roi = (15/12) * $months; // asumsi 15% tahunan
                            @endphp
                            <div class="font-semibold text-green-600">{{ number_format($roi, 1) }}%</div>
                        </div>
                        <div>
                            <span class="text-gray-500">Potensi Return</span>
                            <div class="font-semibold text-green-600">Rp {{ number_format($investment->potential_return) }}</div>
                        </div>
                        <div>
                            <span class="text-gray-500">Tanggal</span>
                            <div class="font-semibold text-gray-900">{{ $investment->created_at->format('d M Y') }}</div>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <div class="text-center py-12">
                <i class="fas fa-chart-line text-gray-400 text-5xl md:text-6xl mb-4"></i>
                <h3 class="text-lg md:text-xl font-semibold text-gray-900 mb-2">Belum Ada Investasi</h3>
                <p class="text-gray-500 mb-4 text-sm md:text-base">Mulai investasi pertama Anda untuk melihat portfolio di sini.</p>
                <a href="{{ route('investments.index') }}" class="inline-flex items-center justify-center w-full sm:w-auto bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors">
                    Mulai Investasi
                </a>
            </div>
            @endforelse
            </div>

            <!-- Pagination -->
            @if($investments->hasPages())
            <div class="mt-4 md:mt-6">
                {{ $investments->links() }}
            </div>
            @endif
        </div>

        <!-- Performance Chart -->
        <div class="bg-white rounded-xl shadow p-4 md:p-6">
            <h2 class="text-lg md:text-xl font-semibold text-gray-900 mb-3 md:mb-4">Performa Investasi</h2>
            <div class="h-48 md:h-64 bg-gray-50 rounded-lg flex items-center justify-center">
                <div class="text-center">
                    <i class="fas fa-chart-area text-gray-400 text-3xl md:text-4xl mb-2"></i>
                    <p class="text-gray-500 text-sm md:text-base">Grafik performa investasi akan ditampilkan di sini</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 