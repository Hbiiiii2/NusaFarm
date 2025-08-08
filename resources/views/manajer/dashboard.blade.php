@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-yellow-50 via-white to-orange-50 pb-24">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <div class="bg-yellow-100 rounded-full p-2">
                        <i class="fas fa-user-tie text-yellow-600 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Dashboard Manajer Lapangan</h1>
                        <p class="text-sm text-gray-600">Selamat datang, {{ auth()->user()->name }}!</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        Manajer Lapangan
                    </span>
                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        {{ $unreadMessages }} Pesan Baru
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="bg-green-100 rounded-full p-2 mr-3">
                        <i class="fas fa-project-diagram text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Proyek Dikelola</p>
                        <p class="text-lg font-bold text-gray-900">{{ $projects->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="bg-yellow-100 rounded-full p-2 mr-3">
                        <i class="fas fa-clock text-yellow-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Laporan Pending</p>
                        <p class="text-lg font-bold text-gray-900">{{ $pendingReports->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="bg-purple-100 rounded-full p-2 mr-3">
                        <i class="fas fa-boxes text-purple-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Permintaan Pending</p>
                        <p class="text-lg font-bold text-gray-900">{{ $pendingRequests->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="bg-blue-100 rounded-full p-2 mr-3">
                        <i class="fas fa-map-marker-alt text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Lahan Menunggu</p>
                        <p class="text-lg font-bold text-gray-900">{{ $pendingFarmlands->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-lg mb-6">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                    <a href="{{ route('manajer.farmlands') }}" class="flex flex-col items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                        <i class="fas fa-map-marker-alt text-blue-600 text-2xl mb-2"></i>
                        <span class="text-sm font-medium text-gray-900">Kelola Lahan</span>
                        @if($pendingFarmlands->count() > 0)
                        <span class="bg-red-500 text-white text-xs rounded-full px-2 py-1 mt-1">{{ $pendingFarmlands->count() }}</span>
                        @endif
                    </a>
                    
                    <a href="{{ route('manajer.reports') }}" class="flex flex-col items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors">
                        <i class="fas fa-chart-bar text-yellow-600 text-2xl mb-2"></i>
                        <span class="text-sm font-medium text-gray-900">Review Laporan</span>
                        @if($pendingReports->count() > 0)
                        <span class="bg-red-500 text-white text-xs rounded-full px-2 py-1 mt-1">{{ $pendingReports->count() }}</span>
                        @endif
                    </a>
                    
                    <a href="{{ route('manajer.supply-requests') }}" class="flex flex-col items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                        <i class="fas fa-boxes text-purple-600 text-2xl mb-2"></i>
                        <span class="text-sm font-medium text-gray-900">Permintaan Barang</span>
                        @if($pendingRequests->count() > 0)
                        <span class="bg-red-500 text-white text-xs rounded-full px-2 py-1 mt-1">{{ $pendingRequests->count() }}</span>
                        @endif
                    </a>
                    
                    <a href="{{ route('manajer.logistics') }}" class="flex flex-col items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                        <i class="fas fa-truck text-green-600 text-2xl mb-2"></i>
                        <span class="text-sm font-medium text-gray-900">Logistik</span>
                    </a>
                    
                    <a href="{{ route('manajer.chat') }}" class="flex flex-col items-center p-4 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors">
                        <i class="fas fa-comments text-indigo-600 text-2xl mb-2"></i>
                        <span class="text-sm font-medium text-gray-900">Chat</span>
                        @if($unreadMessages > 0)
                        <span class="bg-red-500 text-white text-xs rounded-full px-2 py-1 mt-1">{{ $unreadMessages }}</span>
                        @endif
                    </a>
                </div>
            </div>
        </div>

        <!-- Projects Overview -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Managed Projects -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Proyek yang Dikelola</h3>
                </div>
                <div class="p-6">
                    @if($projects->count() > 0)
                        <div class="space-y-4">
                            @foreach($projects->take(3) as $project)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="bg-green-100 rounded-full p-2">
                                        <i class="fas fa-project-diagram text-green-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $project->title }}</p>
                                        <p class="text-sm text-gray-600">{{ $project->farmland->location ?? 'No location' }}</p>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            @if($project->status === 'active') bg-green-100 text-green-800
                                            @elseif($project->status === 'planning') bg-blue-100 text-blue-800
                                            @elseif($project->status === 'finished') bg-gray-100 text-gray-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                            {{ ucfirst($project->status) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $project->start_date->format('d M Y') }}
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @if($projects->count() > 3)
                            <div class="mt-4 text-center">
                                <a href="#" class="text-green-600 hover:text-green-800 text-sm font-medium">
                                    Lihat Semua Proyek →
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-project-diagram text-gray-400 text-4xl mb-4"></i>
                            <p class="text-gray-500">Belum ada proyek yang dikelola</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Aktivitas Terbaru</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @if($pendingReports->count() > 0)
                            <div class="flex items-center p-3 bg-yellow-50 rounded-lg">
                                <div class="bg-yellow-100 rounded-full p-2 mr-3">
                                    <i class="fas fa-clock text-yellow-600"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900">{{ $pendingReports->count() }} Laporan Pending</p>
                                    <p class="text-sm text-gray-600">Menunggu review dan approval</p>
                                </div>
                                <a href="{{ route('manajer.reports') }}" class="text-yellow-600 hover:text-yellow-800 text-sm font-medium">
                                    Review →
                                </a>
                            </div>
                        @endif

                        @if($pendingRequests->count() > 0)
                            <div class="flex items-center p-3 bg-purple-50 rounded-lg">
                                <div class="bg-purple-100 rounded-full p-2 mr-3">
                                    <i class="fas fa-boxes text-purple-600"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900">{{ $pendingRequests->count() }} Permintaan Pending</p>
                                    <p class="text-sm text-gray-600">Menunggu approval pasokan</p>
                                </div>
                                <a href="{{ route('manajer.supply-requests') }}" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                                    Review →
                                </a>
                            </div>
                        @endif

                        @if($pendingReports->count() == 0 && $pendingRequests->count() == 0)
                            <div class="text-center py-8">
                                <i class="fas fa-check-circle text-green-400 text-4xl mb-4"></i>
                                <p class="text-gray-500">Tidak ada aktivitas pending</p>
                                <p class="text-sm text-gray-400">Semua tugas sudah selesai!</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Reports -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Laporan Pending</h2>
            </div>
            <div class="p-6">
                @if($pendingReports->count() > 0)
                    <div class="space-y-4">
                        @foreach($pendingReports as $report)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="bg-yellow-100 rounded-full p-2">
                                    <i class="fas fa-clipboard-list text-yellow-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $report->project->title ?? 'No Project' }}</p>
                                    <p class="text-sm text-gray-600">{{ Str::limit($report->activity_description, 50) }}</p>
                                    <p class="text-xs text-gray-500">oleh {{ $report->user->name }} • {{ $report->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button onclick="approveReport({{ $report->id }})" class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">
                                    <i class="fas fa-check mr-1"></i> Approve
                                </button>
                                <button onclick="rejectReport({{ $report->id }})" class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">
                                    <i class="fas fa-times mr-1"></i> Reject
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-4 text-center">
                        <a href="{{ route('manajer.reports') }}" class="text-yellow-600 hover:text-yellow-800 text-sm font-medium">
                            Lihat Semua Laporan →
                        </a>
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-clipboard-list text-gray-400 text-4xl mb-4"></i>
                        <p class="text-gray-500">Tidak ada laporan pending</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Pending Supply Requests -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Permintaan Pasokan Pending</h2>
            </div>
            <div class="p-6">
                @if($pendingRequests->count() > 0)
                    <div class="space-y-4">
                        @foreach($pendingRequests as $request)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="bg-purple-100 rounded-full p-2">
                                    <i class="fas fa-boxes text-purple-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $request->item_name }}</p>
                                    <p class="text-sm text-gray-600">Qty: {{ $request->quantity }} {{ $request->unit }}</p>
                                    <p class="text-xs text-gray-500">oleh {{ $request->user->name }} • {{ $request->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button onclick="approveRequest({{ $request->id }})" class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">
                                    <i class="fas fa-check mr-1"></i> Approve
                                </button>
                                <button onclick="rejectRequest({{ $request->id }})" class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">
                                    <i class="fas fa-times mr-1"></i> Reject
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-4 text-center">
                        <a href="{{ route('manajer.supply-requests') }}" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                            Lihat Semua Permintaan →
                        </a>
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-boxes text-gray-400 text-4xl mb-4"></i>
                        <p class="text-gray-500">Tidak ada permintaan pending</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function approveReport(reportId) {
    if (confirm('Apakah Anda yakin ingin menyetujui laporan ini?')) {
        // In a real app, you'd submit a form or make an AJAX request
        alert('Laporan berhasil disetujui!');
        location.reload();
    }
}

function rejectReport(reportId) {
    const notes = prompt('Masukkan alasan penolakan:');
    if (notes !== null) {
        // In a real app, you'd submit a form or make an AJAX request
        alert('Laporan berhasil ditolak!');
        location.reload();
    }
}

function approveRequest(requestId) {
    if (confirm('Apakah Anda yakin ingin menyetujui permintaan ini?')) {
        // In a real app, you'd submit a form or make an AJAX request
        alert('Permintaan berhasil disetujui!');
        location.reload();
    }
}

function rejectRequest(requestId) {
    const notes = prompt('Masukkan alasan penolakan:');
    if (notes !== null) {
        // In a real app, you'd submit a form or make an AJAX request
        alert('Permintaan berhasil ditolak!');
        location.reload();
    }
}
</script>
@endsection 