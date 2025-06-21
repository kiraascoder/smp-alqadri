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
        // Data guru dari Surat Keputusan dengan identifikasi gender
        $guruData = [
            [
                "NO" => 1,
                "NAMA" => "KAMIL, S.Pd",
                "JK" => "L",
                "MATA_PELAJARAN" => "Fiqih Aqidah Akhlak",
            ],
            [
                "NO" => 2,
                "NAMA" => "NUR ALIAH, S.Pd",
                "JK" => "P",
                "MATA_PELAJARAN" => "Matematika Prakarya Bahasa Indonesia",
            ],
            [
                "NO" => 3,
                "NAMA" => "MUAMMAR EKO SHIDIQ YUSUF, S.Pd",
                "JK" => "L",
                "MATA_PELAJARAN" => "Bahasa Arab Sejarah Islam",
            ],
            [
                "NO" => 4,
                "NAMA" => "MUZAYYANAH, S.Pd",
                "JK" => "P",
                "MATA_PELAJARAN" => "Tahfidzul Qur'an",
            ],
            [
                "NO" => 5,
                "NAMA" => "ABU BAKAR, S.E",
                "JK" => "L",
                "MATA_PELAJARAN" => "Tahfidzul Qur'an",
            ],
            [
                "NO" => 6,
                "NAMA" => "HASRUDI, S.Sos",
                "JK" => "L",
                "MATA_PELAJARAN" => "Tahfidzul Qur'an Tahfidzul Do'a",
            ],
            [
                "NO" => 7,
                "NAMA" => "MUHAMMAD AL-QADRI",
                "JK" => "L",
                "MATA_PELAJARAN" => "Hadits",
            ],
            [
                "NO" => 8,
                "NAMA" => "HASBIANI, S.Pd",
                "JK" => "P",
                "MATA_PELAJARAN" => "PKN",
            ],
            [
                "NO" => 9,
                "NAMA" => "HASMAYANTI, S.Pd",
                "JK" => "P",
                "MATA_PELAJARAN" => "IPS",
            ],
            [
                "NO" => 10,
                "NAMA" => "MUH. MUQTADIR JAMALUDDIN, S.Ag",
                "JK" => "L",
                "MATA_PELAJARAN" => "Qiraatul Qur'an",
            ],
            [
                "NO" => 11,
                "NAMA" => "SITTI SULEHA SYARIFUDDIN, S.Pd",
                "JK" => "P",
                "MATA_PELAJARAN" => "Bahasa Inggris Bahasa Indonesia",
            ],
            [
                "NO" => 12,
                "NAMA" => "JUMAIDAH, S.Pd",
                "JK" => "P",
                "MATA_PELAJARAN" => "PKN",
            ],
            [
                "NO" => 13,
                "NAMA" => "SYARIFUDDIN, S.Pd",
                "JK" => "L",
                "MATA_PELAJARAN" => "PAI",
            ],
            [
                "NO" => 14,
                "NAMA" => "R. NUGRAHA PRATAMA",
                "JK" => "L",
                "MATA_PELAJARAN" => "Bimbingan Konseling",
            ],
            [
                "NO" => 15,
                "NAMA" => "ANUGRAH YUSUF ARISMAN, S.Pd",
                "JK" => "L",
                "MATA_PELAJARAN" => "IPA",
            ],
            [
                "NO" => 16,
                "NAMA" => "HABUNIAR, S.Kom",
                "JK" => "L",
                "MATA_PELAJARAN" => "PJOK QIRAATUL QUR'AN",
            ],
            [
                "NO" => 17,
                "NAMA" => "WAHYUDI, S.Pd",
                "JK" => "L",
                "MATA_PELAJARAN" => "PJOK",
            ]
        ];

        $this->command->info("🚀 Memulai proses seeding data guru...\n");

        // Counters untuk statistik
        $berhasil = 0;
        $dilewati = 0;
        $gagal = 0;
        $lakiLaki = 0;
        $perempuan = 0;

        // Progress tracking
        $total = count($guruData);
        $processed = 0;

        $this->command->info("👩‍🏫 Memproses data guru...\n");

        foreach ($guruData as $data) {
            $processed++;
            $progress = round(($processed / $total) * 100);

            // Skip jika guru sudah ada
            if (User::where('name', $data['NAMA'])->where('role', 'guru')->exists()) {
                $this->command->warn("[{$progress}%] ⚠️  Guru {$data['NAMA']} sudah ada, dilewati.");
                $dilewati++;
                continue;
            }

            try {
                // Generate email berdasarkan nama guru
                $email = $this->generateEmail($data['NAMA']);

                // Password default: guru123 + nomor urut (2 digit)
                $defaultPassword = 'guru123' . str_pad($data['NO'], 2, '0', STR_PAD_LEFT);

                // Konversi jenis kelamin
                $jenisKelamin = $data['JK'] === 'L' ? 'Laki-laki' : 'Perempuan';

                // Buat user guru dengan jenis kelamin
                $user = User::create([
                    'name' => $data['NAMA'],
                    'email' => $email,
                    'password' => Hash::make($defaultPassword),
                    'role' => 'guru',
                    'jenis_kelamin' => $jenisKelamin,
                    'email_verified_at' => now(), // Auto verify
                ]);

                // Buat data guru hanya dengan user_id
                Guru::create([
                    'user_id' => $user->id,
                ]);

                // Update counters
                $berhasil++;
                if ($data['JK'] === 'L') {
                    $lakiLaki++;
                } else {
                    $perempuan++;
                }

                $gender = $data['JK'] === 'L' ? '👨‍🏫' : '👩‍🏫';
                $mapel = strlen($data['MATA_PELAJARAN']) > 30 ? substr($data['MATA_PELAJARAN'], 0, 30) . '...' : $data['MATA_PELAJARAN'];

                $this->command->info("[{$progress}%] ✓ {$gender} {$data['NAMA']} ({$jenisKelamin}, {$mapel})");
            } catch (\Exception $e) {
                $gagal++;
                $this->command->error("[{$progress}%] ✗ Gagal membuat akun guru: {$data['NAMA']} - {$e->getMessage()}");
            }
        }

        // Tampilkan statistik final
        $this->command->info("\n" . str_repeat("=", 80));
        $this->command->info("👩‍🏫 RINGKASAN SEEDER GURU");
        $this->command->info(str_repeat("=", 80));

        $this->command->info("📈 Statistik Proses:");
        $this->command->info("  ✅ Berhasil dibuat    : {$berhasil} guru");
        $this->command->info("  ⚠️  Dilewati (sudah ada): {$dilewati} guru");
        $this->command->info("  ❌ Gagal            : {$gagal} guru");
        $this->command->info("  📝 Total data       : " . count($guruData) . " guru");

        $this->command->info("\n👥 Statistik Gender:");
        $this->command->info("  👨‍🏫 Laki-laki       : {$lakiLaki} guru (" . round(($lakiLaki / max($berhasil, 1)) * 100, 1) . "%)");
        $this->command->info("  👩‍🏫 Perempuan       : {$perempuan} guru (" . round(($perempuan / max($berhasil, 1)) * 100, 1) . "%)");

        $this->command->info("\n📚 Mata Pelajaran:");
        $mataPelajaran = collect($guruData)->groupBy('MATA_PELAJARAN')->map->count()->sortDesc();
        foreach ($mataPelajaran->take(5) as $mapel => $count) {
            $mapelShort = strlen($mapel) > 40 ? substr($mapel, 0, 40) . '...' : $mapel;
            $this->command->info("  📖 {$mapelShort}: {$count} guru");
        }

        $this->command->info("\n🔐 Informasi Login:");
        $this->command->info("  📧 Format Email     : nama.guru@smpqadri.edu");
        $this->command->info("  🔑 Format Password  : guru123 + nomor urut (2 digit)");
        $this->command->info("  📝 Contoh Login     :");
        $this->command->info("     Email    : kamil.guru@smpqadri.edu");
        $this->command->info("     Password : guru12301");

        $this->command->info("\n🎯 Fitur yang Tersedia:");
        $this->command->info("  ✅ Akun sudah terverifikasi otomatis");
        $this->command->info("  ✅ Data jenis kelamin sudah diset");
        $this->command->info("  ✅ Role guru sudah diset");

        // Informasi khusus guru BK
        $guruBK = collect($guruData)->where('MATA_PELAJARAN', 'Bimbingan Konseling');
        if ($guruBK->isNotEmpty()) {
            $this->command->info("\n🎓 Informasi Guru BK:");
            foreach ($guruBK as $bk) {
                $this->command->info("  👨‍🎓 {$bk['NAMA']} - Bimbingan Konseling");
            }
        }

        if ($berhasil > 0) {
            $this->command->info("\n🎉 Seeder berhasil dijalankan!");
            $this->command->info("🚀 Guru dapat langsung login menggunakan email dan password yang telah dibuat.");
        } else {
            $this->command->warn("\n⚠️  Tidak ada guru baru yang dibuat. Semua data sudah ada atau terjadi error.");
        }

        if ($gagal > 0) {
            $this->command->error("\n❗ Terdapat {$gagal} guru yang gagal dibuat. Periksa log error di atas.");
        }

        $this->command->info("\n" . str_repeat("=", 80));
    }

    /**
     * Generate email berdasarkan nama guru
     */
    private function generateEmail($nama)
    {
        // Bersihkan nama dari gelar dan karakter khusus
        $cleanName = preg_replace('/,\s*S\.\w+/', '', $nama); // Hapus gelar
        $cleanName = preg_replace('/[^a-zA-Z\s]/', '', $cleanName); // Hapus karakter selain huruf dan spasi
        $cleanName = trim($cleanName);
        $cleanName = Str::slug(strtolower($cleanName), '.');

        // Jika nama terlalu panjang, ambil 2 kata pertama
        $nameParts = explode('.', $cleanName);
        if (count($nameParts) > 2) {
            $cleanName = implode('.', array_slice($nameParts, 0, 2));
        }

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
