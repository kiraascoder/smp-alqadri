# Modul Berita Sekolah — SMP Al-Qadri (Laravel 12)

## Fitur
- Kelola berita oleh admin (tambah, ubah, hapus, cari/filter, status draft atau terbit)
- Upload dan hapus foto sampul JPG/PNG/WEBP, maksimal 3 MB
- Slug otomatis, stabil walaupun judul kemudian diperbarui
- Berita publik hanya terlihat jika telah diterbitkan
- Halaman daftar `/berita`, detail `/berita/{slug}` dan 3 berita terbaru pada homepage
- Tidak mengubah tabel siswa, pelanggaran, kebajikan, struktur organisasi
- Input isi berita berupa teks biasa (tidak menerima HTML aktif), mencegah XSS

## Langkah memasang di PC development

1. Backup database dan buat branch Git baru, misalnya `git checkout -b fitur-berita`.
2. Salin isi folder `app`, `database`, dan `resources/views` dari ZIP ke project Laravel dengan struktur folder sama.
3. **File `routes/web.php` dalam ZIP adalah versi lengkap berdasarkan web.php yang Anda kirim pada percakapan sebelumnya.** Bandingkan dengan file web.php Anda saat ini, kemudian gabungkan perubahan daripada menimpa perubahan lokal yang lebih baru.
4. Pada `resources/views/components/sidebar.blade.php`, di dalam blok role admin, tambahkan kode dari `PATCH_SIDEBAR.blade.php` (satu kali saja).
5. Jalankan `php artisan migrate` lalu `php artisan storage:link` (jika symlink belum dibuat).
6. Jalankan `php artisan optimize:clear` dan `php artisan route:list --path=berita`.
7. Uji `/admin/berita`, buat berita Draft, pastikan tidak muncul di `/berita`. Ubah ke Terbit, pastikan muncul.
8. Agar ada 3 berita terbaru di homepage, masukkan kode `PATCH_HOMEPAGE.blade.php` ke `resources/views/welcome.blade.php` sebelum footer. **Pastikan route `/` telah memakai closure dari routes/web.php paket** agar variabel `$beritaTerbaru` tersedia.
9. Tambahkan menu `Berita` ke navbar desktop dan mobile pada `welcome.blade.php` sesuai penempatan yang Anda inginkan:
   `<a href="{{ route('berita.index') }}">Berita</a>`.

## Perhatian untuk server production
- Backup dahulu, deploy file kode dan jalankan migration standar `php artisan migrate --force` setelah memeriksa perubahannya; JANGAN `migrate:fresh`.
- Pastikan `APP_URL` dan disk `public` pada `config/filesystems.php` benar. Foto diakses melalui `public/storage`.
- Jalankan `php artisan storage:link` satu kali; di shared hosting yang membatasi symlink, konfigurasi lokasi public storage harus disesuaikan.
- Form admin hanya bisa diakses role admin jika route tetap berada dalam grup `auth` dan `role:admin`.
- Jika Anda sudah menambahkan fitur lain pada `routes/web.php` sejak file terakhir, **merge** perubahannya; jangan timpa langsung.
- Bila konten berita perlu bold, heading, atau galeri, bisa ditambahkan editor visual setelah modul dasar stabil; saat ini isi memakai teks biasa untuk menghindari HTML tak aman.

## Daftar file inti
- database/migrations/2026_11_19_000000_create_berita_table.php
- app/Models/Berita.php
- app/Http/Controllers/BeritaController.php
- resources/views/admin/berita/index.blade.php
- resources/views/admin/berita/form.blade.php
- resources/views/berita/layout.blade.php
- resources/views/berita/index.blade.php
- resources/views/berita/show.blade.php
- resources/views/berita/_card.blade.php
- routes/web.php
- PATCH_SIDEBAR.blade.php
- PATCH_HOMEPAGE.blade.php
