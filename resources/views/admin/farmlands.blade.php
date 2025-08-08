@extends('layouts.app')

@section('title', 'Manajemen Lahan - Admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Manajemen Lahan</h1>
            <p class="text-gray-600">Kelola verifikasi dan status lahan pertanian</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 flex items-center space-x-2">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Lahan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $farmlands->total() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-map text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Menunggu Verifikasi</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $farmlands->where('status', 'pending_verification')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Disetujui Admin</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $farmlands->where('status', 'approved_by_admin')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check-circle text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Siap Investasi</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $farmlands->where('status', 'ready_for_investment')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-seedling text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Ditolak</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $farmlands->where('status', 'rejected')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-times text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Farmlands List -->
    <div class="bg-white rounded-xl shadow-lg">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Daftar Lahan</h2>
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
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Dokumen
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal Daftar
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
                                <div class="text-sm text-gray-500">{{ $farmland->size }} ha</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $farmland->landlord->name }}</div>
                            <div class="text-sm text-gray-500">{{ $farmland->landlord->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($farmland->status === 'ready_for_investment') bg-green-100 text-green-800
                                @elseif($farmland->status === 'approved_by_admin') bg-blue-100 text-blue-800
                                @elseif($farmland->status === 'pending_verification') bg-yellow-100 text-yellow-800
                                @elseif($farmland->status === 'rejected') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                @if($farmland->status === 'ready_for_investment') Siap Investasi
                                @elseif($farmland->status === 'approved_by_admin') Disetujui Admin
                                @elseif($farmland->status === 'pending_verification') Menunggu Verifikasi
                                @elseif($farmland->status === 'rejected') Ditolak
                                @else {{ $farmland->status }} @endif
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-2">
                                <div class="flex items-center">
                                    <i class="fas fa-certificate text-xs mr-1 {{ $farmland->certificate_path ? 'text-green-600' : 'text-gray-400' }}"></i>
                                    <span class="text-xs {{ $farmland->certificate_path ? 'text-green-600' : 'text-gray-400' }}">Sertifikat</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-map text-xs mr-1 {{ $farmland->map_path ? 'text-green-600' : 'text-gray-400' }}"></i>
                                    <span class="text-xs {{ $farmland->map_path ? 'text-green-600' : 'text-gray-400' }}">Peta</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $farmland->created_at->format('d M Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            @if($farmland->status === 'pending_verification')
                            <div class="flex space-x-2">
                                <button onclick="approveFarmland({{ $farmland->id }})" class="bg-green-600 text-white px-3 py-1 rounded text-xs hover:bg-green-700">
                                    <i class="fas fa-check mr-1"></i> Approve
                                </button>
                                <button onclick="rejectFarmland({{ $farmland->id }})" class="bg-red-600 text-white px-3 py-1 rounded text-xs hover:bg-red-700">
                                    <i class="fas fa-times mr-1"></i> Reject
                                </button>
                            </div>
                            @elseif($farmland->status === 'approved_by_admin')
                            <div class="text-xs text-blue-600">
                                <i class="fas fa-clock mr-1"></i> Menunggu Manajer Lapangan
                            </div>
                            @elseif($farmland->status === 'ready_for_investment')
                            <div class="text-xs text-green-600">
                                <i class="fas fa-check-circle mr-1"></i> Siap untuk Investasi
                            </div>
                            @elseif($farmland->status === 'rejected')
                            <div class="text-xs text-gray-500">
                                Ditolak: {{ $farmland->rejection_reason ?? 'Tidak ada alasan' }}
                            </div>
                            @else
                            <div class="text-xs text-gray-500">
                                Tidak ada aksi
                            </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada lahan yang ditemukan
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

<!-- Approve Modal -->
<div id="approveModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Approve Lahan</h3>
            <p class="text-sm text-gray-600 mb-4">Lahan akan disetujui dan dikirim ke manajer lapangan untuk konfigurasi investasi.</p>
            <form id="approveForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                    <textarea name="notes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Catatan untuk pemilik lahan..."></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeApproveModal()" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                        Batal
                    </button>
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                        Approve
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Reject Lahan</h3>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan *</label>
                    <textarea name="rejection_reason" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="Alasan penolakan..." required></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeRejectModal()" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                        Batal
                    </button>
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                        Reject
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function approveFarmland(farmlandId) {
    const modal = document.getElementById('approveModal');
    const form = document.getElementById('approveForm');
    form.action = `/admin/farmlands/${farmlandId}/approve`;
    modal.classList.remove('hidden');
}

function rejectFarmland(farmlandId) {
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');
    form.action = `/admin/farmlands/${farmlandId}/reject`;
    modal.classList.remove('hidden');
}

function closeApproveModal() {
    document.getElementById('approveModal').classList.add('hidden');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}

// Close modal when clicking outside
window.onclick = function(event) {
    const approveModal = document.getElementById('approveModal');
    const rejectModal = document.getElementById('rejectModal');
    
    if (event.target === approveModal) {
        closeApproveModal();
    }
    if (event.target === rejectModal) {
        closeRejectModal();
    }
}
</script>
@endpush
@endsection 