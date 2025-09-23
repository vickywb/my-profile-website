<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Experience extends Model
{
    protected $fillable = [
        'user_id', 'company_name', 'position',
        'location', 'start_date', 'end_date', 'is_current'
    ];

    protected $casts = [
        'is_current' => 'boolean'
    ];

    // Relationship
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function experienceTranslations(): HasMany
    {
        return $this->hasMany(ExperienceTranslation::class);
    }

    // Accessor
    protected function jobDescription(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $translation = $this->experienceTranslations
                                    ->where('lang', app()->getLocale())
                                    ->first();

                return $translation ? $translation->job_description : $this->job_description; // fallback
            },
        );
    }
}
