@extends('layouts.app')

@section('title', 'Penarikan Dana')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Penarikan Dana</h1>
        <p class="text-gray-600">Tarik dana dari wallet ke rekening bank Anda</p>
    </div>

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

        <form action="{{ route('wallet.process-withdrawal') }}" method="POST">
            @csrf
            
            <!-- Current Balance -->
            <div class="mb-6 p-4 bg-green-50 rounded-lg">
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-700">Saldo Tersedia:</span>
                    <span class="text-2xl font-bold text-green-600">Rp {{ number_format($user->wallet_balance) }}</span>
                </div>
            </div>

            <!-- Bank Account Selection -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-3">Pilih Rekening Bank</label>
                <div class="space-y-3">
                    <label class="bank-option border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:border-green-500 transition-colors">
                        <input type="radio" name="bank_account" value="bca" class="sr-only" checked>
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                                <span class="text-white font-bold text-sm">BCA</span>
                            </div>
                            <div>
                                <div class="font-medium text-gray-900">Bank Central Asia</div>
                                <div class="text-sm text-gray-500">**** 1234 - {{ $user->name }}</div>
                            </div>
                        </div>
                    </label>
                    
                    <label class="bank-option border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:border-green-500 transition-colors">
                        <input type="radio" name="bank_account" value="mandiri" class="sr-only">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center">
                                <span class="text-white font-bold text-sm">MDR</span>
                            </div>
                            <div>
                                <div class="font-medium text-gray-900">Bank Mandiri</div>
                                <div class="text-sm text-gray-500">**** 5678 - {{ $user->name }}</div>
                            </div>
                        </div>
                    </label>
                    
                    <label class="bank-option border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:border-green-500 transition-colors">
                        <input type="radio" name="bank_account" value="bni" class="sr-only">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-yellow-600 rounded-lg flex items-center justify-center">
                                <span class="text-white font-bold text-sm">BNI</span>
                            </div>
                            <div>
                                <div class="font-medium text-gray-900">Bank Negara Indonesia</div>
                                <div class="text-sm text-gray-500">**** 9012 - {{ $user->name }}</div>
                            </div>
                        </div>
                    </label>
                </div>
                @error('bank_account')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Withdrawal Amount -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-3">Nominal Penarikan</label>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mb-4">
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

                <!-- Custom Amount Input -->
                <div id="custom-amount" style="display: none;">
                    <label for="custom_amount" class="block text-sm font-medium text-gray-700 mb-2">Nominal Custom</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                        <input type="number" id="custom_amount" name="custom_amount" min="50000" step="1000" 
                               class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('amount') border-red-500 @enderror" 
                               placeholder="Masukkan nominal penarikan">
                        @error('amount')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Hidden Amount Input -->
            <input type="hidden" name="amount" id="selected_amount" value="50000">

            <!-- Processing Time -->
            <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-clock text-blue-600"></i>
                    <div>
                        <div class="font-medium text-gray-900">Waktu Proses</div>
                        <div class="text-sm text-gray-600">1-3 hari kerja (Senin-Jumat)</div>
                    </div>
                </div>
            </div>

            <!-- Terms -->
            <div class="mb-6">
                <div class="flex items-center">
                    <input type="checkbox" id="terms" name="terms" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded" required>
                    <label for="terms" class="ml-2 block text-sm text-gray-700">
                        Saya setuju dengan <a href="#" class="text-green-600 hover:text-green-500">Syarat & Ketentuan</a> penarikan dana
                    </label>
                </div>
                @error('terms')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex space-x-3">
                <a href="{{ route('wallet.index') }}" class="flex-1 bg-gray-100 text-gray-700 px-6 py-3 rounded-lg text-center hover:bg-gray-200 transition-colors">
                    Batal
                </a>
                <button type="submit" class="flex-1 bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fas fa-money-bill-wave mr-2"></i>
                    Tarik Dana
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const amountBtns = document.querySelectorAll('.amount-btn');
    const bankOptions = document.querySelectorAll('.bank-option');
    const customAmountDiv = document.getElementById('custom-amount');
    const customAmountInput = document.getElementById('custom_amount');
    const selectedAmountInput = document.getElementById('selected_amount');
    const maxAmount = {{ $user->wallet_balance }};

    // Bank selection
    bankOptions.forEach(option => {
        const radio = option.querySelector('input[type="radio"]');
        
        option.addEventListener('click', function() {
            bankOptions.forEach(opt => {
                opt.classList.remove('border-green-500', 'bg-green-50');
                opt.classList.add('border-gray-200');
            });
            
            this.classList.remove('border-gray-200');
            this.classList.add('border-green-500', 'bg-green-50');
            
            radio.checked = true;
        });
        
        if (radio.checked) {
            option.classList.remove('border-gray-200');
            option.classList.add('border-green-500', 'bg-green-50');
        }
    });

    // Amount selection
    amountBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            amountBtns.forEach(b => b.classList.remove('border-green-500', 'bg-green-50'));
            
            this.classList.add('border-green-500', 'bg-green-50');
            
            const amount = this.dataset.amount;
            
            if (amount === 'custom') {
                customAmountDiv.style.display = 'block';
                customAmountInput.focus();
            } else {
                customAmountDiv.style.display = 'none';
                const numAmount = parseInt(amount);
                if (numAmount <= maxAmount) {
                    selectedAmountInput.value = amount;
                } else {
                    alert('Nominal melebihi saldo yang tersedia!');
                    amountBtns[0].click();
                }
            }
        });
    });

    customAmountInput.addEventListener('input', function() {
        const amount = parseInt(this.value) || 0;
        if (amount < 50000) {
            this.setCustomValidity('Minimal penarikan Rp 50.000');
        } else if (amount > maxAmount) {
            this.setCustomValidity('Nominal melebihi saldo yang tersedia');
        } else {
            this.setCustomValidity('');
        }
        selectedAmountInput.value = amount;
    });

    // Set default selection
    amountBtns[0].click();
});
</script>
@endpush
@endsection 