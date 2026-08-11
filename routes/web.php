<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\OrangTuaController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\PWAController;
use App\Http\Controllers\SesiController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::view('/pengumuman', 'pengumuman')->name('pengumuman');
Route::view('/tentang', 'tentang')->name('tentang');
Route::view('/layanan', 'layanan')->name('layanan');

Route::middleware('authenticated')->group(function () {
    Route::get('/login', [SesiController::class, 'LoginView'])->name('login');
    Route::post('/login', [SesiController::class, 'login'])->name('login.submit');

    Route::get('/lupa-password', [ForgotPasswordController::class, 'requestForm'])->name('password.request');
    Route::post('/lupa-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'resetForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [SesiController::class, 'logout'])->middleware('auth')->name('logout');

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::get('/guru', [AdminController::class, 'guru'])->name('admin.guru');
    Route::post('/guru', [AdminController::class, 'storeGuru'])->name('admin-guru.tambah');
    Route::put('/guru/{id}', [AdminController::class, 'editGuru'])->name('admin-guru.edit');
    Route::delete('/guru/{id}', [AdminController::class, 'destroyGuru'])->name('admin.guru.delete');

    Route::get('/kelas', [AdminController::class, 'kelas'])->name('admin.kelas');
    Route::post('/kelas', [AdminController::class, 'storeKelas'])->name('admin.kelas.store');
    Route::put('/kelas/{kelas}', [AdminController::class, 'updateKelas'])->name('admin.kelas.update');
    Route::delete('/kelas/{kelas}', [AdminController::class, 'destroyKelas'])->name('admin.kelas.delete');

    Route::get('/siswa', [AdminController::class, 'siswa'])->name('admin.siswa');
    Route::post('/siswa', [AdminController::class, 'storeSiswa'])->name('admin.siswa.register');
    Route::put('/siswa/{id}', [AdminController::class, 'updateSiswa'])->name('admin.siswa.update');
    Route::delete('/siswa/{id}', [AdminController::class, 'destroySiswa'])->name('admin.siswa.delete');

    Route::get('/orang-tua', [AdminController::class, 'orangTua'])->name('admin.orang');
    Route::post('/orang-tua', [AdminController::class, 'registerOrtu'])->name('admin.orang.register');
    Route::delete('/orang-tua/{id}', [AdminController::class, 'destroyOrangTua'])->name('admin.orang.delete');

    Route::get('/pelanggaran', [AdminController::class, 'pelanggaran'])->name('admin.pelanggaran');
    Route::post('/pelanggaran', [PelanggaranController::class, 'store'])->name('admin.pelanggaran.store');
    Route::put('/pelanggaran/{pelanggaran}', [PelanggaranController::class, 'update'])->name('admin.pelanggaran.update');
    Route::delete('/pelanggaran/{pelanggaran}', [PelanggaranController::class, 'destroy'])->name('admin.pelanggaran.delete');

    Route::get('/skorsing', [AdminController::class, 'skorsing'])->name('admin.skorsing');
    Route::post('/skorsing', [AdminController::class, 'tambahSkorsing'])->name('admin.skorsing.store');
    Route::get('/skorsing/{id}', [AdminController::class, 'detailSkorsing'])->name('admin.skorsing.detail');
    Route::delete('/skorsing/{id}', [AdminController::class, 'destroySkorsing'])->name('admin.skorsing.delete');
    Route::get('/rekap-skorsing', [AdminController::class, 'rekapSkorsing'])->name('admin.rekap-skorsing');
});

Route::prefix('guru')->middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/dashboard', [GuruController::class, 'index'])->name('guru.dashboard');
    Route::get('/profil', [GuruController::class, 'profil'])->name('guru.profil');
    Route::put('/profil', [GuruController::class, 'edit'])->name('guru.edit');

    Route::get('/jenis-pelanggaran', [GuruController::class, 'pelanggaran'])->name('guru.pelanggaran');
    Route::get('/skorsing', [GuruController::class, 'skorsing'])->name('guru.skorsing');
    Route::post('/skorsing', [GuruController::class, 'tambahSkorsing'])->name('guru.skorsing.store');
    Route::get('/skorsing/{id}', [GuruController::class, 'detailSkorsing'])->name('guru.skorsing.detail');
    Route::delete('/skorsing/{id}', [GuruController::class, 'destroySkorsing'])->name('guru.skorsing.delete');
});

Route::prefix('orang-tua')->middleware(['auth', 'role:orang_tua'])->group(function () {
    Route::get('/dashboard', [OrangTuaController::class, 'dashboard'])->name('ortu.dashboard');
    Route::get('/jenis-pelanggaran', [OrangTuaController::class, 'pelanggaran'])->name('ortu.pelanggaran');
    Route::get('/anak', [OrangTuaController::class, 'anak'])->name('ortu.anak');
    Route::get('/skorsing', [OrangTuaController::class, 'skorsing'])->name('ortu.skorsing');
});

// PWA: satu route service worker saja agar tidak terjadi duplikasi route name.
Route::get('/manifest.json', [PWAController::class, 'manifest'])->name('pwa.manifest');
Route::get('/serviceworker.js', function () {
    return response(file_get_contents(public_path('serviceworker.js')), 200, [
        'Content-Type' => 'application/javascript',
        'Cache-Control' => 'public, max-age=86400, must-revalidate',
        'Service-Worker-Allowed' => '/',
    ]);
})->name('pwa.serviceworker');
Route::view('/offline.html', 'pwa.offline')->name('pwa.offline');
Route::view('/pwa/install', 'pwa.install')->name('pwa.install');

Route::fallback(function () {
    abort(404);
});
