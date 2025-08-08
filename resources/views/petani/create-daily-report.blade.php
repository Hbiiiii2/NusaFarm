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
                            <h1 class="text-xl font-bold text-gray-900">Buat Laporan Harian</h1>
                            <p class="text-sm text-gray-600">Dokumentasikan kegiatan harian Anda</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow">
            <form action="{{ route('petani.daily-reports.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
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

                <!-- Activity Description -->
                <div>
                    <label for="activity_description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi Kegiatan <span class="text-red-500">*</span>
                    </label>
                    <textarea name="activity_description" id="activity_description" rows="4" 
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-green-500" 
                        placeholder="Jelaskan kegiatan yang Anda lakukan hari ini..." required>{{ old('activity_description') }}</textarea>
                    @error('activity_description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Weather Condition -->
                <div>
                    <label for="weather_condition" class="block text-sm font-medium text-gray-700 mb-2">
                        Kondisi Cuaca
                    </label>
                    <select name="weather_condition" id="weather_condition" class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="">Pilih kondisi cuaca...</option>
                        <option value="cerah" {{ old('weather_condition') == 'cerah' ? 'selected' : '' }}>Cerah</option>
                        <option value="berawan" {{ old('weather_condition') == 'berawan' ? 'selected' : '' }}>Berawan</option>
                        <option value="hujan" {{ old('weather_condition') == 'hujan' ? 'selected' : '' }}>Hujan</option>
                        <option value="angin" {{ old('weather_condition') == 'angin' ? 'selected' : '' }}>Angin</option>
                    </select>
                    @error('weather_condition')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Plant Condition -->
                <div>
                    <label for="plant_condition" class="block text-sm font-medium text-gray-700 mb-2">
                        Kondisi Tanaman
                    </label>
                    <textarea name="plant_condition" id="plant_condition" rows="3" 
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-green-500" 
                        placeholder="Jelaskan kondisi tanaman (pertumbuhan, kesehatan, dll)...">{{ old('plant_condition') }}</textarea>
                    @error('plant_condition')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pest Issues -->
                <div>
                    <label for="pest_issues" class="block text-sm font-medium text-gray-700 mb-2">
                        Masalah Hama/Penyakit
                    </label>
                    <textarea name="pest_issues" id="pest_issues" rows="3" 
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-green-500" 
                        placeholder="Jelaskan jika ada masalah hama atau penyakit...">{{ old('pest_issues') }}</textarea>
                    @error('pest_issues')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Photo Upload -->
                <div>
                    <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                        Foto Kegiatan
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-green-400 transition-colors">
                        <input type="file" name="photo" id="photo" accept="image/*" class="hidden" />
                        <label for="photo" class="cursor-pointer">
                            <i class="fas fa-camera text-gray-400 text-3xl mb-2"></i>
                            <p class="text-sm text-gray-600">Klik untuk upload foto</p>
                            <p class="text-xs text-gray-500 mt-1">JPG, PNG (max 2MB)</p>
                        </label>
                    </div>
                    @error('photo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Video Upload -->
                <div>
                    <label for="video" class="block text-sm font-medium text-gray-700 mb-2">
                        Video Kegiatan (Opsional)
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-green-400 transition-colors">
                        <input type="file" name="video" id="video" accept="video/*" class="hidden" />
                        <label for="video" class="cursor-pointer">
                            <i class="fas fa-video text-gray-400 text-3xl mb-2"></i>
                            <p class="text-sm text-gray-600">Klik untuk upload video</p>
                            <p class="text-xs text-gray-500 mt-1">MP4, MOV, AVI (max 10MB)</p>
                        </label>
                    </div>
                    @error('video')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('petani.dashboard') }}" 
                        class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                        class="px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Preview image when selected
document.getElementById('photo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.createElement('img');
            preview.src = e.target.result;
            preview.className = 'mt-2 rounded-lg max-w-xs';
            const container = document.getElementById('photo').parentElement;
            const existingPreview = container.querySelector('img');
            if (existingPreview) {
                existingPreview.remove();
            }
            container.appendChild(preview);
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection 