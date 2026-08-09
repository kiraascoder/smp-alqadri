<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Database\Seeder;

class DummyGuruSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['name' => 'Guru Demo Ahmad', 'email' => 'guru.demo1@smpalqadri.sch.id', 'jk' => 'Laki-Laki'],
            ['name' => 'Guru Demo Aisyah', 'email' => 'guru.demo2@smpalqadri.sch.id', 'jk' => 'Perempuan'],
        ];

        foreach ($data as $item) {
            // firstOrCreate: tidak mereset password jika akun sudah ada.
            $user = User::firstOrCreate(
                ['email' => $item['email']],
                [
                    'name' => $item['name'],
                    'password' => 'password123',
                    'role' => 'guru',
                    'jenis_kelamin' => $item['jk'],
                ]
            );

            Guru::firstOrCreate(['user_id' => $user->id]);
        }
    }
}
