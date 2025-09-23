<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
           [
            'name' => 'Vicky Wibisono',
            'email' => 'wibivicky@gmail.com',
            'password' => Hash::make('@Wibivicky2497'),
            'is_admin' => true
           ],
           [
            'name' => 'User Test',
            'email' => 'user@test.com',
            'password' => Hash::make('secret'),
            'is_admin' => false
           ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
