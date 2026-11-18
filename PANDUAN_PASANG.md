# Modul Pengumuman Sekolah — SMP Al-Qadri

Paket Laravel 12 yang terintegrasi dengan fitur **Berita**, **Struktur Organisasi** dan **Homepage V2**.

## Fitur

- Admin: tambah, cari, edit, hapus, filter status, draft/terbit, kategori, ringkasan, prioritas pengumuman penting, dan tanggal berakhir.
- Foto sampul opsional JPG/PNG/WEBP maksimal 3 MB.
- Lampiran PDF opsional maksimal 5 MB, tampil di halaman detail.
- Publik: daftar pengumuman aktif, pencarian/kategori, detail, prioritas penting di atas, pagination.
- Homepage V2: tiga pengumuman aktif terbaru, pengumuman penting diprioritaskan.
- Pengumuman draft/tidak terbit/kedaluwarsa tidak bisa dilihat publik (404 untuk detail).
- Tidak ada penjadwal / queue: memilih **Terbit** langsung memublikasikan sekarang. `expires_on` berakhir pada penutupan hari WITA.

## Isi paket utama

- `app/Models/Pengumuman.php`
- `app/Http/Controllers/PengumumanController.php`
- `database/migrations/2026_11_19_010000_create_pengumuman_sekolah_table.php`
- `resources/views/admin/pengumuman/index.blade.php`
- `resources/views/admin/pengumuman/form.blade.php`
- `resources/views/pengumuman/layout.blade.php`
- `resources/views/pengumuman/index.blade.php`
- `resources/views/pengumuman/show.blade.php`
- `resources/views/pengumuman/_card.blade.php`

## Integrasi (pilih satu cara)

**Cara A — aplikasi Anda masih sama dengan paket Homepage V2 + modul Berita/Struktur sebelumnya:**

1. Backup project dan database, buat Git branch.
2. Salin `app`, `database`, dan `resources/views/{admin/pengumuman,pengumuman}` dari paket ke project.
3. Ganti `routes/web.php` dengan `routes/web.php` dari paket **hanya jika tidak ada perubahan custom lain** yang belum digabung. File ini adalah versi lengkap turunan dari paket Homepage V2, sudah termasuk semua route lama.
4. Ganti `resources/views/welcome.blade.php` dengan versi paket untuk mendapatkan section pengumuman pada homepage.
5. Ganti `resources/views/components/sidebar.blade.php` jika sidebar Anda sama dengan yang sebelumnya dikirim. Menu Berita dan Struktur tetap ada.

**Cara B — aplikasi sudah mengalami perubahan lain:**

1. Salin sembilan file modul utama (model, controller, migration, view admin/publik) ke project.
2. Gabungkan route secara manual dari `docs/PATCH_ROUTES_ONLY.php`. **Hapus atau ganti** `Route::view('/pengumuman', 'pengumuman')` lama agar tidak ada route duplikat.
3. Tambahkan menu admin dari `docs/PATCH_SIDEBAR.blade.php`.
4. Gunakan section dan query `$pengumumanTerbaru` dari `resources/views/welcome.blade.php` paket. Jangan membuat route GET `/` kedua.

## Cara menjalankan

Dari root aplikasi Laravel:

```bash
php artisan migrate:status
php artisan migrate
php artisan storage:link
php artisan optimize:clear
php artisan route:list --path=pengumuman
```

Jika `storage:link` sudah pernah dibuat, Laravel dapat memberitahu bahwa link sudah ada. Itu normal. Bila hosting tidak mengizinkan symlink, perlu penyesuaian penyimpanan sesuai konfigurasi hosting.

**Jangan jalankan `migrate:fresh`, `migrate:refresh`, atau import SQL yang menimpa data production.** Migration ini hanya menambah tabel baru `pengumuman_sekolah` dan tidak mengubah `siswa`, `riwayat_pelanggaran`, `riwayat_kebajikan`, `berita`, atau tabel struktur organisasi.

## URL

| Halaman | URL | Route | Hak akses |
|---|---|---|---|
| Daftar pengumuman publik | `/pengumuman` | `pengumuman` | Publik |
| Detail pengumuman | `/pengumuman/{slug}` | `pengumuman.show` | Publik |
| Admin daftar | `/admin/pengumuman` | `admin.pengumuman.index` | Admin |
| Admin tambah | `/admin/pengumuman/tambah` | `admin.pengumuman.create` | Admin |
| Admin simpan | `POST /admin/pengumuman` | `admin.pengumuman.store` | Admin |
| Admin edit | `/admin/pengumuman/{id}/edit` | `admin.pengumuman.edit` | Admin |
| Admin update | `PUT /admin/pengumuman/{id}` | `admin.pengumuman.update` | Admin |
| Admin hapus | `DELETE /admin/pengumuman/{id}` | `admin.pengumuman.destroy` | Admin |

## Uji minimum sebelum production

1. Login admin, buka `/admin/pengumuman`. Tambahkan pengumuman **Draft**; cek tidak terlihat pada `/pengumuman` dan `/`.
2. Ubah menjadi **Terbit**; cek muncul di daftar, detail, dan homepage (jika salah satu dari tiga teratas).
3. Centang **Penting**; cek naik ke urutan paling atas.
4. Tambah tanggal berakhir kemarin; cek tidak tampil publik dan detail menghasilkan 404. Kembalikan tanggal berakhir ke masa depan.
5. Unggah foto dan PDF kecil; cek berkas dapat dibuka. Ganti/hapus, cek tidak muncul tautan lama.
6. Uji pencarian, filter, pagination serta menu sidebar pada mobile/desktop.
7. Uji data siswa, pelanggaran, kebajikan, berita, dan struktur organisasi tetap normal.

## Catatan

- File foto dan PDF disimpan di disk `public` dan **dapat diakses siapa saja yang memiliki URL berkas**. Jangan unggah dokumen privat atau data sensitif siswa.
- Pastikan izin publikasi untuk foto siswa.
- Isi pengumuman ditampilkan sebagai teks biasa (aman dari HTML pengguna) dan mendukung baris baru.
- Route publik `pengumuman` sengaja dipertahankan agar navbar, homepage, dan footer lama tetap bekerja.
- Aplikasi perlu PHP dan Laravel yang sudah menjalankan modul Berita serta Struktur Organisasi sebelum mengganti `routes/web.php` lengkap.
- Paket lolos pemeriksaan sintaks PHP secara statis, **belum dijalankan pada database dan aplikasi Laravel Anda**.
