<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            // Spoken Languages  
            ['user_id' => 1, 'skill_name' => 'Indonesia (Native)', 'category_skill_id' => 1, 'display_order' => 1],
            ['user_id' => 1, 'skill_name' => 'English (Elementary)', 'category_skill_id' => 1, 'display_order' => 1],

            // Programming Languages
            ['user_id' => 1, 'skill_name' => 'PHP', 'category_skill_id' => 2, 'display_order' => 2],
            ['user_id' => 1, 'skill_name' => 'JavaScript', 'category_skill_id' => 2, 'display_order' => 2],
            ['user_id' => 1, 'skill_name' => 'HTML', 'category_skill_id' => 2, 'display_order' => 2],
            ['user_id' => 1, 'skill_name' => 'CSS', 'category_skill_id' => 2, 'display_order' => 2],
            ['user_id' => 1, 'skill_name' => 'SQL', 'category_skill_id' => 2, 'display_order' => 2],
            
            // Frameworks
            ['user_id' => 1, 'skill_name' => 'Laravel', 'category_skill_id' => 3, 'display_order' => 3],
            ['user_id' => 1, 'skill_name' => 'Vue.js', 'category_skill_id' => 3, 'display_order' => 3],
            ['user_id' => 1, 'skill_name' => 'Bootstrap', 'category_skill_id' => 3, 'display_order' => 3],
            
            // Testing
            ['user_id' => 1, 'skill_name' => 'API Testing', 'category_skill_id' => 4, 'display_order' => 4],
            ['user_id' => 1, 'skill_name' => 'Unit Testing', 'category_skill_id' => 4, 'display_order' => 4],
            
            // Best Practices
            ['user_id' => 1, 'skill_name' => 'MVC Pattern', 'category_skill_id' => 5, 'display_order' => 5],
            ['user_id' => 1, 'skill_name' => 'Repository Pattern', 'category_skill_id' => 5, 'display_order' => 5],
            
            // Databases
            ['user_id' => 1, 'skill_name' => 'MySQL', 'category_skill_id' => 6, 'display_order' => 6],
            ['user_id' => 1, 'skill_name' => 'PostgreSQL', 'category_skill_id' => 6, 'display_order' => 6],
            
            // Others
            ['user_id' => 1, 'skill_name' => 'Building RESTful API', 'category_skill_id' => 7, 'display_order' => 7],
            ['user_id' => 1, 'skill_name' => 'OAuth2', 'category_skill_id' => 7, 'display_order' => 7],
            ['user_id' => 1, 'skill_name' => 'Website Deployment', 'category_skill_id' => 7, 'display_order' => 7],
            
            // Tools
            ['user_id' => 1, 'skill_name' => 'Figma', 'category_skill_id' => 8, 'display_order' => 8],
            ['user_id' => 1, 'skill_name' => 'Git & GitHub', 'category_skill_id' => 8, 'display_order' => 8],
            ['user_id' => 1, 'skill_name' => 'SwaggerUI', 'category_skill_id' => 8, 'display_order' => 8],
            ['user_id' => 1, 'skill_name' => 'MySQL Workbench', 'category_skill_id' => 8, 'display_order' => 8],
        ];

        foreach ($skills as $skill) {
            Skill::create($skill);
        }
    }
}
