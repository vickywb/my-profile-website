<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            [
                'user_id' => 1,
                'project_title' => 'E-commerce',
                'description' => 'Create REST API Using Laravel as a Backend and Vue.Js for Frontend.',
                'project_url' => '-',
                'github_url' => '-'
            ],
            
            [
                'user_id' => 1,
                'project_title' => 'Laracomp',
                'description' => 'Create Website E-commerce Using Laravel 11',
                'project_url' => '-',
                'github_url' => '-'
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}
