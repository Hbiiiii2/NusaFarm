<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GamificationController extends Controller
{
    /**
     * Display user's gamification dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $badges = $user->badges;
        $availableBadges = Badge::whereNotIn('id', $badges->pluck('id'))->get();

        // Calculate XP needed for next level
        $currentLevelXp = ($user->level - 1) * 100;
        $nextLevelXp = $user->level * 100;
        $xpProgress = $user->xp - $currentLevelXp;
        $xpNeeded = $nextLevelXp - $currentLevelXp;
        $progressPercentage = ($xpProgress / $xpNeeded) * 100;

        return view('gamification.dashboard', compact(
            'user', 
            'badges', 
            'availableBadges', 
            'xpProgress', 
            'xpNeeded', 
            'progressPercentage'
        ));
    }

    /**
     * Display daily missions.
     */
    public function missions()
    {
        $user = Auth::user();
        
        // Get user's daily statistics
        $today = now()->startOfDay();
        
        // Investment mission
        $investmentCount = $user->investments()->whereDate('created_at', $today)->count();
        $investmentMissionCompleted = $investmentCount > 0;
        
        // Login mission (check if user logged in today)
        $loginCount = $user->last_login_at && $user->last_login_at->isToday() ? 1 : 0;
        $loginMissionCompleted = $loginCount > 0;
        
        // Top-up mission
        $topupCount = $user->walletTransactions()
            ->where('type', 'topup')
            ->whereDate('created_at', $today)
            ->count();
        $topupMissionCompleted = $topupCount > 0;
        
        // Share mission (this would need to be tracked separately)
        $shareCount = 0; // Placeholder - would need to implement sharing tracking
        $shareMissionCompleted = $shareCount > 0;
        
        // Profile completion mission
        $profileComplete = !empty($user->phone) && !empty($user->address);
        $profileMissionCompleted = $profileComplete;
        
        // Login streak mission
        $loginStreak = $this->calculateLoginStreak($user);
        $streakMissionCompleted = $loginStreak >= 3;
        
        // Calculate totals
        $completedMissions = 0;
        if ($investmentMissionCompleted) $completedMissions++;
        if ($loginMissionCompleted) $completedMissions++;
        if ($topupMissionCompleted) $completedMissions++;
        if ($shareMissionCompleted) $completedMissions++;
        if ($profileMissionCompleted) $completedMissions++;
        if ($streakMissionCompleted) $completedMissions++;
        
        $totalMissions = 6; // Total number of missions
        
        // Calculate total XP earned today
        $totalXpEarned = 0;
        if ($investmentMissionCompleted) $totalXpEarned += 50;
        if ($loginMissionCompleted) $totalXpEarned += 10;
        if ($topupMissionCompleted) $totalXpEarned += 25;
        if ($shareMissionCompleted) $totalXpEarned += 30;
        if ($profileMissionCompleted) $totalXpEarned += 20;
        if ($streakMissionCompleted) $totalXpEarned += 100;
        
        return view('gamification.missions', compact(
            'completedMissions',
            'totalMissions',
            'totalXpEarned',
            'investmentCount',
            'investmentMissionCompleted',
            'loginCount',
            'loginMissionCompleted',
            'topupCount',
            'topupMissionCompleted',
            'shareCount',
            'shareMissionCompleted',
            'profileComplete',
            'profileMissionCompleted',
            'loginStreak',
            'streakMissionCompleted'
        ));
    }
    
    /**
     * Calculate user's login streak.
     */
    private function calculateLoginStreak($user)
    {
        // This is a simplified calculation
        // In a real application, you'd track login dates in a separate table
        $streak = 0;
        $currentDate = now()->startOfDay();
        
        // For demo purposes, we'll simulate a streak based on user creation date
        // In reality, you'd check actual login dates
        $daysSinceCreation = $user->created_at->diffInDays($currentDate);
        
        if ($daysSinceCreation >= 3) {
            $streak = min(3, $daysSinceCreation);
        }
        
        return $streak;
    }

    /**
     * Complete a mission and award XP.
     */
    public function completeMission(Request $request)
    {
        $request->validate([
            'mission_type' => 'required|string',
        ]);

        $user = Auth::user();
        $missionType = $request->mission_type;

        // Define mission rewards
        $missionRewards = [
            'investment' => 50,
            'login' => 10,
            'topup' => 25,
            'share' => 30,
            'profile' => 20,
            'streak' => 100,
        ];

        if (!isset($missionRewards[$missionType])) {
            return redirect()->back()->with('error', 'Misi tidak valid.');
        }

        // Check if mission is already completed today
        $today = now()->startOfDay();
        $missionCompleted = false;

        switch ($missionType) {
            case 'investment':
                $missionCompleted = $user->investments()->whereDate('created_at', $today)->exists();
                break;
            case 'login':
                $missionCompleted = $user->last_login_at && $user->last_login_at->isToday();
                break;
            case 'topup':
                $missionCompleted = $user->walletTransactions()
                    ->where('type', 'topup')
                    ->whereDate('created_at', $today)
                    ->exists();
                break;
            case 'share':
                // For now, always allow share mission (would need separate tracking)
                $missionCompleted = false;
                break;
            case 'profile':
                $missionCompleted = !empty($user->phone) && !empty($user->address);
                break;
            case 'streak':
                $loginStreak = $this->calculateLoginStreak($user);
                $missionCompleted = $loginStreak >= 3;
                break;
        }

        if (!$missionCompleted) {
            return redirect()->back()->with('error', 'Misi belum selesai. Selesaikan misi terlebih dahulu.');
        }

        // Award XP
        $user->addXp($missionRewards[$missionType]);

            // Check for level up
            $oldLevel = $user->level;
            $user->refresh();
            
            if ($user->level > $oldLevel) {
                // Create level up notification
                $user->notifications()->create([
                    'title' => 'Level Up!',
                'message' => "Selamat! Anda telah mencapai level {$user->level}!",
                ]);

                // Check for badge awards based on level
                $this->checkLevelBadges($user);
            }

        return redirect()->back()->with('success', 'Misi selesai! XP diperoleh: ' . $missionRewards[$missionType]);
    }

    /**
     * Display badges page.
     */
    public function badges()
    {
        $user = Auth::user();
        $earnedBadges = $user->badges;
        $allBadges = Badge::all();

        return view('gamification.badges', compact('earnedBadges', 'allBadges'));
    }

    /**
     * Check and award badges based on user achievements.
     */
    private function checkLevelBadges($user)
    {
        $badges = [
            'First Steps' => ['level' => 1, 'description' => 'Reached level 1'],
            'Growing Strong' => ['level' => 5, 'description' => 'Reached level 5'],
            'Farming Expert' => ['level' => 10, 'description' => 'Reached level 10'],
            'Investment Master' => ['level' => 20, 'description' => 'Reached level 20'],
        ];

        foreach ($badges as $badgeName => $requirements) {
            if ($user->level >= $requirements['level']) {
                $badge = Badge::where('name', $badgeName)->first();
                
                if ($badge && !$badge->hasUser($user)) {
                    $badge->awardTo($user);
                    
                    // Create notification for new badge
                    $user->notifications()->create([
                        'title' => 'New Badge Earned!',
                        'message' => "You've earned the '{$badgeName}' badge!",
                    ]);
                }
            }
        }
    }

    /**
     * Get leaderboard data.
     */
    public function leaderboard()
    {
        $topUsers = \App\Models\User::orderBy('xp', 'desc')
            ->orderBy('level', 'desc')
            ->limit(20)
            ->get();

        return view('gamification.leaderboard', compact('topUsers'));
    }
} 