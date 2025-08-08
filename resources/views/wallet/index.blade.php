@extends('layouts.app')

@section('title', 'Wallet')

@section('content')
<div class="min-h-screen bg-green-50 py-2 px-1 flex flex-col items-center">
    <div class="w-full max-w-md space-y-4">
        <!-- Header & Balance Card -->
        <div class="bg-gradient-to-r from-green-400 to-green-600 rounded-3xl shadow-xl p-6 text-white flex items-center justify-between mb-2">
            <div>
                <h2 class="text-lg font-bold mb-1 flex items-center"><i class="fas fa-wallet mr-2"></i> Saldo Wallet</h2>
                <p class="text-3xl font-extrabold">Rp {{ number_format($user->wallet_balance) }}</p>
                <p class="text-green-100 mt-1 text-xs">Saldo tersedia untuk investasi</p>
            </div>
            <div class="flex flex-col space-y-2">
                <a href="{{ route('wallet.topup') }}" class="bg-white bg-opacity-90 text-green-600 font-bold rounded-xl px-4 py-2 shadow hover:bg-green-100 flex items-center justify-center transition">
                    <i class="fas fa-plus mr-2"></i> Top Up
                </a>
                <a href="{{ route('wallet.withdrawal') }}" class="bg-white bg-opacity-90 text-blue-600 font-bold rounded-xl px-4 py-2 shadow hover:bg-blue-100 flex items-center justify-center transition">
                    <i class="fas fa-download mr-2"></i> Tarik Dana
                </a>
            </div>
        </div>
        <!-- Quick Stats -->
        <div class="grid grid-cols-3 gap-3 mb-2">
            <div class="bg-white rounded-2xl shadow p-3 flex flex-col items-center">
                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mb-1">
                    <i class="fas fa-plus text-green-600 text-lg"></i>
                </div>
                <div class="text-xs text-gray-500">Total Top Up</div>
                <div class="text-base font-bold text-gray-900">Rp {{ number_format($user->walletTransactions()->topups()->sum('amount') ?? 0) }}</div>
            </div>
            <div class="bg-white rounded-2xl shadow p-3 flex flex-col items-center">
                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mb-1">
                    <i class="fas fa-chart-line text-blue-600 text-lg"></i>
                </div>
                <div class="text-xs text-gray-500">Total Investasi</div>
                <div class="text-base font-bold text-gray-900">Rp {{ number_format(abs($user->walletTransactions()->investments()->sum('amount') ?? 0)) }}</div>
            </div>
            <div class="bg-white rounded-2xl shadow p-3 flex flex-col items-center">
                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center mb-1">
                    <i class="fas fa-download text-red-600 text-lg"></i>
                </div>
                <div class="text-xs text-gray-500">Total Penarikan</div>
                <div class="text-base font-bold text-gray-900">Rp {{ number_format(abs($user->walletTransactions()->withdrawals()->sum('amount') ?? 0)) }}</div>
            </div>
        </div>
        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl shadow p-4 flex items-center justify-between mb-2">
            <a href="{{ route('wallet.topup') }}" class="flex flex-col items-center flex-1 mx-1 bg-gradient-to-r from-green-400 to-green-500 text-white font-bold rounded-xl py-3 shadow hover:from-green-500 hover:to-green-600 transition">
                <i class="fas fa-plus text-2xl mb-1"></i>
                <span class="text-xs">Top Up</span>
            </a>
            <a href="{{ route('wallet.withdrawal') }}" class="flex flex-col items-center flex-1 mx-1 bg-gradient-to-r from-blue-400 to-blue-500 text-white font-bold rounded-xl py-3 shadow hover:from-blue-500 hover:to-blue-600 transition">
                <i class="fas fa-download text-2xl mb-1"></i>
                <span class="text-xs">Tarik Dana</span>
            </a>
            <a href="{{ route('wallet.transactions') }}" class="flex flex-col items-center flex-1 mx-1 bg-gradient-to-r from-purple-400 to-purple-500 text-white font-bold rounded-xl py-3 shadow hover:from-purple-500 hover:to-purple-600 transition">
                <i class="fas fa-history text-2xl mb-1"></i>
                <span class="text-xs">Transaksi</span>
            </a>
        </div>
        <!-- Recent Transactions -->
        <div class="bg-white rounded-3xl shadow-xl p-5">
            <div class="flex justify-between items-center mb-3">
                <h2 class="text-lg font-bold text-gray-900">Transaksi Terbaru</h2>
                <a href="{{ route('wallet.transactions') }}" class="text-green-600 hover:text-green-700 text-xs font-bold">Lihat Semua</a>
            </div>
            <div class="space-y-3">
                @forelse($transactions as $transaction)
                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-xl hover:bg-green-50 transition">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center
                        @if($transaction->type == 'topup') bg-green-100 @elseif($transaction->type == 'investment') bg-blue-100 @elseif($transaction->type == 'withdrawal') bg-red-100 @else bg-gray-100 @endif">
                        <i class="fas @if($transaction->type == 'topup') fa-plus @elseif($transaction->type == 'investment') fa-chart-line @elseif($transaction->type == 'withdrawal') fa-download @else fa-minus @endif
                            @if($transaction->type == 'topup') text-green-600 @elseif($transaction->type == 'investment') text-blue-600 @elseif($transaction->type == 'withdrawal') text-red-600 @else text-gray-600 @endif text-lg"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-gray-900 text-sm">{{ $transaction->description }}</p>
                        <p class="text-xs text-gray-500">{{ $transaction->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold @if($transaction->amount > 0) text-green-600 @else text-red-600 @endif text-sm">
                            @if($transaction->amount > 0)+@endif Rp {{ number_format(abs($transaction->amount)) }}
                        </p>
                        <p class="text-[10px] text-gray-400 capitalize">{{ $transaction->type }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <i class="fas fa-wallet text-gray-400 text-4xl mb-4"></i>
                    <p class="text-gray-500">Belum ada transaksi</p>
                </div>
                @endforelse
            </div>
            @if($transactions->hasPages())
            <div class="mt-4">
                {{ $transactions->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection 