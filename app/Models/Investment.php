<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'farmland_id',
        'amount',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    /**
     * Get the user who made this investment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the farmland this investment is for.
     */
    public function farmland()
    {
        return $this->belongsTo(Farmland::class);
    }

    /**
     * Calculate potential return based on farmland investment period.
     */
    public function getPotentialReturnAttribute()
    {
        $months = $this->farmland->investment_period_months ?? 12;
        $annualReturn = 15; // Assume 15% annual return
        $periodReturn = ($annualReturn / 12) * $months;
        return $this->amount * (1 + ($periodReturn / 100));
    }
} 