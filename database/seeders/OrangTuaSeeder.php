<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrangTuaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Orang Tua Siswa',
            'email' => 'ortu@example.com',
            'password' => bcrypt('password123'),
            'role' => 'orang_tua',
        ]);
    }
}
