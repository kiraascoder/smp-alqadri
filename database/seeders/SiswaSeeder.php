<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data siswa lengkap dari Excel
        $siswaData = [
            // KELAS 7
            ["NO" => 1, "NAMA" => "AHMAD FATWAL", "JK" => "L", "NISN" => "0128925508", "ROMBEL" => "Kelas 7"],
            ["NO" => 2, "NAMA" => "AHMAD SYAFAR", "JK" => "L", "NISN" => "3122185991", "ROMBEL" => "Kelas 7"],
            ["NO" => 3, "NAMA" => "AISYAH AQILAH", "JK" => "P", "NISN" => "0129568755", "ROMBEL" => "Kelas 7"],
            ["NO" => 4, "NAMA" => "ANDI ALI ZAINAL ABIDIN", "JK" => "L", "NISN" => "0129248846", "ROMBEL" => "Kelas 7"],
            ["NO" => 5, "NAMA" => "Andi Aqsa Nur Ahmad", "JK" => "L", "NISN" => "0123600580", "ROMBEL" => "Kelas 7"],
            ["NO" => 6, "NAMA" => "ANDI FAHREZA REZQULLAH", "JK" => "L", "NISN" => "0129734646", "ROMBEL" => "Kelas 7"],
            ["NO" => 7, "NAMA" => "ANDI NURUL HIKMAH MAESA", "JK" => "P", "NISN" => "0124425950", "ROMBEL" => "Kelas 7"],
            ["NO" => 8, "NAMA" => "ARIEF RAHMAN", "JK" => "L", "NISN" => "0121539871", "ROMBEL" => "Kelas 7"],
            ["NO" => 9, "NAMA" => "ARYA ADHINATA", "JK" => "L", "NISN" => "0123629489", "ROMBEL" => "Kelas 7"],
            ["NO" => 10, "NAMA" => "ARZITA", "JK" => "P", "NISN" => "0129703779", "ROMBEL" => "Kelas 7"],
            ["NO" => 11, "NAMA" => "AULIA NAJWA", "JK" => "P", "NISN" => "0122698374", "ROMBEL" => "Kelas 7"],
            ["NO" => 12, "NAMA" => "FADHILLAH BIMA RAHMAN", "JK" => "L", "NISN" => "0124425951", "ROMBEL" => "Kelas 7"],
            ["NO" => 13, "NAMA" => "FAHRIZAL ADITYA", "JK" => "L", "NISN" => "0129734647", "ROMBEL" => "Kelas 7"],
            ["NO" => 14, "NAMA" => "FEBRIANSYAH", "JK" => "L", "NISN" => "0129703781", "ROMBEL" => "Kelas 7"],
            ["NO" => 15, "NAMA" => "FIRA TIARA SARI", "JK" => "P", "NISN" => "0129703784", "ROMBEL" => "Kelas 7"],
            ["NO" => 16, "NAMA" => "HADIR", "JK" => "L", "NISN" => "0123629491", "ROMBEL" => "Kelas 7"],
            ["NO" => 17, "NAMA" => "HUMAIRAH AZZAHRA", "JK" => "P", "NISN" => "0124425953", "ROMBEL" => "Kelas 7"],
            ["NO" => 18, "NAMA" => "ISMAIL", "JK" => "L", "NISN" => "0129703787", "ROMBEL" => "Kelas 7"],
            ["NO" => 19, "NAMA" => "Mardiyah", "JK" => "P", "NISN" => "0121539874", "ROMBEL" => "Kelas 7"],
            ["NO" => 20, "NAMA" => "MAULANA MALIK IBRAHIM", "JK" => "L", "NISN" => "0123629493", "ROMBEL" => "Kelas 7"],
            ["NO" => 21, "NAMA" => "MIFTAHUL JANNAH", "JK" => "P", "NISN" => "0129734650", "ROMBEL" => "Kelas 7"],
            ["NO" => 22, "NAMA" => "MUH. ARWIN NATSIR", "JK" => "L", "NISN" => "0121539875", "ROMBEL" => "Kelas 7"],
            ["NO" => 23, "NAMA" => "MUH. RIFALDO", "JK" => "L", "NISN" => "0123629494", "ROMBEL" => "Kelas 7"],
            ["NO" => 24, "NAMA" => "MUH. SULTAN HASANUDIN", "JK" => "L", "NISN" => "0129703790", "ROMBEL" => "Kelas 7"],
            ["NO" => 25, "NAMA" => "MUHAMMAD FAJAR", "JK" => "L", "NISN" => "0121539876", "ROMBEL" => "Kelas 7"],
            ["NO" => 26, "NAMA" => "MUHAMMAD FARID RIDHO", "JK" => "L", "NISN" => "0123629495", "ROMBEL" => "Kelas 7"],
            ["NO" => 27, "NAMA" => "MUHAMMAD RAFLI", "JK" => "L", "NISN" => "0129703791", "ROMBEL" => "Kelas 7"],
            ["NO" => 28, "NAMA" => "NADHIFAH AULIA ZAHRA", "JK" => "P", "NISN" => "0124425955", "ROMBEL" => "Kelas 7"],
            ["NO" => 29, "NAMA" => "NAILA HUSNA", "JK" => "P", "NISN" => "0129703793", "ROMBEL" => "Kelas 7"],
            ["NO" => 30, "NAMA" => "NAZWA NURUL AISYAH", "JK" => "P", "NISN" => "0129734651", "ROMBEL" => "Kelas 7"],
            ["NO" => 31, "NAMA" => "NUNUNG FATIMAH", "JK" => "P", "NISN" => "0129703794", "ROMBEL" => "Kelas 7"],
            ["NO" => 32, "NAMA" => "NURAZIZAH", "JK" => "P", "NISN" => "0129734652", "ROMBEL" => "Kelas 7"],
            ["NO" => 33, "NAMA" => "PUTRA HARIANSYAH", "JK" => "L", "NISN" => "0123629496", "ROMBEL" => "Kelas 7"],
            ["NO" => 34, "NAMA" => "RAHMAT HIDAYAT", "JK" => "L", "NISN" => "0129703796", "ROMBEL" => "Kelas 7"],
            ["NO" => 35, "NAMA" => "RIDHA AULIA RAHMAH", "JK" => "P", "NISN" => "0124425956", "ROMBEL" => "Kelas 7"],
            ["NO" => 36, "NAMA" => "RISKI AULIA AZHAR", "JK" => "L", "NISN" => "0129734653", "ROMBEL" => "Kelas 7"],
            ["NO" => 37, "NAMA" => "SALMA", "JK" => "P", "NISN" => "0123629497", "ROMBEL" => "Kelas 7"],
            ["NO" => 38, "NAMA" => "WINDA AULIA", "JK" => "P", "NISN" => "0129703797", "ROMBEL" => "Kelas 7"],

            // KELAS 8
            ["NO" => 39, "NAMA" => "A. ILHAM SAID", "JK" => "L", "NISN" => "0115563993", "ROMBEL" => "Kelas 8"],
            ["NO" => 40, "NAMA" => "ADINDA CHALISHAH RAMADHANI", "JK" => "P", "NISN" => "0115563994", "ROMBEL" => "Kelas 8"],
            ["NO" => 41, "NAMA" => "AGUSTINA", "JK" => "P", "NISN" => "0118634325", "ROMBEL" => "Kelas 8"],
            ["NO" => 42, "NAMA" => "AHMAD FAIQ", "JK" => "L", "NISN" => "0118634326", "ROMBEL" => "Kelas 8"],
            ["NO" => 43, "NAMA" => "AISYAH NUR FADILLAH", "JK" => "P", "NISN" => "0115563996", "ROMBEL" => "Kelas 8"],
            ["NO" => 44, "NAMA" => "ANDI ARFAN", "JK" => "L", "NISN" => "0118634327", "ROMBEL" => "Kelas 8"],
            ["NO" => 45, "NAMA" => "ANDI FAHRUNNISA", "JK" => "P", "NISN" => "0118634328", "ROMBEL" => "Kelas 8"],
            ["NO" => 46, "NAMA" => "ANDI FADILLAH", "JK" => "L", "NISN" => "0115563998", "ROMBEL" => "Kelas 8"],
            ["NO" => 47, "NAMA" => "ANDI NURUL IZZAH", "JK" => "P", "NISN" => "0115563999", "ROMBEL" => "Kelas 8"],
            ["NO" => 48, "NAMA" => "ANDI RISKA AMELIA", "JK" => "P", "NISN" => "0118634329", "ROMBEL" => "Kelas 8"],
            ["NO" => 49, "NAMA" => "ANNISA FEBRIANA", "JK" => "P", "NISN" => "0118634330", "ROMBEL" => "Kelas 8"],
            ["NO" => 50, "NAMA" => "ARDIANSYAH", "JK" => "L", "NISN" => "0115564000", "ROMBEL" => "Kelas 8"],
            ["NO" => 51, "NAMA" => "AZZAHRA YASMIN", "JK" => "P", "NISN" => "0118634331", "ROMBEL" => "Kelas 8"],
            ["NO" => 52, "NAMA" => "DESTA MAHARANI", "JK" => "P", "NISN" => "0115564001", "ROMBEL" => "Kelas 8"],
            ["NO" => 53, "NAMA" => "FADHIL AZZIKRA", "JK" => "L", "NISN" => "0118634332", "ROMBEL" => "Kelas 8"],
            ["NO" => 54, "NAMA" => "FAREL PRATAMA", "JK" => "L", "NISN" => "0115564002", "ROMBEL" => "Kelas 8"],
            ["NO" => 55, "NAMA" => "HASMAR", "JK" => "L", "NISN" => "0118634333", "ROMBEL" => "Kelas 8"],
            ["NO" => 56, "NAMA" => "M. ZHAFRAN MAULANA", "JK" => "L", "NISN" => "0115564003", "ROMBEL" => "Kelas 8"],
            ["NO" => 57, "NAMA" => "MAUDY SYAHARANI", "JK" => "P", "NISN" => "0115564004", "ROMBEL" => "Kelas 8"],
            ["NO" => 58, "NAMA" => "MUH. AHSAN", "JK" => "L", "NISN" => "0118634334", "ROMBEL" => "Kelas 8"],
            ["NO" => 59, "NAMA" => "MUH. ALIF", "JK" => "L", "NISN" => "0115564005", "ROMBEL" => "Kelas 8"],
            ["NO" => 60, "NAMA" => "MUH. ANUGRAH PRATAMA", "JK" => "L", "NISN" => "0115564006", "ROMBEL" => "Kelas 8"],
            ["NO" => 61, "NAMA" => "MUH. FAISAL", "JK" => "L", "NISN" => "0118634335", "ROMBEL" => "Kelas 8"],
            ["NO" => 62, "NAMA" => "MUH. FATUR", "JK" => "L", "NISN" => "0118634336", "ROMBEL" => "Kelas 8"],
            ["NO" => 63, "NAMA" => "MUH. RIVAL", "JK" => "L", "NISN" => "0115564007", "ROMBEL" => "Kelas 8"],
            ["NO" => 64, "NAMA" => "MUHAMMAD AKMAL", "JK" => "L", "NISN" => "0118634337", "ROMBEL" => "Kelas 8"],
            ["NO" => 65, "NAMA" => "MUHAMMAD ALFAREZI", "JK" => "L", "NISN" => "0115564008", "ROMBEL" => "Kelas 8"],
            ["NO" => 66, "NAMA" => "MUHAMMAD FAHRIL", "JK" => "L", "NISN" => "0118634338", "ROMBEL" => "Kelas 8"],
            ["NO" => 67, "NAMA" => "MUHAMMAD RIDWAN", "JK" => "L", "NISN" => "0115564009", "ROMBEL" => "Kelas 8"],
            ["NO" => 68, "NAMA" => "NURAFNI", "JK" => "P", "NISN" => "0118634339", "ROMBEL" => "Kelas 8"],
            ["NO" => 69, "NAMA" => "NURUL INAYAH", "JK" => "P", "NISN" => "0115564010", "ROMBEL" => "Kelas 8"],
            ["NO" => 70, "NAMA" => "NURUL JIHAN", "JK" => "P", "NISN" => "0115564011", "ROMBEL" => "Kelas 8"],
            ["NO" => 71, "NAMA" => "NURUL KHARISMA", "JK" => "P", "NISN" => "0118634340", "ROMBEL" => "Kelas 8"],
            ["NO" => 72, "NAMA" => "RENDY", "JK" => "L", "NISN" => "0115564012", "ROMBEL" => "Kelas 8"],
            ["NO" => 73, "NAMA" => "RESKI AMALIA", "JK" => "P", "NISN" => "0118634341", "ROMBEL" => "Kelas 8"],
            ["NO" => 74, "NAMA" => "SYAFIRAH", "JK" => "P", "NISN" => "0115564013", "ROMBEL" => "Kelas 8"],
            ["NO" => 75, "NAMA" => "SYFIKAH KHAERANI", "JK" => "P", "NISN" => "0115564014", "ROMBEL" => "Kelas 8"],
            ["NO" => 76, "NAMA" => "YUSRIL", "JK" => "L", "NISN" => "0118634342", "ROMBEL" => "Kelas 8"],

            // KELAS 9
            ["NO" => 77, "NAMA" => "A. ANNUR ROBBANI", "JK" => "L", "NISN" => "0106659533", "ROMBEL" => "Kelas 9"],
            ["NO" => 78, "NAMA" => "A. MUH. ALIF ATHALLAH", "JK" => "L", "NISN" => "0103943334", "ROMBEL" => "Kelas 9"],
            ["NO" => 79, "NAMA" => "ANDI ALYSA FADHILLAH", "JK" => "P", "NISN" => "0103943335", "ROMBEL" => "Kelas 9"],
            ["NO" => 80, "NAMA" => "ANDI INDIRA MAHARANI", "JK" => "P", "NISN" => "0106659534", "ROMBEL" => "Kelas 9"],
            ["NO" => 81, "NAMA" => "ANDI NURUL ZAHRA", "JK" => "P", "NISN" => "0103943336", "ROMBEL" => "Kelas 9"],
            ["NO" => 82, "NAMA" => "ANDI RESHA RAMADHAN", "JK" => "L", "NISN" => "0106659535", "ROMBEL" => "Kelas 9"],
            ["NO" => 83, "NAMA" => "ANISA NUR QADRY", "JK" => "P", "NISN" => "0103943337", "ROMBEL" => "Kelas 9"],
            ["NO" => 84, "NAMA" => "FADLY ANWAR", "JK" => "L", "NISN" => "0106659536", "ROMBEL" => "Kelas 9"],
            ["NO" => 85, "NAMA" => "FAIZ AHMAD", "JK" => "L", "NISN" => "0103943338", "ROMBEL" => "Kelas 9"],
            ["NO" => 86, "NAMA" => "FAREL RAMADHAN", "JK" => "L", "NISN" => "0106659537", "ROMBEL" => "Kelas 9"],
            ["NO" => 87, "NAMA" => "FEBRY RAMADHAN", "JK" => "L", "NISN" => "0103943339", "ROMBEL" => "Kelas 9"],
            ["NO" => 88, "NAMA" => "FERA RAMADANI", "JK" => "P", "NISN" => "0106659538", "ROMBEL" => "Kelas 9"],
            ["NO" => 89, "NAMA" => "HABIBI", "JK" => "L", "NISN" => "0103943340", "ROMBEL" => "Kelas 9"],
            ["NO" => 90, "NAMA" => "HASRI", "JK" => "L", "NISN" => "0103943341", "ROMBEL" => "Kelas 9"],
            ["NO" => 91, "NAMA" => "ILHAM PRATAMA", "JK" => "L", "NISN" => "0106659539", "ROMBEL" => "Kelas 9"],
            ["NO" => 92, "NAMA" => "MARWAH", "JK" => "P", "NISN" => "0103943342", "ROMBEL" => "Kelas 9"],
            ["NO" => 93, "NAMA" => "MUH. ARFAN", "JK" => "L", "NISN" => "0106659540", "ROMBEL" => "Kelas 9"],
            ["NO" => 94, "NAMA" => "MUH. ARSHAD", "JK" => "L", "NISN" => "0103943343", "ROMBEL" => "Kelas 9"],
            ["NO" => 95, "NAMA" => "MUH. ICHSAN", "JK" => "L", "NISN" => "0106659541", "ROMBEL" => "Kelas 9"],
            ["NO" => 96, "NAMA" => "MUH. RIFKI", "JK" => "L", "NISN" => "0103943344", "ROMBEL" => "Kelas 9"],
            ["NO" => 97, "NAMA" => "MUHAMMAD ARHAM", "JK" => "L", "NISN" => "0106659542", "ROMBEL" => "Kelas 9"],
            ["NO" => 98, "NAMA" => "MUHAMMAD FATHUR RAHMAN", "JK" => "L", "NISN" => "0103943345", "ROMBEL" => "Kelas 9"],
            ["NO" => 99, "NAMA" => "MUHAMMAD HAFIDZ", "JK" => "L", "NISN" => "0106659543", "ROMBEL" => "Kelas 9"],
            ["NO" => 100, "NAMA" => "MUHAMMAD IRFAN", "JK" => "L", "NISN" => "0106659544", "ROMBEL" => "Kelas 9"],
            ["NO" => 101, "NAMA" => "NABILA AISYAH", "JK" => "P", "NISN" => "0103943346", "ROMBEL" => "Kelas 9"],
            ["NO" => 102, "NAMA" => "NAIDAH AULIA", "JK" => "P", "NISN" => "0106659545", "ROMBEL" => "Kelas 9"],
            ["NO" => 103, "NAMA" => "NOVIANTI", "JK" => "P", "NISN" => "0103943347", "ROMBEL" => "Kelas 9"],
            ["NO" => 104, "NAMA" => "NUR ANNISA", "JK" => "P", "NISN" => "0106659546", "ROMBEL" => "Kelas 9"],
            ["NO" => 105, "NAMA" => "NUR AZIZAH", "JK" => "P", "NISN" => "0103943348", "ROMBEL" => "Kelas 9"],
            ["NO" => 106, "NAMA" => "NURHIDAYAH", "JK" => "P", "NISN" => "0106659547", "ROMBEL" => "Kelas 9"],
            ["NO" => 107, "NAMA" => "NURJANNAH", "JK" => "P", "NISN" => "0103943349", "ROMBEL" => "Kelas 9"],
            ["NO" => 108, "NAMA" => "NURUL AZMI", "JK" => "P", "NISN" => "0106659548", "ROMBEL" => "Kelas 9"],
            ["NO" => 109, "NAMA" => "PUTRI WULANDARI", "JK" => "P", "NISN" => "0103943350", "ROMBEL" => "Kelas 9"],
            ["NO" => 110, "NAMA" => "RAFIKA", "JK" => "P", "NISN" => "0106659549", "ROMBEL" => "Kelas 9"],
            ["NO" => 111, "NAMA" => "RATNA", "JK" => "P", "NISN" => "0103943351", "ROMBEL" => "Kelas 9"],
            ["NO" => 112, "NAMA" => "SAHRUL", "JK" => "L", "NISN" => "0106659550", "ROMBEL" => "Kelas 9"],
            ["NO" => 113, "NAMA" => "SERLY", "JK" => "P", "NISN" => "0103943352", "ROMBEL" => "Kelas 9"],
            ["NO" => 114, "NAMA" => "ZIHAN NURKAMALIAH", "JK" => "P", "NISN" => "0106659551", "ROMBEL" => "Kelas 9"]
        ];

        $this->command->info("🚀 Memulai proses seeding data siswa...\n");

        // Pastikan data kelas sudah ada terlebih dahulu
        $this->command->info("📚 Menyiapkan data kelas...");
        $kelas7 = Kelas::firstOrCreate(['nama_kelas' => 'Kelas 7']);
        $kelas8 = Kelas::firstOrCreate(['nama_kelas' => 'Kelas 8']);
        $kelas9 = Kelas::firstOrCreate(['nama_kelas' => 'Kelas 9']);

        $this->command->info("✓ Kelas berhasil disiapkan");
        $this->command->info("  - {$kelas7->nama_kelas} (ID: {$kelas7->id})");
        $this->command->info("  - {$kelas8->nama_kelas} (ID: {$kelas8->id})");
        $this->command->info("  - {$kelas9->nama_kelas} (ID: {$kelas9->id})\n");

        // Map kelas
        $kelasMap = [
            'Kelas 7' => $kelas7->id,
            'Kelas 8' => $kelas8->id,
            'Kelas 9' => $kelas9->id,
        ];

        // Counters untuk statistik
        $berhasil = 0;
        $dilewati = 0;
        $gagal = 0;
        $lakiLaki = 0;
        $perempuan = 0;

        $this->command->info("👥 Memproses data siswa...\n");

        // Progress bar sederhana
        $total = count($siswaData);
        $processed = 0;

        // Buat akun untuk setiap siswa
        foreach ($siswaData as $data) {
            $processed++;
            $progress = round(($processed / $total) * 100);

            // Skip jika NISN sudah ada
            if (User::whereHas('siswa', function ($query) use ($data) {
                $query->where('nisn', $data['NISN']);
            })->exists()) {
                $this->command->warn("[{$progress}%] ⚠️  Siswa dengan NISN {$data['NISN']} sudah ada, dilewati.");
                $dilewati++;
                continue;
            }

            try {
                // Generate email berdasarkan nama dan NISN
                $email = $this->generateEmail($data['NAMA'], $data['NISN']);

                // Password default: nisn123
                $defaultPassword = $data['NISN'] . '123';

                // Konversi jenis kelamin
                $jenisKelamin = $data['JK'] === 'L' ? 'Laki-laki' : 'Perempuan';

                // Buat user dengan jenis kelamin
                $user = User::create([
                    'name' => $data['NAMA'],
                    'email' => $email,
                    'password' => Hash::make($defaultPassword),
                    'role' => 'siswa',
                    'jenis_kelamin' => $jenisKelamin,
                    'email_verified_at' => now(), // Auto verify
                ]);

                // Buat data siswa
                Siswa::create([
                    'user_id' => $user->id,
                    'nisn' => $data['NISN'],
                    'kelas_id' => $kelasMap[$data['ROMBEL']],
                    'score_bk' => 0, // Default score BK
                ]);

                // Update counters
                $berhasil++;
                if ($data['JK'] === 'L') {
                    $lakiLaki++;
                } else {
                    $perempuan++;
                }

                $gender = $data['JK'] === 'L' ? '👨‍🎓' : '👩‍🎓';
                $this->command->info("[{$progress}%] ✓ {$gender} {$data['NAMA']} ({$jenisKelamin}, {$data['ROMBEL']}, NISN: {$data['NISN']})");
            } catch (\Exception $e) {
                $gagal++;
                $this->command->error("[{$progress}%] ✗ Gagal membuat akun untuk: {$data['NAMA']} - {$e->getMessage()}");
            }
        }

        // Tampilkan statistik final
        $this->command->info("\n" . str_repeat("=", 80));
        $this->command->info("📊 RINGKASAN SEEDER SISWA");
        $this->command->info(str_repeat("=", 80));

        $this->command->info("📈 Statistik Proses:");
        $this->command->info("  ✅ Berhasil dibuat    : {$berhasil} siswa");
        $this->command->info("  ⚠️  Dilewati (sudah ada): {$dilewati} siswa");
        $this->command->info("  ❌ Gagal            : {$gagal} siswa");
        $this->command->info("  📝 Total data       : " . count($siswaData) . " siswa");

        $this->command->info("\n👥 Statistik Gender:");
        $this->command->info("  👨‍🎓 Laki-laki       : {$lakiLaki} siswa (" . round(($lakiLaki / max($berhasil, 1)) * 100, 1) . "%)");
        $this->command->info("  👩‍🎓 Perempuan       : {$perempuan} siswa (" . round(($perempuan / max($berhasil, 1)) * 100, 1) . "%)");

        $this->command->info("\n🏫 Distribusi Per Kelas:");
        $kelas7Count = collect($siswaData)->where('ROMBEL', 'Kelas 7')->count();
        $kelas8Count = collect($siswaData)->where('ROMBEL', 'Kelas 8')->count();
        $kelas9Count = collect($siswaData)->where('ROMBEL', 'Kelas 9')->count();

        $this->command->info("  📚 Kelas 7          : {$kelas7Count} siswa");
        $this->command->info("  📚 Kelas 8          : {$kelas8Count} siswa");
        $this->command->info("  📚 Kelas 9          : {$kelas9Count} siswa");

        $this->command->info("\n🔐 Informasi Login:");
        $this->command->info("  📧 Format Email     : nama.4digit-nisn@smpsekolah.edu");
        $this->command->info("  🔑 Format Password  : NISN + 123");
        $this->command->info("  📝 Contoh Login     :");
        $this->command->info("     Email    : ahmad.fatwal.5508@smpsekolah.edu");
        $this->command->info("     Password : 0128925508123");

        $this->command->info("\n🎯 Fitur yang Tersedia:");
        $this->command->info("  ✅ Akun sudah terverifikasi otomatis");
        $this->command->info("  ✅ Data jenis kelamin sudah diset");
        $this->command->info("  ✅ Score BK default = 0");
        $this->command->info("  ✅ Relasi kelas sudah terhubung");

        if ($berhasil > 0) {
            $this->command->info("\n🎉 Seeder berhasil dijalankan!");
            $this->command->info("🚀 Siswa dapat langsung login menggunakan email dan password yang telah dibuat.");
        } else {
            $this->command->warn("\n⚠️  Tidak ada siswa baru yang dibuat. Semua data sudah ada atau terjadi error.");
        }

        if ($gagal > 0) {
            $this->command->error("\n❗ Terdapat {$gagal} siswa yang gagal dibuat. Periksa log error di atas.");
        }

        $this->command->info("\n" . str_repeat("=", 80));
    }

    /**
     * Generate email berdasarkan nama dan NISN
     */
    private function generateEmail($nama, $nisn)
    {
        // Bersihkan nama dari karakter khusus dan spasi
        $cleanName = strtolower($nama);
        $cleanName = str_replace(['muh.', 'muhammad'], ['muh', 'muh'], $cleanName); // Singkat nama panjang
        $cleanName = preg_replace('/[^a-z\s]/', '', $cleanName); // Hapus karakter non-huruf
        $cleanName = trim($cleanName);
        $cleanName = str_replace(' ', '.', $cleanName); // Ganti spasi dengan titik

        // Jika nama terlalu panjang, ambil 2 kata pertama
        $nameParts = explode('.', $cleanName);
        if (count($nameParts) > 2) {
            $cleanName = implode('.', array_slice($nameParts, 0, 2));
        }

        // Ambil 4 digit terakhir NISN
        $lastNisn = substr($nisn, -4);

        // Generate email
        $baseEmail = $cleanName . '.' . $lastNisn . '@smpsekolah.edu';

        // Cek apakah email sudah ada, jika ya tambah counter
        $counter = 1;
        $email = $baseEmail;

        while (User::where('email', $email)->exists()) {
            $email = $cleanName . '.' . $lastNisn . '.' . $counter . '@smpsekolah.edu';
            $counter++;
        }

        return $email;
    }

    /**
     * Generate random score BK untuk variasi data (opsional)
     */
    private function generateRandomScoreBK()
    {
        // 70% siswa score 0-20 (baik)
        // 20% siswa score 21-60 (sedang) 
        // 8% siswa score 61-100 (tinggi)
        // 2% siswa score 101-150 (sangat tinggi)

        $rand = rand(1, 100);

        if ($rand <= 70) {
            return rand(0, 20); // Kondisi baik
        } elseif ($rand <= 90) {
            return rand(21, 60); // Perlu bimbingan
        } elseif ($rand <= 98) {
            return rand(61, 100); // Perlu perhatian
        } else {
            return rand(101, 150); // Sangat perlu perhatian
        }
    }
}
