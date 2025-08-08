<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FertilizerOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'project_id',
        'fertilizer_name',
        'description',
        'quantity',
        'unit',
        'price_per_unit',
        'total_price',
        'status',
        'processed_at',
        'ready_at',
        'shipped_at',
        'delivered_at',
        'notes',
    ];

    protected $casts = [
        'price_per_unit' => 'decimal:2',
        'total_price' => 'decimal:2',
        'processed_at' => 'datetime',
        'ready_at' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
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
