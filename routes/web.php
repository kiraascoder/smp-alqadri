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
    Route::delete('guru/{id}', [AdminController::class, 'destroyGuru'])->name('admin.guru.delete');
    Route::delete('gurubk/{id}', [AdminController::class, 'destroyGuruBk'])->name('admin.gurubk.delete');
    // Siswa Route`
    Route::get('siswa', [AdminController::class, 'siswa'])->name('admin.siswa');
    Route::post('siswa/register', [AdminController::class, 'register'])->name('admin.siswa.register');
    Route::delete('siswa/{id}', [AdminController::class, 'destroySiswa'])->name('admin.siswa.delete');



    // BK Route
    Route::get('bk', [AdminController::class, 'bk'])->name('admin.bk');
    Route::post('bk-tambah', [AdminController::class, 'storeGuruBk'])->name('admin-bk.tambah');
    Route::put('bk/{id}/edit', [AdminController::class, 'editGuruBk'])->name('admin-bk.edit');
    Route::delete('bk/{id}/delete', [AdminController::class, 'destroyGuruBk'])->name('admin-bk.delete');

    // Pelanggaran
    Route::post('pelanggaran-tambah', [PelanggaranController::class, 'store'])->name('admin.tambah.pelanggaran');



    // Riwayat Skorsing
    Route::delete('riwayat/{id}', [AdminController::class, 'destroyRiwayat'])->name('admin.riwayat.delete');
    Route::delete('admin/skorsing/hapus/{id}', [AdminController::class, 'destroySkorsing'])->name('admin.riwayat.delete');
    Route::get('admin/skorsing/detail/{id}', [AdminController::class, 'detailSkorsing'])->name('admin.skorsing.detail');










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
    Route::get('skorsing/detail/{id}', [GuruController::class, 'detailSkorsing'])->name('guru.skorsing.detail');
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
    Route::post('/skorsing-tambah-bk', [BkController::class, 'tambahSkorsing'])
        ->name('skorsing.tambah-bk');
    Route::get('/konseling', [BkController::class, 'konseling'])
        ->name('bk.konseling');
    Route::post('/konseling-tambah', [BkController::class, 'store'])
        ->name('konseling-Bktambah');
    Route::put('/{id}/konseling-edit', [BkController::class, 'updateStatus'])
        ->name('guru.konseling.update-status');
    Route::delete('/{id}/konseling-hapus', [BkController::class, 'destroy'])
        ->name('konseling-Bkhapus');
    // Pengaduan 
    Route::delete('/{id}/laporan-hapus', [BkController::class, 'destroyPengaduan'])
        ->name('pengaduan.hapus');

    // Skorsing 
    Route::get('skorsing/detail/{id}', [bkController::class, 'detailSkorsing'])->name('admin.skorsing.detail');
    Route::delete('bk/skorsing/hapus/{id}', [BkController::class, 'destroySkorsing'])->name('admin.riwayat.delete');
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


Route::get('/manifest.json', function () {
    $manifest = config('pwa.manifest');

    return response()->json($manifest, 200, [
        'Content-Type' => 'application/manifest+json',
        'Cache-Control' => 'public, max-age=604800', // Cache for 1 week
    ]);
})->name('pwa.manifest');

Route::get('/offline.html', function () {
    return view('pwa.offline');
})->name('pwa.offline');

// Service Worker route (optional, untuk debugging)
Route::get('/serviceworker.js', function () {
    $content = file_get_contents(public_path('serviceworker.js'));

    return response($content, 200, [
        'Content-Type' => 'application/javascript',
        'Cache-Control' => 'public, max-age=86400', // Cache for 1 day
    ]);
})->name('pwa.serviceworker');

// PWA Install helper route
Route::get('/pwa/install', function () {
    return view('pwa.install');
})->name('pwa.install');
