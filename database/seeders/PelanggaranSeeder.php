<?php

namespace Database\Seeders;

use App\Models\Pelanggaran;
use Illuminate\Database\Seeder;

class PelanggaranSeeder extends Seeder
{
    public function run(): void
    {
        $data = [

            // =========================
            // PELANGGARAN RINGAN
            // =========================

            [
                'kategori' => 'Ringan',
                'deskripsi' => 'Memakai seragam dengan atribut tidak lengkap atau tidak sesuai dengan tata tertib sekolah. Memakai seragam dengan tidak benar. Untuk Peserta Didik Ikhwan: baju tidak dikancing, melipat lengan baju, baju dicoret-coret, kaos kaki dilipat atau diturunkan. Untuk Peserta Didik Akhwat: tidak memakai jilbab, ciput, celana panjang di dalam dan seragam tidak sesuai dengan aturan sekolah.',
                'skor' => 5,
            ],
            [
                'kategori' => 'Ringan',
                'deskripsi' => 'Tidur di dalam kelas saat pembelajaran berlangsung.',
                'skor' => 5,
            ],
            [
                'kategori' => 'Ringan',
                'deskripsi' => 'Makan atau minum di dalam kelas saat pembelajaran berlangsung.',
                'skor' => 3,
            ],
            [
                'kategori' => 'Ringan',
                'deskripsi' => 'Membuat atau menggunakan surat izin tidak masuk sekolah palsu.',
                'skor' => 5,
            ],
            [
                'kategori' => 'Ringan',
                'deskripsi' => 'Membawa barang-barang yang tidak ada kaitannya dengan sekolah (kosmetik & alat permainan yang melalaikan).',
                'skor' => 2,
            ],
            [
                'kategori' => 'Ringan',
                'deskripsi' => 'Duduk di atas bangku atau meja guru.',
                'skor' => 2,
            ],
            [
                'kategori' => 'Ringan',
                'deskripsi' => 'Mengganggu atau mengacaukan kelas sendiri atau kelas lain saat jam pelajaran maupun di luar jam pelajaran.',
                'skor' => 2,
            ],
            [
                'kategori' => 'Ringan',
                'deskripsi' => 'Tidak melaksanakan/mengerjakan PR atau tugas.',
                'skor' => 2,
            ],
            [
                'kategori' => 'Ringan',
                'deskripsi' => 'Memakai gelang, kalung, atau anting-anting bagi peserta didik ikhwan.',
                'skor' => 2,
            ],
            [
                'kategori' => 'Ringan',
                'deskripsi' => 'Memakai perhiasan berlebihan atau berdandan bagi peserta didik akhwat.',
                'skor' => 2,
            ],
            [
                'kategori' => 'Ringan',
                'deskripsi' => 'Menghasut atau mengadu domba teman.',
                'skor' => 2,
            ],
            [
                'kategori' => 'Ringan',
                'deskripsi' => 'Membeli makanan atau minuman di luar sekolah tanpa izin.',
                'skor' => 2,
            ],
            [
                'kategori' => 'Ringan',
                'deskripsi' => 'Tidak membawa buku pelajaran sesuai dengan jadwal pelajaran.',
                'skor' => 2,
            ],

            // =========================
            // PELANGGARAN SEDANG
            // =========================

            [
                'kategori' => 'Sedang',
                'deskripsi' => 'Tidak masuk sekolah tanpa keterangan.',
                'skor' => 10,
            ],
            [
                'kategori' => 'Sedang',
                'deskripsi' => 'Keluar lingkungan sekolah tanpa izin.',
                'skor' => 10,
            ],
            [
                'kategori' => 'Sedang',
                'deskripsi' => 'Meloncati pagar sekolah atau pulang tanpa izin sebelum waktunya.',
                'skor' => 10,
            ],
            [
                'kategori' => 'Sedang',
                'deskripsi' => 'Memarkir kendaraan bermotor di luar sekolah.',
                'skor' => 10,
            ],
            [
                'kategori' => 'Sedang',
                'deskripsi' => 'Mengotori atau mencoret-coret dinding, meja, dan kursi dengan tulisan atau gambar tertentu.',
                'skor' => 10,
            ],
            [
                'kategori' => 'Sedang',
                'deskripsi' => 'Membawa handphone, laptop, dan sejenisnya tanpa ada perintah dari guru.',
                'skor' => 10,
            ],
            [
                'kategori' => 'Sedang',
                'deskripsi' => 'Membawa alat musik ke sekolah.',
                'skor' => 10,
            ],
            [
                'kategori' => 'Sedang',
                'deskripsi' => 'Membawa atau menyalakan petasan di sekolah.',
                'skor' => 10,
            ],
            [
                'kategori' => 'Sedang',
                'deskripsi' => 'Meminjam sepeda teman tanpa izin pemilik sepeda.',
                'skor' => 10,
            ],
            [
                'kategori' => 'Sedang',
                'deskripsi' => 'Menghilangkan atau merusak buku sekolah.',
                'skor' => 10,
            ],
            [
                'kategori' => 'Sedang',
                'deskripsi' => 'Terlambat datang ke sekolah, datang di atas pukul 07.30.',
                'skor' => 10,
            ],
            [
                'kategori' => 'Sedang',
                'deskripsi' => 'Keluar kelas tanpa minta izin guru yang ada di dalam kelas.',
                'skor' => 10,
            ],
            [
                'kategori' => 'Sedang',
                'deskripsi' => 'Berada di luar kelas atau kantin saat pelajaran di kelas berlangsung.',
                'skor' => 10,
            ],
            [
                'kategori' => 'Sedang',
                'deskripsi' => 'Bagi Peserta Didik Ikhwan: rambut gondrong, mewarnai rambut, dan memotong rambut yang tidak sesuai dengan potongan rambut pelajar.',
                'skor' => 10,
            ],
            [
                'kategori' => 'Sedang',
                'deskripsi' => 'Tidak memenuhi panggilan/perintah guru, karyawan, atau kepala sekolah.',
                'skor' => 5,
            ],
            [
                'kategori' => 'Sedang',
                'deskripsi' => 'Bernyanyi atau memutar musik di kelas.',
                'skor' => 5,
            ],
            [
                'kategori' => 'Sedang',
                'deskripsi' => 'Merayakan pesta ulang tahun di sekolah.',
                'skor' => 5,
            ],
            [
                'kategori' => 'Sedang',
                'deskripsi' => 'Membuang sampah tidak pada tempatnya.',
                'skor' => 5,
            ],
            [
                'kategori' => 'Sedang',
                'deskripsi' => 'Berkata, berbicara, mengungkap ungkapan yang tidak baik atau mengumpat.',
                'skor' => 5,
            ],

            // =========================
            // PELANGGARAN SANGAT BERAT
            // =========================

            [
                'kategori' => 'Sangat Berat',
                'deskripsi' => 'Melakukan atau terlibat tindakan yang tergolong perbuatan pornografi, asusila atau pelecehan seksual.',
                'skor' => 100,
            ],
            [
                'kategori' => 'Sangat Berat',
                'deskripsi' => 'Membawa, memakai, atau mengedarkan narkoba dan atau minuman keras.',
                'skor' => 100,
            ],
            [
                'kategori' => 'Sangat Berat',
                'deskripsi' => 'Membawa, menyimpan, atau melihat gambar, film atau rekaman yang bertentangan dengan norma agama atau kesusilaan.',
                'skor' => 100,
            ],
            [
                'kategori' => 'Sangat Berat',
                'deskripsi' => 'Terlibat atau menjadi anggota kelompok anak nakal atau kelompok terlarang lainnya.',
                'skor' => 100,
            ],
            [
                'kategori' => 'Sangat Berat',
                'deskripsi' => 'Membawa atau menyimpan senjata tajam atau senjata yang membahayakan di sekolah.',
                'skor' => 100,
            ],
            [
                'kategori' => 'Sangat Berat',
                'deskripsi' => 'Membawa, merokok atau minum minuman keras di lingkungan sekolah dan di luar lingkungan sekolah.',
                'skor' => 100,
            ],
            [
                'kategori' => 'Sangat Berat',
                'deskripsi' => 'Berurusan dengan pihak berwajib karena kenakalan remaja.',
                'skor' => 100,
            ],
            [
                'kategori' => 'Sangat Berat',
                'deskripsi' => 'Terlibat atau terbukti dalam tindak kriminal pencurian, perampasan, dan pemalakan.',
                'skor' => 50,
            ],
            [
                'kategori' => 'Sangat Berat',
                'deskripsi' => 'Berkelahi atau main hakim sendiri, termasuk pengeroyokan dan tawuran.',
                'skor' => 50,
            ],
            [
                'kategori' => 'Sangat Berat',
                'deskripsi' => 'Mencuri, berjudi, bertaruh di lingkungan sekolah atau di luar lingkungan sekolah.',
                'skor' => 50,
            ],
            [
                'kategori' => 'Sangat Berat',
                'deskripsi' => 'Memalsukan tanda tangan orang tua/wali, guru, karyawan, atau kepala sekolah.',
                'skor' => 50,
            ],
            [
                'kategori' => 'Sangat Berat',
                'deskripsi' => 'Meminta uang atau barang kepada teman secara paksa.',
                'skor' => 30,
            ],
            [
                'kategori' => 'Sangat Berat',
                'deskripsi' => 'Mengubah model seragam sekolah yang telah ditentukan.',
                'skor' => 30,
            ],
            [
                'kategori' => 'Sangat Berat',
                'deskripsi' => 'Merusak sarana dan prasarana sekolah.',
                'skor' => 30,
            ],
            [
                'kategori' => 'Sangat Berat',
                'deskripsi' => 'Berpacaran di lingkungan sekolah maupun di luar sekolah.',
                'skor' => 30,
            ],
        ];

        foreach ($data as $item) {
            Pelanggaran::updateOrCreate(
                [
                    'deskripsi' => $item['deskripsi'],
                ],
                [
                    'kategori' => $item['kategori'],
                    'skor' => $item['skor'],
                ]
            );
        }
    }
}
