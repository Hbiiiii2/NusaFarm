@extends('layouts.app')

@section('title', 'Investasi - ' . $farmland->location)

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Investasi</h1>
        <p class="text-gray-600">Pilih jumlah investasi untuk proyek ini</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Investment Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Form Investasi</h2>

                @if($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <ul class="list-disc list-inside text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('investments.store', $farmland) }}" method="POST">
                    @csrf
                    
                    <!-- Investment Amount -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Pilih Nominal Investasi</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            <button type="button" class="amount-btn border-2 border-gray-200 rounded-lg p-4 text-center hover:border-green-500 focus:border-green-500 focus:outline-none" data-amount="{{ $farmland->minimum_investment_amount }}">
                                <div class="text-lg font-semibold text-gray-900">Rp {{ number_format($farmland->minimum_investment_amount) }}</div>
                                <div class="text-sm text-gray-500">Minimal</div>
                            </button>
                            <button type="button" class="amount-btn border-2 border-gray-200 rounded-lg p-4 text-center hover:border-green-500 focus:border-green-500 focus:outline-none" data-amount="{{ $farmland->minimum_investment_amount * 2 }}">
                                <div class="text-lg font-semibold text-gray-900">Rp {{ number_format($farmland->minimum_investment_amount * 2) }}</div>
                                <div class="text-sm text-gray-500">Populer</div>
                            </button>
                            <button type="button" class="amount-btn border-2 border-gray-200 rounded-lg p-4 text-center hover:border-green-500 focus:border-green-500 focus:outline-none" data-amount="{{ $farmland->minimum_investment_amount * 5 }}">
                                <div class="text-lg font-semibold text-gray-900">Rp {{ number_format($farmland->minimum_investment_amount * 5) }}</div>
                                <div class="text-sm text-gray-500">Recommended</div>
                            </button>
                            <button type="button" class="amount-btn border-2 border-gray-200 rounded-lg p-4 text-center hover:border-green-500 focus:border-green-500 focus:outline-none" data-amount="{{ $farmland->minimum_investment_amount * 10 }}">
                                <div class="text-lg font-semibold text-gray-900">Rp {{ number_format($farmland->minimum_investment_amount * 10) }}</div>
                                <div class="text-sm text-gray-500">Investasi</div>
                            </button>
                            <button type="button" class="amount-btn border-2 border-gray-200 rounded-lg p-4 text-center hover:border-green-500 focus:border-green-500 focus:outline-none" data-amount="{{ $farmland->minimum_investment_amount * 20 }}">
                                <div class="text-lg font-semibold text-gray-900">Rp {{ number_format($farmland->minimum_investment_amount * 20) }}</div>
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
                            <input type="number" id="custom_amount" name="custom_amount" min="{{ $farmland->minimum_investment_amount }}" step="1000" 
                                   class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" 
                                   placeholder="Masukkan nominal investasi">
                        </div>
                    </div>

                    <!-- Hidden Amount Input -->
                    <input type="hidden" name="amount" id="selected_amount" value="{{ $farmland->minimum_investment_amount }}">

                    <!-- Terms -->
                    <div class="mb-6">
                        <div class="flex items-center">
                            <input type="checkbox" id="terms" name="terms" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded" required>
                            <label for="terms" class="ml-2 block text-sm text-gray-700">
                                Saya setuju dengan <a href="#" class="text-green-600 hover:text-green-500">Syarat & Ketentuan</a> investasi
                            </label>
                        </div>
                        @error('terms')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex space-x-3">
                        <a href="{{ route('investments.index') }}" class="flex-1 bg-gray-100 text-gray-700 px-6 py-3 rounded-lg text-center hover:bg-gray-200 transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="flex-1 bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors">
                            <i class="fas fa-chart-line mr-2"></i>
                            Investasi Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Farmland Details -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Detail Lahan</h3>
                
                <div class="space-y-4">
                    <div>
                        <h4 class="font-semibold text-gray-900">{{ $farmland->location }}</h4>
                        <p class="text-sm text-gray-600">
                            {{ $farmland->crop_type ?? 'Jenis tanaman belum ditentukan' }}
                        </p>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">15%</div>
                            <div class="text-xs text-gray-500">ROI Tahunan</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-semibold text-gray-900">
                                {{ $farmland->size ?? '-' }} ha
                            </div>
                            <div class="text-xs text-gray-500">Luas Lahan</div>
                        </div>
                    </div>
                    
                    <div class="border-t pt-4">
                        <h5 class="font-medium text-gray-900 mb-2">Periode Investasi</h5>
                        <p class="text-sm text-gray-600">
                            {{ $farmland->investment_period_months ?? 12 }} bulan
                        </p>
                    </div>
                    
                    <div class="border-t pt-4">
                        <h5 class="font-medium text-gray-900 mb-2">Jumlah Investasi</h5>
                        <p class="text-sm text-gray-600">
                            Rp {{ number_format($farmland->required_investment_amount) }}
                        </p>
                    </div>
                    
                    <div class="border-t pt-4">
                        <h5 class="font-medium text-gray-900 mb-2">Status Lahan</h5>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Siap Investasi
                        </span>
                    </div>
                </div>
            </div>

            <!-- Investment Summary -->
            <div class="bg-gray-50 rounded-xl p-6 mt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Investasi</h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Nominal Investasi:</span>
                        <span class="font-semibold text-gray-900" id="summary-amount">Rp 50.000</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">ROI:</span>
                        <span class="font-semibold text-green-600">15%</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Periode:</span>
                        <span class="font-semibold text-gray-900">
                            {{ $farmland->investment_period_months ?? 12 }} bulan
                        </span>
                    </div>
                    <div class="border-t pt-3">
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-900">Potensi Return:</span>
                            <span class="font-bold text-lg text-green-600" id="summary-return">Rp 62.500</span>
                        </div>
                    </div>
                </div>
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
    const summaryReturn = document.getElementById('summary-return');
    const roi = 15; // Annual ROI percentage

    function updateSummary(amount) {
        const formattedAmount = new Intl.NumberFormat('id-ID').format(amount);
        const potentialReturn = amount * (1 + roi / 100);
        const formattedReturn = new Intl.NumberFormat('id-ID').format(potentialReturn);
        
        summaryAmount.textContent = `Rp ${formattedAmount}`;
        summaryReturn.textContent = `Rp ${formattedReturn}`;
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
        updateSummary(amount);
    });

    // Set default selection
    amountBtns[0].click();
});
</script>
@endpush
@endsection 