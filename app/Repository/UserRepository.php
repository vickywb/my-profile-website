<?php

namespace App\Repository;

use App\Models\User;

class UserRepository
{
    public function __construct(private User $user) {}

    public function save(User $user): User
    {
        $user->save();
        
        return $user->fresh();
    }
}