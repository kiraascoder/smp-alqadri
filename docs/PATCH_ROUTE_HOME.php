<?php
// 1. Pastikan dua import ini ada di bagian atas routes/web.php:
use App\Models\Berita;
use App\Models\SchoolPosition;

// 2. GANTI route homepage lama (Route::view('/', 'welcome') atau Route::get('/', ...))
//    dengan route berikut. Jangan membuat dua route GET '/' sekaligus.
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

    return view('welcome', compact('beritaTerbaru', 'leaders'));
})->name('home');
