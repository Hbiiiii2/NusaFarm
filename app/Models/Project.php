<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'farmland_id',
        'manager_id',
        'title',
        'description',
        'status',
        'start_date',
        'end_date',
        'expected_roi',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'expected_roi' => 'decimal:2',
    ];

    /**
     * Get the farmland where this project is located.
     */
    public function farmland()
    {
        return $this->belongsTo(Farmland::class);
    }

    /**
     * Get the manager (user) who manages this project.
     */
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    /**
     * Get the investments in this project through farmland.
     */
    public function investments()
    {
        return $this->farmland->investments();
    }

    /**
     * Get the farming tasks for this project.
     */
    public function farmingTasks()
    {
        return $this->hasMany(FarmingTask::class);
    }

    /**
     * Get the logistics for this project.
     */
    public function logistics()
    {
        return $this->hasMany(Logistics::class);
    }

    /**
     * Calculate total investment amount.
     */
    public function getTotalInvestmentAttribute()
    {
        return $this->investments()->where('status', 'confirmed')->sum('amount');
    }

    /**
     * Calculate current ROI based on project status.
     */
    public function getCurrentRoiAttribute()
    {
        // This would be calculated based on actual harvest results
        // For now, return expected ROI
        return $this->expected_roi;
    }
} 