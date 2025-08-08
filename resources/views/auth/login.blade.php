@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-100 to-green-200 px-2">
    <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-6 sm:p-10 space-y-8">
        <div class="flex flex-col items-center space-y-2">
            <div class="bg-green-200 rounded-full p-4 mb-2 shadow-md">
                <i class="fas fa-chart-line text-green-600 text-3xl"></i>
            </div>
            <h1 class="text-2xl font-extrabold text-green-700 tracking-tight">NusaFarm</h1>
            <p class="text-green-500 text-sm font-medium">Agriculture Investment Platform</p>
            <span class="text-xs text-gray-500">"Grow your wealth while growing food!" 🥕🌾</span>
        </div>
        <div class="flex justify-between space-x-2 mt-2">
            <div class="bg-yellow-100 rounded-xl flex-1 text-center py-2 shadow-sm">
                <span class="font-bold text-yellow-700 text-sm">12% Avg ROI</span>
            </div>
            <div class="bg-green-100 rounded-xl flex-1 text-center py-2 shadow-sm">
                <span class="font-bold text-green-700 text-sm">500+ Farms</span>
            </div>
        </div>
        @if($errors->any())
        <div class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4 rounded-lg flex items-center space-x-3 mt-2">
            <i class="fas fa-exclamation-triangle text-orange-500 text-xl"></i>
            <div class="text-sm font-medium">Email atau password salah, coba masukan lagi</div>
        </div>
        @endif
        <form method="POST" action="{{ route('login') }}" class="space-y-5 mt-4">
            @csrf
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-green-400">
                    <i class="fas fa-envelope"></i>
                </span>
                <input type="text" name="email" placeholder="Email or Phone Number" class="w-full rounded-lg border border-gray-200 pl-10 pr-4 py-3 focus:ring-2 focus:ring-green-300 focus:border-green-400 transition text-sm" required>
            </div>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-green-400">
                    <i class="fas fa-lock"></i>
                </span>
                <input type="password" name="password" placeholder="Password" class="w-full rounded-lg border border-gray-200 pl-10 pr-4 py-3 focus:ring-2 focus:ring-green-300 focus:border-green-400 transition text-sm" required>
            </div>
            <div class="flex justify-end">
                <a href="#" class="text-xs text-green-600 hover:underline font-medium">Forgot Password?</a>
            </div>
            <button type="submit" class="w-full bg-gradient-to-r from-green-400 to-green-600 text-white rounded-lg py-3 font-bold shadow-lg hover:from-green-500 hover:to-green-700 transition text-base">Login</button>
        </form>
        <div class="flex items-center my-2">
            <div class="flex-1 border-t border-gray-200"></div>
            <span class="mx-2 text-gray-400 text-xs font-medium">or continue with</span>
            <div class="flex-1 border-t border-gray-200"></div>
        </div>
        <div class="flex space-x-2">
            <button class="flex-1 bg-white border border-gray-200 rounded-lg py-2 flex items-center justify-center space-x-2 hover:bg-gray-50 shadow-sm">
                <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/google/google-original.svg" class="w-5 h-5" alt="Google"> <span class="text-sm font-medium">Google</span>
            </button>
            <button class="flex-1 bg-white border border-gray-200 rounded-lg py-2 flex items-center justify-center space-x-2 hover:bg-gray-50 shadow-sm">
                <img src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg" class="w-5 h-5" alt="Apple"> <span class="text-sm font-medium">Apple</span>
            </button>
        </div>
        <div class="text-center text-xs text-gray-500 mt-2">
            Don't have an account? <a href="{{ route('register') }}" class="text-green-600 font-bold hover:underline">Register here</a>
        </div>
        <div class="text-center text-[10px] text-gray-400 mt-2">
            Your investments are secured and regulated
        </div>
    </div>
</div>
@endsection 