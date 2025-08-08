<?php

namespace App\Http\Controllers;

use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class WalletController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display wallet dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        $transactions = $user->walletTransactions()
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('wallet.index', compact('user', 'transactions'));
    }

    /**
     * Show top-up form.
     */
    public function topup()
    {
        return view('wallet.topup');
    }

    /**
     * Process top-up request.
     */
    public function processTopup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:10000|max:100000000',
            'payment_method' => 'required|in:bank_transfer,credit_card,e_wallet',
        ], [
            'amount.required' => 'Nominal top up wajib diisi',
            'amount.numeric' => 'Nominal harus berupa angka',
            'amount.min' => 'Minimal top up Rp 10.000',
            'amount.max' => 'Maksimal top up Rp 100.000.000',
            'payment_method.required' => 'Metode pembayaran wajib dipilih',
            'payment_method.in' => 'Metode pembayaran tidak valid',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $user = Auth::user();
            $amount = $request->amount;

            // Simulate payment processing (in real app, integrate with payment gateway)
            $paymentStatus = 'success'; // Simulate successful payment

            if ($paymentStatus === 'success') {
                // Add money to wallet
                $user->addToWallet($amount);

                // Create transaction record
                WalletTransaction::create([
                    'user_id' => $user->id,
                    'type' => 'topup',
                    'amount' => $amount,
                    'description' => "Top-up via " . ucfirst(str_replace('_', ' ', $request->payment_method)),
                ]);

                // Add XP for top-up
                $user->addXp(5);

                DB::commit();

                return redirect()->route('wallet.index')
                    ->with('success', 'Top-up berhasil! Saldo wallet Anda telah diperbarui.');
            }

            DB::rollback();
            return back()->with('error', 'Pembayaran gagal. Silakan coba lagi.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }

    /**
     * Show withdrawal form.
     */
    public function withdrawal()
    {
        $user = Auth::user();
        return view('wallet.withdrawal', compact('user'));
    }

    /**
     * Process withdrawal request.
     */
    public function processWithdrawal(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:50000|max:' . $user->wallet_balance,
            'bank_account' => 'required|string|max:255',
            'terms' => 'required|accepted',
        ], [
            'amount.required' => 'Nominal penarikan wajib diisi',
            'amount.numeric' => 'Nominal harus berupa angka',
            'amount.min' => 'Minimal penarikan Rp 50.000',
            'amount.max' => 'Saldo tidak mencukupi',
            'bank_account.required' => 'Rekening bank wajib dipilih',
            'bank_account.max' => 'Rekening bank terlalu panjang',
            'terms.required' => 'Anda harus menyetujui syarat & ketentuan',
            'terms.accepted' => 'Anda harus menyetujui syarat & ketentuan',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $amount = $request->amount;

            if ($user->deductFromWallet($amount)) {
                // Create transaction record
                WalletTransaction::create([
                    'user_id' => $user->id,
                    'type' => 'withdrawal',
                    'amount' => -$amount,
                    'description' => "Penarikan ke " . ucfirst($request->bank_account),
                ]);

                DB::commit();

                return redirect()->route('wallet.index')
                    ->with('success', 'Permintaan penarikan dana berhasil diajukan! Dana akan ditransfer dalam 1-3 hari kerja.');
            }

            DB::rollback();
            return back()->with('error', 'Saldo tidak mencukupi.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }

    /**
     * Get transaction history.
     */
    public function transactions()
    {
        $user = Auth::user();
        $transactions = $user->walletTransactions()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Calculate totals for summary
        $totalTopup = $user->walletTransactions()->topups()->sum('amount');
        $totalInvestment = abs($user->walletTransactions()->investments()->sum('amount'));
        $totalWithdrawal = abs($user->walletTransactions()->withdrawals()->sum('amount'));
        $totalReward = $user->walletTransactions()->rewards()->sum('amount');

        return view('wallet.transactions', compact('transactions', 'totalTopup', 'totalInvestment', 'totalWithdrawal', 'totalReward'));
    }
} 