<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Guru BK Ganteng',
            'email' => 'gurubk@gmail.com',
            'password' => Hash::make('12345678'),
            'no_hp' => '08123456789',
            'role' => 'guru_bk',
        ]);
    }
}
