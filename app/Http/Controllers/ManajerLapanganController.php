<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DailyReport;
use App\Models\SupplyRequest;
use App\Models\Project;
use App\Models\ChatMessage;
use App\Models\User;
use App\Models\Logistic;
use App\Models\FertilizerOrder;
use App\Models\Farmland;
use App\Models\Notification;

class ManajerLapanganController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:manajer_lapangan');
    }

    public function dashboard()
    {
        $user = auth()->user();
        
        // Get projects managed by this user
        $projects = Project::where('manager_id', $user->id)->with('farmland')->get();
        
        // Get pending daily reports
        $pendingReports = DailyReport::where('status', 'pending')->with(['user', 'project'])->latest()->take(5)->get();
        
        // Get pending supply requests
        $pendingRequests = SupplyRequest::where('status', 'pending')->with(['user', 'project'])->latest()->take(5)->get();
        
        // Get farmlands approved by admin that need manager setup
        $pendingFarmlands = Farmland::where('status', 'approved_by_admin')->with('landlord')->latest()->take(5)->get();
        
        // Get unread messages
        $unreadMessages = ChatMessage::where('receiver_id', $user->id)
            ->where('is_read', false)
            ->count();
        
        return view('manajer.dashboard', compact('projects', 'pendingReports', 'pendingRequests', 'pendingFarmlands', 'unreadMessages'));
    }

    public function farmlands()
    {
        $farmlands = Farmland::where('status', 'approved_by_admin')
            ->with(['landlord', 'approvedByAdmin'])
            ->latest()
            ->paginate(15);
        
        return view('manajer.farmlands', compact('farmlands'));
    }

    public function setupFarmland(Farmland $farmland)
    {
        // Ensure the farmland is approved by admin
        if ($farmland->status !== 'approved_by_admin') {
            abort(403, 'Lahan ini belum disetujui oleh admin.');
        }

        return view('manajer.setup-farmland', compact('farmland'));
    }

    public function makeReadyForInvestment(Request $request, Farmland $farmland)
    {
        // Ensure the farmland is approved by admin
        if ($farmland->status !== 'approved_by_admin') {
            abort(403, 'Lahan ini belum disetujui oleh admin.');
        }

        $request->validate([
            'investment_period_months' => 'required|numeric|min:1|max:60',
            'required_investment_amount' => 'required|numeric|min:1000000',
            'minimum_investment_amount' => 'required|numeric|min:100000',
            'investment_notes' => 'nullable|string|max:1000',
        ]);

        $farmland->update([
            'status' => 'ready_for_investment',
            'ready_for_investment_at' => now(),
            'ready_for_investment_by' => auth()->id(),
            'investment_period_months' => $request->investment_period_months,
            'required_investment_amount' => $request->required_investment_amount,
            'minimum_investment_amount' => $request->minimum_investment_amount,
            'investment_notes' => $request->investment_notes,
        ]);

        // Create notification for landlord
        $farmland->landlord->notifications()->create([
            'title' => 'Lahan Siap untuk Investasi',
            'message' => "Lahan Anda di {$farmland->location} telah dikonfigurasi oleh manajer lapangan dan siap untuk menerima investasi.",
        ]);

        return redirect()->route('manajer.farmlands')->with('success', 'Lahan berhasil dikonfigurasi dan siap untuk investasi!');
    }

    public function reports()
    {
        $reports = DailyReport::with(['user', 'project'])->latest()->paginate(15);
        
        return view('manajer.reports', compact('reports'));
    }

    public function showReport(DailyReport $report)
    {
        $report->load(['user', 'project.farmland']);
        return view('manajer.report-show', compact('report'));
    }

    public function approveReport(Request $request, DailyReport $report)
    {
        $report->update([
            'status' => 'approved',
            'manager_notes' => $request->notes
        ]);
        
        return back()->with('success', 'Laporan berhasil disetujui!');
    }

    public function rejectReport(Request $request, DailyReport $report)
    {
        $report->update([
            'status' => 'rejected',
            'manager_notes' => $request->notes
        ]);
        
        return back()->with('success', 'Laporan berhasil ditolak!');
    }

    public function supplyRequests()
    {
        $requests = SupplyRequest::with(['user', 'project'])->latest()->paginate(15);
        
        return view('manajer.supply-requests', compact('requests'));
    }

    public function approveSupplyRequest(Request $request, SupplyRequest $supplyRequest)
    {
        $supplyRequest->update([
            'status' => 'approved',
            'manager_notes' => $request->notes,
            'approved_at' => now()
        ]);
        
        return back()->with('success', 'Permintaan berhasil disetujui!');
    }

    public function rejectSupplyRequest(Request $request, SupplyRequest $supplyRequest)
    {
        $supplyRequest->update([
            'status' => 'rejected',
            'manager_notes' => $request->notes
        ]);
        
        return back()->with('success', 'Permintaan berhasil ditolak!');
    }

    public function logistics()
    {
        $logistics = Logistic::with(['user', 'project'])->latest()->paginate(15);
        
        return view('manajer.logistics', compact('logistics'));
    }

    public function fertilizerOrders()
    {
        $orders = FertilizerOrder::with(['user', 'project'])->latest()->paginate(15);
        
        return view('manajer.fertilizer-orders', compact('orders'));
    }

    public function chat()
    {
        $user = auth()->user();
        
        // Get users that manajer can chat with (petani, logistik, penyedia pupuk, admin)
        $chatUsers = User::whereIn('role', ['petani', 'logistik', 'penyedia_pupuk', 'admin'])
            ->where('id', '!=', $user->id)
            ->get();
        
        // Get recent conversations - fixed to query the model directly
        $conversations = ChatMessage::where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->with(['sender', 'receiver'])
            ->latest()
            ->get()
            ->groupBy(function($message) use ($user) {
                return $message->sender_id == $user->id ? $message->receiver_id : $message->sender_id;
            });
        
        return view('manajer.chat', compact('chatUsers', 'conversations'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
            'project_id' => 'nullable|exists:projects,id',
        ]);

        ChatMessage::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'project_id' => $request->project_id,
            'message' => $request->message,
            'message_type' => 'text',
        ]);

        return back()->with('success', 'Pesan berhasil dikirim!');
    }
}
