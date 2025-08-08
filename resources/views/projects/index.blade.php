@extends('layouts.app')

@section('title', 'Land Marketplace')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-100 to-green-200 py-4 px-2 flex flex-col items-center pb-24">
    <div class="w-full max-w-5xl space-y-6">
        <!-- Header & Search -->
        <div class="bg-white rounded-2xl shadow p-4 mb-2">
            <div class="flex items-center justify-between mb-3">
                <div class="font-bold text-lg text-green-700 flex items-center">
                    <i class="fas fa-seedling mr-2"></i> Land Marketplace
                </div>
                <div class="text-xs text-gray-500">
                    <span class="font-semibold text-green-700">{{ $totalFarmlands ?? $farmlands->total() }}</span> results
                </div>
            </div>
            <form class="grid grid-cols-1 md:grid-cols-4 gap-3" method="GET" action="{{ route('projects.index') }}">
                <div class="relative md:col-span-2">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Search farms, crops, or locations..." class="w-full rounded-lg border border-gray-200 pl-10 pr-4 py-2 focus:ring-2 focus:ring-green-300 focus:border-green-400 transition text-sm">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-green-400">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-xs text-gray-500">Min Invest</span>
                    <input type="number" min="0" name="min_investment" value="{{ request('min_investment') }}" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm" placeholder="e.g. 500000">
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-xs text-gray-500">Max Invest</span>
                    <input type="number" min="0" name="max_investment" value="{{ request('max_investment') }}" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm" placeholder="e.g. 5000000">
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-xs text-gray-500">Size</span>
                    <input type="number" step="0.1" min="0" name="size_min" value="{{ request('size_min') }}" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm" placeholder="min">
                    <span class="text-xs text-gray-400">-</span>
                    <input type="number" step="0.1" min="0" name="size_max" value="{{ request('size_max') }}" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm" placeholder="max">
                </div>
                <div>
                    <select name="sort" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm">
                        <option value="">Sort by</option>
                        <option value="min_investment_asc" {{ (request('sort')=='min_investment_asc') ? 'selected' : '' }}>Min Investment ↑</option>
                        <option value="min_investment_desc" {{ (request('sort')=='min_investment_desc') ? 'selected' : '' }}>Min Investment ↓</option>
                        <option value="required_asc" {{ (request('sort')=='required_asc') ? 'selected' : '' }}>Total Required ↑</option>
                        <option value="required_desc" {{ (request('sort')=='required_desc') ? 'selected' : '' }}>Total Required ↓</option>
                        <option value="size_asc" {{ (request('sort')=='size_asc') ? 'selected' : '' }}>Size ↑</option>
                        <option value="size_desc" {{ (request('sort')=='size_desc') ? 'selected' : '' }}>Size ↓</option>
                        <option value="period_asc" {{ (request('sort')=='period_asc') ? 'selected' : '' }}>Period ↑</option>
                        <option value="period_desc" {{ (request('sort')=='period_desc') ? 'selected' : '' }}>Period ↓</option>
                    </select>
                </div>
                <div class="md:col-span-1 flex items-stretch space-x-2">
                    <button class="flex-1 bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-green-700">Apply</button>
                    <a href="{{ route('projects.index') }}" class="px-4 py-2 rounded-lg text-sm border border-gray-200 text-gray-600 hover:bg-gray-50">Reset</a>
                </div>
            </form>
        </div>

        <!-- Category Filter -->
        <div class="bg-white rounded-2xl shadow p-4">
            <div class="flex space-x-2 overflow-x-auto pb-2">
                <a href="{{ route('projects.index', ['category' => 'all'] + request()->except('category')) }}" 
                   class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap {{ $category === 'all' || !$category ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700' }}">
                    All Crops
                </a>
                <a href="{{ route('projects.index', ['category' => 'Padi'] + request()->except('category')) }}" 
                   class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap {{ $category === 'Padi' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700' }}">
                    Padi
                </a>
                <a href="{{ route('projects.index', ['category' => 'Jagung'] + request()->except('category')) }}" 
                   class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap {{ $category === 'Jagung' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700' }}">
                    Jagung
                </a>
                <a href="{{ route('projects.index', ['category' => 'Kedelai'] + request()->except('category')) }}" 
                   class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap {{ $category === 'Kedelai' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700' }}">
                    Kedelai
                </a>
                <a href="{{ route('projects.index', ['category' => 'Sayuran'] + request()->except('category')) }}" 
                   class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap {{ $category === 'Sayuran' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700' }}">
                    Sayuran
                </a>
            </div>
        </div>

        <!-- Farmlands Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($farmlands as $farmland)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                <!-- Farmland Image Placeholder -->
                <div class="h-40 bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center relative">
                    <i class="fas fa-seedling text-white text-4xl"></i>
                    <div class="absolute top-3 right-3 bg-green-600 text-white text-xs px-2 py-1 rounded-full">
                        Ready for Investment
                    </div>
                </div>
                
                <!-- Farmland Info -->
                <div class="p-4">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">{{ $farmland->location }}</h3>
                            <p class="text-xs text-gray-600">{{ $farmland->crop_type ?? 'Mixed Crops' }}</p>
                        </div>
                        <div class="text-right">
                            <div class="text-lg font-bold text-green-600">{{ $farmland->size }} ha</div>
                            <div class="text-xs text-gray-500">Land Size</div>
                        </div>
                    </div>
                    
                    <!-- Investment Details -->
                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <div class="bg-gray-50 rounded-lg p-3">
                            <div class="text-xs text-gray-500">Investment Period</div>
                            <div class="font-semibold text-gray-900">{{ $farmland->investment_period_months }} months</div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-3">
                            <div class="text-xs text-gray-500">Total Required</div>
                            <div class="font-semibold text-gray-900">Rp {{ number_format($farmland->required_investment_amount) }}</div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-3">
                            <div class="text-xs text-gray-500">Min Investment</div>
                            <div class="font-semibold text-gray-900">Rp {{ number_format($farmland->minimum_investment_amount) }}</div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-3">
                            <div class="text-xs text-gray-500">Landlord</div>
                            <div class="font-semibold text-gray-900">{{ $farmland->landlord->name }}</div>
                        </div>
                    </div>
                    
                    @if($farmland->investment_notes)
                    <div class="mb-4">
                        <div class="text-xs text-gray-500 mb-1">Investment Notes</div>
                        <p class="text-sm text-gray-700">{{ Str::limit($farmland->investment_notes, 100) }}</p>
                    </div>
                    @endif
                    
                    <!-- Action Button -->
                    <div class="flex gap-2">
                        <a href="{{ route('projects.show', $farmland) }}" 
                           class="flex-1 bg-gray-100 text-gray-800 text-center py-3 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                            Details
                        </a>
                        <a href="{{ route('investments.create', ['farmland' => $farmland->id]) }}" 
                           class="flex-1 bg-green-600 text-white text-center py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                            Invest
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                <i class="fas fa-seedling text-gray-300 text-4xl mb-4"></i>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No Investment Opportunities</h3>
                <p class="text-gray-600">Currently there are no farmlands ready for investment. Check back later!</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($farmlands->hasPages())
        <div class="bg-white rounded-2xl shadow-lg p-4">
            {{ $farmlands->links() }}
        </div>
        @endif
    </div>
</div>
@endsection 