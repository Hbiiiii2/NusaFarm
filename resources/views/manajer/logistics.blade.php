@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-yellow-50 via-white to-orange-50 pb-24">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <div class="bg-blue-100 rounded-full p-2">
                        <i class="fas fa-truck text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Kelola Logistik</h1>
                        <p class="text-sm text-gray-600">Monitor pengiriman dan distribusi</p>
                    </div>
                </div>
                <a href="{{ route('manajer.dashboard') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="bg-blue-100 rounded-full p-2 mr-3">
                        <i class="fas fa-truck text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Deliveries</p>
                        <p class="text-lg font-bold text-gray-900">{{ $logistics->total() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="bg-yellow-100 rounded-full p-2 mr-3">
                        <i class="fas fa-clock text-yellow-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Pending</p>
                        <p class="text-lg font-bold text-gray-900">{{ $logistics->where('status', 'pending')->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="bg-blue-100 rounded-full p-2 mr-3">
                        <i class="fas fa-shipping-fast text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">In Transit</p>
                        <p class="text-lg font-bold text-gray-900">{{ $logistics->where('status', 'in_transit')->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="bg-green-100 rounded-full p-2 mr-3">
                        <i class="fas fa-check text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Delivered</p>
                        <p class="text-lg font-bold text-gray-900">{{ $logistics->where('status', 'delivered')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Logistics Table -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Semua Pengiriman</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Delivery
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Project
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Driver
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($logistics as $logistic)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                            <i class="fas fa-truck text-blue-600"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $logistic->item_name ?? 'General Delivery' }}</div>
                                        <div class="text-sm text-gray-500">{{ $logistic->destination ?? 'No destination' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $logistic->project->title ?? 'No project' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $logistic->user->name ?? 'Not assigned' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($logistic->status === 'delivered') bg-green-100 text-green-800
                                    @elseif($logistic->status === 'in_transit') bg-blue-100 text-blue-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ ucfirst(str_replace('_', ' ', $logistic->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $logistic->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button onclick="viewLogistic({{ $logistic->id }}, '{{ $logistic->item_name ?? 'Delivery' }}', '{{ $logistic->status }}')" 
                                        class="text-blue-600 hover:text-blue-900 mr-3">
                                    <i class="fas fa-eye"></i> View
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                No logistics found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($logistics->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $logistics->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Logistic Details Modal -->
<div id="logisticModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Logistic Details</h3>
                <button onclick="closeLogisticModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div id="logisticDetails" class="space-y-4">
                <!-- Logistic details will be loaded here -->
            </div>
            
            <div class="flex justify-end space-x-3 mt-6">
                <button onclick="closeLogisticModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function viewLogistic(logisticId, logisticTitle, currentStatus) {
    const details = `
        <div>
            <p><strong>Item:</strong> ${logisticTitle}</p>
            <p><strong>Status:</strong> ${currentStatus}</p>
            <p><strong>Logistic ID:</strong> ${logisticId}</p>
            <p class="text-sm text-gray-600">Detailed logistic information would be displayed here.</p>
        </div>
    `;
    
    document.getElementById('logisticDetails').innerHTML = details;
    document.getElementById('logisticModal').classList.remove('hidden');
}

function closeLogisticModal() {
    document.getElementById('logisticModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('logisticModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeLogisticModal();
    }
});
</script>
@endsection 