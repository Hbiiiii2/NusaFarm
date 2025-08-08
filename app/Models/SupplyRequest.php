<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplyRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'project_id',
        'item_name',
        'description',
        'quantity',
        'unit',
        'priority',
        'status',
        'manager_notes',
        'approved_at',
        'fulfilled_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'fulfilled_at' => 'datetime',
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
