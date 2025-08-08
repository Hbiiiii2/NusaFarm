<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farmland extends Model
{
    use HasFactory;

    protected $fillable = [
        'landlord_id',
        'location',
        'size',
        'status',
        'rental_price',
        'description',
        'crop_type',
        'certificate_path',
        'map_path',
        'verified_at',
        'verified_by',
        'rejected_at',
        'rejected_by',
        'rejection_reason',
        'approved_by_admin_at',
        'approved_by_admin_by',
        'ready_for_investment_at',
        'ready_for_investment_by',
        'investment_period_months',
        'required_investment_amount',
        'minimum_investment_amount',
        'investment_notes',
    ];

    protected $casts = [
        'size' => 'float',
        'rental_price' => 'decimal:2',
        'verified_at' => 'datetime',
        'rejected_at' => 'datetime',
        'approved_by_admin_at' => 'datetime',
        'ready_for_investment_at' => 'datetime',
        'investment_period_months' => 'decimal:2',
        'required_investment_amount' => 'decimal:2',
        'minimum_investment_amount' => 'decimal:2',
    ];

    /**
     * Get the landlord (user) who owns this farmland.
     */
    public function landlord()
    {
        return $this->belongsTo(User::class, 'landlord_id');
    }

    /**
     * Get the admin who verified this farmland.
     */
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Get the admin who rejected this farmland.
     */
    public function rejectedBy()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    /**
     * Get the admin who approved this farmland.
     */
    public function approvedByAdmin()
    {
        return $this->belongsTo(User::class, 'approved_by_admin_by');
    }

    /**
     * Get the manager who made this farmland ready for investment.
     */
    public function readyForInvestmentBy()
    {
        return $this->belongsTo(User::class, 'ready_for_investment_by');
    }

    /**
     * Get the projects on this farmland.
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Get the investments for this farmland.
     */
    public function investments()
    {
        return $this->hasMany(Investment::class);
    }

    /**
     * Check if farmland is verified.
     */
    public function isVerified()
    {
        return $this->status === 'verified';
    }

    /**
     * Check if farmland is pending verification.
     */
    public function isPendingVerification()
    {
        return $this->status === 'pending_verification';
    }

    /**
     * Check if farmland is approved by admin.
     */
    public function isApprovedByAdmin()
    {
        return $this->status === 'approved_by_admin';
    }

    /**
     * Check if farmland is ready for investment.
     */
    public function isReadyForInvestment()
    {
        return $this->status === 'ready_for_investment';
    }

    /**
     * Check if farmland is rejected.
     */
    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    /**
     * Scope to get farmlands ready for investment.
     */
    public function scopeReadyForInvestment($query)
    {
        return $query->where('status', 'ready_for_investment');
    }

    /**
     * Scope to get farmlands approved by admin.
     */
    public function scopeApprovedByAdmin($query)
    {
        return $query->where('status', 'approved_by_admin');
    }
} 