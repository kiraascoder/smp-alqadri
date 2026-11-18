<?php
// PANDUAN: kode ini bukan file routes/web.php utuh. Gabungkan dengan routes/web.php Anda.
// 1. Import controller dan model di bagian atas routes/web.php:
use App\Http\Controllers\PengumumanController;
use App\Models\Pengumuman;

// 2. GANTI route lama Route::view('/pengumuman', 'pengumuman') dengan:
Route::get('/pengumuman', [PengumumanController::class, 'publicIndex'])->name('pengumuman');
Route::get('/pengumuman/{pengumuman:slug}', [PengumumanController::class, 'publicShow'])->name('pengumuman.show');

// 3. MASUKKAN 6 route berikut KE DALAM grup Route::prefix('admin')->middleware(['auth','role:admin']):
Route::get('/pengumuman', [PengumumanController::class, 'adminIndex'])->name('admin.pengumuman.index');
Route::get('/pengumuman/tambah', [PengumumanController::class, 'create'])->name('admin.pengumuman.create');
Route::post('/pengumuman', [PengumumanController::class, 'store'])->name('admin.pengumuman.store');
Route::get('/pengumuman/{pengumuman}/edit', [PengumumanController::class, 'edit'])->name('admin.pengumuman.edit');
Route::put('/pengumuman/{pengumuman}', [PengumumanController::class, 'update'])->name('admin.pengumuman.update');
Route::delete('/pengumuman/{pengumuman}', [PengumumanController::class, 'destroy'])->name('admin.pengumuman.destroy');

// 4. Pada route GET '/' yang SUDAH ADA di homepage V2, sebelum return view:
// $pengumumanTerbaru = Pengumuman::visible()
//     ->orderByDesc('is_pinned')->orderByDesc('published_at')->orderByDesc('id')->limit(3)->get();
// Sertakan 'pengumumanTerbaru' pada compact(...).
// Jangan menambahkan Route::get('/') yang kedua.
