@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 pb-24">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <div class="bg-blue-100 rounded-full p-2">
                        <i class="fas fa-shield-alt text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Admin Dashboard</h1>
                        <p class="text-sm text-gray-600">Selamat datang, {{ auth()->user()->name }}!</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        Administrator
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
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="bg-blue-100 rounded-full p-2 mr-3">
                        <i class="fas fa-users text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Users</p>
                        <p class="text-lg font-bold text-gray-900">{{ $totalUsers }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="bg-green-100 rounded-full p-2 mr-3">
                        <i class="fas fa-project-diagram text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Projects</p>
                        <p class="text-lg font-bold text-gray-900">{{ $totalProjects }}</p>
                        <p class="text-xs text-green-600">{{ $activeProjects }} Active</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="bg-yellow-100 rounded-full p-2 mr-3">
                        <i class="fas fa-clipboard-list text-yellow-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Daily Reports</p>
                        <p class="text-lg font-bold text-gray-900">{{ $totalReports }}</p>
                        <p class="text-xs text-yellow-600">{{ $pendingReports }} Pending</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="bg-purple-100 rounded-full p-2 mr-3">
                        <i class="fas fa-boxes text-purple-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Supply Requests</p>
                        <p class="text-lg font-bold text-gray-900">{{ $totalRequests }}</p>
                        <p class="text-xs text-purple-600">{{ $pendingRequests }} Pending</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="bg-orange-100 rounded-full p-2 mr-3">
                        <i class="fas fa-map text-orange-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Farmlands</p>
                        <p class="text-lg font-bold text-gray-900">{{ $totalFarmlands ?? 0 }}</p>
                        <p class="text-xs text-orange-600">{{ $pendingFarmlands ?? 0 }} Pending</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                    <a href="{{ route('admin.users') }}" class="flex flex-col items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                        <i class="fas fa-users text-blue-600 text-2xl mb-2"></i>
                        <span class="text-sm font-medium text-gray-900">Manage Users</span>
                    </a>
                    
                    <a href="{{ route('admin.farmlands') }}" class="flex flex-col items-center p-4 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors">
                        <i class="fas fa-map text-orange-600 text-2xl mb-2"></i>
                        <span class="text-sm font-medium text-gray-900">Manage Farmlands</span>
                        @if(($pendingFarmlands ?? 0) > 0)
                        <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full mt-1">{{ $pendingFarmlands }}</span>
                        @endif
                    </a>
                    
                    <a href="{{ route('admin.projects') }}" class="flex flex-col items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                        <i class="fas fa-project-diagram text-green-600 text-2xl mb-2"></i>
                        <span class="text-sm font-medium text-gray-900">Manage Projects</span>
                    </a>
                    
                    <a href="{{ route('admin.reports') }}" class="flex flex-col items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors">
                        <i class="fas fa-chart-bar text-yellow-600 text-2xl mb-2"></i>
                        <span class="text-sm font-medium text-gray-900">View Reports</span>
                    </a>
                    
                    <a href="{{ route('admin.chat') }}" class="flex flex-col items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                        <i class="fas fa-comments text-purple-600 text-2xl mb-2"></i>
                        <span class="text-sm font-medium text-gray-900">Chat</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Recent Users -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Users</h3>
                </div>
                <div class="p-6">
                    @if($recentUsers->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentUsers as $user)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="bg-blue-100 rounded-full p-2">
                                        <i class="fas fa-user text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $user->name }}</p>
                                        <p class="text-sm text-gray-600">{{ $user->email }}</p>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $user->created_at->diffForHumans() }}
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="mt-4 text-center">
                            <a href="{{ route('admin.users') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                View All Users →
                            </a>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-users text-gray-400 text-4xl mb-4"></i>
                            <p class="text-gray-500">No users found</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Projects -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Projects</h3>
                </div>
                <div class="p-6">
                    @if($recentProjects->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentProjects as $project)
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
                                    {{ $project->created_at->diffForHumans() }}
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="mt-4 text-center">
                            <a href="{{ route('admin.projects') }}" class="text-green-600 hover:text-green-800 text-sm font-medium">
                                View All Projects →
                            </a>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-project-diagram text-gray-400 text-4xl mb-4"></i>
                            <p class="text-gray-500">No projects found</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Reports -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Recent Daily Reports</h2>
            </div>
            <div class="p-6">
                @if($recentReports->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentReports as $report)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="bg-yellow-100 rounded-full p-2">
                                    <i class="fas fa-clipboard-list text-yellow-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $report->project->title ?? 'No Project' }}</p>
                                    <p class="text-sm text-gray-600">{{ Str::limit($report->activity_description, 50) }}</p>
                                    <p class="text-xs text-gray-500">by {{ $report->user->name }} • {{ $report->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                @if($report->status === 'approved')
                                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                        Approved
                                    </span>
                                @elseif($report->status === 'rejected')
                                    <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                        Rejected
                                    </span>
                                @else
                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                        Pending
                                    </span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-4 text-center">
                        <a href="{{ route('admin.reports') }}" class="text-yellow-600 hover:text-yellow-800 text-sm font-medium">
                            View All Reports →
                        </a>
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-clipboard-list text-gray-400 text-4xl mb-4"></i>
                        <p class="text-gray-500">No reports found</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 