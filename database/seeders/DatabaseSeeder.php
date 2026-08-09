<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Master data resmi. Aman dijalankan berulang karena seeder menggunakan updateOrCreate.
        $this->call([
            PelanggaranSeeder::class,
            KebajikanSeeder::class,
        ]);

        // Dummy hanya otomatis pada local/testing.
        if (app()->environment('local', 'testing')) {
            $this->call([
                DummyOrangTuaSeeder::class,
                DummyGuruSeeder::class,
                DummySiswaSeeder::class,
            ]);
        }
    }
}
