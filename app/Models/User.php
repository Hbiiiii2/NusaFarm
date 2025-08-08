<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'xp',
        'level',
        'wallet_balance',
        'last_login_at',
        'last_watered_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'wallet_balance' => 'decimal:2',
        'last_login_at' => 'datetime',
        'last_watered_at' => 'datetime',
    ];

    /**
     * Get the farmlands owned by this user (as landlord).
     */
    public function farmlands()
    {
        return $this->hasMany(Farmland::class, 'landlord_id');
    }

    /**
     * Get the projects managed by this user.
     */
    public function managedProjects()
    {
        return $this->hasMany(Project::class, 'manager_id');
    }

    /**
     * Get the investments made by this user.
     */
    public function investments()
    {
        return $this->hasMany(Investment::class);
    }

    /**
     * Get the wallet transactions for this user.
     */
    public function walletTransactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    /**
     * Get the farming tasks assigned to this user.
     */
    public function farmingTasks()
    {
        return $this->hasMany(FarmingTask::class, 'assigned_to');
    }

    /**
     * Get the logistics handled by this user.
     */
    public function logistics()
    {
        return $this->hasMany(Logistics::class, 'logistics_user_id');
    }

    /**
     * Get the notifications for this user.
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Get the badges earned by this user.
     */
    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'user_badges');
    }

    /**
     * Get the daily reports submitted by this user (as petani).
     */
    public function dailyReports()
    {
        return $this->hasMany(DailyReport::class);
    }

    /**
     * Get the supply requests submitted by this user (as petani).
     */
    public function supplyRequests()
    {
        return $this->hasMany(SupplyRequest::class);
    }

    /**
     * Get the logistics handled by this user (as logistik).
     */
    public function handledLogistics()
    {
        return $this->hasMany(Logistic::class);
    }

    /**
     * Get the fertilizer orders handled by this user (as penyedia pupuk).
     */
    public function fertilizerOrders()
    {
        return $this->hasMany(FertilizerOrder::class);
    }

    /**
     * Get the market orders made by this user (as pedagang pasar).
     */
    public function marketOrders()
    {
        return $this->hasMany(MarketOrder::class);
    }

    /**
     * Get the messages sent by this user.
     */
    public function sentMessages()
    {
        return $this->hasMany(ChatMessage::class, 'sender_id');
    }

    /**
     * Get the messages received by this user.
     */
    public function receivedMessages()
    {
        return $this->hasMany(ChatMessage::class, 'receiver_id');
    }

    /**
     * Check if user has a specific role.
     */
    public function hasRole($role)
    {
        return $this->role === $role;
    }

    /**
     * Add XP to user and check for level up.
     */
    public function addXp($amount)
    {
        $this->xp += $amount;
        
        // Calculate new level (simple formula: level = floor(xp/100) + 1)
        $newLevel = floor($this->xp / 100) + 1;
        
        if ($newLevel > $this->level) {
            $this->level = $newLevel;
            // Could trigger level up event here
        }
        
        $this->save();
    }

    /**
     * Add money to wallet.
     */
    public function addToWallet($amount)
    {
        $this->wallet_balance += $amount;
        $this->save();
    }

    /**
     * Deduct money from wallet.
     */
    public function deductFromWallet($amount)
    {
        if ($this->wallet_balance >= $amount) {
            $this->wallet_balance -= $amount;
            $this->save();
            return true;
        }
        return false;
    }
}
