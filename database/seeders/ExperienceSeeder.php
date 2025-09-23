<?php

namespace Database\Seeders;

use App\Models\Experience;
use Illuminate\Database\Seeder;

class ExperienceSeeder extends Seeder
{
    /**
     * Jalankan seed database.
     */
    public function run(): void
    {
        $experienceData = [
            [
                'experience' => [
                    'user_id' => 1,
                    'company_name' => "Gent's Barbershop",
                    'position' => 'Internship',
                    'location' => 'Surabaya, Indonesia',
                    'start_date' => 'January 2018',
                    'end_date' => 'June 2018',
                    'is_current' => false
                ],
                'translations' => [
                    [
                        'lang' => 'en',
                        'job_description' => "Developed an admin panel using PHP to manage company profile data, enabling the team to update information independently. Responsible for designing and implementing a responsive user interface using HTML, CSS, and Bootstrap to improve the website's appearance and navigation."
                    ],
                    [
                        'lang' => 'id',
                        'job_description' => "Mengembangkan admin panel menggunakan PHP untuk mengelola data profile perusahaan, untuk memfasilitasi tim dalam melakukan pembaruan informasi secara mandiri. Bertanggung jawab dalam mendesain dan mengimplementasikan antarmuka pengguna yang responsif menggunakan HTML, CSS, dan Bootstrap untuk meningkatkan tampilan dan navigasi website."
                    ]
                ]
            ],
            [
                'experience' => [
                    'user_id' => 1,
                    'company_name' => 'Bureau Veritas',
                    'position' => 'Freelance Laravel Developer',
                    'location' => 'Surabaya, Indonesia',
                    'start_date' => 'August 2021',
                    'end_date' => 'October 2021',
                    'is_current' => false
                ],
                'translations' => [
                    [
                        'lang' => 'en',
                        'job_description' => "Actively participated in the development of an admin panel using Laravel for a scheduling and inspection history monitoring system. Involved in designing the database structure to ensure data was well-organized and aligned with system requirements. Collaborated with the team using the Agile methodology, leveraging Git and GitHub for version control. Added features to the website to ensure the project progressed according to plan."
                    ],
                    [
                        'lang' => 'id',
                        'job_description' => "Berperan aktif dalam pengembangan admin panel menggunakan Laravel untuk sistem penjadwalan dan pemantauan riwayat inspeksi. Saya ikut terlibat dalam perancangan struktur database untuk memastikan data dapat terorganisir dengan baik sesuai kebutuhan sistem. Berperan aktif dalam kolaborasi tim dengan metodologi Agile, menggunakan Git dan GitHub untuk version control. Menambahkan fitur-fitur pada website untuk memastikan proyek berjalan sesuai rencana."
                    ]
                ]
            ],
            [
                'experience' => [
                    'user_id' => 1,
                    'company_name' => 'Madeby.id',
                    'position' => 'Freelance Laravel Developer',
                    'location' => 'Surabaya, Indonesia',
                    'start_date' => 'December 2021',
                    'end_date' => 'July 2022',
                    'is_current' => false
                ],
                'translations' => [
                    [
                        'lang' => 'en',
                        'job_description' => "Played an active role in developing features for the admin panel using Laravel and the Agile methodology. Collaborated with the UI/UX team to implement features based on Figma designs and regularly communicated with the backend team leader to ensure tasks were completed accurately and met technical standards. Managed the entire development process using Git and GitHub for organized collaboration. Designed and implemented RESTful APIs that aligned with the UI requirements from Figma. Created comprehensive API documentation for the frontend team using Postman, SwaggerUI, and Laravel-request-docs."
                    ],
                    [
                        'lang' => 'id',
                        'job_description' => "Berperan aktif dalam pengembangan fitur di admin panel menggunakan Laravel dan metodologi Agile. Saya bekerja sama dengan tim UI/UX untuk mengimplementasikan fitur sesuai desain dari Figma. Selain itu, saya secara rutin berdiskusi dengan leader tim backend untuk memastikan setiap tugas selesai dengan akurat dan sesuai dengan standar teknis yang ditetapkan. Seluruh proses pengembangan diatur dengan Git dan GitHub untuk kolaborasi yang terorganisir. Mendesain dan mengimplementasikan RESTful API yang selaras dengan kebutuhan UI yang dirancang di Figma. Saya juga bertanggung jawab membuat dokumentasi API yang lengkap untuk tim frontend menggunakan Postman, SwaggerUI, dan Laravel-request-docs."
                    ]
                ]
            ],
            [
                'experience' => [
                    'user_id' => 1,
                    'company_name' => 'PT. Optimalindo Solusi Purna',
                    'position' => 'Freelance Laravel Developer',
                    'location' => 'Surabaya, Indonesia',
                    'start_date' => 'February 2024',
                    'end_date' => 'June 2024',
                    'is_current' => false
                ],
                'translations' => [
                    [
                        'lang' => 'en',
                        'job_description' => "Designed and implemented a responsive and functional company profile website and admin panel for data management. Utilized Laravel for the backend and Bootstrap, HTML, CSS, and JavaScript for the user interface to ensure an optimal user experience."
                    ],
                    [
                        'lang' => 'id',
                        'job_description' => "Merancang dan mengimplementasikan website company profile dan admin panel yang responsif dan fungsional untuk mengelola data. Menggunakan Laravel untuk backend dan Bootstrap, HTML, CSS, JavaScript untuk antarmuka pengguna, memastikan pengalaman pengguna yang optimal."
                    ]
                ]
            ],
        ];

        // Loop di array data yang sudah terstruktur
        foreach ($experienceData as $data) {
            // 1. Buat data experience utama
            $experience = Experience::create($data['experience']);

            // 2. Loop untuk setiap terjemahan dan gunakan relasi untuk menautkannya
            foreach ($data['translations'] as $translation) {
                $experience->experienceTranslations()->create($translation);
            }
        }
    }
}
