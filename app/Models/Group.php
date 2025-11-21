<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Group extends Model
{
    protected $fillable = ['name', 'description'];
    
    /**
     * The users that belong to the group.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'group_members')
                    ->withTimestamps();
    }
    
    /**
     * Get the number of members in the group.
     */
    public function getMemberCountAttribute(): int
    {
        return $this->users()->count();
    }
}
