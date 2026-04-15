<?php

namespace App\Repository;

use App\Models\UserProfile;

class UserProfileRepository
{
    public function __construct(private UserProfile $userProfile) {}

    public function save(UserProfile $userProfile): UserProfile
    {
        $userProfile->save();
        return $userProfile->fresh();
    }

    public function findByColumn($value, $column)
    {
        return $this->userProfile->where($column, $value)->first();
    }
}