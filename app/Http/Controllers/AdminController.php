<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Models\Farmland;
use App\Models\DailyReport;
use App\Models\SupplyRequest;
use App\Models\ChatMessage;
use App\Models\Notification;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function dashboard()
    {
        // Get statistics
        $totalUsers = User::count();
        $totalProjects = Project::count();
        $activeProjects = Project::where('status', 'active')->count();
        $totalReports = DailyReport::count();
        $pendingReports = DailyReport::where('status', 'pending')->count();
        $totalRequests = SupplyRequest::count();
        $pendingRequests = SupplyRequest::where('status', 'pending')->count();
        
        // Get farmland statistics
        $totalFarmlands = Farmland::count();
        $pendingFarmlands = Farmland::where('status', 'pending_verification')->count();
        $verifiedFarmlands = Farmland::where('status', 'verified')->count();
        
        // Get recent activities
        $recentUsers = User::latest()->take(5)->get();
        $recentProjects = Project::with('farmland')->latest()->take(5)->get();
        $recentReports = DailyReport::with(['user', 'project'])->latest()->take(5)->get();
        $recentFarmlands = Farmland::with('landlord')->latest()->take(5)->get();
        
        // Get unread messages
        $unreadMessages = ChatMessage::where('receiver_id', auth()->id())
            ->where('is_read', false)
            ->count();
        
        return view('admin.dashboard', compact(
            'totalUsers', 'totalProjects', 'activeProjects', 'totalReports', 'pendingReports',
            'totalRequests', 'pendingRequests', 'totalFarmlands', 'pendingFarmlands', 'verifiedFarmlands',
            'recentUsers', 'recentProjects', 'recentReports', 'recentFarmlands', 'unreadMessages'
        ));
    }

    public function users()
    {
        $users = User::with('investments')->latest()->paginate(20);
        
        return view('admin.users', compact('users'));
    }

    public function updateUserRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:user,landlord,petani,manajer_lapangan,logistik,penyedia_pupuk,pedagang_pasar,admin',
        ]);

        $user->update(['role' => $request->role]);

        return back()->with('success', 'Role pengguna berhasil diperbarui!');
    }

    public function farmlands()
    {
        $farmlands = Farmland::with(['landlord', 'projects'])
            ->latest()
            ->paginate(15);
        
        return view('admin.farmlands', compact('farmlands'));
    }

    public function approveFarmland(Request $request, Farmland $farmland)
    {
        $request->validate([
            'notes' => 'nullable|string|max:500',
        ]);

        $farmland->update([
            'status' => 'approved_by_admin',
            'approved_by_admin_at' => now(),
            'approved_by_admin_by' => auth()->id(),
        ]);

        // Create notification for landlord
        $farmland->landlord->notifications()->create([
            'title' => 'Lahan Disetujui Admin',
            'message' => "Lahan Anda di {$farmland->location} telah disetujui oleh admin dan sedang menunggu pengaturan oleh manajer lapangan.",
        ]);

        return back()->with('success', 'Lahan berhasil disetujui dan akan dikelola oleh manajer lapangan!');
    }

    public function rejectFarmland(Request $request, Farmland $farmland)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $farmland->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'rejected_at' => now(),
            'rejected_by' => auth()->id(),
        ]);

        // Create notification for landlord
        $farmland->landlord->notifications()->create([
            'title' => 'Lahan Ditolak',
            'message' => "Lahan Anda di {$farmland->location} ditolak dengan alasan: {$request->rejection_reason}. Silakan perbaiki dan ajukan ulang.",
        ]);

        return back()->with('success', 'Lahan berhasil ditolak!');
    }

    public function projects()
    {
        $projects = Project::with(['farmland', 'manager'])->latest()->paginate(15);
        
        return view('admin.projects', compact('projects'));
    }

    public function updateProjectStatus(Request $request, Project $project)
    {
        $request->validate([
            'status' => 'required|in:planning,active,harvested,finished',
        ]);

        $project->update(['status' => $request->status]);

        return back()->with('success', 'Status proyek berhasil diperbarui!');
    }

    public function reports()
    {
        $reports = DailyReport::with(['user', 'project'])->latest()->paginate(20);
        
        return view('admin.reports', compact('reports'));
    }

    public function supplyRequests()
    {
        $requests = SupplyRequest::with(['user', 'project'])->latest()->paginate(20);
        
        return view('admin.supply-requests', compact('requests'));
    }

    public function chat()
    {
        $user = auth()->user();
        
        // Get users that admin can chat with (all roles except admin)
        $chatUsers = User::where('role', '!=', 'admin')
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
        
        return view('admin.chat', compact('chatUsers', 'conversations'));
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
