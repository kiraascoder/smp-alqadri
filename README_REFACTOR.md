# Refactor SMP Al-Qadri

Paket overlay untuk repository `kiraascoder/smp-alqadri`, disusun berdasarkan struktur `main` yang diperiksa pada 9 Agustus 2026.

## Isi refactor

- UI guru dibuat konsisten dengan layout `components.admin`.
- Halaman profil guru dirapikan dan ditambah fitur ganti password.
- Halaman skorsing guru disederhanakan dan dibuat konsisten.
- Master pelanggaran dinormalisasi menjadi `Ringan`, `Sedang`, `Sangat Berat` dengan field `skor`.
- Seeder 47 jenis pelanggaran resmi.
- Sistem poin kebajikan:
  - master `kebajikans`
  - 38 data kebajikan resmi
  - riwayat pemberian poin kebajikan
  - guru hanya melihat/menghapus riwayat kebajikan yang dibuat sendiri
  - skor riwayat disimpan sebagai snapshot agar perubahan skor master tidak mengubah histori
- Seeder dummy guru, siswa, dan orang tua untuk local/testing.
- Sidebar dirapikan dan ditambah menu Jenis Kebajikan/Poin Kebajikan.
- Riwayat pelanggaran ditambah `skor` snapshot dan `created_by`.

## PENTING sebelum menyalin

Paket ini adalah **overlay**, bukan full repository. Ekstrak/copy isinya ke root project Laravel.

Jika ada perubahan lokal yang belum di-push ke GitHub, backup atau commit dahulu karena beberapa file dalam paket ini menggantikan file dengan path yang sama, terutama:

- `routes/web.php`
- `app/Http/Controllers/GuruController.php`
- `app/Http/Controllers/PelanggaranController.php`
- `app/Models/User.php`
- `app/Models/Siswa.php`
- `resources/views/components/sidebar.blade.php`
- view guru/admin terkait

Disarankan:

```bash
git add .
git commit -m "backup before kebajikan refactor"
```

Lalu salin isi ZIP ke root project.

## Instalasi

Setelah semua file tersalin:

```bash
php artisan optimize:clear
php artisan migrate
php artisan db:seed --class=PelanggaranSeeder
php artisan db:seed --class=KebajikanSeeder
```

JANGAN gunakan:

```bash
php artisan migrate:fresh
php artisan db:wipe
```

karena perintah tersebut menghapus data database.

## Seeder dummy

Seeder dummy sengaja diberi nama terpisah agar tidak menimpa `GuruSeeder` / `SiswaSeeder` resmi yang mungkin sudah ada pada project.

Untuk local/testing:

```bash
php artisan db:seed --class=DummyOrangTuaSeeder
php artisan db:seed --class=DummyGuruSeeder
php artisan db:seed --class=DummySiswaSeeder
```

Password akun dummy:

```text
password123
```

Contoh akun:

```text
guru.demo1@smpalqadri.sch.id
guru.demo2@smpalqadri.sch.id

ortu.demo1@smpalqadri.sch.id
ortu.demo2@smpalqadri.sch.id

siswa.demo1@smpalqadri.sch.id
siswa.demo2@smpalqadri.sch.id
siswa.demo3@smpalqadri.sch.id
siswa.demo4@smpalqadri.sch.id
```

`firstOrCreate()` digunakan pada akun dummy supaya menjalankan seeder ulang tidak mereset password akun yang sudah ada.

## Ganti password guru

Route baru:

```text
PUT /guru/profil/password
guru.password.update
```

Validasi:

- password saat ini wajib benar
- password baru minimal 8 karakter
- konfirmasi harus cocok
- password baru tidak boleh sama dengan password lama

Model `User` tetap menggunakan cast Laravel `password => hashed`.

## Pelanggaran

Master yang digunakan:

```text
pelanggarans
- id
- kategori
- deskripsi
- skor
- created_at
- updated_at
```

Migration `2026_08_09_220000_normalize_pelanggarans_table.php` menangani schema lama repository yang masih menggunakan:

```text
kategori enum(ringan, sedang, berat)
pengurangan_score
```

Kategori setelah refactor:

```text
Ringan
Sedang
Sangat Berat
```

Seeder resmi:

```text
13 Ringan
19 Sedang
15 Sangat Berat
47 Total
```

## Kebajikan

Master:

```text
kebajikans
- id
- deskripsi
- skor
- timestamps
```

Riwayat:

```text
riwayat_kebajikan
- id
- siswa_id
- kebajikan_id
- created_by
- tanggal
- skor
- keterangan
- timestamps
```

`skor` pada riwayat adalah snapshot. Misalnya master awal +5 kemudian diubah menjadi +10, riwayat lama tetap +5.

## Poin pelanggaran dan kebajikan

Kebajikan tidak langsung mengubah `score_bk`. Poin positif disimpan terpisah pada `riwayat_kebajikan` agar histori tidak hilang.

Contoh total kebajikan siswa:

```php
$siswa = Siswa::withSum('riwayatKebajikan as total_kebajikan', 'skor')->find($id);
```

Dengan desain ini aplikasi tetap dapat menampilkan:

```text
Poin Pelanggaran : 20
Poin Kebajikan   : +35
```

Tanpa kehilangan rincian masing-masing histori.

## Route baru utama

```text
Admin
GET    /admin/kebajikan
POST   /admin/kebajikan
PUT    /admin/kebajikan/{kebajikan}
DELETE /admin/kebajikan/{kebajikan}

Guru
PUT    /guru/profil/password
GET    /guru/kebajikan
POST   /guru/kebajikan
DELETE /guru/kebajikan/{riwayat}
```

## Verifikasi setelah pemasangan

Jalankan:

```bash
php artisan optimize:clear
php artisan route:list
php artisan migrate:status
```

Pastikan route berikut muncul:

```text
guru.password.update
guru.kebajikan
guru.kebajikan.store
guru.kebajikan.delete
admin.kebajikan
admin.kebajikan.store
admin.kebajikan.update
admin.kebajikan.delete
```

Kemudian tes manual:

1. Login guru.
2. Buka Profil dan ganti password.
3. Logout dan login menggunakan password baru.
4. Buka Skorsing dan tambah satu pelanggaran.
5. Buka Poin Kebajikan dan berikan satu poin kebajikan.
6. Pastikan guru hanya melihat histori yang dibuat sendiri.
7. Login admin dan buka Jenis Pelanggaran serta Jenis Kebajikan.

## File yang sengaja tidak diganti

`GuruSeeder.php` dan `SiswaSeeder.php` resmi yang mungkin sudah berisi dataset sekolah **tidak ditimpa**. Paket menggunakan `DummyGuruSeeder` dan `DummySiswaSeeder` untuk data testing agar data resmi aman.
