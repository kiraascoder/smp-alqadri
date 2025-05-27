<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Guru Biologi',
            'email' => 'gurubiologi@gmail.com',
            'password' => Hash::make('12345678'),
            'no_hp' => '08123456789',
            'role' => 'guru',
        ]);
    }
}
