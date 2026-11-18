<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ trim($__env->yieldContent('page_title', 'Berita Sekolah')) }} | SMP Al-Qadri</title>
    <meta name="description" content="{{ $metaDescription ?? 'Berita, prestasi, dan kegiatan terbaru SMP Al-Qadri Islamic School.' }}">
    <meta name="theme-color" content="#047857">
    <link rel="icon" href="{{ asset('logo-baru.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    {{-- Sesuai pola halaman publik SMP Al-Qadri saat ini. --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="min-h-screen bg-slate-50 text-slate-800">
<header class="border-b border-slate-200 bg-white">
    <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-4 px-5 py-4 lg:px-8">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <img src="{{ asset('logo-baru.png') }}" alt="Logo SMP Al-Qadri" class="h-11 w-11 object-contain">
            <span class="leading-tight"><strong class="block text-slate-900">SMP AL-QADRI</strong><span class="text-xs font-medium text-emerald-700">Islamic School</span></span>
        </a>
        <nav class="flex flex-wrap gap-4 text-sm font-medium text-slate-600 sm:gap-7">
            <a href="{{ route('home') }}" class="hover:text-emerald-700">Beranda</a>
            <a href="{{ route('berita.index') }}" class="text-emerald-700">Berita</a>
            <a href="{{ route('pengumuman') }}" class="hover:text-emerald-700">Pengumuman</a>
            <a href="{{ route('tentang') }}" class="hover:text-emerald-700">Tentang</a>
        </nav>
    </div>
</header>
<main>@yield('content')</main>
<footer class="mt-16 border-t border-slate-200 bg-white py-8">
    <div class="mx-auto max-w-7xl px-5 text-sm text-slate-500 lg:px-8">
        © {{ date('Y') }} SMP Al-Qadri Islamic School · <a href="{{ route('home') }}" class="text-emerald-700 hover:underline">Kembali ke Beranda</a>
    </div>
</footer>
</body>
</html>
