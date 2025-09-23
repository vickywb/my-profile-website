<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $technologies = [
            [
                'name' => 'Laravel'
            ],
            [
                'name' => 'MySQL'
            ],
            [
                'name' => 'JavaScript'
            ],
            [
                'name' => 'Vue.js'
            ],
            [
                'name' => 'PHP'
            ],
            [
                'name' => 'HTML'
            ],
            [
                'name' => 'CSS'
            ],
            [
                'name' => 'Bootstrap'
            ],
            [
                'name' => 'Tailwind CSS'
            ],
            [
                'name' => 'Blade'
            ]
        ];

        foreach ($technologies as $technology) {
            Technology::create($technology);
        }
    }
}
