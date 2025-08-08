<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logistics extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'logistics_user_id',
        'delivery_type',
        'status',
        'delivery_date',
    ];

    protected $casts = [
        'delivery_date' => 'date',
    ];

    /**
     * Get the project this logistics belongs to.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the logistics user handling this delivery.
     */
    public function logisticsUser()
    {
        return $this->belongsTo(User::class, 'logistics_user_id');
    }

    /**
     * Scope for pending deliveries.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for in-transit deliveries.
     */
    public function scopeInTransit($query)
    {
        return $query->where('status', 'in_transit');
    }

    /**
     * Scope for delivered items.
     */
    public function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }

    /**
     * Mark delivery as in transit.
     */
    public function markAsInTransit()
    {
        $this->status = 'in_transit';
        $this->save();
    }

    /**
     * Mark delivery as delivered.
     */
    public function markAsDelivered()
    {
        $this->status = 'delivered';
        $this->save();
    }
} 