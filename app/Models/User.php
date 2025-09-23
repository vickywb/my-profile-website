<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\UserProfile;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationship
    public function userProfile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function certifications(): HasMany
    {
        return $this->hasMany(Certification::class);
    }

    public function education(): HasOne
    {
        return $this->hasOne(Education::class);
    }

    public function socialLinks(): HasMany
    {
        return $this->hasMany(SocialLink::class);
    }

    public function experiences(): HasMany
    {
        return $this->hasMany(Experience::class);
    }

    public function userCvFiles(): HasMany
    {
        return $this->hasMany(UserCvFile::class);
    }

    // Accessor
    public function certificate()
    {
        foreach ($this->certifications() as $certificate) {
            return $certificate;
        }
    }

    protected function userCvUploaded(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $translation = $this->userCvFiles()
                                    ->where('lang', app()->getLocale())
                                    ->first();

                return $translation ? $translation->cv_id : $this->cv_id; // fallback
            },
        );
    }
}
