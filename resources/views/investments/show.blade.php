@extends('layouts.app')

@section('title', 'Detail Investasi')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Detail Investasi</h1>
            <p class="text-gray-600">Informasi lengkap investasi Anda</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('investments.portfolio') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 flex items-center space-x-2">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Investment Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Investment Info Card -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">{{ $investment->farmland->location }}</h2>
                        <p class="text-gray-600">{{ $investment->farmland->crop_type ?? 'Mixed Crops' }}</p>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                        @if($investment->status == 'confirmed') bg-green-100 text-green-800 
                        @elseif($investment->status == 'pending') bg-yellow-100 text-yellow-800 
                        @else bg-red-100 text-red-800 @endif">
                        @if($investment->status == 'confirmed') Dikonfirmasi
                        @elseif($investment->status == 'pending') Menunggu
                        @else Dikembalikan @endif
                    </span>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-900">Rp {{ number_format($investment->amount) }}</div>
                        <div class="text-sm text-gray-500">Nominal Investasi</div>
                    </div>
                    <div class="text-center">
                        @php
                            $months = $investment->farmland->investment_period_months ?? 12;
                            $roi = (15/12) * $months; // asumsi 15% tahunan
                        @endphp
                        <div class="text-2xl font-bold text-green-600">{{ number_format($roi, 1) }}%</div>
                        <div class="text-sm text-gray-500">ROI</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600">Rp {{ number_format($investment->potential_return) }}</div>
                        <div class="text-sm text-gray-500">Potensi Return</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ $investment->created_at->format('d M Y') }}</div>
                        <div class="text-sm text-gray-500">Tanggal Investasi</div>
                    </div>
                </div>
            </div>

            <!-- Project Progress -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Progress Proyek</h3>
                
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-sm text-gray-600 mb-1">
                            <span>Progress Keseluruhan</span>
                            <span>60%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-green-600 h-3 rounded-full" style="width: 60%"></div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="border rounded-lg p-4">
                            <div class="flex items-center space-x-3 mb-2">
                                <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                <span class="font-medium text-gray-900">Persiapan Lahan</span>
                            </div>
                            <p class="text-sm text-gray-600">Lahan telah disiapkan dan siap untuk penanaman</p>
                        </div>
                        
                        <div class="border rounded-lg p-4">
                            <div class="flex items-center space-x-3 mb-2">
                                <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                <span class="font-medium text-gray-900">Penanaman</span>
                            </div>
                            <p class="text-sm text-gray-600">Benih telah ditanam dan mulai tumbuh</p>
                        </div>
                        
                        <div class="border rounded-lg p-4">
                            <div class="flex items-center space-x-3 mb-2">
                                <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                                <span class="font-medium text-gray-900">Pemeliharaan</span>
                            </div>
                            <p class="text-sm text-gray-600">Sedang dalam tahap pemeliharaan dan perawatan</p>
                        </div>
                        
                        <div class="border rounded-lg p-4">
                            <div class="flex items-center space-x-3 mb-2">
                                <div class="w-3 h-3 bg-gray-300 rounded-full"></div>
                                <span class="font-medium text-gray-900">Panen</span>
                            </div>
                            <p class="text-sm text-gray-600">Menunggu masa panen</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Media Terbaru dari Laporan Harian -->
            @if(isset($latestReports) && $latestReports->count() > 0)
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Update Terbaru dari Lapangan</h3>
                <div class="space-y-4">
                    @foreach($latestReports as $report)
                    <div class="border rounded-lg p-4">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-green-600 text-sm"></i>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900 text-sm">{{ $report->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $report->created_at->format('d M Y H:i') }}</div>
                                </div>
                            </div>
                            <span class="text-xs text-gray-500">{{ $report->project->title ?? 'Proyek' }}</span>
                        </div>

                        <p class="text-sm text-gray-700 mb-3">{{ $report->activity_description }}</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if($report->photo_path)
                            <div>
                                <img src="{{ asset('storage/'.$report->photo_path) }}" alt="Foto Laporan" class="rounded-lg w-full object-cover">
                            </div>
                            @endif
                            @if($report->video_path)
                            <div>
                                <video controls class="w-full rounded-lg">
                                    <source src="{{ asset('storage/'.$report->video_path) }}" type="video/mp4">
                                    Browser Anda tidak mendukung video.
                                </video>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Project Timeline -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Timeline Proyek</h3>
                
                <div class="space-y-4">
                    <div class="flex items-center space-x-4">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-white text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-gray-900">Persiapan Lahan</div>
                            <div class="text-sm text-gray-500">-</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-white text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-gray-900">Penanaman</div>
                            <div class="text-sm text-gray-500">15 Jan 2024</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-clock text-white text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-gray-900">Pemeliharaan</div>
                            <div class="text-sm text-gray-500">Sedang berlangsung</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                            <i class="fas fa-circle text-gray-400 text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-gray-900">Panen</div>
                            <div class="text-sm text-gray-500">-</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Project Details -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Proyek</h3>
                
                <div class="space-y-4">
                    <div>
                        <span class="text-sm text-gray-500">Luas Lahan</span>
                        <div class="font-semibold text-gray-900">{{ $investment->farmland->size }} ha</div>
                    </div>
                    
                    <div>
                        <span class="text-sm text-gray-500">Periode Investasi</span>
                        <div class="font-semibold text-gray-900">{{ $months }} bulan</div>
                    </div>
                    
                    <div>
                        <span class="text-sm text-gray-500">Durasi</span>
                        <div class="font-semibold text-gray-900">{{ $months }} bulan</div>
                    </div>
                    
                    <div>
                        <span class="text-sm text-gray-500">Landlord</span>
                        <div class="font-semibold text-gray-900">{{ $investment->farmland->landlord->name }}</div>
                    </div>
                </div>
            </div>

            <!-- Return Calculator -->
            <div class="bg-gray-50 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Kalkulator Return</h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Investasi Awal:</span>
                        <span class="font-semibold text-gray-900">Rp {{ number_format($investment->amount) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">ROI:</span>
                        <span class="font-semibold text-green-600">{{ number_format($roi, 1) }}%</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Keuntungan:</span>
                        <span class="font-semibold text-green-600">Rp {{ number_format($investment->potential_return - $investment->amount) }}</span>
                    </div>
                    <div class="border-t pt-3">
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-900">Total Return:</span>
                            <span class="font-bold text-lg text-green-600">Rp {{ number_format($investment->potential_return) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            
        </div>
    </div>
</div>
@endsection 