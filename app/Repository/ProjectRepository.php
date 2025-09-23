<?php

namespace App\Repository;

use App\Models\Project;

class ProjectRepository
{
    private $project;

    public function __construct(Project $project) {
        $this->project = $project;
    }

    public function save(Project $project)
    {
        $project->save();   

        return $project;
    }
}