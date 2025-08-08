<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'project_id',
        'product_name',
        'description',
        'quantity',
        'unit',
        'price_per_unit',
        'total_price',
        'status',
        'confirmed_at',
        'harvesting_at',
        'ready_at',
        'delivered_at',
        'received_at',
        'feedback',
        'rating',
    ];

    protected $casts = [
        'price_per_unit' => 'decimal:2',
        'total_price' => 'decimal:2',
        'confirmed_at' => 'datetime',
        'harvesting_at' => 'datetime',
        'ready_at' => 'datetime',
        'delivered_at' => 'datetime',
        'received_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
