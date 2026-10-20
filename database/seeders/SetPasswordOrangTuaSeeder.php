<?php

namespace Database\Seeders;

use App\Models\OrangTua;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SetPasswordOrangTuaSeeder extends Seeder
{
    public function run(): void
    {
        $password = 'password123!';

        $updated = 0;
        $skipped = 0;

        OrangTua::with('user')
            ->whereHas('user', function ($query) {
                $query->where('role', 'orang_tua');
            })
            ->chunkById(100, function ($orangTuas) use (
                $password,
                &$updated,
                &$skipped
            ) {
                foreach ($orangTuas as $orangTua) {
                    $user = $orangTua->user;

                    if (! $user) {
                        $skipped++;
                        continue;
                    }

                    $user->update([
                        'password' => Hash::make($password),
                    ]);

                    $updated++;
                }
            });

        $this->command->info('========================================');
        $this->command->info('PASSWORD ORANG TUA');
        $this->command->info('========================================');
        $this->command->info('Akun diperbarui : ' . $updated);
        $this->command->info('Akun dilewati   : ' . $skipped);
        $this->command->info('Password        : ' . $password);
    }
}
