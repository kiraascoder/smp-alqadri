<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Struktur organisasi SMP Al-Qadri Islamic School: pimpinan, wali kelas, guru, dan staf sekolah.">
    <title>Struktur Organisasi - SMP Al-Qadri Islamic School</title>
    <link rel="icon" type="image/png" href="{{ asset('logo-baru.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .org-roots { display: flex; align-items: flex-start; justify-content: center; gap: 24px; width: max-content; min-width: 100%; }
        .org-children { display: flex; justify-content: center; align-items: flex-start; gap: 16px; padding-top: 34px; position: relative; width: max-content; min-width: 100%; }
        .org-item { display: flex; flex-direction: column; position: relative; align-items: center; }
        .org-card { width: 216px; max-width: 100%; }
        .org-item > .org-children::before { content: ''; position: absolute; height: 24px; width: 2px; top: 0; left: 50%; background: #94a3b8; }
        .org-children > .org-item::before { content: ''; position: absolute; width: 2px; height: 17px; background: #94a3b8; left: 50%; top: -17px; }
        .org-children > .org-item:not(:only-child)::after { content: ''; position: absolute; height: 2px; left: 0; right: 0; top: -17px; background: #94a3b8; }
        .org-children > .org-item:first-child::after { left: 50%; }
        .org-children > .org-item:last-child::after { right: 50%; }
        .org-grid-children { display: grid; grid-template-columns: repeat(4, 216px); gap: 18px; justify-content: center; }
        .org-grid-children > .org-item::before, .org-grid-children > .org-item::after { display: none; }
        @media (max-width: 640px) { .org-card { width: 192px; } .org-grid-children { grid-template-columns: repeat(3, 192px); } }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 min-h-screen">
<header class="bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-5 py-4 flex items-center justify-between gap-3">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <img src="{{ asset('logo-baru.png') }}" alt="Logo SMP Al-Qadri" class="w-11 h-11 object-contain">
            <span class="font-bold">SMP Al-Qadri <span class="block text-sm text-emerald-700 font-medium">Islamic School</span></span>
        </a>
        <a href="{{ route('home') }}" class="text-sm font-semibold text-emerald-700 hover:underline">Kembali ke Beranda</a>
    </div>
</header>
<main>
    <section class="bg-emerald-900 text-white py-14">
        <div class="max-w-7xl mx-auto px-5 text-center">
            <p class="text-emerald-200 text-sm font-medium uppercase tracking-widest">Profil Sekolah</p>
            <h1 class="text-3xl md:text-4xl font-extrabold mt-2">Struktur Organisasi Sekolah</h1>
            <p class="text-emerald-100 max-w-2xl mx-auto mt-4">Susunan pimpinan, dewan guru, dan staf SMP Al-Qadri Islamic School.</p>
        </div>
    </section>
    <section class="py-10 px-4">
        @if($roots->isEmpty())
            <p class="text-center text-slate-500 py-20">Struktur organisasi belum dipublikasikan.</p>
        @else
            <p class="text-center text-sm text-slate-500 mb-5">Geser secara horizontal untuk melihat keseluruhan bagan.</p>
            <div class="overflow-x-auto pb-12" role="region" aria-label="Bagan struktur organisasi" tabindex="0">
                <div class="org-roots px-6 py-4">
                    @foreach($roots as $root)
                        @include('struktur._node', ['node' => $root, 'positions' => $positions])
                    @endforeach
                </div>
            </div>
        @endif
    </section>
</main>
<footer class="bg-white border-t border-slate-200 text-center text-sm text-slate-500 py-6">
    SMP Al-Qadri Islamic School
</footer>
</body>
</html>
