<?php

use App\Http\Controllers\GuruController;
use App\Http\Controllers\KonselingController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminSesiController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->middleware('admin:admin')->group(function () {
    Route::get('dashboard', [AdminSesiController::class, 'index'])->name('admin.dashboard');
});

Route::prefix('admin')->middleware('authenticated')->group(function () {
    Route::get('login', [AdminSesiController::class, 'adminLoginView'])->name('admin.login');
    Route::post('login', [SesiController::class, 'login'])->name('admin.login.submit');
});


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
});

// Siswa
Route::prefix('siswa')->middleware('admin:siswa')->group(function () {
    Route::get('/dashboard', [SiswaController::class, 'index'])
        ->name('siswa.dashboard');
    // Profil Siswa
    Route::get('/profil-siswa', [SiswaController::class, 'profil'])
        ->name('siswa.profil');
    // Konseling
    Route::get('/konseling', [KonselingController::class, 'index'])
        ->name('siswa.konseling');
    Route::post('/konseling-tambah', [KonselingController::class, 'store'])
        ->name('konseling.tambah');
    Route::delete('/{id}/konseling-hapus', [KonselingController::class, 'destroy'])
        ->name('konseling.hapus');


    Route::get('/pelanggaran', [SiswaController::class, 'pelanggaran'])
        ->name('siswa.pelanggaran');
    // Laporan
    Route::get('/laporan', [LaporanController::class, 'laporan'])
        ->name('siswa.laporan');
});


Route::post('/logout', [SesiController::class, 'logout'])->name('logout');
