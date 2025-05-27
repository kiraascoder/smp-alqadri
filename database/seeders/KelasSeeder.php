<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kelas')->insert([
            ['nama_kelas' => 'X IPA 1', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kelas' => 'X IPA 2', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kelas' => 'XI IPS 1', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kelas' => 'XI IPA 1', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kelas' => 'XII IPS 2', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kelas' => 'XII IPA 1', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
