<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Skill extends Model
{
    protected $fillable = [
        'user_id', 'skill_name', 'category_skill_id', 'display_order'
    ];
    
    // Relationship
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categorySkill(): BelongsTo
    {
        return $this->belongsTo(CategorySkill::class, 'category_skill_id');
    }
}
