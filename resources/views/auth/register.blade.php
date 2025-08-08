@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-100 to-green-200 px-2">
    <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-8 space-y-6">
        <div class="flex flex-col items-center space-y-2">
            <div class="bg-green-200 rounded-full p-4 mb-2 shadow-md">
                <i class="fas fa-seedling text-green-600 text-3xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-green-700">NusaFarm</h1>
            <p class="text-green-500 text-sm">Agriculture Investment Platform</p>
            <span class="text-xs text-gray-500">"Grow your wealth while growing food!" 🥕🌾</span>
        </div>
        @if($errors->any())
        <div class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4 rounded-lg flex items-center space-x-3 mt-2">
            <i class="fas fa-exclamation-triangle text-orange-500 text-xl"></i>
            <div>
                @foreach($errors->all() as $error)
                    <div class="text-sm font-medium">{{ $error }}</div>
                @endforeach
            </div>
        </div>
        @endif
        <form action="{{ route('register') }}" method="POST" class="space-y-4 mt-2">
            @csrf
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-green-400">
                    <i class="fas fa-user"></i>
                </span>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama Lengkap" class="w-full rounded-lg border border-gray-200 pl-10 pr-4 py-3 focus:ring-2 focus:ring-green-300 focus:border-green-400 transition text-sm" required>
            </div>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-green-400">
                    <i class="fas fa-envelope"></i>
                </span>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" class="w-full rounded-lg border border-gray-200 pl-10 pr-4 py-3 focus:ring-2 focus:ring-green-300 focus:border-green-400 transition text-sm" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-2">Pilih Peran</label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="role-option border-2 border-gray-200 rounded-lg p-3 cursor-pointer hover:border-green-500 hover:shadow-md transition-all duration-200 flex flex-col items-center @if(old('role')=='user') border-green-500 bg-green-50 @endif">
                        <input type="radio" name="role" value="user" class="sr-only" {{ old('role') == 'user' ? 'checked' : '' }}>
                        <i class="fas fa-user-circle text-xl text-blue-600 mb-1"></i>
                        <span class="font-medium text-xs text-center">Investor</span>
                    </label>
                    <label class="role-option border-2 border-gray-200 rounded-lg p-3 cursor-pointer hover:border-green-500 hover:shadow-md transition-all duration-200 flex flex-col items-center @if(old('role')=='landlord') border-green-500 bg-green-50 @endif">
                        <input type="radio" name="role" value="landlord" class="sr-only" {{ old('role') == 'landlord' ? 'checked' : '' }}>
                        <i class="fas fa-home text-xl text-green-600 mb-1"></i>
                        <span class="font-medium text-xs text-center">Pemilik Lahan</span>
                    </label>
                    <label class="role-option border-2 border-gray-200 rounded-lg p-3 cursor-pointer hover:border-green-500 hover:shadow-md transition-all duration-200 flex flex-col items-center @if(old('role')=='petani') border-green-500 bg-green-50 @endif">
                        <input type="radio" name="role" value="petani" class="sr-only" {{ old('role') == 'petani' ? 'checked' : '' }}>
                        <i class="fas fa-seedling text-xl text-orange-600 mb-1"></i>
                        <span class="font-medium text-xs text-center">Petani</span>
                    </label>
                    <label class="role-option border-2 border-gray-200 rounded-lg p-3 cursor-pointer hover:border-green-500 hover:shadow-md transition-all duration-200 flex flex-col items-center @if(old('role')=='manajer_lapangan') border-green-500 bg-green-50 @endif">
                        <input type="radio" name="role" value="manajer_lapangan" class="sr-only" {{ old('role') == 'manajer_lapangan' ? 'checked' : '' }}>
                        <i class="fas fa-user-tie text-xl text-purple-600 mb-1"></i>
                        <span class="font-medium text-xs text-center">Manajer</span>
                    </label>
                    <label class="role-option border-2 border-gray-200 rounded-lg p-3 cursor-pointer hover:border-green-500 hover:shadow-md transition-all duration-200 flex flex-col items-center @if(old('role')=='logistik') border-green-500 bg-green-50 @endif">
                        <input type="radio" name="role" value="logistik" class="sr-only" {{ old('role') == 'logistik' ? 'checked' : '' }}>
                        <i class="fas fa-truck text-xl text-indigo-600 mb-1"></i>
                        <span class="font-medium text-xs text-center">Logistik</span>
                    </label>
                    <label class="role-option border-2 border-gray-200 rounded-lg p-3 cursor-pointer hover:border-green-500 hover:shadow-md transition-all duration-200 flex flex-col items-center @if(old('role')=='penyedia_pupuk') border-green-500 bg-green-50 @endif">
                        <input type="radio" name="role" value="penyedia_pupuk" class="sr-only" {{ old('role') == 'penyedia_pupuk' ? 'checked' : '' }}>
                        <i class="fas fa-leaf text-xl text-yellow-600 mb-1"></i>
                        <span class="font-medium text-xs text-center">Penyedia Pupuk</span>
                    </label>
                    <label class="role-option border-2 border-gray-200 rounded-lg p-3 cursor-pointer hover:border-green-500 hover:shadow-md transition-all duration-200 flex flex-col items-center @if(old('role')=='pedagang_pasar') border-green-500 bg-green-50 @endif">
                        <input type="radio" name="role" value="pedagang_pasar" class="sr-only" {{ old('role') == 'pedagang_pasar' ? 'checked' : '' }}>
                        <i class="fas fa-store text-xl text-red-600 mb-1"></i>
                        <span class="font-medium text-xs text-center">Pedagang Pasar</span>
                    </label>
                    <label class="role-option border-2 border-gray-200 rounded-lg p-3 cursor-pointer hover:border-green-500 hover:shadow-md transition-all duration-200 flex flex-col items-center @if(old('role')=='admin') border-green-500 bg-green-50 @endif">
                        <input type="radio" name="role" value="admin" class="sr-only" {{ old('role') == 'admin' ? 'checked' : '' }}>
                        <i class="fas fa-cog text-xl text-gray-600 mb-1"></i>
                        <span class="font-medium text-xs text-center">Admin</span>
                    </label>
                </div>
            </div>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-green-400">
                    <i class="fas fa-lock"></i>
                </span>
                <input type="password" name="password" placeholder="Password (min. 6 karakter)" class="w-full rounded-lg border border-gray-200 pl-10 pr-4 py-3 focus:ring-2 focus:ring-green-300 focus:border-green-400 transition text-sm" required>
            </div>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-green-400">
                    <i class="fas fa-lock"></i>
                </span>
                <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" class="w-full rounded-lg border border-gray-200 pl-10 pr-4 py-3 focus:ring-2 focus:ring-green-300 focus:border-green-400 transition text-sm" required>
            </div>
            <div class="flex items-center">
                <input type="checkbox" id="terms" name="terms" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded" required>
                <label for="terms" class="ml-2 block text-xs text-gray-700">
                    Saya setuju dengan <a href="#" class="text-green-600 hover:text-green-500">Syarat & Ketentuan</a> dan <a href="#" class="text-green-600 hover:text-green-500">Kebijakan Privasi</a>
                </label>
            </div>
            <button type="submit" class="w-full bg-gradient-to-r from-green-400 to-green-600 text-white py-3 rounded-lg font-bold shadow-lg hover:from-green-500 hover:to-green-700 transition text-base">
                <i class="fas fa-user-plus mr-2"></i> Daftar Sekarang
            </button>
        </form>
        
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleOptions = document.querySelectorAll('.role-option');
            const radioInputs = document.querySelectorAll('input[name="role"]');
            
            // Handle role selection
            roleOptions.forEach((option, index) => {
                option.addEventListener('click', function() {
                    // Remove active state from all options
                    roleOptions.forEach(opt => {
                        opt.classList.remove('border-green-500', 'bg-green-50');
                        opt.classList.add('border-gray-200');
                    });
                    
                    // Add active state to clicked option
                    this.classList.remove('border-gray-200');
                    this.classList.add('border-green-500', 'bg-green-50');
                    
                    // Check the corresponding radio input
                    const radioInput = this.querySelector('input[type="radio"]');
                    if (radioInput) {
                        radioInput.checked = true;
                    }
                });
            });
            
            // Set initial state based on old input or default
            radioInputs.forEach((input, index) => {
                if (input.checked) {
                    const parentLabel = input.closest('.role-option');
                    if (parentLabel) {
                        parentLabel.classList.remove('border-gray-200');
                        parentLabel.classList.add('border-green-500', 'bg-green-50');
                    }
                }
            });
        });
        </script>
        <div class="text-center text-xs text-gray-500 mt-2">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-green-600 font-bold hover:underline">Masuk di sini</a>
        </div>
    </div>
</div>
@endsection 