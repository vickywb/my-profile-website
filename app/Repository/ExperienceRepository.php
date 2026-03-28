<?php

namespace App\Repository;

use App\Models\Experience;

class ExperienceRepository
{
    public function __construct(private Experience $experience) {}

    public function save(Experience $experience): Experience
    {
        $experience->save();

        return $experience->fresh();
    }

    public function findById(int $id): ?Experience
    {
        return $this->experience->find($id);
    }
    
    public function delete(Experience $experience): bool
    {
        return $experience->delete();
    }
}