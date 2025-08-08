<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Farmland;
use App\Models\Project;
use App\Models\Investment;
use App\Models\DailyReport;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class LandlordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:landlord');
    }

    public function dashboard()
    {
        $user = auth()->user();
        
        // Get landlord's farmlands
        $farmlands = $user->farmlands()->with(['projects.investments'])->get();
        
        // Get active projects on landlord's land
        $activeProjects = Project::whereHas('farmland', function($query) use ($user) {
            $query->where('landlord_id', $user->id);
        })->where('status', 'active')->with(['farmland', 'manager'])->get();
        
        // Get total investments on landlord's land
        $totalInvestments = Investment::whereHas('farmland', function($query) use ($user) {
            $query->where('landlord_id', $user->id);
        })->where('status', 'confirmed')->sum('amount');
        
        // Get recent daily reports from landlord's farms
        $recentReports = DailyReport::whereHas('project.farmland', function($query) use ($user) {
            $query->where('landlord_id', $user->id);
        })->with(['project', 'user'])->latest()->take(5)->get();
        
        // Get unread messages
        $unreadMessages = $user->receivedMessages()->where('is_read', false)->count();
        
        // Get collaboration stats - simplified to avoid collection issues
        $uniqueFarmers = 0;
        $uniqueInvestors = 0;
        
        // Calculate unique farmers and investors from the loaded data
        if ($recentReports->count() > 0) {
            $uniqueFarmers = $recentReports->pluck('user_id')->unique()->count();
        }
        
        if ($farmlands->count() > 0) {
            $farmlandIds = $farmlands->pluck('id');
            
            $uniqueInvestors = Investment::whereIn('farmland_id', $farmlandIds)
                ->where('status', 'confirmed')
                ->distinct()
                ->count('user_id');
        }

        return view('landlord.dashboard', compact(
            'farmlands', 
            'activeProjects', 
            'totalInvestments', 
            'recentReports', 
            'unreadMessages',
            'uniqueFarmers',
            'uniqueInvestors'
        ));
    }

    public function farmlands()
    {
        $user = auth()->user();
        $farmlands = $user->farmlands()->with(['investments', 'projects'])->withCount('investments')->paginate(10);
        
        return view('landlord.farmlands', compact('farmlands'));
    }

    public function createFarmland()
    {
        return view('landlord.create-farmland');
    }

    public function storeFarmland(Request $request)
    {
        $request->validate([
            'location' => 'required|string|max:255',
            'size' => 'required|numeric|min:0.1',
            'rental_price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'crop_type' => 'nullable|string|max:100',
            'certificate_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'location_map' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $data = $request->all();
        $data['landlord_id'] = auth()->id();
        $data['status'] = 'pending_verification';

        // Handle file uploads
        if ($request->hasFile('certificate_document')) {
            $data['certificate_path'] = $request->file('certificate_document')->store('farmland/certificates', 'public');
        }

        if ($request->hasFile('location_map')) {
            $data['map_path'] = $request->file('location_map')->store('farmland/maps', 'public');
        }

        Farmland::create($data);

        return redirect()->route('landlord.farmlands')->with('success', 'Lahan berhasil didaftarkan dan menunggu verifikasi!');
    }

    public function showFarmland(Farmland $farmland)
    {
        // Ensure the farmland belongs to the authenticated landlord
        if ($farmland->landlord_id !== auth()->id()) {
            abort(403, 'Unauthorized access to farmland.');
        }

        $farmland->load(['projects.investments', 'projects.manager']);
        
        // Get recent activity on this farmland
        $recentReports = DailyReport::whereHas('project', function($query) use ($farmland) {
            $query->where('farmland_id', $farmland->id);
        })->with(['project', 'user'])->latest()->take(10)->get();

        return view('landlord.show-farmland', compact('farmland', 'recentReports'));
    }

    public function editFarmland(Farmland $farmland)
    {
        // Ensure the farmland belongs to the authenticated landlord
        if ($farmland->landlord_id !== auth()->id()) {
            abort(403, 'Unauthorized access to farmland.');
        }

        return view('landlord.edit-farmland', compact('farmland'));
    }

    public function updateFarmland(Request $request, Farmland $farmland)
    {
        // Ensure the farmland belongs to the authenticated landlord
        if ($farmland->landlord_id !== auth()->id()) {
            abort(403, 'Unauthorized access to farmland.');
        }

        $request->validate([
            'location' => 'required|string|max:255',
            'size' => 'required|numeric|min:0.1',
            'rental_price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'crop_type' => 'nullable|string|max:100',
            'certificate_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'location_map' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $data = $request->all();

        // Handle file uploads
        if ($request->hasFile('certificate_document')) {
            // Delete old certificate if exists
            if ($farmland->certificate_path) {
                Storage::disk('public')->delete($farmland->certificate_path);
            }
            $data['certificate_path'] = $request->file('certificate_document')->store('farmland/certificates', 'public');
        }

        if ($request->hasFile('location_map')) {
            // Delete old map if exists
            if ($farmland->map_path) {
                Storage::disk('public')->delete($farmland->map_path);
            }
            $data['map_path'] = $request->file('location_map')->store('farmland/maps', 'public');
        }

        $farmland->update($data);

        return redirect()->route('landlord.farmlands')->with('success', 'Data lahan berhasil diperbarui!');
    }

    public function progressReports()
    {
        $user = auth()->user();
        
        $reports = DailyReport::whereHas('project.farmland', function($query) use ($user) {
            $query->where('landlord_id', $user->id);
        })->with(['project.farmland', 'user'])->latest()->paginate(15);

        return view('landlord.progress-reports', compact('reports'));
    }

    public function collaborationHistory()
    {
        $user = auth()->user();
        
        // Get farmers who worked on landlord's land
        $farmers = User::whereHas('dailyReports.project.farmland', function($query) use ($user) {
            $query->where('landlord_id', $user->id);
        })->with(['dailyReports' => function($query) use ($user) {
            $query->whereHas('project.farmland', function($q) use ($user) {
                $q->where('landlord_id', $user->id);
            });
        }])->get();
        
        // Get investors who invested in projects on landlord's land
        $investors = User::whereHas('investments.farmland', function($query) use ($user) {
            $query->where('landlord_id', $user->id);
        })->with(['investments' => function($query) use ($user) {
            $query->whereHas('farmland', function($q) use ($user) {
                $q->where('landlord_id', $user->id);
            })->where('status', 'confirmed');
        }])->get();

        return view('landlord.collaboration-history', compact('farmers', 'investors'));
    }

    public function chat()
    {
        $user = auth()->user();
        
        // Get users that landlord can chat with (manajer, logistik, petani, admin)
        $chatUsers = User::whereIn('role', ['manajer_lapangan', 'logistik', 'petani', 'admin'])
            ->where('id', '!=', $user->id)
            ->get();
        
        // Get recent conversations
        $conversations = ChatMessage::where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->with(['sender', 'receiver'])
            ->latest()
            ->get()
            ->groupBy(function($message) use ($user) {
                return $message->sender_id == $user->id ? $message->receiver_id : $message->sender_id;
            });
        
        return view('landlord.chat', compact('chatUsers', 'conversations'));
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

    public function documents()
    {
        $user = auth()->user();
        $farmlands = $user->farmlands()->get();
        
        return view('landlord.documents', compact('farmlands'));
    }
}