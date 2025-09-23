<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Education extends Model
{
    protected $fillable = [
        'user_id', 'institution_name', 'degree',  'field_of_study',
        'grade_gpa', 'start_at', 'end_at'
    ];

    protected $casts = [
        'grade_gpa' => 'string'
    ];
    
    // Relationship
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
