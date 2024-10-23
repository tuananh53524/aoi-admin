<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo 1 user với role 'root'
        User::create([
            'name' => 'Root User',
            'email' => 'root@example.com',
            'avatar' => '',
            'password' => Hash::make('password'),
            'role' => config('app.roles.root'), 
        ]);

        // Tạo 15 users với role 'admin'
        for ($i = 1; $i <= 15; $i++) {
            User::create([
                'name' => 'Admin User ' . $i,
                'email' => 'admin' . $i . '@example.com',
                'avatar' => '',
                'password' => Hash::make('password'),
                'role' => config('app.roles.admin'),
            ]);
        }
    }
}
