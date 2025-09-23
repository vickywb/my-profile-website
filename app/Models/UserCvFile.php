<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserCvFile extends Model
{
    protected $fillable = [
        'user_id', 'lang', 'cv_id'
    ];

    // Relasi untuk CV File menggunakan cv_id
    public function cvFile(): BelongsTo
    {
        return $this->belongsTo(File::class, 'cv_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
