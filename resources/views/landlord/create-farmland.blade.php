@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-blue-50 pb-24">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('landlord.farmlands') }}" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div class="bg-green-100 rounded-full p-2">
                        <i class="fas fa-plus text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Daftarkan Lahan Baru</h1>
                        <p class="text-sm text-gray-600">Upload informasi dan dokumen legalitas lahan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @if($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6">
            <div class="flex items-center mb-2">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                <strong>Terjadi Kesalahan:</strong>
            </div>
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Informasi Lahan</h2>
                <p class="text-sm text-gray-600">Lengkapi data lahan dan upload dokumen yang diperlukan</p>
            </div>
            
            <form action="{{ route('landlord.farmlands.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                
                <!-- Basic Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                            Lokasi Lahan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="location" name="location" value="{{ old('location') }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            placeholder="Contoh: Desa Sukamaju, Kec. Cianjur, Jawa Barat">
                    </div>
                    
                    <div>
                        <label for="size" class="block text-sm font-medium text-gray-700 mb-2">
                            Luas Lahan (Hektar) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="size" name="size" value="{{ old('size') }}" step="0.1" min="0.1" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            placeholder="Contoh: 2.5">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="rental_price" class="block text-sm font-medium text-gray-700 mb-2">
                            Harga Sewa per Bulan (Rp) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="rental_price" name="rental_price" value="{{ old('rental_price') }}" min="0" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            placeholder="Contoh: 5000000">
                    </div>
                    
                    <div>
                        <label for="crop_type" class="block text-sm font-medium text-gray-700 mb-2">
                            Jenis Tanaman yang Cocok
                        </label>
                        <input type="text" id="crop_type" name="crop_type" value="{{ old('crop_type') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            placeholder="Contoh: Padi, Jagung, Sayuran">
                    </div>
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi Lahan
                    </label>
                    <textarea id="description" name="description" rows="4"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                        placeholder="Deskripsikan kondisi lahan, akses jalan, sumber air, dan fasilitas lainnya...">{{ old('description') }}</textarea>
                </div>

                <!-- Document Upload Section -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-upload text-green-600 mr-2"></i>
                        Upload Dokumen Legalitas
                    </h3>
                    <p class="text-sm text-gray-600 mb-6">Upload dokumen untuk mempercepat proses verifikasi lahan</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Certificate Upload -->
                        <div>
                            <label for="certificate_document" class="block text-sm font-medium text-gray-700 mb-2">
                                Sertifikat Lahan (PDF, JPG, PNG)
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-green-500 transition-colors">
                                <input type="file" id="certificate_document" name="certificate_document" 
                                    accept=".pdf,.jpg,.jpeg,.png" class="hidden" onchange="updateFileName(this, 'cert-filename')">
                                <label for="certificate_document" class="cursor-pointer">
                                    <div class="text-gray-400 mb-2">
                                        <i class="fas fa-certificate text-3xl"></i>
                                    </div>
                                    <div class="text-sm text-gray-600">
                                        <span class="text-green-600 font-medium">Klik untuk upload</span> sertifikat lahan
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        Maksimal 5MB (PDF, JPG, PNG)
                                    </div>
                                </label>
                                <div id="cert-filename" class="mt-2 text-sm text-green-600 hidden"></div>
                            </div>
                        </div>

                        <!-- Map Upload -->
                        <div>
                            <label for="location_map" class="block text-sm font-medium text-gray-700 mb-2">
                                Peta Lokasi (PDF, JPG, PNG)
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-green-500 transition-colors">
                                <input type="file" id="location_map" name="location_map" 
                                    accept=".pdf,.jpg,.jpeg,.png" class="hidden" onchange="updateFileName(this, 'map-filename')">
                                <label for="location_map" class="cursor-pointer">
                                    <div class="text-gray-400 mb-2">
                                        <i class="fas fa-map text-3xl"></i>
                                    </div>
                                    <div class="text-sm text-gray-600">
                                        <span class="text-green-600 font-medium">Klik untuk upload</span> peta lokasi
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        Maksimal 5MB (PDF, JPG, PNG)
                                    </div>
                                </label>
                                <div id="map-filename" class="mt-2 text-sm text-green-600 hidden"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mt-6">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-blue-600 mt-1 mr-3"></i>
                        <div class="text-sm text-blue-700">
                            <p class="font-medium mb-1">Informasi Verifikasi:</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>Lahan akan diverifikasi oleh tim admin dalam 1-3 hari kerja</li>
                                <li>Upload dokumen yang lengkap akan mempercepat proses verifikasi</li>
                                <li>Anda akan mendapat notifikasi setelah proses verifikasi selesai</li>
                                <li>Lahan yang terverifikasi dapat langsung menerima proyek pertanian</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200 mt-6">
                    <a href="{{ route('landlord.farmlands') }}" class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>
                        Daftarkan Lahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function updateFileName(input, displayId) {
    const display = document.getElementById(displayId);
    if (input.files && input.files[0]) {
        display.textContent = input.files[0].name;
        display.classList.remove('hidden');
    } else {
        display.classList.add('hidden');
    }
}
</script>
@endsection