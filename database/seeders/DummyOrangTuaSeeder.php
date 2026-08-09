<?php

namespace Database\Seeders;

use App\Models\OrangTua;
use App\Models\User;
use Illuminate\Database\Seeder;

class DummyOrangTuaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['name' => 'Orang Tua Demo 1', 'email' => 'ortu.demo1@smpalqadri.sch.id', 'jk' => 'Laki-Laki'],
            ['name' => 'Orang Tua Demo 2', 'email' => 'ortu.demo2@smpalqadri.sch.id', 'jk' => 'Perempuan'],
        ];

        foreach ($data as $item) {
            $user = User::firstOrCreate(
                ['email' => $item['email']],
                [
                    'name' => $item['name'],
                    'password' => 'password123',
                    'role' => 'orang_tua',
                    'jenis_kelamin' => $item['jk'],
                ]
            );

            OrangTua::firstOrCreate(['user_id' => $user->id]);
        }
    }
}
