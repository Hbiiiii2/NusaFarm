<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Get the users who have earned this badge.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_badges');
    }

    /**
     * Check if a user has this badge.
     */
    public function hasUser($user)
    {
        return $this->users()->where('user_id', $user->id)->exists();
    }

    /**
     * Award this badge to a user.
     */
    public function awardTo($user)
    {
        if (!$this->hasUser($user)) {
            $this->users()->attach($user->id);
            return true;
        }
        return false;
    }

    /**
     * Remove this badge from a user.
     */
    public function removeFrom($user)
    {
        $this->users()->detach($user->id);
    }
} 