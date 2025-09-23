<?php

namespace Database\Seeders;

use App\Models\SocialLink;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SocialLinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $socialLinks = [
            [
                'user_id' => 1,
                'platform_name' => 'LinkedIn',
                'platform_url' => 'https://linkedin.com/in/vicky-wibisono-wibi',
                'icon_class' => 'bi bi-linkedin',
                'is_active' => true,
                'display_order' => 1
            ],
            [
                'user_id' => 1,
                'platform_name' => 'GitHub',
                'platform_url' => 'https://github.com/vickywb',
                'icon_class' => 'bi bi-github',
                'is_active' => true,
                'display_order' => 2
            ],
            [
                'user_id' => 1,
                'platform_name' => 'Email',
                'platform_url' => 'mailto:wibivicky@gmail.com',
                'icon_class' => 'bi bi-envelope',
                'is_active' => true,
                'display_order' => 3
            ]
        ];

        foreach ($socialLinks as $socialLink) {
            SocialLink::create($socialLink);
        }
    }
}
