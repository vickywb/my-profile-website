<?php

namespace App\Repository;

use App\Models\Experience;

class ExperienceRepository
{
    private $experience;

    public function __construct(Experience $experience) {
        $this->experience = $experience;
    }

    public function save(Experience $experience)
    {
       $experience->save();

        return $experience;
    }
}