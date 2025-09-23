<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialLink extends Model
{
    protected $fillable = [
        'user_id', 'platform_name', 'platform_url', 'is_active', 'icon_class',
        'display_order'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];
    
    // Relationship
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
