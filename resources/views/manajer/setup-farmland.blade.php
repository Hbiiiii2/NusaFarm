@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-yellow-50 via-white to-orange-50 pb-24">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <div class="bg-yellow-100 rounded-full p-2">
                        <i class="fas fa-cog text-yellow-600 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Konfigurasi Lahan</h1>
                        <p class="text-sm text-gray-600">Atur periode investasi dan jumlah investasi yang diperlukan</p>
                    </div>
                </div>
                <a href="{{ route('manajer.farmlands') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Farmland Info -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Lahan</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-600">Lokasi</p>
                    <p class="text-lg text-gray-900">{{ $farmland->location }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Ukuran</p>
                    <p class="text-lg text-gray-900">{{ $farmland->size }} hektar</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Harga Sewa</p>
                    <p class="text-lg text-gray-900">Rp {{ number_format($farmland->rental_price) }}/bulan</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Jenis Tanaman</p>
                    <p class="text-lg text-gray-900">{{ $farmland->crop_type ?? 'Belum ditentukan' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Pemilik</p>
                    <p class="text-lg text-gray-900">{{ $farmland->landlord->name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Email</p>
                    <p class="text-lg text-gray-900">{{ $farmland->landlord->email }}</p>
                </div>
            </div>
        </div>

        <!-- Configuration Form -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Konfigurasi Investasi</h2>
            <form action="{{ route('manajer.farmlands.ready-for-investment', $farmland) }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="investment_period_months" class="block text-sm font-medium text-gray-700 mb-2">
                            Periode Investasi (Bulan) *
                        </label>
                        <input type="number" 
                               id="investment_period_months" 
                               name="investment_period_months" 
                               min="1" 
                               max="60" 
                               step="0.5"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Contoh: 12"
                               required>
                        <p class="text-xs text-gray-500 mt-1">Durasi investasi dalam bulan (1-60 bulan)</p>
                    </div>

                    <div>
                        <label for="required_investment_amount" class="block text-sm font-medium text-gray-700 mb-2">
                            Total Investasi yang Diperlukan (Rp) *
                        </label>
                        <input type="number" 
                               id="required_investment_amount" 
                               name="required_investment_amount" 
                               min="1000000" 
                               step="100000"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Contoh: 50000000"
                               required>
                        <p class="text-xs text-gray-500 mt-1">Total dana yang diperlukan untuk proyek ini</p>
                    </div>

                    <div>
                        <label for="minimum_investment_amount" class="block text-sm font-medium text-gray-700 mb-2">
                            Investasi Minimum per Investor (Rp) *
                        </label>
                        <input type="number" 
                               id="minimum_investment_amount" 
                               name="minimum_investment_amount" 
                               min="100000" 
                               step="10000"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Contoh: 1000000"
                               required>
                        <p class="text-xs text-gray-500 mt-1">Jumlah minimum yang dapat diinvestasikan per investor</p>
                    </div>

                    <div>
                        <label for="expected_roi" class="block text-sm font-medium text-gray-700 mb-2">
                            ROI yang Diharapkan (%)
                        </label>
                        <input type="number" 
                               id="expected_roi" 
                               name="expected_roi" 
                               min="5" 
                               max="100" 
                               step="0.1"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Contoh: 25"
                               value="20">
                        <p class="text-xs text-gray-500 mt-1">Return on Investment yang diharapkan dalam persen</p>
                    </div>
                </div>

                <div class="mt-6">
                    <label for="investment_notes" class="block text-sm font-medium text-gray-700 mb-2">
                        Catatan Investasi
                    </label>
                    <textarea id="investment_notes" 
                              name="investment_notes" 
                              rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Jelaskan detail proyek, risiko, dan informasi penting lainnya untuk investor..."></textarea>
                    <p class="text-xs text-gray-500 mt-1">Informasi tambahan yang akan ditampilkan kepada investor</p>
                </div>

                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('manajer.farmlands') }}" 
                       class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400">
                        Batal
                    </a>
                    <button type="submit" 
                            class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                        <i class="fas fa-check mr-2"></i> Siapkan untuk Investasi
                    </button>
                </div>
            </form>
        </div>

        <!-- Investment Preview -->
        <div class="bg-blue-50 rounded-xl p-6 mt-6">
            <h3 class="text-lg font-semibold text-blue-900 mb-4">
                <i class="fas fa-eye mr-2"></i> Preview untuk Investor
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white rounded-lg p-4">
                    <p class="text-sm font-medium text-gray-600">Periode Investasi</p>
                    <p class="text-lg font-bold text-gray-900" id="preview-period">-</p>
                </div>
                <div class="bg-white rounded-lg p-4">
                    <p class="text-sm font-medium text-gray-600">Total Investasi</p>
                    <p class="text-lg font-bold text-gray-900" id="preview-total">-</p>
                </div>
                <div class="bg-white rounded-lg p-4">
                    <p class="text-sm font-medium text-gray-600">Investasi Minimum</p>
                    <p class="text-lg font-bold text-gray-900" id="preview-minimum">-</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const periodInput = document.getElementById('investment_period_months');
    const totalInput = document.getElementById('required_investment_amount');
    const minimumInput = document.getElementById('minimum_investment_amount');
    
    const previewPeriod = document.getElementById('preview-period');
    const previewTotal = document.getElementById('preview-total');
    const previewMinimum = document.getElementById('preview-minimum');
    
    function updatePreview() {
        if (periodInput.value) {
            previewPeriod.textContent = periodInput.value + ' bulan';
        }
        if (totalInput.value) {
            previewTotal.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(totalInput.value);
        }
        if (minimumInput.value) {
            previewMinimum.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(minimumInput.value);
        }
    }
    
    periodInput.addEventListener('input', updatePreview);
    totalInput.addEventListener('input', updatePreview);
    minimumInput.addEventListener('input', updatePreview);
});
</script>
@endpush
@endsection 