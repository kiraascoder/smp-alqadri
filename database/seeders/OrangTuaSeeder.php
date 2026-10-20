<?php

namespace Database\Seeders;

use App\Models\OrangTua;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class OrangTuaSeeder extends Seeder
{
    public function run(): void
    {
        $phone = '6282377244019';

        $user = User::query()
            ->where('role', User::ROLE_ORANG_TUA)
            ->where('no_hp', $phone)
            ->first();

        if (! $user) {
            $user = User::create([
                'name' => 'Irmansyah Muslimin',
                'email' => 'irmansyah.muslimin.ortu@smpalqadri.local',
                'no_hp' => $phone,
                'jenis_kelamin' => 'Laki-Laki',
                'password' => Hash::make('password123!'),
                'role' => User::ROLE_ORANG_TUA,
                'email_verified_at' => now(),
            ]);
        } else {
            $user->update([
                'name' => 'Irmansyah Muslimin',
                'no_hp' => $phone,
                'password' => Hash::make('password123!'),
                'role' => User::ROLE_ORANG_TUA,
            ]);
        }

        OrangTua::firstOrCreate([
            'user_id' => $user->id,
        ]);

        $this->command->info('========================================');
        $this->command->info('AKUN ORANG TUA');
        $this->command->info('========================================');
        $this->command->info('Nama     : Irmansyah Muslimin');
        $this->command->info('No. HP   : 6282377244019');
        $this->command->info('Password : password123!');
        $this->command->info('Role     : orang_tua');
        $this->command->info('Email    : ' . $user->email);
        $this->command->info('User ID  : ' . $user->id);
    }
}
