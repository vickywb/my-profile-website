<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategorySkill extends Model
{
    protected $fillable = [
        'name'
    ];

    // Relationship
    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class);
    }
}
