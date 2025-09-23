<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

class File extends Model
{
    protected $fillable = [
        'name', 'directory', 'file_url'
    ];

    // Relationship
    public function userProfiles(): HasMany
    {
        return $this->hasMany(UserProfile::class);
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certification::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    // Accessor
    protected function showFile(): Attribute
    {
        return new Attribute(
            get: fn () => Storage::url($this->directory)
        );
    }

}
