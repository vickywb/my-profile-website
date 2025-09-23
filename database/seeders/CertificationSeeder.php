<?php

namespace Database\Seeders;

use App\Models\Certification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CertificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $certifications = [
            [
                'user_id' => 1,
                'cert_name' => 'Course Certificate Theoretical and Practical Understanding of SQL',
                'issuing_organization' => 'sololearn',
                'issue_date' => '24 June, 2022',
            ],
            [
                'user_id' => 1,
                'cert_name' => 'Course Certificate Theoretical and Practical Understanding of PHP',
                'issuing_organization' => 'sololearn',
                'issue_date' => '12 September, 2022',
            ],
            [
                'user_id' => 1,
                'cert_name' => 'Course Certificate Theoretical and Practical Understanding of JavaScript',
                'issuing_organization' => 'sololearn',
                'issue_date' => '15 September, 2022',
            ],
            [
                'user_id' => 1,
                'cert_name' => 'Mastering Laravel 8 for Beginners & Intermediate',
                'issuing_organization' => 'sololearn',
                'issue_date' => '26 September, 2022',
            ],
        ];

        foreach ($certifications as $certification) {
            Certification::create($certification);
        }
    }
}
