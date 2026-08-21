<?php

namespace Database\Seeders;

use App\Models\Kebajikan;
use Illuminate\Database\Seeder;

class KebajikanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['deskripsi' => 'Aktif bertanya atau menjawab dalam pembelajaran', 'skor' => 2],
            ['deskripsi' => 'Memimpin doa sebelum atau sesudah pembelajaran', 'skor' => 3],
            ['deskripsi' => 'Membaca Al-Qur\'an (tadarus) dengan baik di depan kelas', 'skor' => 5],
            ['deskripsi' => 'Mengikuti kajian keislaman dengan aktif', 'skor' => 5],
            ['deskripsi' => 'Menjadi petugas upacara dengan baik', 'skor' => 5],
            ['deskripsi' => 'Menjadi ketua kelas yang menjalankan tugas dengan baik selama satu bulan', 'skor' => 5],
            ['deskripsi' => 'Menjadi pengurus kelas yang disiplin', 'skor' => 5],
            ['deskripsi' => 'Membantu guru tanpa diminta', 'skor' => 5],
            ['deskripsi' => 'Membantu teman yang mengalami kesulitan belajar', 'skor' => 5],
            ['deskripsi' => 'Mengembalikan barang temuan kepada pemilik atau guru', 'skor' => 5],
            ['deskripsi' => 'Menjaga kebersihan kelas di luar jadwal piket', 'skor' => 5],
            ['deskripsi' => 'Menjadi pelopor kebersihan lingkungan sekolah', 'skor' => 5],
            ['deskripsi' => 'Melaporkan potensi bahaya atau kerusakan fasilitas sekolah', 'skor' => 5],
            ['deskripsi' => 'Menanam atau merawat tanaman sekolah', 'skor' => 5],
            ['deskripsi' => 'Mengikuti kerja bakti sekolah', 'skor' => 5],
            ['deskripsi' => 'Menyelesaikan seluruh tugas tepat waktu selama satu bulan', 'skor' => 5],
            ['deskripsi' => 'Hadir tepat waktu selama 1 bulan penuh tanpa terlambat', 'skor' => 10],
            ['deskripsi' => 'Memakai seragam lengkap dan rapi selama 1 bulan', 'skor' => 10],
            ['deskripsi' => 'Menyelesaikan hafalan (murojaah) sesuai target', 'skor' => 10],
            ['deskripsi' => 'Memperoleh nilai tertinggi di kelas', 'skor' => 10],
            ['deskripsi' => 'Mengalami peningkatan nilai akademik yang signifikan', 'skor' => 10],
            ['deskripsi' => 'Mengikuti perlombaan mewakili sekolah', 'skor' => 10],
            ['deskripsi' => 'Menjadi duta sekolah pada suatu kegiatan', 'skor' => 10],
            ['deskripsi' => 'Menjadi mentor belajar bagi teman', 'skor' => 10],
            ['deskripsi' => 'Mengikuti kegiatan ekstrakurikuler secara aktif selama satu semester', 'skor' => 10],
            ['deskripsi' => 'Tidak pernah alfa selama 1 semester', 'skor' => 15],
            ['deskripsi' => 'Menjadi juara kelas', 'skor' => 15],
            ['deskripsi' => 'Juara lomba tingkat sekolah', 'skor' => 15],
            ['deskripsi' => 'Menjadi pengurus organisasi (OSIS/IPM/Pramuka) yang aktif', 'skor' => 15],
            ['deskripsi' => 'Juara lomba tingkat kecamatan', 'skor' => 20],
            ['deskripsi' => 'Menjadi teladan kedisiplinan selama satu semester', 'skor' => 20],
            ['deskripsi' => 'Menjadi teladan akhlak dan adab menurut penilaian guru', 'skor' => 20],
            ['deskripsi' => 'Tidak memiliki pelanggaran selama satu semester', 'skor' => 20],
            ['deskripsi' => 'Tidak memiliki pelanggaran selama satu tahun pelajaran', 'skor' => 20],
            ['deskripsi' => 'Menjadi inspirasi atau teladan berdasarkan rekomendasi dewan guru', 'skor' => 20],
            ['deskripsi' => 'Juara lomba tingkat kabupaten', 'skor' => 30],
            ['deskripsi' => 'Juara lomba tingkat provinsi', 'skor' => 40],
            ['deskripsi' => 'Juara lomba tingkat nasional', 'skor' => 40],
        ];

        foreach ($data as $item) {
            Kebajikan::updateOrCreate(
                ['deskripsi' => $item['deskripsi']],
                ['skor' => $item['skor']]
            );
        }

        $this->command?->info('KebajikanSeeder selesai: ' . count($data) . ' kebajikan diproses.');
    }
}
