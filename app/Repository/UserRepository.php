<?php

namespace App\Repository;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function save(User $user)
    {
        if (request()->filled('password')) {
            $user->password = Hash::make($user->password);
        } else {
            $user->password = $user->getRawOriginal('password');
        }

        $user->save();
        
        return $user;
    }
}