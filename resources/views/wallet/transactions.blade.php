@extends('layouts.app')

@section('title', 'Riwayat Transaksi')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Riwayat Transaksi</h1>
            <p class="text-gray-600">Lihat semua transaksi wallet Anda</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('wallet.index') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 flex items-center space-x-2">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- Transaction Summary -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Top-up</p>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalTopup ?? 0) }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-plus text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Investasi</p>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalInvestment ?? 0) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-chart-line text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Penarikan</p>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalWithdrawal ?? 0) }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-red-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Reward</p>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalReward ?? 0) }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-gift text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex flex-wrap gap-4">
            <div class="flex items-center space-x-2">
                <label class="text-sm font-medium text-gray-700">Tipe:</label>
                <select class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    <option value="">Semua Tipe</option>
                    <option value="topup">Top-up</option>
                    <option value="investment">Investasi</option>
                    <option value="withdrawal">Penarikan</option>
                    <option value="reward">Reward</option>
                </select>
            </div>
            
            <div class="flex items-center space-x-2">
                <label class="text-sm font-medium text-gray-700">Periode:</label>
                <select class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    <option value="">Semua Waktu</option>
                    <option value="today">Hari Ini</option>
                    <option value="week">Minggu Ini</option>
                    <option value="month">Bulan Ini</option>
                    <option value="year">Tahun Ini</option>
                </select>
            </div>
            
            <div class="flex items-center space-x-2">
                <label class="text-sm font-medium text-gray-700">Status:</label>
                <select class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    <option value="">Semua Status</option>
                    <option value="success">Berhasil</option>
                    <option value="pending">Menunggu</option>
                    <option value="failed">Gagal</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Transactions List -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-900">Daftar Transaksi</h2>
            <div class="flex space-x-2">
                <button class="bg-gray-100 text-gray-700 px-3 py-2 rounded-lg text-sm hover:bg-gray-200">
                    <i class="fas fa-download mr-1"></i>
                    Export
                </button>
            </div>
        </div>

        <div class="space-y-4">
            @forelse($transactions as $transaction)
            <div class="border rounded-lg p-6 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center
                            @if($transaction->type == 'topup') bg-green-100 text-green-600
                            @elseif($transaction->type == 'investment') bg-blue-100 text-blue-600
                            @elseif($transaction->type == 'withdrawal') bg-red-100 text-red-600
                            @else bg-purple-100 text-purple-600 @endif">
                            @if($transaction->type == 'topup')
                                <i class="fas fa-plus text-lg"></i>
                            @elseif($transaction->type == 'investment')
                                <i class="fas fa-chart-line text-lg"></i>
                            @elseif($transaction->type == 'withdrawal')
                                <i class="fas fa-money-bill-wave text-lg"></i>
                            @else
                                <i class="fas fa-gift text-lg"></i>
                            @endif
                        </div>
                        
                        <div>
                            <h3 class="font-semibold text-gray-900">
                                @if($transaction->type == 'topup') Top-up Wallet
                                @elseif($transaction->type == 'investment') Investasi
                                @elseif($transaction->type == 'withdrawal') Penarikan Dana
                                @else Reward
                                @endif
                            </h3>
                            <p class="text-sm text-gray-500">{{ $transaction->created_at->format('d M Y H:i') }}</p>
                            <p class="text-sm text-gray-600">{{ $transaction->description }}</p>
                        </div>
                    </div>
                    
                    <div class="text-right">
                        <div class="text-lg font-bold 
                            @if($transaction->amount > 0) text-green-600 @else text-red-600 @endif">
                            @if($transaction->amount > 0)
                                +Rp {{ number_format($transaction->amount) }}
                            @else
                                -Rp {{ number_format(abs($transaction->amount)) }}
                            @endif
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Berhasil
                        </span>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-12">
                <i class="fas fa-receipt text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Transaksi</h3>
                <p class="text-gray-500 mb-4">Mulai melakukan transaksi untuk melihat riwayat di sini.</p>
                <a href="{{ route('wallet.topup') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors">
                    Top-up Wallet
                </a>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($transactions->hasPages())
        <div class="mt-6">
            {{ $transactions->links() }}
        </div>
        @endif
    </div>

    <!-- Transaction Chart -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Grafik Transaksi</h2>
        <div class="h-64 bg-gray-50 rounded-lg flex items-center justify-center">
            <div class="text-center">
                <i class="fas fa-chart-line text-gray-400 text-4xl mb-2"></i>
                <p class="text-gray-500">Grafik transaksi akan ditampilkan di sini</p>
            </div>
        </div>
    </div>
</div>
@endsection 