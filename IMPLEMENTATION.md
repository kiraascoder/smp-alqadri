# SMP Al-Qadri — Refactor Role, Siswa, Orang Tua, dan Skorsing

Patch ini merombak aplikasi agar hanya mempunyai tiga role login:

- `admin`
- `guru`
- `orang_tua`

`Siswa` bukan akun dan tidak mempunyai email/password/login.

## Struktur data utama

```text
users
├── admin
├── guru ── 1:1 ── guru
└── orang_tua ── 1:1 ── orang_tua ── 1:N ── siswa
                                              │
                                              └── 1:N riwayat_pelanggaran

riwayat_pelanggaran.created_by ──> users.id
```

### `siswa`

- `nama`
- `kelas_id`
- `tanggal_lahir`
- `orang_tua_id` nullable
- `score_bk`

### `riwayat_pelanggaran`

- `siswa_id`
- `pelanggaran_id`
- `created_by`
- `skor` (snapshot skor saat skorsing dibuat)
- `tanggal`
- `keterangan`

Snapshot `skor` mencegah riwayat lama berubah jika bobot master pelanggaran diedit kemudian.

## Hak akses

### Admin

- Dashboard
- Master Kelas
- Guru
- Siswa
- Orang Tua
- Jenis Pelanggaran
- Skorsing
- Rekap Skorsing + filter tanggal/pembuat/kelas/siswa/pelanggaran

### Guru

- Dashboard
- Jenis Pelanggaran read-only
- Skorsing
- Profil

Guru tetap dapat memilih siswa saat membuat skorsing, tetapi tidak mempunyai halaman/sidebar Data Siswa. Riwayat skorsing Guru dibatasi di query dengan `created_by = auth()->id()`.

### Orang Tua

- Login
- Lupa/reset password
- Dashboard
- Jenis Pelanggaran read-only
- Anak
- Skorsing anak read-only

Semua query data Anak/Skorsing Orang Tua dibatasi melalui profil `orang_tua` milik user login.

## File lama yang dipensiunkan

Lihat `REMOVE_FILES.txt`. Termasuk controller/view/migration untuk role `siswa`, `guru_bk`, konseling/laporan lama, dan migration tambahan yang berbenturan dengan schema baru.

## Cara menerapkan

Dari root repo `smp-alqadri`, ekstrak folder patch ini lalu jalankan:

```bash
bash /path/ke/smp-alqadri-refactor/scripts/apply-refactor.sh /path/ke/repo/smp-alqadri
```

Atau copy manual isi folder `app`, `bootstrap`, `database`, `routes`, `resources`, dan `tests` ke repo, lalu hapus file pada `REMOVE_FILES.txt`.

Tambahkan ke `.env`:

```env
ADMIN_NAME="Administrator"
ADMIN_EMAIL="admin@domain-sekolah.sch.id"
ADMIN_PASSWORD="password-kuat-anda"
ADMIN_PHONE=""
```

Lalu:

```bash
php artisan optimize:clear
php artisan migrate:fresh --seed
php artisan storage:link
php artisan test --filter=RefactorAccessTest
```

Karena data lama memang tidak perlu dipertahankan, `migrate:fresh` adalah jalur yang ditujukan untuk refactor ini.

## Lupa password

Flow reset password sudah menggunakan password broker Laravel. Agar email reset benar-benar terkirim, konfigurasi `MAIL_*` dan `APP_URL` di `.env` harus valid.

## Smoke test manual

1. Login Admin dari akun hasil seeder.
2. Buat Master Kelas.
3. Buat minimal satu Guru.
4. Buat Siswa (tanpa akun/login).
5. Buat akun Orang Tua dan tautkan siswa.
6. Buat Jenis Pelanggaran.
7. Login Guru, buat Skorsing untuk siswa.
8. Pastikan Guru hanya melihat riwayat yang dia buat.
9. Login Orang Tua, pastikan hanya anak sendiri dan skorsing anak sendiri yang tampil.
10. Login Admin, buka Rekap Skorsing dan coba seluruh filter.
11. Ubah skor master pelanggaran; pastikan skor riwayat lama tetap menggunakan snapshot lama.
12. Uji Lupa Password setelah `MAIL_*` dikonfigurasi.

## Validasi yang sudah dilakukan pada patch

- `php -l` untuk seluruh file PHP non-Blade: lulus.
- Referensi method controller dari route: lulus.
- Referensi nama route pada view yang dibuat: lulus.
- Scan role lama `siswa` / `guru_bk` di patch aktif: tidak ditemukan.
- Feature test disediakan untuk isolasi role, isolasi skorsing Guru, privasi Orang Tua, dan pencatatan `created_by` + snapshot skor.

Full `php artisan test` belum dapat dijalankan di lingkungan pembuatan patch karena source repo lengkap tidak tersedia secara lokal; jalankan perintah test setelah patch diterapkan ke clone repo Anda.
