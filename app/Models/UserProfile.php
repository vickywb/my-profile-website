<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id', 'file_id', 'phone_number', 'address'
    ];

    // Relationship
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function profileImage()
    {
        return $this->belongsTo(File::class, 'file_id');
    }

    public function userProfileTranslations(): HasMany
    {
        return $this->hasMany(UserProfileTranslation::class);
    }

    // Accessor
    protected function bioTranslation(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $translation = $this->userProfileTranslations()
                                    ->where('lang', app()->getLocale())
                                    ->first();

                return $translation ? $translation->bio : $this->bio; // fallback
            },
        );
    }
    
    protected function fullBioTranslation(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $translation = $this->userProfileTranslations()
                                    ->where('lang', app()->getLocale())
                                    ->first();

                return $translation ? $translation->full_bio : $this->full_bio; // fallback
            },
        );
    }

}
