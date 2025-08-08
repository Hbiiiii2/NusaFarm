<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DailyReport;
use App\Models\SupplyRequest;
use App\Models\Project;
use App\Models\FarmingTask;
use App\Models\ChatMessage;
use App\Models\User;

class PetaniController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:petani');
    }

    public function dashboard()
    {
        $user = auth()->user();
        
        // Get projects where user is assigned as petani
        $projects = Project::where('status', 'active')->get();
        
        // Get recent daily reports
        $recentReports = $user->dailyReports()->with('project')->latest()->take(5)->get();
        
        // Get pending supply requests
        $pendingRequests = $user->supplyRequests()->with('project')->where('status', 'pending')->get();
        
        // Get unread messages
        $unreadMessages = $user->receivedMessages()->where('is_read', false)->count();
        
        return view('petani.dashboard', compact('projects', 'recentReports', 'pendingRequests', 'unreadMessages'));
    }

    public function dailyReports()
    {
        $user = auth()->user();
        $reports = $user->dailyReports()->with('project')->latest()->paginate(10);
        
        return view('petani.daily-reports', compact('reports'));
    }

    public function createDailyReport()
    {
        $userId = auth()->id();
        // Ambil proyek aktif yang sedang ditugaskan ke petani ini melalui FarmingTask
        $assignedProjectIds = FarmingTask::where('assigned_to', $userId)
            ->pluck('project_id')
            ->unique()
            ->toArray();

        $projects = Project::with('farmland')
            ->where('status', 'active')
            ->whereIn('id', $assignedProjectIds)
            ->orderBy('title')
            ->get();
        return view('petani.create-daily-report', compact('projects'));
    }

    public function storeDailyReport(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'activity_description' => 'required|string',
            'weather_condition' => 'nullable|in:cerah,berawan,hujan,angin',
            'plant_condition' => 'nullable|string',
            'pest_issues' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'video' => 'nullable|mimes:mp4,mov,avi|max:10240',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();

        // Validasi bahwa petani memang ditugaskan pada proyek tersebut
        $isAssigned = FarmingTask::where('assigned_to', $data['user_id'])
            ->where('project_id', $request->project_id)
            ->exists();
        if (!$isAssigned) {
            return back()->withErrors(['project_id' => 'Anda tidak ditugaskan pada proyek ini.'])->withInput();
        }

        // Handle file uploads
        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('daily-reports/photos', 'public');
        }

        if ($request->hasFile('video')) {
            $data['video_path'] = $request->file('video')->store('daily-reports/videos', 'public');
        }

        DailyReport::create($data);

        return redirect()->route('petani.daily-reports')->with('success', 'Laporan harian berhasil dibuat!');
    }

    public function supplyRequests()
    {
        $user = auth()->user();
        $requests = $user->supplyRequests()->with('project')->latest()->paginate(10);
        
        return view('petani.supply-requests', compact('requests'));
    }

    public function createSupplyRequest()
    {
        $projects = Project::where('status', 'active')->get();
        return view('petani.create-supply-request', compact('projects'));
    }

    public function storeSupplyRequest(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'item_name' => 'required|string',
            'description' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'unit' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();

        SupplyRequest::create($data);

        return redirect()->route('petani.supply-requests')->with('success', 'Permintaan sarana produksi berhasil dibuat!');
    }

    public function chat()
    {
        $user = auth()->user();
        
        // Get users that petani can chat with (manajer, logistik, penyedia pupuk)
        $chatUsers = User::whereIn('role', ['manajer_lapangan', 'logistik', 'penyedia_pupuk'])
            ->where('id', '!=', $user->id)
            ->get();
        
        // Get recent conversations
        $conversations = $user->sentMessages()
            ->orWhere('receiver_id', $user->id)
            ->with(['sender', 'receiver'])
            ->latest()
            ->get()
            ->groupBy(function($message) use ($user) {
                return $message->sender_id == $user->id ? $message->receiver_id : $message->sender_id;
            });
        
        return view('petani.chat', compact('chatUsers', 'conversations'));
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
