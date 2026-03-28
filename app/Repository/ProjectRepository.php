<?php

namespace App\Repository;

use App\Models\Project;

class ProjectRepository
{
    public function __construct(private Project $project) {}

    public function save(Project $project): Project
    {
        $project->save();   

        return $project->fresh();
    }

    public function findById(int $id): ?Project
    {
      return $this->project->find($id);
    }
}