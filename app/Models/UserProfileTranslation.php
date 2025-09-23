<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfileTranslation extends Model
{
    protected $fillable = [
        'user_profile_id', 'lang', 'bio', 'full_bio'
    ];

    // Relationship
    public function userProfile(): BelongsTo
    {
        return $this->belongsTo(UserProfile::class);
    }
}
