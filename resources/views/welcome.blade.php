<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMP Al-Qadri Islamic School | Beranda</title>
    <meta name="description" content="Website resmi SMP Al-Qadri Islamic School. Temukan berita sekolah, struktur organisasi, pengumuman, dan akses portal guru serta orang tua.">
    <meta name="theme-color" content="#065f46">
    <meta property="og:type" content="website">
    <meta property="og:title" content="SMP Al-Qadri Islamic School">
    <meta property="og:description" content="Informasi, berita, dan layanan digital SMP Al-Qadri Islamic School.">
    <meta property="og:url" content="{{ url('/') }}">
    <link rel="icon" type="image/png" href="{{ asset('logo-baru.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/icons/icon-192x192.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    {{-- Menjaga kompatibilitas dengan homepage lama yang memakai Tailwind CDN. --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root { color-scheme: light; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        html { scroll-behavior: smooth; scroll-padding-top: 92px; }
        .font-arabic { font-family: 'Amiri', serif; }
        .hero-slider { isolation: isolate; }
        .hero-slide {
            position: absolute; inset: 0; display: flex; align-items: center;
            opacity: 0; visibility: hidden; pointer-events: none;
            transition: opacity .7s ease, visibility .7s ease;
        }
        .hero-slide.is-active { opacity: 1; visibility: visible; pointer-events: auto; z-index: 1; }
        .hero-fallback {
            background: radial-gradient(circle at 82% 26%, rgba(244, 192, 82, .38), transparent 28%),
                        radial-gradient(circle at 13% 84%, rgba(52, 211, 153, .22), transparent 35%),
                        linear-gradient(125deg, #063c33 0%, #065f46 48%, #0d7662 100%);
        }
        .hero-overlay { background: linear-gradient(90deg, rgba(3, 35, 29, .92) 0%, rgba(3, 52, 42, .78) 48%, rgba(4, 55, 45, .19) 100%); }
        .slider-dot { width: 10px; height: 10px; border-radius: 999px; background: rgba(255,255,255,.48); transition: all .25s ease; }
        .slider-dot[aria-current="true"] { width: 34px; background: #fff; }
        .shadow-soft { box-shadow: 0 17px 45px rgba(18, 52, 44, .08); }
        .lift { transition: transform .25s ease, box-shadow .25s ease; }
        .lift:hover { transform: translateY(-4px); box-shadow: 0 20px 42px rgba(10, 62, 46, .12); }
        .clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
        .section-label { letter-spacing: .16em; text-transform: uppercase; font-size: .73rem; font-weight: 800; color: #047857; }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { scroll-behavior: auto !important; transition-duration: .01ms !important; animation-duration: .01ms !important; }
        }
    </style>
</head>
@php
    // Foto slideshow: unggah file ke public/images/slider/ sesuai nama berikut.
    // Bila foto belum tersedia, tampilkan gradasi hijau agar homepage tetap rapi.
    $slides = array_map(function ($slide) {
        $slide['exists'] = is_file(public_path($slide['path']));
        $slide['src'] = asset($slide['path']);
        return $slide;
    }, [
        [
            'path' => 'images/slider/slide-1.jpg',
            'eyebrow' => 'Selamat datang di SMP Al-Qadri',
            'title' => 'Membentuk Generasi Berilmu dan Berakhlak',
            'description' => 'Lingkungan pendidikan Islami yang mendukung prestasi, karakter, dan tumbuh kembang peserta didik.',
            'link' => route('tentang'),
            'link_text' => 'Mengenal Sekolah',
        ],
        [
            'path' => 'images/slider/slide-2.jpg',
            'eyebrow' => 'Kegiatan dan Prestasi',
            'title' => 'Tumbuh, Berkarya, dan Menginspirasi',
            'description' => 'Ikuti cerita kegiatan, prestasi, serta pengalaman belajar siswa melalui kabar terbaru sekolah.',
            'link' => route('berita.index'),
            'link_text' => 'Jelajahi Berita',
        ],
        [
            'path' => 'images/slider/slide-3.jpg',
            'eyebrow' => 'Keluarga Besar Sekolah',
            'title' => 'Bersama Membangun Masa Depan',
            'description' => 'Kenali pimpinan, tenaga pendidik, dan jajaran sekolah yang mendampingi setiap langkah belajar.',
            'link' => route('struktur.index'),
            'link_text' => 'Struktur Organisasi',
        ],
    ]);

    $beritaTerbaru = $beritaTerbaru ?? collect();
    $pengumumanTerbaru = $pengumumanTerbaru ?? collect();
    $leaders = $leaders ?? collect();
    $dashboardUrl = auth()->check() ? match (auth()->user()->role) {
        'admin' => route('admin.dashboard'),
        'guru' => route('guru.dashboard'),
        'orang_tua' => route('ortu.dashboard'),
        default => route('home'),
    } : route('login');
@endphp
<body class="bg-[#f8faf9] text-slate-800 antialiased">
    <div id="offline-status" class="fixed inset-x-0 top-0 z-[100] hidden bg-amber-500 px-5 py-2 text-center text-xs font-bold text-white" role="status">
        Anda sedang offline. Beberapa fitur mungkin tidak tersedia.
    </div>

    {{-- TOP BAR --}}
    <div class="hidden bg-emerald-950 text-white lg:block">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-5 py-2.5 text-[11px] font-semibold tracking-wide lg:px-8">
            <span>Website Resmi SMP Al-Qadri Islamic School</span>
            <div class="flex items-center gap-5 text-emerald-100">
                <a class="hover:text-white" href="{{ route('pengumuman') }}">Informasi & Pengumuman</a>
                <span class="h-3 w-px bg-emerald-700"></span>
                <a class="hover:text-white" href="{{ route('berita.index') }}">Kabar Sekolah Terbaru</a>
            </div>
        </div>
    </div>

    {{-- NAVBAR --}}
    <header class="sticky top-0 z-50 border-b border-slate-200/80 bg-white/95 backdrop-blur-xl">
        <div class="mx-auto flex h-[76px] max-w-7xl items-center justify-between gap-5 px-5 lg:px-8">
            <a href="{{ route('home') }}" class="flex min-w-0 items-center gap-3" aria-label="Beranda SMP Al-Qadri">
                <img src="{{ asset('logo-baru.png') }}" alt="Logo SMP Al-Qadri" class="h-12 w-12 shrink-0 object-contain">
                <span class="block min-w-0 leading-tight">
                    <span class="block text-base font-extrabold tracking-tight text-emerald-950">SMP AL-QADRI</span>
                    <span class="mt-1 block text-[11px] font-bold tracking-[.17em] text-emerald-700">ISLAMIC SCHOOL</span>
                </span>
            </a>
            <nav class="hidden items-center gap-7 text-[13px] font-bold text-slate-600 lg:flex" aria-label="Navigasi utama">
                <a href="{{ route('home') }}" class="text-emerald-700">Beranda</a>
                <a href="{{ route('tentang') }}" class="transition hover:text-emerald-700">Tentang</a>
                <a href="{{ route('berita.index') }}" class="transition hover:text-emerald-700">Berita</a>
                <a href="{{ route('struktur.index') }}" class="transition hover:text-emerald-700">Struktur Organisasi</a>
                <a href="{{ route('pengumuman') }}" class="transition hover:text-emerald-700">Pengumuman</a>
                <a href="{{ route('layanan') }}" class="transition hover:text-emerald-700">Layanan</a>
            </nav>
            <div class="flex items-center gap-2">
                <a href="{{ $dashboardUrl }}" class="hidden rounded-full bg-emerald-700 px-5 py-3 text-xs font-extrabold text-white transition hover:bg-emerald-800 sm:inline-flex">
                    {{ auth()->check() ? 'Dashboard' : 'Login Portal' }}
                </a>
                <button type="button" id="mobile-menu-button" aria-label="Buka menu navigasi" aria-controls="mobile-menu" aria-expanded="false" class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-slate-200 text-slate-800 lg:hidden">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>
        <nav id="mobile-menu" class="hidden border-t border-slate-100 bg-white p-4 shadow-xl lg:hidden" aria-label="Navigasi mobile">
            <div class="mx-auto flex max-w-7xl flex-col gap-1 text-sm font-semibold">
                <a href="{{ route('home') }}" class="rounded-xl px-4 py-3 text-emerald-700 hover:bg-emerald-50">Beranda</a>
                <a href="{{ route('tentang') }}" class="rounded-xl px-4 py-3 hover:bg-emerald-50">Tentang Sekolah</a>
                <a href="{{ route('berita.index') }}" class="rounded-xl px-4 py-3 hover:bg-emerald-50">Berita</a>
                <a href="{{ route('struktur.index') }}" class="rounded-xl px-4 py-3 hover:bg-emerald-50">Struktur Organisasi</a>
                <a href="{{ route('pengumuman') }}" class="rounded-xl px-4 py-3 hover:bg-emerald-50">Pengumuman</a>
                <a href="{{ route('layanan') }}" class="rounded-xl px-4 py-3 hover:bg-emerald-50">Layanan</a>
                <a href="{{ $dashboardUrl }}" class="mt-2 rounded-xl bg-emerald-700 px-4 py-3 text-center text-white">{{ auth()->check() ? 'Buka Dashboard' : 'Login Portal' }}</a>
            </div>
        </nav>
    </header>

    <main>
        {{-- JUMBOTRON: SLIDESHOW GAMBAR --}}
        <section aria-label="Sorotan sekolah" class="bg-emerald-950">
            <div id="hero-slider" class="hero-slider relative h-[590px] overflow-hidden sm:h-[630px] lg:h-[650px]" role="region" aria-roledescription="carousel" aria-label="Galeri sorotan SMP Al-Qadri" tabindex="0">
                @foreach($slides as $slide)
                    <div class="hero-slide {{ $loop->first ? 'is-active' : '' }}" data-hero-slide aria-hidden="{{ $loop->first ? 'false' : 'true' }}">
                        @if($slide['exists'])
                            <img src="{{ $slide['src'] }}" alt="Dokumentasi sekolah: {{ $slide['eyebrow'] }}" class="absolute inset-0 h-full w-full object-cover" {{ $loop->first ? 'fetchpriority=high' : 'loading=lazy' }}>
                        @else
                            <div class="hero-fallback absolute inset-0" aria-hidden="true"></div>
                            <img src="{{ asset('logo-baru.png') }}" alt="" class="pointer-events-none absolute -right-20 top-1/2 hidden h-[500px] w-[500px] -translate-y-1/2 object-contain opacity-[.09] lg:block" aria-hidden="true">
                        @endif
                        <div class="hero-overlay absolute inset-0" aria-hidden="true"></div>
                        <div class="relative z-10 mx-auto w-full max-w-7xl px-5 pb-20 pt-4 lg:px-8">
                            <div class="max-w-[750px] text-white">
                                <div class="mb-6 inline-flex items-center gap-3 rounded-full border border-white/25 bg-white/10 px-4 py-2.5 text-[11px] font-extrabold uppercase tracking-[.16em] backdrop-blur">
                                    <span class="h-2 w-2 rounded-full bg-amber-300"></span>
                                    {{ $slide['eyebrow'] }}
                                </div>
                                <h1 class="max-w-3xl text-4xl font-extrabold leading-[1.16] tracking-tight sm:text-5xl lg:text-[62px]">
                                    {{ $slide['title'] }}
                                </h1>
                                <p class="mt-6 max-w-xl text-sm leading-8 text-emerald-50/95 sm:text-base lg:text-lg">{{ $slide['description'] }}</p>
                                <div class="mt-9 flex flex-wrap items-center gap-3">
                                    <a href="{{ $slide['link'] }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-amber-400 px-7 py-3.5 text-sm font-extrabold text-emerald-950 transition hover:bg-amber-300">
                                        {{ $slide['link_text'] }} <span aria-hidden="true">→</span>
                                    </a>
                                    <a href="{{ route('berita.index') }}" class="inline-flex items-center justify-center rounded-full border border-white/50 px-7 py-3.5 text-sm font-bold text-white transition hover:bg-white/15">Kabar Sekolah</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="pointer-events-none absolute inset-x-0 bottom-0 z-10 h-24 bg-gradient-to-t from-emerald-950/60 to-transparent"></div>
                <button id="hero-prev" type="button" aria-label="Slide sebelumnya" class="absolute bottom-7 right-24 z-20 flex h-11 w-11 items-center justify-center rounded-full border border-white/50 bg-white/10 text-white backdrop-blur transition hover:bg-white/25 sm:bottom-10 sm:right-32">
                    <svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="m15 18-6-6 6-6"/></svg>
                </button>
                <button id="hero-next" type="button" aria-label="Slide berikutnya" class="absolute bottom-7 right-10 z-20 flex h-11 w-11 items-center justify-center rounded-full border border-white/50 bg-white/10 text-white backdrop-blur transition hover:bg-white/25 sm:bottom-10 sm:right-16">
                    <svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg>
                </button>
                <div class="absolute bottom-10 left-5 z-20 flex items-center gap-2 sm:left-10 lg:left-[max(2rem,calc((100vw-80rem)/2+2rem))]" aria-label="Pilih slide">
                    @foreach($slides as $slide)
                        <button type="button" data-slide-to="{{ $loop->index }}" aria-label="Tampilkan slide {{ $loop->iteration }}" aria-current="{{ $loop->first ? 'true' : 'false' }}" class="slider-dot"></button>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- SHORTCUTS --}}
        <section class="relative z-20 -mt-1 bg-white py-9 sm:py-11">
            <div class="mx-auto grid max-w-7xl grid-cols-2 gap-3 px-5 sm:gap-5 lg:grid-cols-4 lg:px-8">
                @foreach([
                    ['href' => route('berita.index'), 'icon' => '01', 'title' => 'Berita Sekolah', 'detail' => 'Kegiatan & prestasi'],
                    ['href' => route('struktur.index'), 'icon' => '02', 'title' => 'Struktur Organisasi', 'detail' => 'Pimpinan & tenaga pendidik'],
                    ['href' => route('pengumuman'), 'icon' => '03', 'title' => 'Pengumuman', 'detail' => 'Informasi resmi sekolah'],
                    ['href' => $dashboardUrl, 'icon' => '04', 'title' => 'Portal Sekolah', 'detail' => 'Akses sesuai akun'],
                ] as $shortcut)
                    <a href="{{ $shortcut['href'] }}" class="lift group flex min-h-[126px] flex-col justify-between rounded-2xl border border-emerald-100 bg-[#f7faf8] p-5 sm:p-6">
                        <span class="flex items-center justify-between"><span class="text-xs font-extrabold tracking-widest text-emerald-600">{{ $shortcut['icon'] }}</span><span class="text-xl text-emerald-700 transition group-hover:translate-x-1" aria-hidden="true">↗</span></span>
                        <span class="block"><strong class="block text-sm font-extrabold text-emerald-950 sm:text-base">{{ $shortcut['title'] }}</strong><span class="mt-1 block text-[11px] leading-5 text-slate-500 sm:text-xs">{{ $shortcut['detail'] }}</span></span>
                    </a>
                @endforeach
            </div>
        </section>

        {{-- ABOUT --}}
        <section id="tentang-singkat" class="overflow-hidden bg-white py-16 lg:py-24">
            <div class="mx-auto grid max-w-7xl items-center gap-12 px-5 lg:grid-cols-2 lg:gap-20 lg:px-8">
                <div class="relative flex min-h-[400px] items-center justify-center overflow-hidden rounded-[30px] bg-emerald-950 p-8 shadow-soft sm:min-h-[470px]">
                    <div class="absolute -left-16 -top-16 h-56 w-56 rounded-full bg-amber-400/20 blur-3xl"></div>
                    <div class="absolute -bottom-16 -right-14 h-56 w-56 rounded-full bg-emerald-400/20 blur-3xl"></div>
                    @if(is_file(public_path('images/slider/slide-2.jpg')))
                        <img src="{{ asset('images/slider/slide-2.jpg') }}" alt="Dokumentasi kegiatan SMP Al-Qadri" loading="lazy" class="absolute inset-0 h-full w-full object-cover opacity-50">
                    @endif
                    <div class="relative z-10 flex flex-col items-center text-center text-white">
                        <div class="mb-6 rounded-[27px] border border-white/30 bg-white/95 p-5 shadow-xl"><img src="{{ asset('logo-baru.png') }}" alt="Logo SMP Al-Qadri" class="h-28 w-28 object-contain sm:h-32 sm:w-32"></div>
                        <p class="text-xs font-bold uppercase tracking-[.24em] text-amber-200">Islamic School</p>
                        <h2 class="mt-3 text-3xl font-extrabold sm:text-4xl">SMP Al-Qadri</h2>
                        <p class="mt-4 max-w-sm text-sm leading-7 text-emerald-50">Lingkungan belajar yang mengutamakan ilmu, akhlak, dan kepedulian.</p>
                    </div>
                </div>
                <div>
                    <p class="section-label">Tentang Sekolah</p>
                    <h2 class="mt-4 text-3xl font-extrabold leading-tight tracking-tight text-emerald-950 sm:text-4xl lg:text-[43px]">Tempat Bertumbuh dalam Ilmu dan Karakter</h2>
                    <p class="mt-6 text-sm leading-8 text-slate-600 sm:text-base">SMP Al-Qadri Islamic School berkomitmen mendukung pembelajaran dan pembinaan karakter peserta didik. Melalui kerja sama sekolah, guru, dan orang tua, kami membangun lingkungan pendidikan yang terarah dan penuh perhatian.</p>
                    <div class="mt-7 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-2xl border border-slate-100 bg-[#f4f9f6] p-5"><span class="text-sm font-extrabold text-emerald-950">Pendidikan Islami</span><p class="mt-2 text-xs leading-6 text-slate-600">Menguatkan pengetahuan dan nilai-nilai kebaikan.</p></div>
                        <div class="rounded-2xl border border-slate-100 bg-[#f4f9f6] p-5"><span class="text-sm font-extrabold text-emerald-950">Kolaborasi Sekolah</span><p class="mt-2 text-xs leading-6 text-slate-600">Menghubungkan guru dan orang tua dalam satu portal.</p></div>
                    </div>
                    <a href="{{ route('tentang') }}" class="mt-8 inline-flex items-center gap-3 rounded-full bg-emerald-800 px-7 py-3.5 text-sm font-bold text-white transition hover:bg-emerald-900">Selengkapnya tentang Sekolah <span aria-hidden="true">→</span></a>
                </div>
            </div>
        </section>

        {{-- BERITA TERBARU --}}
        <section id="berita" class="bg-[#f2f7f4] py-16 lg:py-24">
            <div class="mx-auto max-w-7xl px-5 lg:px-8">
                <div class="mb-10 flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
                    <div><p class="section-label">Kabar & Aktivitas</p><h2 class="mt-3 text-3xl font-extrabold tracking-tight text-emerald-950 sm:text-4xl">Berita Terbaru Sekolah</h2><p class="mt-3 max-w-xl text-sm leading-7 text-slate-600">Cerita kegiatan, prestasi siswa, serta informasi yang diterbitkan sekolah.</p></div>
                    <a href="{{ route('berita.index') }}" class="inline-flex shrink-0 items-center gap-2 text-sm font-extrabold text-emerald-800 hover:text-emerald-950">Lihat Semua Berita <span aria-hidden="true">→</span></a>
                </div>
                @if($beritaTerbaru->isNotEmpty())
                    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                        @foreach($beritaTerbaru as $item)
                            <article class="lift overflow-hidden rounded-[24px] border border-slate-100 bg-white shadow-soft">
                                <a href="{{ route('berita.show', $item->slug) }}" class="block" aria-label="Baca berita: {{ $item->judul }}">
                                    <div class="relative h-56 overflow-hidden bg-emerald-800">
                                        @if($item->gambar)
                                            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($item->gambar) }}" alt="Foto berita: {{ $item->judul }}" loading="lazy" class="h-full w-full object-cover transition duration-500 hover:scale-105">
                                        @else
                                            <div class="hero-fallback flex h-full w-full items-center justify-center"><img src="{{ asset('logo-baru.png') }}" alt="" class="h-28 w-28 object-contain opacity-75"></div>
                                        @endif
                                        <span class="absolute bottom-4 left-4 rounded-full bg-white px-3 py-1.5 text-[11px] font-extrabold text-emerald-800 shadow">{{ $item->kategori ?: 'Berita Sekolah' }}</span>
                                    </div>
                                    <div class="p-6">
                                        <time class="text-[11px] font-bold tracking-wide text-slate-500" datetime="{{ $item->published_at?->toDateString() }}">{{ $item->published_at?->copy()->timezone('Asia/Makassar')->translatedFormat('d F Y') }}</time>
                                        <h3 class="clamp-2 mt-3 text-lg font-extrabold leading-7 text-slate-900">{{ $item->judul }}</h3>
                                        <p class="clamp-3 mt-3 text-sm leading-7 text-slate-600">{{ $item->ringkasan }}</p>
                                        <span class="mt-6 inline-flex items-center gap-2 text-xs font-extrabold text-emerald-700">Baca Artikel <span aria-hidden="true">→</span></span>
                                    </div>
                                </a>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="rounded-3xl border border-emerald-100 bg-white px-8 py-14 text-center shadow-soft"><div class="mx-auto mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-50 text-2xl text-emerald-700" aria-hidden="true">✦</div><h3 class="text-lg font-extrabold text-emerald-950">Belum ada berita diterbitkan</h3><p class="mx-auto mt-3 max-w-md text-sm leading-7 text-slate-600">Berita kegiatan dan prestasi akan ditampilkan di sini setelah admin menerbitkan artikel.</p><a href="{{ route('berita.index') }}" class="mt-5 inline-flex text-sm font-bold text-emerald-700 hover:underline">Buka Halaman Berita →</a></div>
                @endif
            </div>
        </section>

        {{-- PENGUMUMAN SEKOLAH --}}
        <section id="pengumuman-terbaru" class="bg-white py-16 lg:py-24">
            <div class="mx-auto max-w-7xl px-5 lg:px-8">
                <div class="mb-10 flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
                    <div>
                        <p class="section-label">Informasi Resmi</p>
                        <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-emerald-950 sm:text-4xl">Pengumuman Sekolah</h2>
                        <p class="mt-3 max-w-xl text-sm leading-7 text-slate-600">Jadwal, pemberitahuan penting, dan informasi resmi terbaru bagi warga sekolah.</p>
                    </div>
                    <a href="{{ route('pengumuman') }}" class="inline-flex shrink-0 items-center gap-2 text-sm font-extrabold text-emerald-800 hover:text-emerald-950">Lihat Semua Pengumuman <span aria-hidden="true">→</span></a>
                </div>
                @if($pengumumanTerbaru->isNotEmpty())
                    <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
                        @foreach($pengumumanTerbaru as $item)
                            <a href="{{ route('pengumuman.show', $item->slug) }}"
                               class="lift group block overflow-hidden rounded-[24px] border border-emerald-100 bg-[#f8fbf9] p-6 shadow-sm sm:p-7">
                                <div class="flex items-start justify-between gap-3">
                                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-[11px] font-extrabold text-emerald-800">{{ $item->kategori ?: 'Umum' }}</span>
                                    @if($item->is_pinned)<span class="rounded-full bg-amber-100 px-3 py-1 text-[11px] font-bold text-amber-800">Penting</span>@endif
                                </div>
                                <time datetime="{{ $item->published_at?->toDateString() }}" class="mt-6 block text-xs font-semibold text-slate-500">{{ $item->published_at?->copy()->timezone('Asia/Makassar')->format('d/m/Y') }}</time>
                                <h3 class="clamp-2 mt-3 text-lg font-extrabold leading-7 text-emerald-950 group-hover:text-emerald-700">{{ $item->judul }}</h3>
                                <p class="clamp-3 mt-3 text-sm leading-7 text-slate-600">{{ $item->ringkasan }}</p>
                                <span class="mt-6 inline-flex text-xs font-extrabold text-emerald-700">Baca Pengumuman →</span>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="rounded-3xl border border-emerald-100 bg-[#f7faf8] px-8 py-12 text-center">
                        <h3 class="text-lg font-extrabold text-emerald-950">Belum ada pengumuman aktif</h3>
                        <p class="mx-auto mt-3 max-w-md text-sm leading-7 text-slate-600">Pengumuman akan muncul setelah admin menerbitkan informasi resmi sekolah.</p>
                        <a href="{{ route('pengumuman') }}" class="mt-5 inline-flex text-sm font-bold text-emerald-700 hover:underline">Buka Halaman Pengumuman →</a>
                    </div>
                @endif
            </div>
        </section>

        {{-- STRUKTUR ORGANISASI --}}
        <section id="struktur" class="bg-white py-16 lg:py-24">
            <div class="mx-auto max-w-7xl px-5 lg:px-8">
                <div class="mb-10 text-center"><p class="section-label">Keluarga Besar Sekolah</p><h2 class="mt-3 text-3xl font-extrabold tracking-tight text-emerald-950 sm:text-4xl">Struktur Organisasi</h2><p class="mx-auto mt-4 max-w-2xl text-sm leading-7 text-slate-600">Kenali orang-orang yang berperan dalam pengelolaan dan pendidikan di SMP Al-Qadri Islamic School.</p></div>
                @if($leaders->isNotEmpty())
                    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                        @foreach($leaders as $position)
                            <article class="overflow-hidden rounded-[24px] border border-emerald-100 bg-[#f8fbf9] shadow-soft">
                                <div class="bg-emerald-900 px-5 py-4 text-center"><h3 class="text-sm font-extrabold leading-6 text-white">{{ $position->title }}</h3></div>
                                <div class="space-y-6 px-5 py-7 text-center">
                                    @forelse($position->members->take(2) as $member)
                                        <div>
                                            @if($member->photo_path)
                                                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($member->photo_path) }}" alt="Foto {{ $member->name }}" loading="lazy" class="mx-auto mb-4 h-24 w-24 rounded-full border-4 border-white object-cover shadow-md">
                                            @else
                                                <div class="mx-auto mb-4 flex h-24 w-24 items-center justify-center rounded-full border-4 border-white bg-emerald-100 text-3xl font-extrabold text-emerald-700 shadow-md" aria-hidden="true">{{ mb_strtoupper(mb_substr($member->name, 0, 1)) }}</div>
                                            @endif
                                            <p class="text-sm font-extrabold leading-6 text-emerald-950">{{ $member->name }}</p>
                                            @if($member->subtitle)<p class="mt-1 text-xs leading-5 text-slate-500">{{ $member->subtitle }}</p>@endif
                                        </div>
                                    @empty
                                        <div class="py-8"><p class="text-sm text-slate-500">Belum ada personel yang dipublikasikan.</p></div>
                                    @endforelse
                                    @if($position->members->count() > 2)<p class="text-xs font-semibold text-emerald-700">+ {{ $position->members->count() - 2 }} personel lainnya</p>@endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="mx-auto max-w-2xl rounded-3xl border border-emerald-100 bg-[#f7faf8] px-7 py-11 text-center"><div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-emerald-100 text-2xl text-emerald-800" aria-hidden="true">⌂</div><h3 class="mt-5 text-lg font-extrabold text-emerald-950">Struktur organisasi sekolah</h3><p class="mt-3 text-sm leading-7 text-slate-600">Profil pimpinan dan personel akan muncul di sini setelah dipilih oleh admin untuk ditampilkan pada homepage.</p></div>
                @endif
                <div class="mt-10 text-center"><a href="{{ route('struktur.index') }}" class="inline-flex items-center justify-center gap-3 rounded-full border-2 border-emerald-700 px-7 py-3.5 text-sm font-extrabold text-emerald-800 transition hover:bg-emerald-700 hover:text-white">Lihat Bagan Organisasi Lengkap <span aria-hidden="true">→</span></a></div>
            </div>
        </section>

        {{-- SISTEM INFORMASI --}}
        <section id="fitur" class="bg-[#f2f7f4] py-16 lg:py-20">
            <div class="mx-auto max-w-7xl px-5 lg:px-8">
                <div class="mb-9 max-w-2xl"><p class="section-label">Layanan Digital</p><h2 class="mt-3 text-3xl font-extrabold text-emerald-950 sm:text-4xl">Satu Portal untuk Warga Sekolah</h2><p class="mt-4 text-sm leading-7 text-slate-600">Pengelolaan informasi dan pendampingan siswa dilakukan melalui sistem dengan hak akses sesuai peran.</p></div>
                <div class="grid gap-5 md:grid-cols-3">
                    <div class="rounded-[24px] border border-emerald-100 bg-white p-7"><span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100 text-lg font-extrabold text-emerald-800">01</span><h3 class="mt-6 text-lg font-extrabold text-emerald-950">Administrasi Sekolah</h3><p class="mt-3 text-sm leading-7 text-slate-600">Admin mengelola data akademik, pengumuman, berita, serta laporan yang dibutuhkan sekolah.</p></div>
                    <div class="rounded-[24px] border border-emerald-100 bg-white p-7"><span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100 text-lg font-extrabold text-emerald-800">02</span><h3 class="mt-6 text-lg font-extrabold text-emerald-950">Pembinaan Siswa</h3><p class="mt-3 text-sm leading-7 text-slate-600">Guru dapat mencatat dan meninjau riwayat pelanggaran serta kebajikan siswa secara terstruktur.</p></div>
                    <div class="rounded-[24px] border border-emerald-100 bg-white p-7"><span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100 text-lg font-extrabold text-emerald-800">03</span><h3 class="mt-6 text-lg font-extrabold text-emerald-950">Informasi Orang Tua</h3><p class="mt-3 text-sm leading-7 text-slate-600">Orang tua dapat memantau informasi dan perkembangan anak melalui akun masing-masing.</p></div>
                </div>
            </div>
        </section>

        {{-- NILAI SEKOLAH & CTA --}}
        <section class="relative overflow-hidden bg-emerald-950 py-20 text-white lg:py-24">
            <div class="absolute -left-16 -top-20 h-72 w-72 rounded-full bg-emerald-500/15 blur-3xl" aria-hidden="true"></div>
            <div class="absolute -bottom-28 -right-20 h-72 w-72 rounded-full bg-amber-300/10 blur-3xl" aria-hidden="true"></div>
            <div class="relative mx-auto max-w-4xl px-5 text-center lg:px-8">
                <p class="font-arabic text-4xl leading-relaxed text-amber-200 sm:text-5xl" lang="ar" dir="rtl">وَقُل رَّبِّ زِدْنِي عِلْمًا</p>
                <p class="mt-4 text-xs font-bold uppercase tracking-widest text-emerald-200">QS. Taha: 114</p>
                <h2 class="mt-8 text-3xl font-extrabold leading-tight sm:text-4xl">Bersama Membangun Generasi Berilmu dan Berakhlak</h2>
                <p class="mx-auto mt-5 max-w-2xl text-sm leading-8 text-emerald-100">“Dan katakanlah: Ya Tuhanku, tambahkanlah kepadaku ilmu pengetahuan.”</p>
                <div class="mt-9 flex flex-wrap justify-center gap-3"><a href="{{ $dashboardUrl }}" class="inline-flex items-center justify-center rounded-full bg-amber-400 px-8 py-3.5 text-sm font-extrabold text-emerald-950 transition hover:bg-amber-300">{{ auth()->check() ? 'Buka Dashboard' : 'Masuk Portal Sekolah' }}</a><a href="{{ route('pengumuman') }}" class="inline-flex items-center justify-center rounded-full border border-white/40 px-8 py-3.5 text-sm font-extrabold text-white transition hover:bg-white/10">Lihat Pengumuman</a><button id="install-button" onclick="installSchoolApp()" type="button" class="hidden items-center justify-center rounded-full border border-white/40 px-7 py-3.5 text-sm font-bold text-white hover:bg-white/10">Instal Aplikasi</button></div>
            </div>
        </section>
    </main>

    {{-- FOOTER --}}
    <footer class="bg-[#09251f] py-14 text-emerald-50">
        <div class="mx-auto max-w-7xl px-5 lg:px-8">
            <div class="grid gap-10 border-b border-white/10 pb-12 md:grid-cols-3 lg:grid-cols-12">
                <div class="lg:col-span-5"><div class="flex items-center gap-3"><img src="{{ asset('logo-baru.png') }}" alt="Logo SMP Al-Qadri" class="h-14 w-14 rounded-xl bg-white p-1 object-contain"><span><span class="block text-base font-extrabold text-white">SMP AL-QADRI</span><span class="mt-1 block text-xs font-semibold tracking-widest text-emerald-300">ISLAMIC SCHOOL</span></span></div><p class="mt-6 max-w-md text-sm leading-8 text-emerald-100/70">Website resmi SMP Al-Qadri Islamic School, sebagai pusat informasi sekolah dan akses layanan digital untuk guru serta orang tua.</p></div>
                <div class="md:col-span-1 lg:col-span-3"><h3 class="text-sm font-extrabold text-white">Informasi Sekolah</h3><div class="mt-5 flex flex-col gap-3 text-sm text-emerald-100/70"><a class="hover:text-white" href="{{ route('tentang') }}">Tentang Sekolah</a><a class="hover:text-white" href="{{ route('berita.index') }}">Berita Sekolah</a><a class="hover:text-white" href="{{ route('struktur.index') }}">Struktur Organisasi</a><a class="hover:text-white" href="{{ route('pengumuman') }}">Pengumuman</a><a class="hover:text-white" href="{{ route('layanan') }}">Layanan</a></div></div>
                <div class="md:col-span-1 lg:col-span-4"><h3 class="text-sm font-extrabold text-white">Portal Sekolah</h3><p class="mt-5 max-w-xs text-sm leading-8 text-emerald-100/70">Akses layanan khusus admin, guru, dan orang tua menggunakan akun yang telah diberikan sekolah.</p><a href="{{ $dashboardUrl }}" class="mt-5 inline-flex items-center gap-2 text-sm font-extrabold text-amber-300 hover:text-amber-200">{{ auth()->check() ? 'Buka Dashboard' : 'Login Portal' }} <span aria-hidden="true">→</span></a></div>
            </div>
            <div class="flex flex-col justify-between gap-3 pt-7 text-xs text-emerald-100/50 sm:flex-row"><p>© {{ date('Y') }} SMP Al-Qadri Islamic School. Hak cipta dilindungi.</p><p>Sistem Informasi Sekolah</p></div>
        </div>
    </footer>

    <script>
        // Navigasi mobile.
        const mobileButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        mobileButton?.addEventListener('click', () => {
            const isOpen = mobileButton.getAttribute('aria-expanded') === 'true';
            mobileButton.setAttribute('aria-expanded', String(!isOpen));
            mobileMenu?.classList.toggle('hidden', isOpen);
        });
        mobileMenu?.querySelectorAll('a').forEach(link => link.addEventListener('click', () => {
            mobileMenu.classList.add('hidden');
            mobileButton?.setAttribute('aria-expanded', 'false');
        }));

        // Jumbotron slideshow: otomatis tiap 6 detik, jeda saat hover/focus, dukung reduced motion.
        (() => {
            const root = document.getElementById('hero-slider');
            if (!root) return;
            const slides = Array.from(root.querySelectorAll('[data-hero-slide]'));
            const dots = Array.from(root.querySelectorAll('[data-slide-to]'));
            const prev = document.getElementById('hero-prev');
            const next = document.getElementById('hero-next');
            const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
            let current = 0;
            let timer = null;

            function goTo(index) {
                if (!slides.length) return;
                current = (index + slides.length) % slides.length;
                slides.forEach((slide, i) => {
                    const active = i === current;
                    slide.classList.toggle('is-active', active);
                    slide.setAttribute('aria-hidden', String(!active));
                    // Hindari tautan dalam slide tersembunyi bisa ditab.
                    slide.querySelectorAll('a, button').forEach(el => { el.tabIndex = active ? 0 : -1; });
                });
                dots.forEach((dot, i) => dot.setAttribute('aria-current', String(i === current)));
            }
            function stop() { if (timer !== null) { clearInterval(timer); timer = null; } }
            function start() {
                stop();
                if (reducedMotion.matches || document.hidden || slides.length <= 1) return;
                timer = window.setInterval(() => goTo(current + 1), 6000);
            }
            prev?.addEventListener('click', () => { goTo(current - 1); start(); });
            next?.addEventListener('click', () => { goTo(current + 1); start(); });
            dots.forEach((dot, i) => dot.addEventListener('click', () => { goTo(i); start(); }));
            root.addEventListener('mouseenter', stop);
            root.addEventListener('mouseleave', start);
            root.addEventListener('focusin', stop);
            root.addEventListener('focusout', (event) => { if (!root.contains(event.relatedTarget)) start(); });
            root.addEventListener('keydown', (event) => {
                if (event.key === 'ArrowLeft' || event.key === 'ArrowRight') {
                    event.preventDefault(); goTo(current + (event.key === 'ArrowRight' ? 1 : -1));
                }
            });
            document.addEventListener('visibilitychange', start);
            reducedMotion.addEventListener?.('change', start);
            goTo(0);
            start();
        })();

        // PWA: mempertahankan fungsi homepage lama.
        let deferredPrompt = null;
        const installButton = document.getElementById('install-button');
        window.addEventListener('beforeinstallprompt', event => {
            event.preventDefault(); deferredPrompt = event;
            installButton?.classList.remove('hidden');
            installButton?.classList.add('inline-flex');
        });
        async function installSchoolApp() {
            if (!deferredPrompt) return;
            deferredPrompt.prompt();
            await deferredPrompt.userChoice;
            deferredPrompt = null;
            installButton?.classList.add('hidden');
            installButton?.classList.remove('inline-flex');
        }
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/serviceworker.js').catch(error => {
                    console.error('Service Worker gagal:', error);
                });
            });
        }
        const offlineStatus = document.getElementById('offline-status');
        function updateConnectionStatus() { offlineStatus?.classList.toggle('hidden', navigator.onLine); }
        window.addEventListener('online', updateConnectionStatus);
        window.addEventListener('offline', updateConnectionStatus);
        updateConnectionStatus();
    </script>
</body>
</html>
