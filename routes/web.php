<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BkController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KonselingController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminSesiController;

Route::get('/', function () {
    return view('welcome');
});

// Public Route

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pengumuman', function () {
    return view('pengumuman');
})->name('pengumuman');

Route::get('/tentang', function () {
    return view('tentang');
})->name('tentang');

Route::get('/layanan', function () {
    return view('layanan');
})->name('layanan');



// Admin Route
Route::prefix('admin')->middleware('admin:admin')->group(function () {
    Route::get('dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    // Guru Route
    Route::get('guru', [AdminController::class, 'guru'])->name('admin.guru');
    Route::post('guru-tambah', [AdminController::class, 'storeGuru'])->name('admin-guru.tambah');
    Route::put('guru/{id}/edit', [AdminController::class, 'editGuru'])->name('admin-guru.edit');
    Route::delete('guru/{id}/delete', [AdminController::class, 'destroyGuru'])->name('admin-guru.delete');

    // Siswa Route
    Route::get('siswa', [AdminController::class, 'siswa'])->name('admin.siswa');


    // BK Route
    Route::get('bk', [AdminController::class, 'bk'])->name('admin.bk');
    Route::post('bk-tambah', [AdminController::class, 'storeGuruBk'])->name('admin-bk.tambah');
    Route::put('bk/{id}/edit', [AdminController::class, 'editGuruBk'])->name('admin-bk.edit');
    Route::delete('bk/{id}/delete', [AdminController::class, 'destroyGuruBk'])->name('admin-bk.delete');



    Route::get('laporan', [AdminController::class, 'laporan'])->name('admin.laporan');
    Route::get('riwayat', [AdminController::class, 'riwayat'])->name('admin.riwayat');
    Route::get('pengaduan', [AdminController::class, 'pengaduan'])->name('admin.pengaduan');
    Route::get('pelanggaran', [AdminController::class, 'pelanggaran'])->name('admin.pelanggaran');
});

// Admin Login Route
Route::prefix('admin')->middleware('authenticated')->group(function () {
    Route::get('login', [AdminSesiController::class, 'adminLoginView'])->name('admin.login');
    Route::post('login', [SesiController::class, 'login'])->name('admin.login.submit');
});

// Auth Route
Route::middleware('authenticated')->group(function () {
    Route::get('login', [SesiController::class, 'LoginView'])->name('login');
    Route::post('login', [SesiController::class, 'login'])->name('login.submit');
    Route::get('register', [SesiController::class, 'registerView'])->name('register');
    Route::post('register', [SesiController::class, 'register'])->name('register.submit');
});



// Guru Route
Route::prefix('guru')->middleware('admin:guru')->group(function () {
    Route::get('/dashboard', [GuruController::class, 'index'])
        ->name('guru.dashboard');
    // Profil Guru
    Route::get('/profil', [GuruController::class, 'profil'])
        ->name('guru.profil');
    Route::put('/profil-guru/edit', [GuruController::class, 'edit'])
        ->name('guru.edit');
    // Lihat Siswa
    Route::get('/siswa', [GuruController::class, 'siswa'])
        ->name('guru.siswa');
    //  Skorsing
    Route::get('/skorsing', [GuruController::class, 'skorsing'])
        ->name('guru.skorsing');
    Route::post('/skorsing-tambah', [GuruController::class, 'tambahSkorsing'])
        ->name('skorsing.tambah');
    // Pelanggaran Siswa
    Route::get('/pelanggaran', [GuruController::class, 'pelanggaran'])
        ->name('guru.pelanggaran');
});
// Guru Bk Route
Route::prefix('bk')->middleware('admin:guru_bk')->group(function () {
    // Profile Route
    Route::get('/dashboard', [BkController::class, 'index'])
        ->name('bk.dashboard');
    Route::put('/profil-bk/edit', [BkController::class, 'edit'])
        ->name('bk.edit');
    Route::get('/profil', [BkController::class, 'profil'])
        ->name('bk.profil');
    Route::get('/pengaduan', [BkController::class, 'pengaduan'])
        ->name('bk.pengaduan');
    Route::get('/pelanggaran', [BkController::class, 'pelanggaran'])
        ->name('bk.pelanggaran');
    Route::get('/riwayat', [BkController::class, 'riwayat'])
        ->name('bk.riwayat');
    Route::get('/skorsing', [BkController::class, 'skorsing'])
        ->name('bk.skorsing');
    Route::get('/konseling', [BkController::class, 'konseling'])
        ->name('bk.konseling');
    Route::post('/konseling-tambah', [BkController::class, 'store'])
        ->name('konseling-Bktambah');
    Route::post('/konseling-hapus', [BkController::class, 'destroy'])
        ->name('konseling-Bkhapus');
});

// Siswa
Route::prefix('siswa')->middleware('admin:siswa')->group(function () {
    Route::get('/dashboard', [SiswaController::class, 'index'])
        ->name('siswa.dashboard');
    // Profil Siswa
    Route::get('/profil-siswa', [SiswaController::class, 'profil'])
        ->name('siswa.profil');
    Route::put('/profil-siswa/edit', [SiswaController::class, 'edit'])
        ->name('siswa.edit');
    // Konseling
    Route::get('/konseling', [KonselingController::class, 'index'])
        ->name('siswa.konseling');
    Route::post('/konseling-tambah', [KonselingController::class, 'store'])
        ->name('konseling.tambah');
    Route::delete('/{id}/konseling-hapus', [KonselingController::class, 'destroy'])
        ->name('konseling.hapus');

    // Pelanggaran
    Route::get('/pelanggaran', [PelanggaranController::class, 'pelanggaran'])
        ->name('siswa.pelanggaran');
    Route::post('/pelanggaran-tambah', [PelanggaranController::class, 'store'])
        ->name('pelanggaran.tambah');
    Route::delete('/{id}/pelanggaran-hapus', [PelanggaranController::class, 'destroy'])
        ->name('pelanggaran.hapus');
    // Laporan
    Route::get('/laporan', [LaporanController::class, 'laporan'])
        ->name('siswa.laporan');
    Route::post('/laporan-tambah', [LaporanController::class, 'store'])
        ->name('laporan.tambah');
    Route::delete('/{id}/laporan-hapus', [LaporanController::class, 'destroy'])
        ->name('laporan.hapus');
});







Route::post('/logout', [SesiController::class, 'logout'])->name('logout');
