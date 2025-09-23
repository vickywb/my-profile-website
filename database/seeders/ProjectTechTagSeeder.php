<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectTechTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mapping = [
            1 => [1, 2, 4, 8],
            2 => [1, 2, 8, 10]
        ];

        foreach ($mapping as $projectId => $techTags) {
            foreach ($techTags as $techTagId) {
                DB::table('project_tech_tag')->insert([
                    'project_id' => $projectId,
                    'technology_id' => $techTagId
                ]);
            }
        }
    }
}
