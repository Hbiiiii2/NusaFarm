@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-green-100 pb-24">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('petani.dashboard') }}" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-arrow-left text-xl"></i>
                        </a>
                        <div>
                            <h1 class="text-xl font-bold text-gray-900">Permintaan Sarana Produksi</h1>
                            <p class="text-sm text-gray-600">Ajukan permintaan barang atau alat yang diperlukan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow">
            <form action="{{ route('petani.supply-requests.store') }}" method="POST" class="p-6 space-y-6">
                @csrf
                
                <!-- Project Selection -->
                <div>
                    <label for="project_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Pilih Proyek <span class="text-red-500">*</span>
                    </label>
                    <select name="project_id" id="project_id" class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                        <option value="">Pilih proyek...</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                {{ $project->title }} - {{ $project->farmland->location ?? 'Lokasi tidak tersedia' }}
                            </option>
                        @endforeach
                    </select>
                    @error('project_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Item Name -->
                <div>
                    <label for="item_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Barang <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="item_name" id="item_name" value="{{ old('item_name') }}"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-green-500"
                        placeholder="Contoh: Pupuk NPK, Cangkul, Benih Jagung..." required>
                    @error('item_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi Detail <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description" id="description" rows="4" 
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-green-500"
                        placeholder="Jelaskan detail barang yang diperlukan, spesifikasi, atau alasan penggunaannya..." required>{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Quantity and Unit -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
                            Jumlah <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}" min="1"
                            class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            placeholder="Masukkan jumlah..." required>
                        @error('quantity')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="unit" class="block text-sm font-medium text-gray-700 mb-2">
                            Satuan <span class="text-red-500">*</span>
                        </label>
                        <select name="unit" id="unit" class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                            <option value="">Pilih satuan...</option>
                            <option value="kg" {{ old('unit') == 'kg' ? 'selected' : '' }}>Kilogram (kg)</option>
                            <option value="liter" {{ old('unit') == 'liter' ? 'selected' : '' }}>Liter</option>
                            <option value="buah" {{ old('unit') == 'buah' ? 'selected' : '' }}>Buah</option>
                            <option value="pack" {{ old('unit') == 'pack' ? 'selected' : '' }}>Pack</option>
                            <option value="karung" {{ old('unit') == 'karung' ? 'selected' : '' }}>Karung</option>
                            <option value="meter" {{ old('unit') == 'meter' ? 'selected' : '' }}>Meter</option>
                            <option value="set" {{ old('unit') == 'set' ? 'selected' : '' }}>Set</option>
                            <option value="unit" {{ old('unit') == 'unit' ? 'selected' : '' }}>Unit</option>
                        </select>
                        @error('unit')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Priority -->
                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">
                        Prioritas <span class="text-red-500">*</span>
                    </label>
                    <select name="priority" id="priority" class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                        <option value="">Pilih prioritas...</option>
                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Rendah - Bisa ditunda</option>
                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Sedang - Normal</option>
                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Tinggi - Segera diperlukan</option>
                        <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Urgent - Sangat mendesak</option>
                    </select>
                    @error('priority')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Priority Explanation -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex">
                        <i class="fas fa-info-circle text-blue-400 mt-1 mr-3"></i>
                        <div>
                            <h4 class="text-sm font-medium text-blue-800 mb-2">Panduan Prioritas:</h4>
                            <ul class="text-sm text-blue-700 space-y-1">
                                <li><strong>Rendah:</strong> Barang yang bisa ditunda atau tidak mendesak</li>
                                <li><strong>Sedang:</strong> Barang yang diperlukan dalam waktu normal</li>
                                <li><strong>Tinggi:</strong> Barang yang segera diperlukan untuk kelancaran kerja</li>
                                <li><strong>Urgent:</strong> Barang yang sangat mendesak dan kritis</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('petani.dashboard') }}" 
                        class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                        class="px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Kirim Permintaan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 