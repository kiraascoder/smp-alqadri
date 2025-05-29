<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PelanggaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $data = [
            // Pelanggaran Ringan
            ['kategori' => 'ringan', 'deskripsi' => 'Memakai seragam dengan atribut tidak lengkap atau tidak sesuai dengan tata tertib sekolah.', 'skor' => 5],
            ['kategori' => 'ringan', 'deskripsi' => 'Tidak di dalam kelas saat pembelajaran berlangsung.', 'skor' => 2],
            ['kategori' => 'ringan', 'deskripsi' => 'Makan atau minum di dalam kelas saat pembelajaran berlangsung.', 'skor' => 2],
            ['kategori' => 'ringan', 'deskripsi' => 'Membuat atau menggunakan surat izin tidak masuk sekolah palsu.', 'skor' => 2],
            ['kategori' => 'ringan', 'deskripsi' => 'Membawa barang-barang yang tidak ada kaitannya dengan sekolah (Kosmetik & alat permainan yang tidak dibalikkan).', 'skor' => 2],
            ['kategori' => 'ringan', 'deskripsi' => 'Duduk di atas bangku atau meja guru.', 'skor' => 2],
            ['kategori' => 'ringan', 'deskripsi' => 'Mengganggu atau mengacaukan isi sendiri atau kelas lain saat jam pelajaran maupun di luar jam pelajaran.', 'skor' => 2],
            ['kategori' => 'ringan', 'deskripsi' => 'Tidak melaksanakan / mengerjakan PR, atau tugas.', 'skor' => 2],
            ['kategori' => 'ringan', 'deskripsi' => 'Memakai perhiasan berlebihan atau anting-anting bagi peserta didik ikhwan.', 'skor' => 2],
            ['kategori' => 'ringan', 'deskripsi' => 'Memakai perhiasan atau berdandan bagi peserta didik akhwat.', 'skor' => 2],
            ['kategori' => 'ringan', 'deskripsi' => 'Memakai alas kaki selain sepatu.', 'skor' => 2],
            ['kategori' => 'ringan', 'deskripsi' => 'Membeli makanan atau minuman di luar sekolah tanpa izin.', 'skor' => 2],
            ['kategori' => 'ringan', 'deskripsi' => 'Keluar masuk kelas bukan sesuai dengan jadwal pelajaran.', 'skor' => 2],

            // Pelanggaran Sedang
            ['kategori' => 'sedang', 'deskripsi' => 'Tidak masuk sekolah tanpa keterangan.', 'skor' => 15],
            ['kategori' => 'sedang', 'deskripsi' => 'Keluar lingkungan sekolah tanpa izin.', 'skor' => 15],
            ['kategori' => 'sedang', 'deskripsi' => 'Meloncati pagar sekolah atau pulang tanpa izin sebelum waktunya.', 'skor' => 15],
            ['kategori' => 'sedang', 'deskripsi' => 'Memarkir kendaraan bermotor di luar sekolah.', 'skor' => 10],
            ['kategori' => 'sedang', 'deskripsi' => 'Mengotori atau mencoret-coret dinding, meja, dan kursi dengan tulisan atau gambar tertentu.', 'skor' => 10],
            ['kategori' => 'sedang', 'deskripsi' => 'Membawa hp, alat komunikasi, dan sejenisnya tanpa ada perintah dari guru.', 'skor' => 10],
            ['kategori' => 'sedang', 'deskripsi' => 'Membawa alat musik ke sekolah.', 'skor' => 10],
            ['kategori' => 'sedang', 'deskripsi' => 'Membawa atau menyalakan petasan di sekolah.', 'skor' => 10],
            ['kategori' => 'sedang', 'deskripsi' => 'Meminjam sepeda teman tanpa izin pemilik sepeda.', 'skor' => 10],
            ['kategori' => 'sedang', 'deskripsi' => 'Tidak masuk atau meninggalkan rukun subuh di sekolah.', 'skor' => 10],
            ['kategori' => 'sedang', 'deskripsi' => 'Terlambat datang ke sekolah, datang di atas pukul 07.30.', 'skor' => 10],
            ['kategori' => 'sedang', 'deskripsi' => 'Keluar kelas tanpa minta izin guru yang ada di dalam kelas.', 'skor' => 10],
            ['kategori' => 'sedang', 'deskripsi' => 'Bada di luar kelas atau kantin saat pelajaran di kelas berlangsung.', 'skor' => 10],
            ['kategori' => 'sedang', 'deskripsi' => 'Bagi peserta didik ikhwan: rambut gondrong, mewarnai rambut, dan memotong rambut yang tidak sesuai ketentuan tata berpakaian.', 'skor' => 10],
            ['kategori' => 'sedang', 'deskripsi' => 'Tidak memenuhi panggilan / perintah guru, karyawan, atau kepala sekolah.', 'skor' => 5],
            ['kategori' => 'sedang', 'deskripsi' => 'Bernyanyi atau memainkan musik di kelas.', 'skor' => 5],
            ['kategori' => 'sedang', 'deskripsi' => 'Merayakan pesta ulang tahun di sekolah.', 'skor' => 5],
            ['kategori' => 'sedang', 'deskripsi' => 'Membuang sampah tidak pada tempatnya.', 'skor' => 5],
            ['kategori' => 'sedang', 'deskripsi' => 'Berkata, berbicara, menggunakan ungkapan yang tidak baik atau mengumpat.', 'skor' => 5],

            // Pelanggaran Berat
            ['kategori' => 'berat', 'deskripsi' => 'Melakukan atau terlibat tindakan yang tergolong perbuatan pornografi, asusila atau pelecehan seksual.', 'skor' => 100],
            ['kategori' => 'berat', 'deskripsi' => 'Membawa, memakai, atau mengedarkan narkoba dan atau minuman keras.', 'skor' => 100],
            ['kategori' => 'berat', 'deskripsi' => 'Membawa, menyimpan atau melihat gambar, film atau rekaman yang bertentangan dengan norma agama atau kesusilaan.', 'skor' => 100],
            ['kategori' => 'berat', 'deskripsi' => 'Terlibat atau menjadi anggota kelompok anak nakal atau kelompok terlarang lainnya.', 'skor' => 100],
            ['kategori' => 'berat', 'deskripsi' => 'Membawa atau menyimpan senjata tajam atau senjata yang membahayakan di sekolah.', 'skor' => 100],
            ['kategori' => 'berat', 'deskripsi' => 'Membawa, merokok atau minum minuman keras di lingkungan sekolah dan di luar lingkungan sekolah.', 'skor' => 100],
            ['kategori' => 'berat', 'deskripsi' => 'Berurusan dengan pihak berwajib karena kenakalan remaja.', 'skor' => 100],
            ['kategori' => 'berat', 'deskripsi' => 'Terlibat atau terbukti dalam tindak kriminal pencurian, perampasan, dan pemalakan.', 'skor' => 50],
            ['kategori' => 'berat', 'deskripsi' => 'Berkelahi atau main hakim sendiri, termasuk pengeroyokan dan tawuran.', 'skor' => 50],
            ['kategori' => 'berat', 'deskripsi' => 'Mencuri, berjudi, bertaruh di lingkungan sekolah atau di luar lingkungan sekolah.', 'skor' => 50],
            ['kategori' => 'berat', 'deskripsi' => 'Memalsukan tanda tangan orang tua / wali, guru, karyawan, atau kepala sekolah.', 'skor' => 50],
            ['kategori' => 'berat', 'deskripsi' => 'Memalak atau mengambil barang kepada teman secara paksa.', 'skor' => 30],
            ['kategori' => 'berat', 'deskripsi' => 'Mengubah model seragam sekolah yang telah ditentukan.', 'skor' => 30],
            ['kategori' => 'berat', 'deskripsi' => 'Merusak sarana dan prasarana sekolah.', 'skor' => 30],
        ];

        DB::table('pelanggarans')->insert($data);
    }
}
