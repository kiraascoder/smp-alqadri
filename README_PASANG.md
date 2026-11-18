# Homepage baru SMP Al-Qadri — Jumbotron, Berita & Struktur Organisasi

Paket ini mengganti **tampilan halaman Beranda** saja. Tidak mengubah data dan tidak menambah tabel.

## Isi
- `resources/views/welcome.blade.php` — halaman homepage baru lengkap.
- `docs/PATCH_ROUTE_HOME.php` — kode untuk mengganti *hanya* route GET `/` dalam `routes/web.php`.

## Cara memasang
1. Backup dahulu `resources/views/welcome.blade.php` dan `routes/web.php`.
2. Salin `resources/views/welcome.blade.php` dari paket ke project.
3. Buka `routes/web.php`. Pastikan terdapat import `App\Models\Berita` dan `App\Models\SchoolPosition`.
4. **Ganti** route homepage sebelumnya (`Route::view('/', 'welcome')` atau `Route::get('/', ...)`) dengan kode di `docs/PATCH_ROUTE_HOME.php`. Jangan menduplikasi route `/`.
5. Pastikan route `berita.index`, `berita.show` dan `struktur.index` telah terpasang; juga migration `berita`, `school_positions` dan `school_position_members` telah sukses.
6. Unggah tiga foto sekolah dengan nama persis:
   - `public/images/slider/slide-1.jpg`
   - `public/images/slider/slide-2.jpg`
   - `public/images/slider/slide-3.jpg`
   Gunakan foto horizontal sekitar **1920×900 px**, dioptimasi agar ringan (sekitar 200–500 KB jika memungkinkan). Foto tidak disertakan dalam ZIP, karena harus menggunakan dokumentasi asli sekolah. Jika foto belum ada, slideshow tetap tampil memakai gradasi hijau.
7. Untuk menampilkan personel di homepage, buka `/admin/struktur-organisasi`: aktifkan `Publikasikan` dan `Homepage` untuk jabatan, aktifkan `Publikasikan` untuk personel. Maksimal empat jabatan tampil di homepage; halaman `/struktur-organisasi` tetap memuat struktur lengkap.
8. Agar berita muncul, admin harus membuat berita dengan status **Terbit**, dan tanggal publikasinya tidak berada di masa depan. Homepage menampilkan tiga terbaru.
9. Jalankan:
   ```bash
   php artisan optimize:clear
   php artisan route:list --name=home
   php artisan route:list --name=berita
   php artisan route:list --name=struktur
   php artisan view:cache
   ```
   Jika ingin mengedit view lagi dalam development, gunakan `php artisan view:clear`.
10. Uji di browser pada desktop dan mobile: slider, tombol navigasi, route, foto berita, personel, dan login.

## Catatan penting
- Jangan jalankan `migrate:fresh` pada server production.
- Foto berita/personel memakai disk Laravel `public`. Pastikan `php artisan storage:link` pernah dijalankan dan folder `storage` bisa diakses publik.
- Jika menggunakan Tailwind CDN pada website lama, paket ini mengikuti pendekatan tersebut agar langsung kompatibel. Untuk production yang lebih optimal, pindahkan kelas yang digunakan ke build Tailwind/Vite sebelum menghapus CDN.
- Perhatikan izin publikasi foto/nama peserta didik pada berita.
- Paket tidak menyediakan pengelolaan slider melalui admin: gambar slider diatur dengan mengganti tiga file di `public/images/slider`.
- Jika website memakai service worker PWA, versi cache lama dapat menunda tampilan homepage baru. Perbarui strategi cache saat deployment jika perlu.
