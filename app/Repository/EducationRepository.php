<?php

namespace App\Repository;

use App\Models\Education;

class EducationRepository
{
    public function __construct(private Education $education) {}

    public function save(Education $education): Education
    {
        $education->save();

        return $education->fresh();
    }

    public function findById(int $id): ?Education
    {
        return $this->education->find($id);
    }
    
    public function delete(Education $education): bool
    {
        return $education->delete();
    }
}