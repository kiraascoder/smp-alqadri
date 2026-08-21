<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        $dataGuru = [
            [
                'nama' => 'HASRIANI, S.Pd.,Gr',
                'email' => 'anih15363@gmail.com',
                'no_hp' => '+62 852-9895-2241',
            ],
            [
                'nama' => 'ADE RAFIKA YUSRI, S.T',
                'email' => 'aderafikayusri12@gmail.com',
                'no_hp' => '+62 853-9419-8496',
            ],
            [
                'nama' => 'KAMIL, S.Pd.,Gr',
                'email' => 'abdullahkamil604@gmail.com',
                'no_hp' => '+62 853-9759-7959',
            ],
            [
                'nama' => 'ABU BAKAR, S.E',
                'email' => 'abubakar84254@gmail.com',
                'no_hp' => '+62 853-4869-0844',
            ],
            [
                'nama' => 'HASRUDI, S.Sos',
                'email' => 'nuriftahul31@gmail.com',
                'no_hp' => '+62 813-4782-7202',
            ],
            [
                'nama' => 'SITTI SULEHA SYARIFUDDIN, S.Pd',
                'email' => 'sittisuleha17@gmail.com',
                'no_hp' => '+62 823-4821-6936',
            ],
            [
                'nama' => 'Gr. HASMAWATI, S.Pd',
                'email' => 'hasmawatiyamin@gmail.com',
                'no_hp' => '+62 831-2148-1167',
            ],
            [
                'nama' => 'MUHAMMAD MUQTADIR JAMALUDDIN, S.Ag',
                'email' => 'muqtadirmuhammad11@gmail.com',
                'no_hp' => '+62 823-5953-4979',
            ],
            [
                'nama' => 'ANUGRAH YUSUF ARISMAN, S.Pd.,M.Pd',
                'email' => 'anugrahyusuf238@gmail.com',
                'no_hp' => '+62 823-4534-1668',
            ],
            [
                'nama' => 'ANDI MULIA, S.Pd',
                'email' => 'andimulia2313@gmail.com',
                'no_hp' => '+62 812-4222-3428',
            ],
            [
                'nama' => 'MUH.SALIM FARHAN, B.A',
                'email' => 'salimfarhan0409@gmail.com',
                'no_hp' => '+967 777 658 361',
            ],
            [
                'nama' => 'NURFASURA, S.Pd',
                'email' => 'nurfasura47@gmail.com',
                'no_hp' => '+62 882-0195-42857',
            ],
            [
                'nama' => 'ARHAM AKRAMULLAH, S.Pd.,Gr',
                'email' => 'arhamakramullah22@gmail.com',
                'no_hp' => '+62 821-1133-3969',
            ],
            [
                'nama' => 'HASBUNIAR, S.Kom',
                'email' => 'hasbuniarbakri@gmail.com',
                'no_hp' => '+62 852-5555-9525',
            ],
            [
                'nama' => 'NUR SAFITRI, S.Pd.,Gr',
                'email' => 'nursafitri9906@gmail.com',
                'no_hp' => '+62 852-4270-9770',
            ],
            [
                'nama' => 'SINAR, S.Pd.,Gr',
                'email' => 'sinar120998@gmail.com',
                'no_hp' => '+62 822-9310-4626',
            ],
            [
                'nama' => 'VANI INDAH LESTARI',
                'email' => 'vaniindahlestari393@gmail.com',
                'no_hp' => '+62 823-4919-5755',
            ],
            [
                'nama' => 'WAHYUDI SYAMSUL, S.Pd',
                'email' => 'wahyudisyamsul29@gmail.com',
                'no_hp' => '+62 823-9432-0921',
            ],
            [
                'nama' => 'NUR HASYIKIN, S.Hum.,M.Hum',
                'email' => 'nhasyikin017@gmail.com',
                'no_hp' => '+62 823-4642-4024',
            ],
            [
                'nama' => 'ABDUL RAHMAT HADI',
                'email' => 'abdrahmathadi@gmail.com',
                'no_hp' => '+62 823-3711-8680',
            ],
        ];

        // Password hanya dipakai saat akun guru pertama kali dibuat.
        // Jalankan dengan SEED_GURU_PASSWORD di .env jika ingin mengganti default.
        $defaultPassword = env('SEED_GURU_PASSWORD', 'Guru@12345');

        foreach ($dataGuru as $data) {
            DB::transaction(function () use ($data, $defaultPassword) {
                $user = User::where('email', $data['email'])->first();

                if (! $user) {
                    $user = User::create([
                        'name' => $data['nama'],
                        'email' => $data['email'],
                        'password' => Hash::make($defaultPassword),
                        'role' => 'guru',
                        'no_hp' => $data['no_hp'],
                        'email_verified_at' => now(),
                    ]);
                } else {
                    // Update data profil tanpa mereset password yang sudah diganti guru.
                    $user->update([
                        'name' => $data['nama'],
                        'role' => 'guru',
                        'no_hp' => $data['no_hp'],
                    ]);
                }

                Guru::firstOrCreate([
                    'user_id' => $user->id,
                ]);
            });
        }

        $this->command?->info('GuruSeeder selesai: '.count($dataGuru).' guru diproses.');
    }
}