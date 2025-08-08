<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'description',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    /**
     * Get the user who owns this transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for top-up transactions.
     */
    public function scopeTopups($query)
    {
        return $query->where('type', 'topup');
    }

    /**
     * Scope for investment transactions.
     */
    public function scopeInvestments($query)
    {
        return $query->where('type', 'investment');
    }

    /**
     * Scope for withdrawal transactions.
     */
    public function scopeWithdrawals($query)
    {
        return $query->where('type', 'withdrawal');
    }

    /**
     * Scope for reward transactions.
     */
    public function scopeRewards($query)
    {
        return $query->where('type', 'reward');
    }
} 