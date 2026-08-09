<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DummySiswaSeeder extends Seeder
{
    public function run(): void
    {
        $kelas = Kelas::firstOrCreate(['nama_kelas' => 'Kelas 7']);

        $ortuUser = User::where('email', 'ortu.demo1@smpalqadri.sch.id')->first();

        $data = [
            ['name' => 'Ahmad Fauzan Demo', 'email' => 'siswa.demo1@smpalqadri.sch.id', 'nisn' => '9000000001', 'jk' => 'Laki-Laki', 'lahir' => '2013-01-10'],
            ['name' => 'Aisyah Zahra Demo', 'email' => 'siswa.demo2@smpalqadri.sch.id', 'nisn' => '9000000002', 'jk' => 'Perempuan', 'lahir' => '2013-07-22'],
            ['name' => 'Muhammad Fadhil Demo', 'email' => 'siswa.demo3@smpalqadri.sch.id', 'nisn' => '9000000003', 'jk' => 'Laki-Laki', 'lahir' => '2013-04-15'],
            ['name' => 'Fatimah Az-Zahra Demo', 'email' => 'siswa.demo4@smpalqadri.sch.id', 'nisn' => '9000000004', 'jk' => 'Perempuan', 'lahir' => '2013-11-05'],
        ];

        $hasUserId = Schema::hasColumn('siswa', 'user_id');
        $hasNisn = Schema::hasColumn('siswa', 'nisn');
        $hasNama = Schema::hasColumn('siswa', 'nama');
        $hasTanggalLahir = Schema::hasColumn('siswa', 'tanggal_lahir');
        $hasOrangTuaId = Schema::hasColumn('siswa', 'orang_tua_id');

        foreach ($data as $item) {
            $user = User::firstOrCreate(
                ['email' => $item['email']],
                [
                    'name' => $item['name'],
                    'password' => 'password123',
                    'role' => 'siswa',
                    'jenis_kelamin' => $item['jk'],
                ]
            );

            $lookup = $hasNisn
                ? ['nisn' => $item['nisn']]
                : ($hasUserId ? ['user_id' => $user->id] : ['nama' => $item['name']]);

            $values = ['kelas_id' => $kelas->id];

            if ($hasUserId) {
                $values['user_id'] = $user->id;
            }
            if ($hasNama) {
                $values['nama'] = $item['name'];
            }
            if ($hasTanggalLahir) {
                $values['tanggal_lahir'] = $item['lahir'];
            }
            if ($hasOrangTuaId && $ortuUser) {
                // Model Siswa saat ini mengarah langsung ke users melalui orang_tua_id.
                $values['orang_tua_id'] = $ortuUser->id;
            }

            // firstOrCreate menjaga score/history data yang sudah ada.
            Siswa::firstOrCreate($lookup, $values);
        }
    }
}
