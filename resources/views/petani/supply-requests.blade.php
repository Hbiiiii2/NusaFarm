@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-green-100 pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
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
                            <p class="text-sm text-gray-600">Riwayat permintaan barang dan alat</p>
                        </div>
                    </div>
                    <a href="{{ route('petani.supply-requests.create') }}" 
                        class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Buat Permintaan Baru
                    </a>
                </div>
            </div>
        </div>

        <!-- Requests List -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Daftar Permintaan</h2>
            </div>
            <div class="p-6">
                @if($requests->count() > 0)
                    <div class="space-y-4">
                        @foreach($requests as $request)
                        <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3 mb-3">
                                        <div class="bg-blue-100 rounded-full p-2">
                                            <i class="fas fa-boxes text-blue-600"></i>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900">{{ $request->item_name }}</h3>
                                            <p class="text-sm text-gray-600">{{ $request->project->title ?? 'Proyek' }} - {{ $request->created_at->format('d M Y H:i') }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <p class="text-gray-700">{{ $request->description }}</p>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                        <div class="flex items-center space-x-2">
                                            <i class="fas fa-hashtag text-gray-500"></i>
                                            <span class="text-sm text-gray-600">Jumlah: {{ $request->quantity }} {{ $request->unit }}</span>
                                        </div>
                                        
                                        <div class="flex items-center space-x-2">
                                            <i class="fas fa-flag text-gray-500"></i>
                                            <span class="text-sm text-gray-600">Prioritas: 
                                                @if($request->priority === 'urgent')
                                                    <span class="text-red-600 font-medium">Urgent</span>
                                                @elseif($request->priority === 'high')
                                                    <span class="text-orange-600 font-medium">Tinggi</span>
                                                @elseif($request->priority === 'medium')
                                                    <span class="text-yellow-600 font-medium">Sedang</span>
                                                @else
                                                    <span class="text-green-600 font-medium">Rendah</span>
                                                @endif
                                            </span>
                                        </div>
                                        
                                        <div class="flex items-center space-x-2">
                                            <i class="fas fa-calendar text-gray-500"></i>
                                            <span class="text-sm text-gray-600">Dibuat: {{ $request->created_at->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                    
                                    @if($request->manager_notes)
                                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                                        <div class="flex">
                                            <i class="fas fa-comment text-yellow-400 mt-1 mr-3"></i>
                                            <div>
                                                <p class="text-sm font-medium text-yellow-800">Catatan Manajer:</p>
                                                <p class="text-sm text-yellow-700 mt-1">{{ $request->manager_notes }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    
                                    @if($request->approved_at)
                                    <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded mt-4">
                                        <div class="flex">
                                            <i class="fas fa-check text-green-400 mt-1 mr-3"></i>
                                            <div>
                                                <p class="text-sm font-medium text-green-800">Disetujui pada: {{ $request->approved_at->format('d M Y H:i') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    
                                    @if($request->fulfilled_at)
                                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded mt-4">
                                        <div class="flex">
                                            <i class="fas fa-truck text-blue-400 mt-1 mr-3"></i>
                                            <div>
                                                <p class="text-sm font-medium text-blue-800">Barang telah diterima pada: {{ $request->fulfilled_at->format('d M Y H:i') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                
                                <div class="ml-4">
                                    @if($request->status === 'fulfilled')
                                        <span class="bg-green-100 text-green-800 text-xs font-medium px-3 py-1 rounded-full">
                                            <i class="fas fa-check mr-1"></i>Selesai
                                        </span>
                                    @elseif($request->status === 'approved')
                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-3 py-1 rounded-full">
                                            <i class="fas fa-thumbs-up mr-1"></i>Disetujui
                                        </span>
                                    @elseif($request->status === 'rejected')
                                        <span class="bg-red-100 text-red-800 text-xs font-medium px-3 py-1 rounded-full">
                                            <i class="fas fa-times mr-1"></i>Ditolak
                                        </span>
                                    @else
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-3 py-1 rounded-full">
                                            <i class="fas fa-clock mr-1"></i>Pending
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $requests->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-boxes text-gray-400 text-5xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada permintaan</h3>
                        <p class="text-gray-500 mb-6">Mulai ajukan permintaan sarana produksi yang diperlukan</p>
                        <a href="{{ route('petani.supply-requests.create') }}" 
                            class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>
                            Buat Permintaan Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 