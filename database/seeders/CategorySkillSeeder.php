<?php

namespace Database\Seeders;

use App\Models\CategorySkill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorieSkills = [
            [
                'name' => 'Languages',
            ],
            [
                'name' => 'Programming Languages',
            ],
            [
                'name' => 'Framework and Libraries',
            ],[
                'name' => 'Testing',
            ],
            [
                'name' => 'Pattern, Principles, and Best Practices',
            ],
            [
                'name' => 'Databases',
            ],
            [
                'name' => 'Others',
            ],
            [
                'name' => 'Tools',
            ],
        ];

        foreach ($categorieSkills as $categorieSkill) {
            CategorySkill::create($categorieSkill);
        }
    }
}
