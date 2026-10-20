<?php

namespace Database\Seeders;

use App\Models\OrangTua;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestingAkunOrangTuaSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate(
            [
                'no_hp' => '6282377244019',
            ],
            [
                'name' => 'Irman Syah Muslimin',
                'email' => 'irmansyah.muslimin.ortu@smpalqadri.local',
                'no_hp' => '6282377244019',
                'jenis_kelamin' => 'Laki-Laki',
                'password' => Hash::make('OrangTua123!'),
                'role' => User::ROLE_ORANG_TUA,
            ]
        );

        OrangTua::firstOrCreate(
            [
                'user_id' => $user->id,
            ]
        );

        $this->command->info('Akun orang tua berhasil dibuat/diperbarui.');
        $this->command->info('Nama     : ' . $user->name);
        $this->command->info('No. HP   : ' . $user->no_hp);
        $this->command->info('Email    : ' . $user->email);
        $this->command->info('Role     : ' . $user->role);
        $this->command->info('User ID  : ' . $user->id);
    }
}
