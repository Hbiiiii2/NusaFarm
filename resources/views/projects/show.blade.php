@extends('layouts.app')

@section('title', 'Farmland Details')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-100 to-green-200 py-4 px-2 flex flex-col items-center pb-24">
    <div class="w-full max-w-md space-y-6">
        <!-- Header -->
        <div class="bg-white rounded-2xl shadow p-4">
            <div class="flex items-center justify-between mb-2">
                <div class="font-bold text-lg text-green-700 flex items-center">
                    <i class="fas fa-seedling mr-2"></i> Farmland Details
                </div>
                <a href="{{ route('projects.index') }}" class="text-green-600 hover:text-green-700">
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
        </div>

        <!-- Farmland Image -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="h-64 bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center relative">
                <i class="fas fa-seedling text-white text-6xl"></i>
                <div class="absolute top-4 right-4 bg-green-600 text-white text-sm px-3 py-1 rounded-full">
                    Ready for Investment
                </div>
            </div>
        </div>

        <!-- Farmland Info -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $farmland->location }}</h1>
            <p class="text-gray-600 mb-4">{{ $farmland->crop_type ?? 'Mixed Crops' }}</p>
            
            <!-- Key Stats -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600">{{ $farmland->size }}</div>
                    <div class="text-sm text-gray-500">Hectares</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600">{{ $farmland->investment_period_months }}</div>
                    <div class="text-sm text-gray-500">Months</div>
                </div>
            </div>

            <!-- Investment Details -->
            <div class="space-y-4 mb-6">
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Total Investment Required</span>
                        <span class="font-bold text-gray-900">Rp {{ number_format($farmland->required_investment_amount) }}</span>
                    </div>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Minimum Investment</span>
                        <span class="font-bold text-gray-900">Rp {{ number_format($farmland->minimum_investment_amount) }}</span>
                    </div>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Monthly Rental</span>
                        <span class="font-bold text-gray-900">Rp {{ number_format($farmland->rental_price) }}</span>
                    </div>
                </div>
            </div>

            <!-- Landlord Info -->
            <div class="border-t pt-4 mb-6">
                <h3 class="font-semibold text-gray-900 mb-2">Landlord Information</h3>
                <div class="bg-blue-50 rounded-lg p-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-blue-600"></i>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">{{ $farmland->landlord->name }}</div>
                            <div class="text-sm text-gray-600">{{ $farmland->landlord->email }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Investment Notes -->
            @if($farmland->investment_notes)
            <div class="border-t pt-4 mb-6">
                <h3 class="font-semibold text-gray-900 mb-2">Investment Notes</h3>
                <div class="bg-yellow-50 rounded-lg p-4">
                    <p class="text-gray-700">{{ $farmland->investment_notes }}</p>
                </div>
            </div>
            @endif

            <!-- Description -->
            @if($farmland->description)
            <div class="border-t pt-4 mb-6">
                <h3 class="font-semibold text-gray-900 mb-2">Description</h3>
                <p class="text-gray-700">{{ $farmland->description }}</p>
            </div>
            @endif

            <!-- Investment Action -->
            <div class="border-t pt-6">
                <div class="bg-green-50 rounded-lg p-4 mb-4">
                    <div class="text-center">
                        <div class="text-sm text-gray-600 mb-2">Ready to invest?</div>
                        <div class="text-lg font-bold text-green-600">Minimum: Rp {{ number_format($farmland->minimum_investment_amount) }}</div>
                    </div>
                </div>
                
                <a href="{{ route('investments.create', ['farmland' => $farmland->id]) }}" 
                   class="w-full bg-green-600 text-white text-center py-4 rounded-lg font-bold text-lg hover:bg-green-700 transition-colors">
                    Invest Now
                </a>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Additional Information</h3>
            <div class="space-y-3 text-sm text-gray-600">
                <div class="flex justify-between">
                    <span>Configured by:</span>
                    <span class="font-medium">{{ $farmland->readyForInvestmentBy->name ?? 'Manager' }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Ready since:</span>
                    <span class="font-medium">{{ $farmland->ready_for_investment_at ? $farmland->ready_for_investment_at->format('d/m/Y') : 'N/A' }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Approved by admin:</span>
                    <span class="font-medium">{{ $farmland->approved_by_admin_at ? $farmland->approved_by_admin_at->format('d/m/Y') : 'N/A' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 