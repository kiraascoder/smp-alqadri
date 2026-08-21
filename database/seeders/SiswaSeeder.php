<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        /*
         * Seeder ini menyesuaikan struktur tabel siswa saat ini:
         * id, orang_tua_id, kelas_id, nama, tanggal_lahir, score_bk, timestamps.
         *
         * Siswa TIDAK dibuatkan akun pada tabel users karena siswa tidak login.
         * orang_tua_id sengaja tidak diubah oleh seeder.
         * score_bk siswa lama juga tidak direset.
         */
        $dataSiswa = [
            [
                'nama' => 'IZZAT IBNU RAHMAN AL GIFARI',
                'kelas' => 'Kelas 7A',
                'tanggal_lahir' => '2013-11-27',
            ],
            [
                'nama' => 'M. DYRGA ALIM RAMADHAN',
                'kelas' => 'Kelas 7A',
                'tanggal_lahir' => '2013-08-03',
            ],
            [
                'nama' => 'MUH. FAHMI',
                'kelas' => 'Kelas 7A',
                'tanggal_lahir' => '2013-11-23',
            ],
            [
                'nama' => 'MUH. FAJRIN',
                'kelas' => 'Kelas 7A',
                'tanggal_lahir' => '2013-09-23',
            ],
            [
                'nama' => 'MUH. RIFAT HASRUL',
                'kelas' => 'Kelas 7A',
                'tanggal_lahir' => '2014-02-26',
            ],
            [
                'nama' => 'MUH. RIZKY PRATAMA AYYUB',
                'kelas' => 'Kelas 7A',
                'tanggal_lahir' => '2013-09-13',
            ],
            [
                'nama' => 'MUHAMMAD AFIQ KAHAR',
                'kelas' => 'Kelas 7A',
                'tanggal_lahir' => '2014-05-05',
            ],
            [
                'nama' => 'MUHAMMAD AL HABSYI',
                'kelas' => 'Kelas 7A',
                'tanggal_lahir' => '2013-07-31',
            ],
            [
                'nama' => 'MUHAMMAD DAFFA',
                'kelas' => 'Kelas 7A',
                'tanggal_lahir' => '2014-04-30',
            ],
            [
                'nama' => 'MUHAMMAD FAIZ ALFARIZY',
                'kelas' => 'Kelas 7A',
                'tanggal_lahir' => '2014-03-14',
            ],
            [
                'nama' => 'MUHAMMAD FAUZAN ASWANDI',
                'kelas' => 'Kelas 7A',
                'tanggal_lahir' => '2014-01-12',
            ],
            [
                'nama' => 'MUHAMMAD FIRZHA EL MUBARAK',
                'kelas' => 'Kelas 7A',
                'tanggal_lahir' => '2014-06-05',
            ],
            [
                'nama' => 'MUHAMMAD IBNU ABDILLAH',
                'kelas' => 'Kelas 7A',
                'tanggal_lahir' => '2013-09-27',
            ],
            [
                'nama' => 'MUHAMMAD KHIAR AMMAR',
                'kelas' => 'Kelas 7A',
                'tanggal_lahir' => '2014-04-18',
            ],
            [
                'nama' => 'MUHAMMAD RAIHAN',
                'kelas' => 'Kelas 7A',
                'tanggal_lahir' => '2013-07-25',
            ],
            [
                'nama' => 'MUHAMMAD RESTU',
                'kelas' => 'Kelas 7A',
                'tanggal_lahir' => '2013-12-12',
            ],
            [
                'nama' => 'RADJA AFFAN NUGRAHA NURDIN',
                'kelas' => 'Kelas 7A',
                'tanggal_lahir' => '2014-08-25',
            ],
            [
                'nama' => 'ZECH AHMAD BATTAR HATF',
                'kelas' => 'Kelas 7A',
                'tanggal_lahir' => '2014-06-11',
            ],
            [
                'nama' => 'A. MUH. KHOIRI ATHALA PASELEWORY',
                'kelas' => 'Kelas 7B',
                'tanggal_lahir' => '2013-09-14',
            ],
            [
                'nama' => 'A.W.FATHIR',
                'kelas' => 'Kelas 7B',
                'tanggal_lahir' => '2013-09-01',
            ],
            [
                'nama' => 'ABDUL KHOBIR MASRUL MUSA',
                'kelas' => 'Kelas 7B',
                'tanggal_lahir' => '2014-06-11',
            ],
            [
                'nama' => 'ABIDZAR AL-KHALIFI',
                'kelas' => 'Kelas 7B',
                'tanggal_lahir' => '2014-04-21',
            ],
            [
                'nama' => 'ABIDZAR ALIF YUSRAN',
                'kelas' => 'Kelas 7B',
                'tanggal_lahir' => '2014-05-10',
            ],
            [
                'nama' => 'ABU DZAR AL-GHIFARI. E',
                'kelas' => 'Kelas 7B',
                'tanggal_lahir' => '2013-10-02',
            ],
            [
                'nama' => 'AFDHAL MAHZUZ FIRMAN',
                'kelas' => 'Kelas 7B',
                'tanggal_lahir' => '2014-01-28',
            ],
            [
                'nama' => 'AHMAD AKRAM',
                'kelas' => 'Kelas 7B',
                'tanggal_lahir' => '2014-05-30',
            ],
            [
                'nama' => 'AHMAD QOLBI RAUDHAH ABRAR',
                'kelas' => 'Kelas 7B',
                'tanggal_lahir' => '2013-10-12',
            ],
            [
                'nama' => 'AHMAD ZAKY ISMAIL',
                'kelas' => 'Kelas 7B',
                'tanggal_lahir' => '2013-07-11',
            ],
            [
                'nama' => 'AL GHAZALI',
                'kelas' => 'Kelas 7B',
                'tanggal_lahir' => '2014-04-26',
            ],
            [
                'nama' => 'Andi Ahmad Al Faraby',
                'kelas' => 'Kelas 7B',
                'tanggal_lahir' => '2013-02-25',
            ],
            [
                'nama' => 'ANDI MIRZA UKAIL',
                'kelas' => 'Kelas 7B',
                'tanggal_lahir' => '2013-11-01',
            ],
            [
                'nama' => 'ANDI PANGERAN MAHAWIRA',
                'kelas' => 'Kelas 7B',
                'tanggal_lahir' => '2014-06-12',
            ],
            [
                'nama' => 'ASYAM AL SYAUQI',
                'kelas' => 'Kelas 7B',
                'tanggal_lahir' => '2014-02-27',
            ],
            [
                'nama' => 'GHALI MUHAMMAD KYFA',
                'kelas' => 'Kelas 7B',
                'tanggal_lahir' => '2014-02-08',
            ],
            [
                'nama' => 'GHANI MUHAMMAD KYFA',
                'kelas' => 'Kelas 7B',
                'tanggal_lahir' => '2014-02-08',
            ],
            [
                'nama' => 'IBNU ABBAD. A',
                'kelas' => 'Kelas 7B',
                'tanggal_lahir' => '2014-02-17',
            ],
            [
                'nama' => 'MUHAMMAD ALFATHI CHENDRA MAMBANI',
                'kelas' => 'Kelas 7B',
                'tanggal_lahir' => '2013-01-08',
            ],
            [
                'nama' => 'MUHAMMAD SULTAN ABIDZAR',
                'kelas' => 'Kelas 7B',
                'tanggal_lahir' => '2014-01-07',
            ],
            [
                'nama' => 'MUHAMMAD SYIHAB AL KHUDRI A',
                'kelas' => 'Kelas 7B',
                'tanggal_lahir' => '2014-02-16',
            ],
            [
                'nama' => 'MUHAMMAD ZUBAIR SIRAJULHAQ',
                'kelas' => 'Kelas 7B',
                'tanggal_lahir' => '2014-05-10',
            ],
            [
                'nama' => 'MUHARRAM SHAFWAN MUBARAK',
                'kelas' => 'Kelas 7B',
                'tanggal_lahir' => '2013-11-18',
            ],
            [
                'nama' => 'RAKI ALTAMIS FAHEEM',
                'kelas' => 'Kelas 7B',
                'tanggal_lahir' => '2014-06-17',
            ],
            [
                'nama' => 'A. NUR FATIHA AKIL',
                'kelas' => 'Kelas 7C',
                'tanggal_lahir' => '2013-08-16',
            ],
            [
                'nama' => 'ADZKIA SAUFA SHALIHAH',
                'kelas' => 'Kelas 7C',
                'tanggal_lahir' => '2014-06-16',
            ],
            [
                'nama' => 'AFIKA VANIA EVARISTA',
                'kelas' => 'Kelas 7C',
                'tanggal_lahir' => '2013-10-30',
            ],
            [
                'nama' => 'AFRA ALTHAFUNNISA TAMSIR',
                'kelas' => 'Kelas 7C',
                'tanggal_lahir' => '2013-09-19',
            ],
            [
                'nama' => 'Aisyah Nur Kanis',
                'kelas' => 'Kelas 7C',
                'tanggal_lahir' => '2013-09-23',
            ],
            [
                'nama' => 'ALIFA AZQIARA',
                'kelas' => 'Kelas 7C',
                'tanggal_lahir' => '2014-06-24',
            ],
            [
                'nama' => 'ANDI AFIFAH FITYAH FAHRUDDIN',
                'kelas' => 'Kelas 7C',
                'tanggal_lahir' => '2014-03-22',
            ],
            [
                'nama' => 'ANNISA AWALIAH AZZAHRAH',
                'kelas' => 'Kelas 7C',
                'tanggal_lahir' => '2013-12-01',
            ],
            [
                'nama' => 'AQILAH SALSABILA ZAHIRANI',
                'kelas' => 'Kelas 7C',
                'tanggal_lahir' => '2014-01-26',
            ],
            [
                'nama' => 'DAFITHA NURKANZHA',
                'kelas' => 'Kelas 7C',
                'tanggal_lahir' => '2014-06-09',
            ],
            [
                'nama' => 'DWI PUTRINI',
                'kelas' => 'Kelas 7C',
                'tanggal_lahir' => '2013-12-12',
            ],
            [
                'nama' => 'DZAKIRA QURRATU AINI',
                'kelas' => 'Kelas 7C',
                'tanggal_lahir' => '2014-01-20',
            ],
            [
                'nama' => 'FATIN SUCI RAMADHANI',
                'kelas' => 'Kelas 7C',
                'tanggal_lahir' => '2013-07-26',
            ],
            [
                'nama' => 'INAYAH KHERUN NISA',
                'kelas' => 'Kelas 7C',
                'tanggal_lahir' => '2013-06-19',
            ],
            [
                'nama' => 'KESYA NUR MUDIA',
                'kelas' => 'Kelas 7C',
                'tanggal_lahir' => '2014-01-23',
            ],
            [
                'nama' => 'KHAERUNNISA SALSABILA IKBAL',
                'kelas' => 'Kelas 7C',
                'tanggal_lahir' => '2014-02-17',
            ],
            [
                'nama' => 'KHANSA MALIYANAH IDRIS',
                'kelas' => 'Kelas 7C',
                'tanggal_lahir' => '2013-09-18',
            ],
            [
                'nama' => 'LUTHFYAH HUMAIRA IFFAH',
                'kelas' => 'Kelas 7C',
                'tanggal_lahir' => '2014-05-24',
            ],
            [
                'nama' => 'NAJWA KHAIRA WILDA',
                'kelas' => 'Kelas 7C',
                'tanggal_lahir' => '2013-10-05',
            ],
            [
                'nama' => 'NAYLA MUAZHARA',
                'kelas' => 'Kelas 7C',
                'tanggal_lahir' => '2013-11-15',
            ],
            [
                'nama' => 'NUR ALIFA AZZAHRA BASIT',
                'kelas' => 'Kelas 7C',
                'tanggal_lahir' => '2014-02-05',
            ],
            [
                'nama' => 'NUR KHAZANAH',
                'kelas' => 'Kelas 7C',
                'tanggal_lahir' => '2014-03-24',
            ],
            [
                'nama' => 'NUR TZARWA ALYHA',
                'kelas' => 'Kelas 7C',
                'tanggal_lahir' => '2013-05-17',
            ],
            [
                'nama' => 'NUR ZAHIDA QALBI NADHIFA',
                'kelas' => 'Kelas 7C',
                'tanggal_lahir' => '2013-09-21',
            ],
            [
                'nama' => 'NURUL MAGHFIRAH MUSTARI',
                'kelas' => 'Kelas 7C',
                'tanggal_lahir' => '2013-10-17',
            ],
            [
                'nama' => 'QISYA SAFIRAH',
                'kelas' => 'Kelas 7C',
                'tanggal_lahir' => '2013-11-27',
            ],
            [
                'nama' => 'RUQAYYAH RAHMAH',
                'kelas' => 'Kelas 7C',
                'tanggal_lahir' => '2013-02-10',
            ],
            [
                'nama' => 'SALSABILA NADHIFAH. M',
                'kelas' => 'Kelas 7C',
                'tanggal_lahir' => '2013-12-02',
            ],
            [
                'nama' => 'SARAH KHANZA HUMAIRAH',
                'kelas' => 'Kelas 7C',
                'tanggal_lahir' => '2013-12-11',
            ],
            [
                'nama' => 'SITI AISYAH',
                'kelas' => 'Kelas 7C',
                'tanggal_lahir' => '2013-12-17',
            ],
            [
                'nama' => 'SITI NAGINA IRWAN',
                'kelas' => 'Kelas 7C',
                'tanggal_lahir' => '2014-05-17',
            ],
            [
                'nama' => 'SYAURAH FATIN SAYADI',
                'kelas' => 'Kelas 7C',
                'tanggal_lahir' => '2013-12-03',
            ],
            [
                'nama' => 'UVI SRY ILHAMI',
                'kelas' => 'Kelas 7C',
                'tanggal_lahir' => '2013-11-23',
            ],
            [
                'nama' => 'AHMAD ALIF RAUF',
                'kelas' => 'Kelas 8A',
                'tanggal_lahir' => '2013-03-01',
            ],
            [
                'nama' => 'Andi Abid Aqil Rajendra',
                'kelas' => 'Kelas 8A',
                'tanggal_lahir' => '2013-06-29',
            ],
            [
                'nama' => 'ANDI MUHAMMAD ADAM KHAIZURAN',
                'kelas' => 'Kelas 8A',
                'tanggal_lahir' => '2012-10-20',
            ],
            [
                'nama' => 'ANDI MUHAMMAD ZAHY DAFFA',
                'kelas' => 'Kelas 8A',
                'tanggal_lahir' => '2012-09-28',
            ],
            [
                'nama' => 'ANDI RAHMAT NUR ASYAM',
                'kelas' => 'Kelas 8A',
                'tanggal_lahir' => '2012-12-12',
            ],
            [
                'nama' => 'AZFAR QABIL',
                'kelas' => 'Kelas 8A',
                'tanggal_lahir' => '2013-05-14',
            ],
            [
                'nama' => 'M. Gibran Al-Gazaly',
                'kelas' => 'Kelas 8A',
                'tanggal_lahir' => '2010-10-30',
            ],
            [
                'nama' => 'M. KHOLIL SAHARUDDIN',
                'kelas' => 'Kelas 8A',
                'tanggal_lahir' => '2012-11-15',
            ],
            [
                'nama' => 'Muh. Abdan R',
                'kelas' => 'Kelas 8A',
                'tanggal_lahir' => '2012-10-06',
            ],
            [
                'nama' => 'Muh. Abidzar Mahmud',
                'kelas' => 'Kelas 8A',
                'tanggal_lahir' => '2013-05-16',
            ],
            [
                'nama' => 'MUH. ABRAR SAPUTRA ANDINAS',
                'kelas' => 'Kelas 8A',
                'tanggal_lahir' => '2012-09-02',
            ],
            [
                'nama' => 'MUH. AKMAL UMRA',
                'kelas' => 'Kelas 8A',
                'tanggal_lahir' => '2012-11-07',
            ],
            [
                'nama' => 'MUH. ALIM',
                'kelas' => 'Kelas 8A',
                'tanggal_lahir' => '2013-01-01',
            ],
            [
                'nama' => 'MUH. FADHIL',
                'kelas' => 'Kelas 8A',
                'tanggal_lahir' => '2012-09-25',
            ],
            [
                'nama' => 'Muh. Fudhail Arzaq Idris',
                'kelas' => 'Kelas 8A',
                'tanggal_lahir' => '2012-09-07',
            ],
            [
                'nama' => 'Muh. Naufal Alfath Anwar',
                'kelas' => 'Kelas 8A',
                'tanggal_lahir' => '2013-02-15',
            ],
            [
                'nama' => 'MUH. RIZQI AKBAR',
                'kelas' => 'Kelas 8A',
                'tanggal_lahir' => '2013-06-20',
            ],
            [
                'nama' => 'MUH. ZUBAIR ZAIM',
                'kelas' => 'Kelas 8A',
                'tanggal_lahir' => '2012-10-09',
            ],
            [
                'nama' => 'Muhammad Ahnaf',
                'kelas' => 'Kelas 8A',
                'tanggal_lahir' => '2012-11-28',
            ],
            [
                'nama' => 'MUHAMMAD ALTAF ADABY',
                'kelas' => 'Kelas 8A',
                'tanggal_lahir' => '2013-05-24',
            ],
            [
                'nama' => 'Muhammad Arlan Chairil',
                'kelas' => 'Kelas 8A',
                'tanggal_lahir' => '2013-02-22',
            ],
            [
                'nama' => 'MUHAMMAD ASYRAF MUNIR',
                'kelas' => 'Kelas 8A',
                'tanggal_lahir' => '2012-11-30',
            ],
            [
                'nama' => 'Muhammad Irsyad Hermansyah',
                'kelas' => 'Kelas 8A',
                'tanggal_lahir' => '2012-12-31',
            ],
            [
                'nama' => 'MUHAMMAD MUKRAMIN',
                'kelas' => 'Kelas 8A',
                'tanggal_lahir' => '2012-06-05',
            ],
            [
                'nama' => 'ADRIAN MAKMUR',
                'kelas' => 'Kelas 8B',
                'tanggal_lahir' => '2013-01-05',
            ],
            [
                'nama' => 'AHMAD FAIZ',
                'kelas' => 'Kelas 8B',
                'tanggal_lahir' => '2013-02-17',
            ],
            [
                'nama' => 'AHMAD NUFAIL ASBULLAH',
                'kelas' => 'Kelas 8B',
                'tanggal_lahir' => '2013-05-21',
            ],
            [
                'nama' => 'ANDI ADIYATMA NUGRAHA KERRANG',
                'kelas' => 'Kelas 8B',
                'tanggal_lahir' => '2012-02-07',
            ],
            [
                'nama' => 'Andi Muh. Dhafir Khalis R',
                'kelas' => 'Kelas 8B',
                'tanggal_lahir' => '2012-07-06',
            ],
            [
                'nama' => 'ANDI MUH. ILHAM',
                'kelas' => 'Kelas 8B',
                'tanggal_lahir' => '2013-01-13',
            ],
            [
                'nama' => 'Hafizh Ayatullah',
                'kelas' => 'Kelas 8B',
                'tanggal_lahir' => '2013-02-24',
            ],
            [
                'nama' => 'Hisyam Hanif',
                'kelas' => 'Kelas 8B',
                'tanggal_lahir' => '2013-04-19',
            ],
            [
                'nama' => 'M. Batara Arif',
                'kelas' => 'Kelas 8B',
                'tanggal_lahir' => '2012-03-24',
            ],
            [
                'nama' => 'M. RIZKY ADITYA',
                'kelas' => 'Kelas 8B',
                'tanggal_lahir' => '2013-05-09',
            ],
            [
                'nama' => 'MUH. ABDUL RAJAB',
                'kelas' => 'Kelas 8B',
                'tanggal_lahir' => '2013-06-06',
            ],
            [
                'nama' => 'MUH. ARHAM',
                'kelas' => 'Kelas 8B',
                'tanggal_lahir' => '2013-02-24',
            ],
            [
                'nama' => 'MUH. ARIF R',
                'kelas' => 'Kelas 8B',
                'tanggal_lahir' => '2013-02-18',
            ],
            [
                'nama' => 'MUH. RIFKY IBRAHIM',
                'kelas' => 'Kelas 8B',
                'tanggal_lahir' => '2013-05-12',
            ],
            [
                'nama' => 'Muhammad Fakhri Yusuf',
                'kelas' => 'Kelas 8B',
                'tanggal_lahir' => '2012-12-15',
            ],
            [
                'nama' => 'Muhammad Farhan Bahtiar',
                'kelas' => 'Kelas 8B',
                'tanggal_lahir' => '2013-01-29',
            ],
            [
                'nama' => 'MUHAMMAD MARWAN',
                'kelas' => 'Kelas 8B',
                'tanggal_lahir' => '2012-09-24',
            ],
            [
                'nama' => 'MUHAMMAD NABIL AMRAN',
                'kelas' => 'Kelas 8B',
                'tanggal_lahir' => '2012-08-13',
            ],
            [
                'nama' => 'MUHAMMAD NAUFAL ALFATIH',
                'kelas' => 'Kelas 8B',
                'tanggal_lahir' => '2013-04-21',
            ],
            [
                'nama' => 'MUHAMMAD REZKI ARDIANSYAH',
                'kelas' => 'Kelas 8B',
                'tanggal_lahir' => '2012-11-04',
            ],
            [
                'nama' => 'MUHAMMAD SHULFIQKY',
                'kelas' => 'Kelas 8B',
                'tanggal_lahir' => '2013-03-28',
            ],
            [
                'nama' => 'MUHAMMAD TRI ARFAN',
                'kelas' => 'Kelas 8B',
                'tanggal_lahir' => '2012-12-16',
            ],
            [
                'nama' => 'RAISUL NABIL ATHAILLAH',
                'kelas' => 'Kelas 8B',
                'tanggal_lahir' => '2012-07-05',
            ],
            [
                'nama' => 'Ryandra Ramadhan',
                'kelas' => 'Kelas 8B',
                'tanggal_lahir' => '2012-08-11',
            ],
            [
                'nama' => 'ANASYRAH',
                'kelas' => 'Kelas 8C',
                'tanggal_lahir' => '2012-12-21',
            ],
            [
                'nama' => 'AQILA AZZAHRA',
                'kelas' => 'Kelas 8C',
                'tanggal_lahir' => '2013-03-01',
            ],
            [
                'nama' => 'Ariqah Fatinah S',
                'kelas' => 'Kelas 8C',
                'tanggal_lahir' => '2013-04-12',
            ],
            [
                'nama' => 'FAQIHA ALTHAFUNNISA',
                'kelas' => 'Kelas 8C',
                'tanggal_lahir' => '2012-09-06',
            ],
            [
                'nama' => 'FATIMAH AZZAHRA',
                'kelas' => 'Kelas 8C',
                'tanggal_lahir' => '2012-08-25',
            ],
            [
                'nama' => 'HASHIFAH SYAKILA HR',
                'kelas' => 'Kelas 8C',
                'tanggal_lahir' => '2013-04-25',
            ],
            [
                'nama' => 'ICI AFIFATUNNISAH N. PATARA',
                'kelas' => 'Kelas 8C',
                'tanggal_lahir' => '2013-02-17',
            ],
            [
                'nama' => 'KAYLA RAMADHANI RUDITTYA',
                'kelas' => 'Kelas 8C',
                'tanggal_lahir' => '2013-07-17',
            ],
            [
                'nama' => 'Musdalifa Masrullah',
                'kelas' => 'Kelas 8C',
                'tanggal_lahir' => '2012-12-20',
            ],
            [
                'nama' => 'NADILA',
                'kelas' => 'Kelas 8C',
                'tanggal_lahir' => '2013-05-05',
            ],
            [
                'nama' => 'Nur Afifah Fitiya Udin',
                'kelas' => 'Kelas 8C',
                'tanggal_lahir' => '2013-06-14',
            ],
            [
                'nama' => 'NUR AFRAH',
                'kelas' => 'Kelas 8C',
                'tanggal_lahir' => '2012-09-14',
            ],
            [
                'nama' => 'RAISA NARAYA LUTHFIANA',
                'kelas' => 'Kelas 8C',
                'tanggal_lahir' => '2013-06-14',
            ],
            [
                'nama' => 'RHARA KHUMAERA RAHMAT',
                'kelas' => 'Kelas 8C',
                'tanggal_lahir' => '2013-05-24',
            ],
            [
                'nama' => 'SHOFIE ASSYABIYA HARTONO',
                'kelas' => 'Kelas 8C',
                'tanggal_lahir' => '2013-06-29',
            ],
            [
                'nama' => 'SITI AKIFAH NAILAH',
                'kelas' => 'Kelas 8C',
                'tanggal_lahir' => '2013-04-09',
            ],
            [
                'nama' => 'SITTI NUR ASIA',
                'kelas' => 'Kelas 8C',
                'tanggal_lahir' => '2012-02-24',
            ],
            [
                'nama' => 'SULFA KANIAH',
                'kelas' => 'Kelas 8C',
                'tanggal_lahir' => '2013-01-05',
            ],
            [
                'nama' => 'UFAIRAH NUR AFIFAH',
                'kelas' => 'Kelas 8C',
                'tanggal_lahir' => '2013-06-02',
            ],
            [
                'nama' => 'UMMI FAJRIA',
                'kelas' => 'Kelas 8C',
                'tanggal_lahir' => '2012-10-07',
            ],
            [
                'nama' => 'HAURA NAZHIFA ANDINY',
                'kelas' => 'Kelas 8C',
                'tanggal_lahir' => '2012-10-19',
            ],
            [
                'nama' => 'AHMAD FATWAL',
                'kelas' => 'Kelas 9A',
                'tanggal_lahir' => '2012-01-22',
            ],
            [
                'nama' => 'ANDI ALI ZAINAL ABIDIN',
                'kelas' => 'Kelas 9A',
                'tanggal_lahir' => '2012-05-28',
            ],
            [
                'nama' => 'Andi Aqsa Nur Ahmad',
                'kelas' => 'Kelas 9A',
                'tanggal_lahir' => '2012-05-06',
            ],
            [
                'nama' => 'DZAKI MUBARAK RAMLI',
                'kelas' => 'Kelas 9A',
                'tanggal_lahir' => '2011-10-05',
            ],
            [
                'nama' => 'GHALY SAAD RIFAI ASRIL',
                'kelas' => 'Kelas 9A',
                'tanggal_lahir' => '2012-05-28',
            ],
            [
                'nama' => 'M. RIFKY KURNIAWAN',
                'kelas' => 'Kelas 9A',
                'tanggal_lahir' => '2011-11-25',
            ],
            [
                'nama' => 'MUH. ASYAM FAIZ IRWAN',
                'kelas' => 'Kelas 9A',
                'tanggal_lahir' => '2011-10-09',
            ],
            [
                'nama' => 'MUH. FAJAR NASRULLAH',
                'kelas' => 'Kelas 9A',
                'tanggal_lahir' => '2012-02-15',
            ],
            [
                'nama' => 'MUH. NAIZAR AZMI IRWAN',
                'kelas' => 'Kelas 9A',
                'tanggal_lahir' => '2012-06-22',
            ],
            [
                'nama' => 'MUH. RAIHAN. MR',
                'kelas' => 'Kelas 9A',
                'tanggal_lahir' => '2012-08-12',
            ],
            [
                'nama' => 'MUH. ZAHY MAKARIM NASMAR',
                'kelas' => 'Kelas 9A',
                'tanggal_lahir' => '2012-03-13',
            ],
            [
                'nama' => 'Muhammad Alif',
                'kelas' => 'Kelas 9A',
                'tanggal_lahir' => '2011-09-21',
            ],
            [
                'nama' => 'MUHAMMAD ARFAN',
                'kelas' => 'Kelas 9A',
                'tanggal_lahir' => '2011-07-19',
            ],
            [
                'nama' => 'MUHAMMAD FAIZ',
                'kelas' => 'Kelas 9A',
                'tanggal_lahir' => '2012-03-01',
            ],
            [
                'nama' => 'MUHAMMAD ILZAM',
                'kelas' => 'Kelas 9A',
                'tanggal_lahir' => '2011-12-11',
            ],
            [
                'nama' => 'RAMIS AMIR',
                'kelas' => 'Kelas 9A',
                'tanggal_lahir' => '2010-11-27',
            ],
            [
                'nama' => 'AHMAD FAUZAN',
                'kelas' => 'Kelas 9A',
                'tanggal_lahir' => '2012-07-01',
            ],
            [
                'nama' => 'AISYAH AQILAH',
                'kelas' => 'Kelas 9B',
                'tanggal_lahir' => '2012-04-07',
            ],
            [
                'nama' => 'ALYA KHARISA',
                'kelas' => 'Kelas 9B',
                'tanggal_lahir' => '2012-04-27',
            ],
            [
                'nama' => 'ANDI ATIKA NR',
                'kelas' => 'Kelas 9B',
                'tanggal_lahir' => '2012-02-28',
            ],
            [
                'nama' => 'ANDI BESSE CHAYRA. H',
                'kelas' => 'Kelas 9B',
                'tanggal_lahir' => '2012-04-14',
            ],
            [
                'nama' => 'ANDI LIYANA ZAHIRAH',
                'kelas' => 'Kelas 9B',
                'tanggal_lahir' => '2012-08-21',
            ],
            [
                'nama' => 'ANDI NUR ANIQAH',
                'kelas' => 'Kelas 9B',
                'tanggal_lahir' => '2011-11-26',
            ],
            [
                'nama' => 'AZAHRAH SAIFUL',
                'kelas' => 'Kelas 9B',
                'tanggal_lahir' => '2012-04-14',
            ],
            [
                'nama' => 'DWI NAISHYLA POETRI',
                'kelas' => 'Kelas 9B',
                'tanggal_lahir' => '2011-03-27',
            ],
            [
                'nama' => 'DYANDA SAFANA BALQIS',
                'kelas' => 'Kelas 9B',
                'tanggal_lahir' => '2011-12-17',
            ],
            [
                'nama' => 'FATIMAH SYALWA AZ ZAHRAH',
                'kelas' => 'Kelas 9B',
                'tanggal_lahir' => '2011-09-11',
            ],
            [
                'nama' => 'Khalilah Chantika',
                'kelas' => 'Kelas 9B',
                'tanggal_lahir' => '2011-11-11',
            ],
            [
                'nama' => 'NAILA KAIYASAH PUTRI ILHAM',
                'kelas' => 'Kelas 9B',
                'tanggal_lahir' => '2011-12-17',
            ],
            [
                'nama' => 'NAYLA PUTRI',
                'kelas' => 'Kelas 9B',
                'tanggal_lahir' => '2012-03-31',
            ],
            [
                'nama' => 'NINDITA AMELIA ARDININGRUM',
                'kelas' => 'Kelas 9B',
                'tanggal_lahir' => '2012-01-14',
            ],
            [
                'nama' => 'NUR AFIFAH ADNAN',
                'kelas' => 'Kelas 9B',
                'tanggal_lahir' => '2011-09-09',
            ],
            [
                'nama' => 'Nur Fadillah',
                'kelas' => 'Kelas 9B',
                'tanggal_lahir' => '2012-05-19',
            ],
            [
                'nama' => 'NUR SAKINA IBRAHIM',
                'kelas' => 'Kelas 9B',
                'tanggal_lahir' => '2012-03-29',
            ],
            [
                'nama' => 'OCXEL ALZENA JAZLYN',
                'kelas' => 'Kelas 9B',
                'tanggal_lahir' => '2011-06-16',
            ],
            [
                'nama' => 'RATU AFIQAH BASRI',
                'kelas' => 'Kelas 9B',
                'tanggal_lahir' => '2012-05-17',
            ],
            [
                'nama' => 'RAYATUL HIDAYAH',
                'kelas' => 'Kelas 9B',
                'tanggal_lahir' => '2012-01-29',
            ],
            [
                'nama' => 'SITTI AISYAH IMAM',
                'kelas' => 'Kelas 9B',
                'tanggal_lahir' => '2011-09-20',
            ],
            [
                'nama' => 'Ummi Kalsum',
                'kelas' => 'Kelas 9B',
                'tanggal_lahir' => '2011-07-23',
            ],
            [
                'nama' => 'ZALFA MAZAYA ARIS',
                'kelas' => 'Kelas 9B',
                'tanggal_lahir' => '2011-09-27',
            ],
        ];

        $kelasMap = [];

        foreach (collect($dataSiswa)->pluck('kelas')->unique() as $namaKelas) {
            $kelasMap[$namaKelas] = Kelas::firstOrCreate([
                'nama_kelas' => $namaKelas,
            ])->id;
        }

        foreach ($dataSiswa as $data) {
            // Karena tabel siswa saat ini tidak mempunyai NIS/NISN,
            // nama digunakan sebagai identifier. Pada file sumber tidak ada nama duplikat.
            $siswa = Siswa::firstOrNew([
                'nama' => $data['nama'],
            ]);

            $siswa->kelas_id = $kelasMap[$data['kelas']];
            $siswa->tanggal_lahir = $data['tanggal_lahir'];

            // Hanya siswa baru yang diberi score awal 0.
            if (! $siswa->exists) {
                $siswa->score_bk = 0;
            }

            $siswa->save();
        }

        $this->command?->info('SiswaSeeder selesai: '.count($dataSiswa).' siswa diproses.');
    }
}