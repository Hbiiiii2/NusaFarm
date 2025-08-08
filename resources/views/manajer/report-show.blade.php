@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-yellow-50 via-white to-orange-50 pb-24">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-6">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow p-4 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="{{ route('manajer.reports') }}" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <div>
                    <h1 class="text-xl font-bold text-gray-900">Detail Laporan Harian</h1>
                    <p class="text-sm text-gray-600">Dikirim oleh {{ $report->user->name }} pada {{ $report->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                @if($report->status === 'approved') bg-green-100 text-green-800
                @elseif($report->status === 'rejected') bg-red-100 text-red-800
                @else bg-yellow-100 text-yellow-800 @endif">
                {{ ucfirst($report->status) }}
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Activity -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-3">Deskripsi Kegiatan</h2>
                    <p class="text-gray-700 leading-relaxed">{{ $report->activity_description }}</p>
                </div>

                <!-- Media -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Media</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if($report->photo_path)
                        <div>
                            <img src="{{ asset('storage/'.$report->photo_path) }}" alt="Foto Laporan" class="rounded-lg w-full object-cover">
                        </div>
                        @else
                        <div class="border-2 border-dashed border-gray-200 rounded-lg p-6 text-center text-sm text-gray-500">
                            Tidak ada foto
                        </div>
                        @endif

                        @if($report->video_path)
                        <div>
                            <video controls class="w-full rounded-lg">
                                <source src="{{ asset('storage/'.$report->video_path) }}" type="video/mp4">
                                Browser Anda tidak mendukung video.
                            </video>
                        </div>
                        @else
                        <div class="border-2 border-dashed border-gray-200 rounded-lg p-6 text-center text-sm text-gray-500">
                            Tidak ada video
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Detail Kondisi</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="text-gray-500">Cuaca</div>
                            <div class="font-semibold text-gray-900">{{ $report->weather_condition ? ucfirst($report->weather_condition) : '-' }}</div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="text-gray-500">Kondisi Tanaman</div>
                            <div class="font-semibold text-gray-900">{{ $report->plant_condition ?: '-' }}</div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="text-gray-500">Hama/Penyakit</div>
                            <div class="font-semibold text-gray-900">{{ $report->pest_issues ?: '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Proyek</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Proyek</span>
                            <span class="font-semibold text-gray-900">{{ $report->project->title ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Lokasi</span>
                            <span class="font-semibold text-gray-900">{{ $report->project->farmland->location ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Luas Lahan</span>
                            <span class="font-semibold text-gray-900">{{ optional($report->project->farmland)->size ? $report->project->farmland->size.' ha' : '-' }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Tindakan</h3>
                    @if($report->status === 'pending')
                    <form method="POST" action="{{ route('manajer.reports.approve', $report) }}" class="space-y-3">
                        @csrf
                        <textarea name="notes" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" placeholder="Catatan (opsional)"></textarea>
                        <button class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Approve</button>
                    </form>
                    <form method="POST" action="{{ route('manajer.reports.reject', $report) }}" class="space-y-3 mt-3">
                        @csrf
                        <textarea name="notes" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" placeholder="Alasan penolakan (opsional)"></textarea>
                        <button class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">Reject</button>
                    </form>
                    @else
                    <div class="text-sm text-gray-600">Laporan sudah {{ $report->status }}.</div>
                    @endif
                </div>

                @if($report->manager_notes)
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                    <div class="flex">
                        <i class="fas fa-comment text-yellow-400 mt-1 mr-3"></i>
                        <div>
                            <p class="text-sm font-medium text-yellow-800">Catatan Manajer</p>
                            <p class="text-sm text-yellow-700 mt-1">{{ $report->manager_notes }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

