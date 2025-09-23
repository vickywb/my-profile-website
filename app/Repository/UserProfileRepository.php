<?php

namespace App\Repository;

use App\Models\UserProfile;
use Illuminate\Support\Facades\Hash;

class UserProfileRepository
{
    private $userProfile;

    public function __construct(UserProfile $userProfile) {
        $this->userProfile = $userProfile;
    }

    public function save(UserProfile $userProfile)
    {
        $userProfile->save();
        return $userProfile;
    }
}