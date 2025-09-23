<?php

namespace Database\Seeders;

use App\Models\Education;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $educations = [
            [
                'user_id' => 1,
                'institution_name' => 'Universitas Dr. Soetomo',
                'degree' =>  'Computer Science',
                'field_of_study' => 'Informatics Engineering',
                'grade_gpa' => 3.21,
                'start_at' => 2015,
                'end_at' => 2020
            ]
        ];

        foreach ($educations as $education) {
            Education::create($education);
        }
    }
}
