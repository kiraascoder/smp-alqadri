<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Utama',
            'email' => 'adminsmpalqadri@gmail.com',
            'password' => Hash::make('adminsmpalqadri'),
            'no_hp' => '08123456789',
            'role' => 'admin',
        ]);
    }
}
