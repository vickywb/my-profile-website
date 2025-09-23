<?php

namespace Database\Seeders;

use App\Models\UserProfile;
use App\Models\UserProfileTranslation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profileData = [
            [
                'UserProfile' => [
                    'user_id' => 1,
                    'phone_number' => '081334545131',
                    'address' => 'Pondok Nirwana Anggaswangi Cluster Gloriosa, Blok F.30',
                ],
                'translations' => [
                    [
                        'lang' => 'en',
                        'bio' => 'Fullstack Web Developer with 2+ years of experience building web applications using PHP and the Laravel Framework. I prioritize clean, readable, and structured code to ensure scalability and long-term maintenance. I am also proactive in continuous learning, currently deepening my knowledge of Vue.js and performance-driven query optimization to build more efficient applications.',
                        'full_bio' => 'As a web developer specializing in PHP and Laravel, I am dedicated to creating efficient and scalable websites that are easy for other developers to understand and maintain. 
                        My goal is to deliver a good user experience while ensuring the code remains clean and readable. 
                        While my primary expertise is in backend development, I also have experience with frontend technologies like Vue.js and am always keen to learn and adapt to new programming languages.'
                    ],
                    [
                        'lang' => 'id',
                        'bio' => 'Sebagai seorang Fullstack Web Developer dengan pengalaman lebih dari 2 tahun, saya berfokus pada pembangunan aplikasi web menggunakan PHP dan Laravel Framework. Saya memprioritaskan penulisan kode yang bersih, mudah dibaca, dan terstruktur untuk memastikan skalabilitas dan kemudahan pemeliharaan jangka panjang. Saya juga proaktif dalam belajar, saat ini sedang mendalami Vue.js dan optimasi query performa untuk membangun aplikasi yang lebih efisien.',
                        'full_bio' => 'As a web developer specializing in PHP and Laravel, I am dedicated to creating efficient and scalable websites that are easy for other developers to understand and maintain. 
                        My goal is to deliver a good user experience while ensuring the code remains clean and readable. 
                        While my primary expertise is in backend development, I also have experience with frontend technologies like Vue.js and am always keen to learn and adapt to new programming languages.'
                    ],
                
                ]
            ]
        ];

        foreach ($profileData as $data) {
           $userProfiledata = UserProfile::create($data['UserProfile']);
            foreach ($data['translations'] as $translation) {
                $userProfiledata->userProfileTranslations()->create($translation);
            }
        }
    }
}
