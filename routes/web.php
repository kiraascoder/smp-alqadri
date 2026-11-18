<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BeritaController;
use App\Models\Berita;
use App\Models\Pengumuman;
use App\Models\SchoolPosition;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KebajikanController;
use App\Http\Controllers\OrangTuaController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\PWAController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\SchoolStructureController;
use App\Http\Controllers\SesiController;
use Illuminate\Support\Facades\Route;

/* --------------------------------------------------------------------------
 | PUBLIC
 * -------------------------------------------------------------------------- */
// Homepage beserta tiga berita terbaru yang sudah diterbitkan.
Route::get('/', function () {
    $beritaTerbaru = Berita::published()
        ->orderByDesc('published_at')
        ->orderByDesc('id')
        ->limit(3)
        ->get();

    $leaders = SchoolPosition::query()
        ->where('is_active', true)
        ->where('show_homepage', true)
        ->with(['members' => function ($query) {
            $query->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('id');
        }])
        ->orderBy('sort_order')
        ->orderBy('id')
        ->limit(4)
        ->get();

    // Tiga pengumuman aktif dan terbaru; yang penting berada paling atas.
    $pengumumanTerbaru = Pengumuman::visible()
        ->orderByDesc('is_pinned')
        ->orderByDesc('published_at')
        ->orderByDesc('id')
        ->limit(3)
        ->get();

    return view('welcome', compact('beritaTerbaru', 'leaders', 'pengumumanTerbaru'));
})->name('home');
// Pengumuman publik: nama route lama tetap 'pengumuman' agar menu tidak rusak.
Route::get('/pengumuman', [PengumumanController::class, 'publicIndex'])
    ->name('pengumuman');
Route::get('/pengumuman/{pengumuman:slug}', [PengumumanController::class, 'publicShow'])
    ->name('pengumuman.show');
Route::view('/tentang', 'tentang')->name('tentang');
Route::view('/layanan', 'layanan')->name('layanan');

// BERITA PUBLIK
Route::get('/berita', [BeritaController::class, 'publicIndex'])
    ->name('berita.index');
Route::get('/berita/{berita:slug}', [BeritaController::class, 'publicShow'])
    ->name('berita.show');

// Struktur organisasi dapat dilihat tanpa login.
Route::get('/struktur-organisasi', [SchoolStructureController::class, 'publicIndex'])
    ->name('struktur.index');

/* --------------------------------------------------------------------------
 | AUTHENTICATION
 * -------------------------------------------------------------------------- */
Route::get('/login', [SesiController::class, 'LoginView'])->name('login');
Route::post('/login', [SesiController::class, 'login'])->name('login.submit');

// Login orang tua dengan OTP WhatsApp masih dinonaktifkan.
// Orang tua menggunakan email dan password melalui /login.

/* --------------------------------------------------------------------------
 | FORGOT PASSWORD
 * -------------------------------------------------------------------------- */
Route::get('/lupa-password', [ForgotPasswordController::class, 'requestForm'])
    ->name('password.request');
Route::post('/lupa-password', [ForgotPasswordController::class, 'sendResetLink'])
    ->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'resetForm'])
    ->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])
    ->name('password.update');

/* --------------------------------------------------------------------------
 | LOGOUT
 * -------------------------------------------------------------------------- */
// GET /logout hanya mengarahkan kembali, tidak membuat sesi logout.
Route::get('/logout', function () {
    if (! auth()->check()) {
        return redirect()->route('login');
    }

    return match (auth()->user()->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'guru' => redirect()->route('guru.dashboard'),
        'orang_tua' => redirect()->route('ortu.dashboard'),
        default => redirect()->route('home'),
    };
})->name('logout.redirect');

// Logout sebenarnya hanya memakai POST.
Route::post('/logout', [SesiController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/* --------------------------------------------------------------------------
 | ADMIN
 * -------------------------------------------------------------------------- */
Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'index'])
            ->name('admin.dashboard');

        // Penilaian pelanggaran
        Route::get('/penilaian-pelanggaran', [AdminController::class, 'penilaianPelanggaran'])
            ->name('admin.penilaian-pelanggaran');
        Route::patch('/penilaian-pelanggaran/{riwayat}', [AdminController::class, 'beriPoinPelanggaran'])
            ->name('admin.penilaian-pelanggaran.update');

        // Penilaian kebajikan
        Route::get('/penilaian-kebajikan', [AdminController::class, 'penilaianKebajikan'])
            ->name('admin.penilaian-kebajikan');
        Route::patch('/penilaian-kebajikan/{riwayat}', [AdminController::class, 'beriPoinKebajikan'])
            ->name('admin.penilaian-kebajikan.update');

        // Struktur Organisasi Sekolah
        Route::get('/struktur-organisasi', [SchoolStructureController::class, 'adminIndex'])
            ->name('admin.struktur.index');
        Route::post('/struktur-organisasi/jabatan', [SchoolStructureController::class, 'storePosition'])
            ->name('admin.struktur.positions.store');
        Route::put('/struktur-organisasi/jabatan/{position}', [SchoolStructureController::class, 'updatePosition'])
            ->name('admin.struktur.positions.update');
        Route::delete('/struktur-organisasi/jabatan/{position}', [SchoolStructureController::class, 'destroyPosition'])
            ->name('admin.struktur.positions.destroy');
        Route::post('/struktur-organisasi/personel', [SchoolStructureController::class, 'storeMember'])
            ->name('admin.struktur.members.store');
        Route::put('/struktur-organisasi/personel/{member}', [SchoolStructureController::class, 'updateMember'])
            ->name('admin.struktur.members.update');
        Route::delete('/struktur-organisasi/personel/{member}', [SchoolStructureController::class, 'destroyMember'])
            ->name('admin.struktur.members.destroy');

        /*
        |--------------------------------------------------------------------------
        | PENGUMUMAN SEKOLAH - ADMIN
        |--------------------------------------------------------------------------
        */
        Route::get('/pengumuman', [PengumumanController::class, 'adminIndex'])
            ->name('admin.pengumuman.index');
        Route::get('/pengumuman/tambah', [PengumumanController::class, 'create'])
            ->name('admin.pengumuman.create');
        Route::post('/pengumuman', [PengumumanController::class, 'store'])
            ->name('admin.pengumuman.store');
        Route::get('/pengumuman/{pengumuman}/edit', [PengumumanController::class, 'edit'])
            ->name('admin.pengumuman.edit');
        Route::put('/pengumuman/{pengumuman}', [PengumumanController::class, 'update'])
            ->name('admin.pengumuman.update');
        Route::delete('/pengumuman/{pengumuman}', [PengumumanController::class, 'destroy'])
            ->name('admin.pengumuman.destroy');

        /*
        |--------------------------------------------------------------------------
        | BERITA SEKOLAH - ADMIN
        |--------------------------------------------------------------------------
        */
        Route::get('/berita', [BeritaController::class, 'adminIndex'])
            ->name('admin.berita.index');
        Route::get('/berita/tambah', [BeritaController::class, 'create'])
            ->name('admin.berita.create');
        Route::post('/berita', [BeritaController::class, 'store'])
            ->name('admin.berita.store');
        Route::get('/berita/{berita}/edit', [BeritaController::class, 'edit'])
            ->name('admin.berita.edit');
        Route::put('/berita/{berita}', [BeritaController::class, 'update'])
            ->name('admin.berita.update');
        Route::delete('/berita/{berita}', [BeritaController::class, 'destroy'])
            ->name('admin.berita.destroy');


        // Guru
        Route::get('/guru', [AdminController::class, 'guru'])->name('admin.guru');
        Route::post('/guru', [AdminController::class, 'storeGuru'])->name('admin-guru.tambah');
        Route::put('/guru/{id}', [AdminController::class, 'editGuru'])->name('admin-guru.edit');
        Route::delete('/guru/{id}', [AdminController::class, 'destroyGuru'])->name('admin.guru.delete');

        // Kelas
        Route::get('/kelas', [AdminController::class, 'kelas'])->name('admin.kelas');
        Route::post('/kelas', [AdminController::class, 'storeKelas'])->name('admin.kelas.store');
        Route::put('/kelas/{kelas}', [AdminController::class, 'updateKelas'])->name('admin.kelas.update');
        Route::delete('/kelas/{kelas}', [AdminController::class, 'destroyKelas'])->name('admin.kelas.delete');

        // Siswa
        Route::get('/siswa', [AdminController::class, 'siswa'])->name('admin.siswa');
        Route::post('/siswa', [AdminController::class, 'storeSiswa'])->name('admin.siswa.register');
        Route::put('/siswa/{id}', [AdminController::class, 'updateSiswa'])->name('admin.siswa.update');
        Route::delete('/siswa/{id}', [AdminController::class, 'destroySiswa'])->name('admin.siswa.delete');

        // Orang Tua
        Route::get('/orang-tua', [AdminController::class, 'orangTua'])->name('admin.orang');
        Route::post('/orang-tua', [AdminController::class, 'registerOrtu'])->name('admin.orang.register');
        Route::delete('/orang-tua/{id}', [AdminController::class, 'destroyOrangTua'])->name('admin.orang.delete');

        // Master Pelanggaran
        Route::get('/pelanggaran', [AdminController::class, 'pelanggaran'])->name('admin.pelanggaran');
        Route::post('/pelanggaran', [PelanggaranController::class, 'store'])->name('admin.pelanggaran.store');
        Route::put('/pelanggaran/{pelanggaran}', [PelanggaranController::class, 'update'])
            ->name('admin.pelanggaran.update');
        Route::delete('/pelanggaran/{pelanggaran}', [PelanggaranController::class, 'destroy'])
            ->name('admin.pelanggaran.delete');

        // Master Kebajikan
        Route::get('/kebajikan', [KebajikanController::class, 'index'])->name('admin.kebajikan');
        Route::post('/kebajikan', [KebajikanController::class, 'store'])->name('admin.kebajikan.store');
        Route::put('/kebajikan/{kebajikan}', [KebajikanController::class, 'update'])
            ->name('admin.kebajikan.update');
        Route::delete('/kebajikan/{kebajikan}', [KebajikanController::class, 'destroy'])
            ->name('admin.kebajikan.delete');

        // Pemberian Poin Kebajikan
        Route::get('/poin-kebajikan', [AdminController::class, 'poinKebajikan'])
            ->name('admin.poin-kebajikan');
        Route::post('/poin-kebajikan', [AdminController::class, 'beriKebajikan'])
            ->name('admin.poin-kebajikan.store');
        Route::delete('/poin-kebajikan/{riwayat}', [AdminController::class, 'hapusKebajikan'])
            ->name('admin.poin-kebajikan.delete');

        // Skorsing
        Route::get('/skorsing', [AdminController::class, 'skorsing'])->name('admin.skorsing');
        Route::post('/skorsing', [AdminController::class, 'tambahSkorsing'])->name('admin.skorsing.store');
        Route::get('/skorsing/{id}', [AdminController::class, 'detailSkorsing'])
            ->name('admin.skorsing.detail');
        Route::delete('/skorsing/{id}', [AdminController::class, 'destroySkorsing'])
            ->name('admin.skorsing.delete');

        // Rekap Skorsing
        Route::get('/rekap-skorsing', [AdminController::class, 'rekapSkorsing'])
            ->name('admin.rekap-skorsing');
        Route::get('/rekap-skorsing/pdf', [AdminController::class, 'rekapSkorsingPdf'])
            ->name('admin.rekap-skorsing.pdf');

        // Rekap Kebajikan
        Route::get('/rekap-kebajikan', [AdminController::class, 'rekapKebajikan'])
            ->name('admin.rekap-kebajikan');
        Route::get('/rekap-kebajikan/pdf', [AdminController::class, 'rekapKebajikanPdf'])
            ->name('admin.rekap-kebajikan.pdf');
    });

/* --------------------------------------------------------------------------
 | GURU
 * -------------------------------------------------------------------------- */
Route::prefix('guru')
    ->middleware(['auth', 'role:guru'])
    ->group(function () {
        Route::get('/dashboard', [GuruController::class, 'index'])->name('guru.dashboard');
        Route::get('/profil', [GuruController::class, 'profil'])->name('guru.profil');
        Route::put('/profil', [GuruController::class, 'edit'])->name('guru.edit');
        Route::put('/profil/password', [GuruController::class, 'updatePassword'])
            ->name('guru.password.update');

        Route::get('/jenis-pelanggaran', [GuruController::class, 'pelanggaran'])
            ->name('guru.pelanggaran');
        Route::get('/skorsing', [GuruController::class, 'skorsing'])->name('guru.skorsing');
        Route::post('/skorsing', [GuruController::class, 'tambahSkorsing'])
            ->name('guru.skorsing.store');
        Route::get('/skorsing/{id}', [GuruController::class, 'detailSkorsing'])
            ->name('guru.skorsing.detail');
        Route::delete('/skorsing/{id}', [GuruController::class, 'destroySkorsing'])
            ->name('guru.skorsing.delete');

        Route::get('/kebajikan', [KebajikanController::class, 'guruIndex'])
            ->name('guru.kebajikan');
        Route::post('/kebajikan', [KebajikanController::class, 'beriPoin'])
            ->name('guru.kebajikan.store');
        Route::delete('/kebajikan/{riwayat}', [KebajikanController::class, 'hapusRiwayat'])
            ->name('guru.kebajikan.delete');
    });

/* --------------------------------------------------------------------------
 | ORANG TUA
 * -------------------------------------------------------------------------- */
Route::prefix('orang-tua')
    ->middleware(['auth', 'role:orang_tua'])
    ->group(function () {
        Route::get('/dashboard', [OrangTuaController::class, 'dashboard'])->name('ortu.dashboard');
        Route::get('/profil', [OrangTuaController::class, 'profil'])->name('ortu.profil');
        Route::put('/profil', [OrangTuaController::class, 'updateProfil'])
            ->name('ortu.profil.update');
        Route::put('/profil/password', [OrangTuaController::class, 'updatePassword'])
            ->name('ortu.password.update');
        Route::get('/jenis-pelanggaran', [OrangTuaController::class, 'pelanggaran'])
            ->name('ortu.pelanggaran');
        Route::get('/kebajikan', [OrangTuaController::class, 'kebajikan'])
            ->name('ortu.kebajikan');
    });

/* --------------------------------------------------------------------------
 | PWA
 * -------------------------------------------------------------------------- */
Route::get('/manifest.json', [PWAController::class, 'manifest'])
    ->name('pwa.manifest');

Route::get('/serviceworker.js', function () {
    $path = public_path('serviceworker.js');
    abort_unless(file_exists($path), 404);

    return response(file_get_contents($path), 200, [
        'Content-Type' => 'application/javascript',
        'Cache-Control' => 'no-cache, no-store, must-revalidate',
        'Service-Worker-Allowed' => '/',
    ]);
})->name('pwa.serviceworker');

Route::view('/offline.html', 'pwa.offline')->name('pwa.offline');
Route::view('/pwa/install', 'pwa.install')->name('pwa.install');

/* --------------------------------------------------------------------------
 | FALLBACK
 * -------------------------------------------------------------------------- */
Route::fallback(function () {
    abort(404);
});
