<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExperienceTranslation extends Model
{
    protected $fillable = [
        'experience_id', 'job_description', 'lang'
    ];

    public function experience(): BelongsTo
    {
        return $this->belongsTo(Experience::class);
    }
}
