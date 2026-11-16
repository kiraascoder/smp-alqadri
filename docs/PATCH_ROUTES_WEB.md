# Perubahan pada routes/web.php

## 1. Tambahkan import di paling atas:

```php
use App\Http\Controllers\SchoolStructureController;
use App\Models\SchoolPosition;
```

## 2. Di area PUBLIC, tambahkan route baru sebelum AUTHENTICATION:

```php
Route::get('/struktur-organisasi', [SchoolStructureController::class, 'publicIndex'])
    ->name('struktur.index');
```

## 3. Dalam group `Route::prefix('admin')->middleware(['auth', 'role:admin'])`, tambahkan:

```php
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
```

Route resource binding otomatis menggunakan nama parameter `{position}` / `{member}` sesuai controller.

## 4. Jika ingin ringkasan pimpinan pada homepage

Di area PUBLIC, **ganti**, jangan gandakan route:

```php
Route::view('/', 'welcome')->name('home');
```

dengan:

```php
Route::get('/', function () {
    $leaders = SchoolPosition::query()
        ->where('is_active', true)
        ->where('show_homepage', true)
        ->with(['members' => fn ($q) => $q->where('is_active', true)
            ->orderBy('sort_order')->orderBy('id')])
        ->orderBy('sort_order')->orderBy('id')->limit(4)->get();

    return view('welcome', compact('leaders'));
})->name('home');
```

**Jalankan migration sebelum mengganti route homepage**, agar tabel sudah ada.

## 5. Pengecekan route

```bash
php artisan route:list --path=struktur-organisasi
```
