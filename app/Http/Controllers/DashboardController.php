<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the dashboard - redirects to role-specific dashboard
     */
    public function index()
    {
        $user = Auth::user();
        
        // Redirect to role-specific dashboard
        switch ($user->role) {
            case 'petani':
                return redirect()->route('petani.dashboard');
            case 'manajer_lapangan':
                return redirect()->route('manajer.dashboard');
            case 'logistik':
                return redirect()->route('logistik.dashboard');
            case 'penyedia_pupuk':
                return redirect()->route('pupuk.dashboard');
            case 'pedagang_pasar':
                return redirect()->route('pedagang.dashboard');
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'landlord':
                return redirect()->route('landlord.dashboard');
            case 'user':
            default:
                // For investors, show the general dashboard
                // Get recent activities
                $recentTransactions = $user->walletTransactions()
                    ->latest()
                    ->limit(5)
                    ->get();
                    
                // Get available projects
                $availableProjects = \App\Models\Project::with(['farmland', 'manager'])
                    ->where('status', 'active')
                    ->orWhere('status', 'planning')
                    ->limit(3)
                    ->get();
                    
                return view('dashboard', compact('user', 'recentTransactions', 'availableProjects'));
        }
    }
} 