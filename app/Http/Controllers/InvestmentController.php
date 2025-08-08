<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use App\Models\Project;
use App\Models\Farmland;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InvestmentController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of available projects for investment.
     */
    public function index()
    {
        $projects = Project::with(['farmland', 'manager'])
            ->where(function($query) {
                $query->where('status', 'active')
                      ->orWhere('status', 'planning');
            })
            ->paginate(10);

        return view('investments.index', compact('projects'));
    }

    /**
     * Show the form for creating a new investment.
     */
    public function create(Farmland $farmland)
    {
        // Ensure the farmland is ready for investment
        if ($farmland->status !== 'ready_for_investment') {
            abort(404, 'Farmland not available for investment.');
        }
        
        // Load the farmland with its relationships
        $farmland->load(['landlord', 'readyForInvestmentBy']);
        
        return view('investments.create', compact('farmland'));
    }

    /**
     * Store a newly created investment.
     */
    public function store(Request $request, Farmland $farmland)
    {
        $user = Auth::user();
        
        // Ensure the farmland is ready for investment
        if ($farmland->status !== 'ready_for_investment') {
            abort(404, 'Farmland not available for investment.');
        }
        
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:' . $farmland->minimum_investment_amount . '|max:' . $user->wallet_balance,
            'terms' => 'required|accepted',
        ], [
            'amount.required' => 'Nominal investasi wajib diisi',
            'amount.numeric' => 'Nominal harus berupa angka',
            'amount.min' => 'Minimal investasi Rp ' . number_format($farmland->minimum_investment_amount),
            'amount.max' => 'Saldo tidak mencukupi',
            'terms.required' => 'Anda harus menyetujui syarat & ketentuan',
            'terms.accepted' => 'Anda harus menyetujui syarat & ketentuan',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $amount = $request->amount;

            // Check if user has sufficient balance
            if ($user->wallet_balance < $amount) {
                return back()->with('error', 'Saldo tidak mencukupi untuk investasi ini.');
            }

            // Create investment
            $investment = Investment::create([
                'user_id' => $user->id,
                'farmland_id' => $farmland->id,
                'amount' => $amount,
                'status' => 'confirmed',
            ]);

            // Deduct from user wallet
            if (!$user->deductFromWallet($amount)) {
                throw new \Exception('Gagal mengurangi saldo wallet');
            }

            // Create wallet transaction record
            WalletTransaction::create([
                'user_id' => $user->id,
                'type' => 'investment',
                'amount' => -$amount,
                'description' => "Investasi dalam lahan: {$farmland->location}",
            ]);

            // Add XP for investment
            $user->addXp(10);

            // Create notification
            $user->notifications()->create([
                'title' => 'Investasi Berhasil',
                'message' => "Investasi Anda sebesar Rp " . number_format($amount) . " dalam lahan '{$farmland->location}' telah dikonfirmasi.",
            ]);

            DB::commit();

            return redirect()->route('investments.index')
                ->with('success', 'Investasi berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }

    /**
     * Display the specified investment.
     */
    public function show(Investment $investment)
    {
        // Check if the investment belongs to the authenticated user
        if ($investment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Eager load relations needed by the view
        $investment->load(['farmland.landlord']);

        // Ambil laporan harian terbaru yang berkaitan dengan proyek pada lahan ini
        // Asumsi: laporan harian terhubung ke Project, dan Project berada di Farmland yang sama
        $latestReports = \App\Models\DailyReport::with(['project.farmland', 'user'])
            ->whereHas('project', function ($q) use ($investment) {
                $q->where('farmland_id', $investment->farmland_id);
            })
            ->latest()
            ->take(3)
            ->get();

        return view('investments.show', compact('investment', 'latestReports'));
    }

    /**
     * Display user's investment portfolio.
     */
    public function portfolio()
    {
        $user = Auth::user();
        $investments = $user->investments()
            ->with(['farmland.landlord', 'farmland.readyForInvestmentBy'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $totalInvested = $user->investments()
            ->where('status', 'confirmed')
            ->sum('amount');

        $confirmedInvestments = $user->investments()
            ->where('status', 'confirmed')
            ->with('farmland')
            ->get();

        $totalPotentialReturn = $confirmedInvestments->sum(function ($investment) {
            $months = $investment->farmland->investment_period_months ?? 12;
            $annualReturn = 15; // Assume 15% annual return
            $periodReturn = ($annualReturn / 12) * $months;
            return $investment->amount * (1 + ($periodReturn / 100));
        });

        // Average ROI (%), based on assumed annual 15% scaled by period
        $averageRoi = 0;
        if ($confirmedInvestments->count() > 0) {
            $averageRoi = $confirmedInvestments->avg(function ($investment) {
                $months = $investment->farmland->investment_period_months ?? 12;
                $annualReturn = 15;
                return ($annualReturn / 12) * $months; // percent
            });
        }

        return view('investments.portfolio', compact('investments', 'totalInvested', 'totalPotentialReturn', 'averageRoi'));
    }
} 