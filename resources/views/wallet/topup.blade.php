@extends('layouts.app')

@section('title', 'Top Up Wallet')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Top Up Wallet</h1>
        <p class="text-gray-600">Tambah saldo wallet untuk investasi</p>
    </div>

    <!-- Top Up Form -->
    <div class="bg-white rounded-xl shadow-lg p-8">
        @if($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('wallet.process-topup') }}" method="POST">
            @csrf
            
            <!-- Amount Selection -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-3">Pilih Nominal</label>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    <button type="button" class="amount-btn border-2 border-gray-200 rounded-lg p-4 text-center hover:border-green-500 focus:border-green-500 focus:outline-none" data-amount="50000">
                        <div class="text-lg font-semibold text-gray-900">Rp 50.000</div>
                        <div class="text-sm text-gray-500">Minimal</div>
                    </button>
                    <button type="button" class="amount-btn border-2 border-gray-200 rounded-lg p-4 text-center hover:border-green-500 focus:border-green-500 focus:outline-none" data-amount="100000">
                        <div class="text-lg font-semibold text-gray-900">Rp 100.000</div>
                        <div class="text-sm text-gray-500">Populer</div>
                    </button>
                    <button type="button" class="amount-btn border-2 border-gray-200 rounded-lg p-4 text-center hover:border-green-500 focus:border-green-500 focus:outline-none" data-amount="250000">
                        <div class="text-lg font-semibold text-gray-900">Rp 250.000</div>
                        <div class="text-sm text-gray-500">Recommended</div>
                    </button>
                    <button type="button" class="amount-btn border-2 border-gray-200 rounded-lg p-4 text-center hover:border-green-500 focus:border-green-500 focus:outline-none" data-amount="500000">
                        <div class="text-lg font-semibold text-gray-900">Rp 500.000</div>
                        <div class="text-sm text-gray-500">Investasi</div>
                    </button>
                    <button type="button" class="amount-btn border-2 border-gray-200 rounded-lg p-4 text-center hover:border-green-500 focus:border-green-500 focus:outline-none" data-amount="1000000">
                        <div class="text-lg font-semibold text-gray-900">Rp 1.000.000</div>
                        <div class="text-sm text-gray-500">Premium</div>
                    </button>
                    <button type="button" class="amount-btn border-2 border-gray-200 rounded-lg p-4 text-center hover:border-green-500 focus:border-green-500 focus:outline-none" data-amount="custom">
                        <div class="text-lg font-semibold text-gray-900">Custom</div>
                        <div class="text-sm text-gray-500">Nominal lain</div>
                    </button>
                </div>
            </div>

            <!-- Custom Amount Input -->
            <div class="mb-6" id="custom-amount" style="display: none;">
                <label for="custom_amount" class="block text-sm font-medium text-gray-700 mb-2">Nominal Custom</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                    <input type="number" id="custom_amount" name="custom_amount" min="10000" step="1000" 
                           class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('amount') border-red-500 @enderror" 
                           placeholder="Masukkan nominal">
                    @error('amount')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Hidden Amount Input -->
            <input type="hidden" name="amount" id="selected_amount" value="50000">

            <!-- Payment Method -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-3">Metode Pembayaran</label>
                <div class="space-y-3">
                    <label class="flex items-center space-x-3 p-4 border rounded-lg hover:bg-gray-50 cursor-pointer">
                        <input type="radio" name="payment_method" value="bank_transfer" class="text-green-600 focus:ring-green-500" checked>
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-university text-blue-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Transfer Bank</p>
                                <p class="text-sm text-gray-500">BCA, Mandiri, BNI, BRI</p>
                            </div>
                        </div>
                    </label>

                    <label class="flex items-center space-x-3 p-4 border rounded-lg hover:bg-gray-50 cursor-pointer">
                        <input type="radio" name="payment_method" value="credit_card" class="text-green-600 focus:ring-green-500">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-credit-card text-purple-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Kartu Kredit</p>
                                <p class="text-sm text-gray-500">Visa, Mastercard, JCB</p>
                            </div>
                        </div>
                    </label>

                    <label class="flex items-center space-x-3 p-4 border rounded-lg hover:bg-gray-50 cursor-pointer">
                        <input type="radio" name="payment_method" value="e_wallet" class="text-green-600 focus:ring-green-500">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-mobile-alt text-orange-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">E-Wallet</p>
                                <p class="text-sm text-gray-500">GoPay, OVO, DANA, LinkAja</p>
                            </div>
                        </div>
                    </label>
                </div>
                @error('payment_method')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Summary -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Nominal Top Up:</span>
                    <span class="font-semibold text-gray-900" id="summary-amount">Rp 50.000</span>
                </div>
                <div class="flex justify-between items-center mt-2">
                    <span class="text-gray-600">Biaya Admin:</span>
                    <span class="font-semibold text-gray-900">Rp 0</span>
                </div>
                <div class="border-t pt-2 mt-2">
                    <div class="flex justify-between items-center">
                        <span class="font-medium text-gray-900">Total:</span>
                        <span class="font-bold text-lg text-green-600" id="summary-total">Rp 50.000</span>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex space-x-3">
                <a href="{{ route('wallet.index') }}" class="flex-1 bg-gray-100 text-gray-700 px-6 py-3 rounded-lg text-center hover:bg-gray-200 transition-colors">
                    Batal
                </a>
                <button type="submit" class="flex-1 bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors">
                    Top Up Sekarang
                </button>
            </div>
        </form>
    </div>

    <!-- Info -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-start space-x-3">
            <i class="fas fa-info-circle text-blue-600 mt-1"></i>
            <div>
                <h3 class="font-medium text-blue-900">Informasi Top Up</h3>
                <ul class="text-sm text-blue-800 mt-2 space-y-1">
                    <li>• Minimal top up Rp 50.000</li>
                    <li>• Maksimal top up Rp 100.000.000</li>
                    <li>• Proses top up akan diproses dalam 1-5 menit</li>
                    <li>• Saldo akan langsung ditambahkan ke wallet Anda</li>
                    <li>• Tidak ada biaya admin untuk top up</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const amountBtns = document.querySelectorAll('.amount-btn');
    const customAmountDiv = document.getElementById('custom-amount');
    const customAmountInput = document.getElementById('custom_amount');
    const selectedAmountInput = document.getElementById('selected_amount');
    const summaryAmount = document.getElementById('summary-amount');
    const summaryTotal = document.getElementById('summary-total');

    function updateSummary(amount) {
        const formattedAmount = new Intl.NumberFormat('id-ID').format(amount);
        summaryAmount.textContent = `Rp ${formattedAmount}`;
        summaryTotal.textContent = `Rp ${formattedAmount}`;
        selectedAmountInput.value = amount;
    }

    amountBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from all buttons
            amountBtns.forEach(b => b.classList.remove('border-green-500', 'bg-green-50'));
            
            // Add active class to clicked button
            this.classList.add('border-green-500', 'bg-green-50');
            
            const amount = this.dataset.amount;
            
            if (amount === 'custom') {
                customAmountDiv.style.display = 'block';
                customAmountInput.focus();
            } else {
                customAmountDiv.style.display = 'none';
                updateSummary(parseInt(amount));
            }
        });
    });

    customAmountInput.addEventListener('input', function() {
        const amount = parseInt(this.value) || 0;
        if (amount < 10000) {
            this.setCustomValidity('Minimal top up Rp 10.000');
        } else if (amount > 100000000) {
            this.setCustomValidity('Maksimal top up Rp 100.000.000');
        } else {
            this.setCustomValidity('');
        }
        updateSummary(amount);
    });

    // Set default selection
    amountBtns[0].click();
});
</script>
@endpush
@endsection 