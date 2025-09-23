<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    protected $fillable = [
        'user_id', 'project_title', 'description', 'project_url', 'github_url', 'file_id'
    ];
    
    // Relationship
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }

    public function technologies(): BelongsToMany
    {
        return $this->belongsToMany(Technology::class, 'project_tech_tag');
    }

    // Accessor
    public function getSlug(): String
    {
        return Str::slug($this->project_title);
    }
}
