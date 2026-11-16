# Modul Struktur Organisasi — SMP Al-Qadri Islamic School

Paket kode tambahan untuk repo https://github.com/kiraascoder/smp-alqadri. Tidak otomatis dipasang pada repo/server. Paket ini dibangun dari route dan Blade repo publik yang dicek pada 6 November 2026, serta gaya kode Laravel yang diberikan pengguna dalam percakapan.

## Fitur
- Admin mengelola jabatan/kelompok dan relasi induk-anak (hierarki tanpa batasan level kaku)
- Admin mengelola nama personel, gelar/keterangan singkat, foto opsional, urutan
- Satu jabatan bisa memiliki banyak personel; seorang personel dapat didaftarkan ke lebih dari satu jabatan
- Draft/publikasi per jabatan dan personel
- Admin memilih jabatan yang ditampilkan ringkas di homepage
- Halaman publik `/struktur-organisasi` berbentuk bagan yang dapat digeser horizontal
- Integrasi dengan homepage dan sidebar existing melalui potongan kode di `docs/`

## Cara pemasangan LOCAL / STAGING

1. Backup database saat ini. Disarankan buat branch Git baru.
2. Salin direktori `app`, `database`, dan `resources` dari paket ini ke akar project Laravel **tanpa menimpa file yang sudah ada** (file di paket baru).
3. Jalankan `php artisan migrate` (bukan `migrate:fresh`). Migration ini hanya membuat dua tabel baru.
4. Jalankan `php artisan storage:link` untuk foto (jika belum).
5. Terapkan route dari `docs/PATCH_ROUTES_WEB.md`.
6. Terapkan menu admin dari `docs/PATCH_SIDEBAR.md`.
7. Terapkan ringkasan homepage dari `docs/PATCH_HOMEPAGE.md` jika diperlukan; jalankan migration lebih dahulu sebelum mengganti route `/`.
8. **Opsional:** jalankan `php artisan db:seed --class=SchoolPositionSeeder` hanya jika ingin membuat daftar jabatan template. Seeder hanya membuat jabatan kosong, tidak menebak nama orang pada foto.
9. Jalankan `php artisan optimize:clear` dan `php artisan route:list --path=struktur-organisasi`.
10. Masuk sebagai admin, buka `/admin/struktur-organisasi`, isi personel dan publikasikan.

## Testing manual sebelum deploy
- Pengunjung tanpa login dapat membaca `/struktur-organisasi` namun tidak mengakses `/admin/struktur-organisasi`.
- Guru dan orang tua tidak bisa mengelola struktur.
- Admin dapat tambah/edit/hapus posisi dan personel; hapus posisi yang beranak harus ditolak.
- Pemindahan induk ke turunan diri sendiri harus ditolak.
- Tidak ada personel draft yang bocor ke halaman publik.
- Foto opsional tampil setelah `storage:link`; hapus/ganti foto bekerja.
- Urutan jabatan/personel konsisten. Tampilan desktop/mobile bisa scroll horizontal.
- Homepage tetap tampil tanpa jabatan, lalu menampilkan maksimal 4 jabatan yang dicentang homepage.
- Fitur skorsing, kebajikan, dan semua tabel siswa tidak terpengaruh.

## Catatan
- Ini adalah implementasi dasar yang sudah diperiksa dengan `php -l`, tetapi belum dijalankan pada aplikasi Laravel pengguna sehingga tetap harus diuji end-to-end di staging.
- Pengurutan memakai angka `sort_order`, bukan drag-and-drop. Drag-and-drop dapat menjadi fase berikutnya.
- Publikasikan nama/foto staf setelah mendapat persetujuan sekolah.
- Bagan top-level belum memiliki garis putus-putus relasi koordinatif seperti pada foto referensi, tetapi semua posisi dan garis hubungan hierarkis dapat diatur.
- Saat ini pemilih induk menampilkan semua jabatan dalam daftar biasa; siklus ditolak saat submit.
