<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;

class UpdateScoreBKSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Siswa::query()->update([
            'score_bk' => 100,
        ]);

        $this->command->info('✅ Semua score_bk siswa berhasil diubah menjadi 100.');
    }
}
