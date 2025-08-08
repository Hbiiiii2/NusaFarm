@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-yellow-50 via-white to-orange-50 pb-24">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <div class="bg-yellow-100 rounded-full p-2">
                        <i class="fas fa-map-marker-alt text-yellow-600 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Kelola Lahan</h1>
                        <p class="text-sm text-gray-600">Lahan yang disetujui admin dan perlu dikonfigurasi</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        Manajer Lapangan
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="bg-blue-100 rounded-full p-2 mr-3">
                        <i class="fas fa-clock text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Menunggu Konfigurasi</p>
                        <p class="text-lg font-bold text-gray-900">{{ $farmlands->total() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="bg-green-100 rounded-full p-2 mr-3">
                        <i class="fas fa-seedling text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Siap Investasi</p>
                        <p class="text-lg font-bold text-gray-900">{{ \App\Models\Farmland::where('status', 'ready_for_investment')->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="bg-purple-100 rounded-full p-2 mr-3">
                        <i class="fas fa-project-diagram text-purple-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Proyek</p>
                        <p class="text-lg font-bold text-gray-900">{{ \App\Models\Project::count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Farmlands Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Lahan yang Perlu Dikonfigurasi</h2>
                <p class="text-sm text-gray-600">Konfigurasi periode investasi dan jumlah investasi yang diperlukan</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Lahan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pemilik
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ukuran
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Disetujui Oleh
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($farmlands as $farmland)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $farmland->location }}</div>
                                    <div class="text-sm text-gray-500">{{ $farmland->crop_type ?? 'Belum ditentukan' }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $farmland->landlord->name }}</div>
                                <div class="text-sm text-gray-500">{{ $farmland->landlord->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $farmland->size }} ha</div>
                                <div class="text-sm text-gray-500">Rp {{ number_format($farmland->rental_price) }}/bulan</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $farmland->approvedByAdmin->name ?? 'Admin' }}</div>
                                <div class="text-sm text-gray-500">Admin</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $farmland->approved_by_admin_at ? $farmland->approved_by_admin_at->format('d/m/Y') : '-' }}</div>
                                <div class="text-sm text-gray-500">{{ $farmland->approved_by_admin_at ? $farmland->approved_by_admin_at->format('H:i') : '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('manajer.farmlands.setup', $farmland) }}" 
                                   class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700">
                                    <i class="fas fa-cog mr-1"></i> Konfigurasi
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                Tidak ada lahan yang menunggu konfigurasi
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($farmlands->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $farmlands->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection 