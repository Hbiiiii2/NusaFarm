@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-blue-50 pb-24">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <div class="bg-purple-100 rounded-full p-2">
                        <i class="fas fa-handshake text-purple-600 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Riwayat Kerjasama</h1>
                        <p class="text-sm text-gray-600">Histori kerja sama dengan petani dan investor</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Farmers Section -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-user-friends text-green-600 mr-2"></i>
                        Petani Partner ({{ $farmers->count() }})
                    </h2>
                    <p class="text-sm text-gray-600">Petani yang pernah bekerja di lahan Anda</p>
                </div>
                <div class="p-6">
                    @if($farmers->count() > 0)
                        <div class="space-y-4">
                            @foreach($farmers as $farmer)
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                            <span class="text-green-600 font-semibold">{{ substr($farmer->name, 0, 2) }}</span>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900">{{ $farmer->name }}</h4>
                                            <p class="text-sm text-gray-600">{{ $farmer->email }}</p>
                                            <div class="flex items-center text-xs text-gray-500 mt-1">
                                                <i class="fas fa-calendar mr-1"></i>
                                                Bergabung {{ $farmer->created_at->format('M Y') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm font-semibold text-green-600">
                                            {{ $farmer->dailyReports->count() }} Laporan
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            Terakhir: {{ $farmer->dailyReports->max('created_at')?->diffForHumans() ?? 'Tidak ada' }}
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Recent Activity -->
                                @if($farmer->dailyReports->count() > 0)
                                <div class="mt-3 pt-3 border-t border-gray-100">
                                    <h5 class="text-xs font-semibold text-gray-600 mb-2">Aktivitas Terbaru:</h5>
                                    <div class="space-y-2">
                                        @foreach($farmer->dailyReports->take(2) as $report)
                                        <div class="bg-gray-50 rounded p-2">
                                            <p class="text-xs text-gray-700">{{ Str::limit($report->activity_description, 80) }}</p>
                                            <div class="flex items-center justify-between mt-1">
                                                <span class="text-xs text-gray-500">{{ $report->project->title }}</span>
                                                <span class="text-xs text-gray-500">{{ $report->created_at->format('d M') }}</span>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                <!-- Contact Button -->
                                <div class="mt-3 pt-3 border-t border-gray-100">
                                    <a href="{{ route('landlord.chat') }}" class="inline-flex items-center text-xs text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-comments mr-1"></i>
                                        Kirim Pesan
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-user-friends text-gray-400 text-3xl mb-4"></i>
                            <p class="text-gray-500">Belum ada petani yang bekerja di lahan Anda</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Investors Section -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-chart-line text-blue-600 mr-2"></i>
                        Investor Partner ({{ $investors->count() }})
                    </h2>
                    <p class="text-sm text-gray-600">Investor yang berinvestasi di lahan Anda</p>
                </div>
                <div class="p-6">
                    @if($investors->count() > 0)
                        <div class="space-y-4">
                            @foreach($investors as $investor)
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                            <span class="text-blue-600 font-semibold">{{ substr($investor->name, 0, 2) }}</span>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900">{{ $investor->name }}</h4>
                                            <p class="text-sm text-gray-600">{{ $investor->email }}</p>
                                            <div class="flex items-center text-xs text-gray-500 mt-1">
                                                <i class="fas fa-calendar mr-1"></i>
                                                Bergabung {{ $investor->created_at->format('M Y') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm font-semibold text-blue-600">
                                            Rp {{ number_format($investor->investments->sum('amount')) }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $investor->investments->count() }} Investasi
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Investment Details -->
                                @if($investor->investments->count() > 0)
                                <div class="mt-3 pt-3 border-t border-gray-100">
                                    <h5 class="text-xs font-semibold text-gray-600 mb-2">Detail Investasi:</h5>
                                    <div class="space-y-2">
                                        @foreach($investor->investments->take(3) as $investment)
                                        <div class="bg-gray-50 rounded p-2">
                                            <div class="flex items-center justify-between">
                                                <span class="text-xs text-gray-700">{{ $investment->project->title }}</span>
                                                <span class="text-xs font-semibold text-blue-600">Rp {{ number_format($investment->amount) }}</span>
                                            </div>
                                            <div class="flex items-center justify-between mt-1">
                                                <span class="text-xs text-gray-500 capitalize">{{ $investment->status }}</span>
                                                <span class="text-xs text-gray-500">{{ $investment->created_at->format('d M Y') }}</span>
                                            </div>
                                        </div>
                                        @endforeach
                                        @if($investor->investments->count() > 3)
                                        <div class="text-xs text-gray-500 text-center">
                                            +{{ $investor->investments->count() - 3 }} investasi lainnya
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endif

                                <!-- Contact Button -->
                                <div class="mt-3 pt-3 border-t border-gray-100">
                                    <a href="{{ route('landlord.chat') }}" class="inline-flex items-center text-xs text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-comments mr-1"></i>
                                        Kirim Pesan
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-chart-line text-gray-400 text-3xl mb-4"></i>
                            <p class="text-gray-500">Belum ada investor di lahan Anda</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Overall Statistics -->
        @if($farmers->count() > 0 || $investors->count() > 0)
        <div class="mt-8 bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Statistik Kerjasama</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-user-friends text-green-600 text-2xl"></i>
                    </div>
                    <div class="text-2xl font-bold text-green-600">{{ $farmers->count() }}</div>
                    <div class="text-sm text-gray-500">Petani Partner</div>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-chart-line text-blue-600 text-2xl"></i>
                    </div>
                    <div class="text-2xl font-bold text-blue-600">{{ $investors->count() }}</div>
                    <div class="text-sm text-gray-500">Investor Partner</div>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-clipboard-list text-yellow-600 text-2xl"></i>
                    </div>
                    <div class="text-2xl font-bold text-yellow-600">{{ $farmers->sum(function($farmer) { return $farmer->dailyReports->count(); }) }}</div>
                    <div class="text-sm text-gray-500">Total Laporan</div>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-dollar-sign text-purple-600 text-2xl"></i>
                    </div>
                    <div class="text-2xl font-bold text-purple-600">Rp {{ number_format($investors->sum(function($investor) { return $investor->investments->sum('amount'); })) }}</div>
                    <div class="text-sm text-gray-500">Total Investasi</div>
                </div>
            </div>
        </div>
        @endif

        <!-- Quick Actions -->
        <div class="mt-8 bg-gradient-to-r from-green-500 to-blue-600 rounded-lg shadow p-6 text-white">
            <h3 class="text-lg font-semibold mb-4">Tingkatkan Kerjasama</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('landlord.farmlands.create') }}" class="bg-white bg-opacity-20 rounded-lg p-4 hover:bg-opacity-30 transition-colors">
                    <i class="fas fa-plus text-2xl mb-2"></i>
                    <h4 class="font-semibold">Tambah Lahan</h4>
                    <p class="text-sm opacity-90">Daftarkan lahan baru untuk menarik lebih banyak partner</p>
                </a>
                <a href="{{ route('projects.index') }}" class="bg-white bg-opacity-20 rounded-lg p-4 hover:bg-opacity-30 transition-colors">
                    <i class="fas fa-project-diagram text-2xl mb-2"></i>
                    <h4 class="font-semibold">Lihat Proyek</h4>
                    <p class="text-sm opacity-90">Jelajahi proyek pertanian yang tersedia</p>
                </a>
                <a href="{{ route('landlord.chat') }}" class="bg-white bg-opacity-20 rounded-lg p-4 hover:bg-opacity-30 transition-colors">
                    <i class="fas fa-comments text-2xl mb-2"></i>
                    <h4 class="font-semibold">Mulai Chat</h4>
                    <p class="text-sm opacity-90">Komunikasi dengan petani dan investor</p>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection