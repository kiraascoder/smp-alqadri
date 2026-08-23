<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KebajikanController;
use App\Http\Controllers\OrangTuaController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\PWAController;
use App\Http\Controllers\SesiController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/

Route::view('/', 'welcome')->name('home');
Route::view('/pengumuman', 'pengumuman')->name('pengumuman');
Route::view('/tentang', 'tentang')->name('tentang');
Route::view('/layanan', 'layanan')->name('layanan');


/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/

Route::get('/login', function () {

    if (auth()->check()) {
        return match (auth()->user()->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'guru' => redirect()->route('guru.dashboard'),
            'orang_tua' => redirect()->route('ortu.dashboard'),
            default => redirect()->route('home'),
        };
    }

    return view('auth.login');
})->name('login');


Route::post('/login', [SesiController::class, 'login'])
    ->name('login.submit');


/*
|--------------------------------------------------------------------------
| FORGOT PASSWORD
|--------------------------------------------------------------------------
*/

Route::get(
    '/lupa-password',
    [ForgotPasswordController::class, 'requestForm']
)->name('password.request');

Route::post(
    '/lupa-password',
    [ForgotPasswordController::class, 'sendResetLink']
)->name('password.email');

Route::get(
    '/reset-password/{token}',
    [ForgotPasswordController::class, 'resetForm']
)->name('password.reset');

Route::post(
    '/reset-password',
    [ForgotPasswordController::class, 'reset']
)->name('password.update');


/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

Route::post('/logout', [SesiController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [AdminController::class, 'index'])
            ->name('admin.dashboard');


        /*
        |--------------------------------------------------------------------------
        | Guru
        |--------------------------------------------------------------------------
        */

        Route::get('/guru', [AdminController::class, 'guru'])
            ->name('admin.guru');

        Route::post('/guru', [AdminController::class, 'storeGuru'])
            ->name('admin-guru.tambah');

        Route::put('/guru/{id}', [AdminController::class, 'editGuru'])
            ->name('admin-guru.edit');

        Route::delete('/guru/{id}', [AdminController::class, 'destroyGuru'])
            ->name('admin.guru.delete');


        /*
        |--------------------------------------------------------------------------
        | Kelas
        |--------------------------------------------------------------------------
        */

        Route::get('/kelas', [AdminController::class, 'kelas'])
            ->name('admin.kelas');

        Route::post('/kelas', [AdminController::class, 'storeKelas'])
            ->name('admin.kelas.store');

        Route::put('/kelas/{kelas}', [AdminController::class, 'updateKelas'])
            ->name('admin.kelas.update');

        Route::delete('/kelas/{kelas}', [AdminController::class, 'destroyKelas'])
            ->name('admin.kelas.delete');


        /*
        |--------------------------------------------------------------------------
        | Siswa
        |--------------------------------------------------------------------------
        */

        Route::get('/siswa', [AdminController::class, 'siswa'])
            ->name('admin.siswa');

        Route::post('/siswa', [AdminController::class, 'storeSiswa'])
            ->name('admin.siswa.register');

        Route::put('/siswa/{id}', [AdminController::class, 'updateSiswa'])
            ->name('admin.siswa.update');

        Route::delete('/siswa/{id}', [AdminController::class, 'destroySiswa'])
            ->name('admin.siswa.delete');


        /*
        |--------------------------------------------------------------------------
        | Orang Tua
        |--------------------------------------------------------------------------
        */

        Route::get('/orang-tua', [AdminController::class, 'orangTua'])
            ->name('admin.orang');

        Route::post('/orang-tua', [AdminController::class, 'registerOrtu'])
            ->name('admin.orang.register');

        Route::delete('/orang-tua/{id}', [AdminController::class, 'destroyOrangTua'])
            ->name('admin.orang.delete');


        /*
        |--------------------------------------------------------------------------
        | Master Pelanggaran
        |--------------------------------------------------------------------------
        */

        Route::get('/pelanggaran', [AdminController::class, 'pelanggaran'])
            ->name('admin.pelanggaran');

        Route::post('/pelanggaran', [PelanggaranController::class, 'store'])
            ->name('admin.pelanggaran.store');

        Route::put(
            '/pelanggaran/{pelanggaran}',
            [PelanggaranController::class, 'update']
        )->name('admin.pelanggaran.update');

        Route::delete(
            '/pelanggaran/{pelanggaran}',
            [PelanggaranController::class, 'destroy']
        )->name('admin.pelanggaran.delete');


        /*
        |--------------------------------------------------------------------------
        | Master Kebajikan
        |--------------------------------------------------------------------------
        */

        Route::get('/kebajikan', [KebajikanController::class, 'index'])
            ->name('admin.kebajikan');

        Route::post('/kebajikan', [KebajikanController::class, 'store'])
            ->name('admin.kebajikan.store');

        Route::put(
            '/kebajikan/{kebajikan}',
            [KebajikanController::class, 'update']
        )->name('admin.kebajikan.update');

        Route::delete(
            '/kebajikan/{kebajikan}',
            [KebajikanController::class, 'destroy']
        )->name('admin.kebajikan.delete');

        /*
    |--------------------------------------------------------------------------
    | Pemberian Kebajikan
    |--------------------------------------------------------------------------
    */

        Route::get(
            '/poin-kebajikan',
            [AdminController::class, 'poinKebajikan']
        )->name('admin.poin-kebajikan');

        Route::post(
            '/poin-kebajikan',
            [AdminController::class, 'beriKebajikan']
        )->name('admin.poin-kebajikan.store');

        Route::delete(
            '/poin-kebajikan/{riwayat}',
            [AdminController::class, 'hapusKebajikan']
        )->name('admin.poin-kebajikan.delete');
        /*
        |--------------------------------------------------------------------------
        | Skorsing
        |--------------------------------------------------------------------------
        */

        Route::get('/skorsing', [AdminController::class, 'skorsing'])
            ->name('admin.skorsing');

        Route::post('/skorsing', [AdminController::class, 'tambahSkorsing'])
            ->name('admin.skorsing.store');

        Route::get('/skorsing/{id}', [AdminController::class, 'detailSkorsing'])
            ->name('admin.skorsing.detail');

        Route::delete('/skorsing/{id}', [AdminController::class, 'destroySkorsing'])
            ->name('admin.skorsing.delete');


        /*
        |--------------------------------------------------------------------------
        | Rekap Skorsing
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/rekap-skorsing',
            [AdminController::class, 'rekapSkorsing']
        )->name('admin.rekap-skorsing');

        Route::get(
            '/rekap-skorsing/pdf',
            [AdminController::class, 'rekapSkorsingPdf']
        )->name('admin.rekap-skorsing.pdf');


        /*
        |--------------------------------------------------------------------------
        | Rekap Kebajikan
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/rekap-kebajikan',
            [AdminController::class, 'rekapKebajikan']
        )->name('admin.rekap-kebajikan');

        Route::get(
            '/rekap-kebajikan/pdf',
            [AdminController::class, 'rekapKebajikanPdf']
        )->name('admin.rekap-kebajikan.pdf');
    });


/*
|--------------------------------------------------------------------------
| GURU
|--------------------------------------------------------------------------
*/

Route::prefix('guru')
    ->middleware(['auth', 'role:guru'])
    ->group(function () {

        Route::get('/dashboard', [GuruController::class, 'index'])
            ->name('guru.dashboard');


        /*
        |--------------------------------------------------------------------------
        | Profil
        |--------------------------------------------------------------------------
        */

        Route::get('/profil', [GuruController::class, 'profil'])
            ->name('guru.profil');

        Route::put('/profil', [GuruController::class, 'edit'])
            ->name('guru.edit');

        Route::put('/profil/password', [GuruController::class, 'updatePassword'])
            ->name('guru.password.update');


        /*
        |--------------------------------------------------------------------------
        | Pelanggaran
        |--------------------------------------------------------------------------
        */

        Route::get('/jenis-pelanggaran', [GuruController::class, 'pelanggaran'])
            ->name('guru.pelanggaran');


        /*
        |--------------------------------------------------------------------------
        | Skorsing
        |--------------------------------------------------------------------------
        */

        Route::get('/skorsing', [GuruController::class, 'skorsing'])
            ->name('guru.skorsing');

        Route::post('/skorsing', [GuruController::class, 'tambahSkorsing'])
            ->name('guru.skorsing.store');

        Route::get('/skorsing/{id}', [GuruController::class, 'detailSkorsing'])
            ->name('guru.skorsing.detail');

        Route::delete('/skorsing/{id}', [GuruController::class, 'destroySkorsing'])
            ->name('guru.skorsing.delete');


        /*
        |--------------------------------------------------------------------------
        | Kebajikan
        |--------------------------------------------------------------------------
        */

        Route::get('/kebajikan', [KebajikanController::class, 'guruIndex'])
            ->name('guru.kebajikan');

        Route::post('/kebajikan', [KebajikanController::class, 'beriPoin'])
            ->name('guru.kebajikan.store');

        Route::delete(
            '/kebajikan/{riwayat}',
            [KebajikanController::class, 'hapusRiwayat']
        )->name('guru.kebajikan.delete');
    });


/*
|--------------------------------------------------------------------------
| ORANG TUA
|--------------------------------------------------------------------------
*/

Route::prefix('orang-tua')
    ->middleware(['auth', 'role:orang_tua'])
    ->group(function () {

        Route::get(
            '/dashboard',
            [OrangTuaController::class, 'dashboard']
        )->name('ortu.dashboard');


        Route::get(
            '/jenis-pelanggaran',
            [OrangTuaController::class, 'pelanggaran']
        )->name('ortu.pelanggaran');


        Route::get(
            '/kebajikan',
            [OrangTuaController::class, 'kebajikan']
        )->name('ortu.kebajikan');
    });


/*
|--------------------------------------------------------------------------
| PWA
|--------------------------------------------------------------------------
*/

Route::get('/manifest.json', [PWAController::class, 'manifest'])
    ->name('pwa.manifest');


Route::get('/serviceworker.js', function () {

    $path = public_path('serviceworker.js');

    abort_unless(file_exists($path), 404);

    return response(
        file_get_contents($path),
        200,
        [
            'Content-Type' => 'application/javascript',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Service-Worker-Allowed' => '/',
        ]
    );
})->name('pwa.serviceworker');


Route::view('/offline.html', 'pwa.offline')
    ->name('pwa.offline');

Route::view('/pwa/install', 'pwa.install')
    ->name('pwa.install');


/*
|--------------------------------------------------------------------------
| FALLBACK
|--------------------------------------------------------------------------
*/

Route::fallback(function () {
    abort(404);
});
