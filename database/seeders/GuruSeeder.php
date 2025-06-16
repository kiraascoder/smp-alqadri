<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Guru;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data guru dari Surat Keputusan
        $guruData = [
            [
                "NO" => 1,
                "NAMA" => "KAMIL, S.Pd",
                "NIP" => "766077667713062",
                "TERHITUNG_MULAI" => "11 Juli 2021",
                "JABATAN" => "GTY",
                "TUGAS" => "VII, VIII, IX",
                "MATA_PELAJARAN" => "Fiqih Aqidah Akhlak",
                "JAM" => 26
            ],
            [
                "NO" => 2,
                "NAMA" => "NUR ALIAH, S.Pd",
                "NIP" => "",
                "TERHITUNG_MULAI" => "13 Juli 2022",
                "JABATAN" => "GTY",
                "TUGAS" => "VII, VIII, IX VIII AKHWAT",
                "MATA_PELAJARAN" => "Matematika Prakarya Bahasa Indonesia",
                "JAM" => 26
            ],
            [
                "NO" => 3,
                "NAMA" => "MUAMMAR EKO SHIDIQ YUSUF, S.Pd",
                "NIP" => "",
                "TERHITUNG_MULAI" => "13 Juli 2022",
                "JABATAN" => "GTY",
                "TUGAS" => "VII, VIII, IX",
                "MATA_PELAJARAN" => "Bahasa Arab Sejarah Islam",
                "JAM" => 24
            ],
            [
                "NO" => 4,
                "NAMA" => "MUZAYYANAH, S.Pd",
                "NIP" => "",
                "TERHITUNG_MULAI" => "Januari 2023",
                "JABATAN" => "GTY",
                "TUGAS" => "VII AKHWAT, VIII AKHWAT, IX AKHWAT",
                "MATA_PELAJARAN" => "Tahfidzul Qur'an",
                "JAM" => 27
            ],
            [
                "NO" => 5,
                "NAMA" => "ABU BAKAR, S.E",
                "NIP" => "",
                "TERHITUNG_MULAI" => "Agustus 2023",
                "JABATAN" => "GTY",
                "TUGAS" => "VII IKHWAN, VIII IKHWAN, IX IKHWAN",
                "MATA_PELAJARAN" => "Tahfidzul Qur'an",
                "JAM" => 6
            ],
            [
                "NO" => 6,
                "NAMA" => "HASRUDI, S.Sos",
                "NIP" => "",
                "TERHITUNG_MULAI" => "30 September 2023",
                "JABATAN" => "GTY",
                "TUGAS" => "VII IKHWAN, VIII IKHWAN, IX IKHWAN",
                "MATA_PELAJARAN" => "Tahfidzul Qur'an Tahfidzul Do'a",
                "JAM" => 26
            ],
            [
                "NO" => 7,
                "NAMA" => "MUHAMMAD AL-QADRI",
                "NIP" => "",
                "TERHITUNG_MULAI" => "8 Juli 2024",
                "JABATAN" => "GTY",
                "TUGAS" => "VII, VIII, IX",
                "MATA_PELAJARAN" => "Hadits",
                "JAM" => 12
            ],
            [
                "NO" => 8,
                "NAMA" => "HASBIANI, S.Pd",
                "NIP" => "884176465521012",
                "TERHITUNG_MULAI" => "8 Juli 2024",
                "JABATAN" => "GTY",
                "TUGAS" => "VII, VIII AKHWAT",
                "MATA_PELAJARAN" => "PKN",
                "JAM" => 6
            ],
            [
                "NO" => 9,
                "NAMA" => "HASMAYANTI, S.Pd",
                "NIP" => "044577367423016",
                "TERHITUNG_MULAI" => "8 Juli 2024",
                "JABATAN" => "GTY",
                "TUGAS" => "VII, VIII, IX",
                "MATA_PELAJARAN" => "IPS",
                "JAM" => 12
            ],
            [
                "NO" => 10,
                "NAMA" => "MUH. MUQTADIR JAMALUDDIN, S.Ag",
                "NIP" => "",
                "TERHITUNG_MULAI" => "8 Juli 2024",
                "JABATAN" => "GTY",
                "TUGAS" => "VII, VIII, IX AKHWAT",
                "MATA_PELAJARAN" => "Qiraatul Qur'an",
                "JAM" => 20
            ],
            [
                "NO" => 11,
                "NAMA" => "SITTI SULEHA SYARIFUDDIN, S.Pd",
                "NIP" => "",
                "TERHITUNG_MULAI" => "8 Juli 2024",
                "JABATAN" => "GTY",
                "TUGAS" => "VII, VIII IKHWAN",
                "MATA_PELAJARAN" => "Bahasa Inggris Bahasa Indonesia",
                "JAM" => 18
            ],
            [
                "NO" => 12,
                "NAMA" => "JUMAIDAH, S.Pd",
                "NIP" => "SURNANTI",
                "TERHITUNG_MULAI" => "8 Juli 2024",
                "JABATAN" => "GTY",
                "TUGAS" => "VII, VIII, IX",
                "MATA_PELAJARAN" => "PKN",
                "JAM" => 6
            ],
            [
                "NO" => 13,
                "NAMA" => "SYARIFUDDIN, S.Pd",
                "NIP" => "674671672250302",
                "TERHITUNG_MULAI" => "8 Juli 2024",
                "JABATAN" => "GTY",
                "TUGAS" => "IX",
                "MATA_PELAJARAN" => "PAI",
                "JAM" => 4
            ],
            [
                "NO" => 14,
                "NAMA" => "R. NUGRAHA PRATAMA",
                "NIP" => "",
                "TERHITUNG_MULAI" => "8 Juli 2024",
                "JABATAN" => "GTY",
                "TUGAS" => "VII, VIII, IX",
                "MATA_PELAJARAN" => "Bimbingan Konseling",
                "JAM" => 12
            ],
            [
                "NO" => 15,
                "NAMA" => "ANUGRAH YUSUF ARISMAN, S.Pd",
                "NIP" => "",
                "TERHITUNG_MULAI" => "14 Oktober 2024",
                "JABATAN" => "GTY",
                "TUGAS" => "VII, VIII, IX",
                "MATA_PELAJARAN" => "IPA",
                "JAM" => 12
            ],
            [
                "NO" => 16,
                "NAMA" => "HABUNIAR, S.Kom",
                "NIP" => "",
                "TERHITUNG_MULAI" => "6 Januari 2025",
                "JABATAN" => "GTY",
                "TUGAS" => "VII, IX AKHWAT IX IKHWAN",
                "MATA_PELAJARAN" => "PJOK QIRAATUL QUR'AN",
                "JAM" => 10
            ],
            [
                "NO" => 17,
                "NAMA" => "WAHYUDI, S.Pd",
                "NIP" => "",
                "TERHITUNG_MULAI" => "6 Januari 2025",
                "JABATAN" => "GTY",
                "TUGAS" => "VIII, IX IKHWAN",
                "MATA_PELAJARAN" => "PJOK",
                "JAM" => 6
            ]
        ];

        foreach ($guruData as $data) {

            if (User::where('name', $data['NAMA'])->where('role', 'guru')->exists()) {
                $this->command->info("Guru {$data['NAMA']} sudah ada, dilewati.");
                continue;
            }

            try {

                $email = $this->generateEmail($data['NAMA'], $data['NIP']);


                $defaultPassword = 'guru123' . str_pad($data['NO'], 2, '0', STR_PAD_LEFT);

                // Buat user guru
                $user = User::create([
                    'name' => $data['NAMA'],
                    'email' => $email,
                    'password' => Hash::make($defaultPassword),
                    'role' => 'guru',
                    'email_verified_at' => now(), // Auto verify
                ]);

                // Buat data guru
                Guru::create([
                    'user_id' => $user->id,
                ]);

                $this->command->info("✓ Berhasil membuat akun guru: {$data['NAMA']}");
            } catch (\Exception $e) {
                $this->command->error("✗ Gagal membuat akun guru: {$data['NAMA']} - {$e->getMessage()}");
            }
        }

        $this->command->info("\n📊 Seeder Guru selesai dijalankan!");
        $this->command->info("📧 Email format: nama.guru@smpqadri.edu");
        $this->command->info("🔑 Password default: guru123 + nomor urut (contoh: guru12301)");
        $this->command->info("👥 Total guru: " . count($guruData));
        $this->command->line('');
        $this->command->info('🔐 Contoh login guru:');
        $this->command->info('   Email: kamil.guru@smpqadri.edu');
        $this->command->info('   Password: guru12301');
    }

    /**
     * Generate email berdasarkan nama guru
     */
    private function generateEmail($nama, $nip = '')
    {
        // Bersihkan nama dari gelar dan karakter khusus
        $cleanName = preg_replace('/,\s*S\.\w+/', '', $nama); // Hapus gelar
        $cleanName = Str::slug(strtolower($cleanName), '.');

        // Generate email dengan format nama.guru@smpqadri.edu
        $baseEmail = $cleanName . '.guru@smpqadri.edu';

        // Cek apakah email sudah ada
        $counter = 1;
        $email = $baseEmail;

        while (User::where('email', $email)->exists()) {
            $email = $cleanName . '.guru.' . $counter . '@smpqadri.edu';
            $counter++;
        }

        return $email;
    }
}
