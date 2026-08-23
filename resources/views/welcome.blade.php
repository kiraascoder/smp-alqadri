<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        SMP Al-Qadri Islamic School
    </title>

    <meta name="description"
        content="Website resmi SMP Al-Qadri Islamic School. Informasi sekolah, pengumuman, layanan sekolah, serta Sistem Informasi Bimbingan dan Konseling untuk guru, orang tua, dan administrator.">

    <meta name="keywords"
        content="SMP Al-Qadri, SMP Al-Qadri Islamic School, sekolah Islam, pendidikan Islam, bimbingan konseling, informasi sekolah">

    <meta name="author" content="SMP Al-Qadri Islamic School">

    <meta name="theme-color" content="#047857">

    <meta property="og:title" content="SMP Al-Qadri Islamic School">

    <meta property="og:description" content="Website resmi SMP Al-Qadri Islamic School">

    <meta property="og:url" content="{{ url('/') }}">

    <meta property="og:type" content="website">


    {{-- PWA --}}
    <link rel="manifest" href="/manifest.json">

    <link rel="apple-touch-icon" href="/images/icons/icon-192x192.png">

    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">


    {{-- FONT --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Amiri:wght@400;700&display=swap"
        rel="stylesheet">


    {{-- TAILWIND --}}
    <script src="https://cdn.tailwindcss.com"></script>


    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }

        .arabic {
            font-family: 'Amiri', serif;
            direction: rtl;
        }

        .hero-gradient {
            background:
                linear-gradient(135deg,
                    #064e3b 0%,
                    #047857 50%,
                    #059669 100%);
        }

        .glass {
            background: rgba(255, 255, 255, 0.10);
            border: 1px solid rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
        }

        .card-hover {
            transition: all .3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow:
                0 20px 35px rgba(15, 23, 42, .10);
        }
    </style>
</head>


<body class="bg-slate-50 text-slate-800">


    {{-- ============================================================= --}}
    {{-- OFFLINE STATUS --}}
    {{-- ============================================================= --}}

    <div id="offline-status"
        class="
            hidden
            fixed top-0 left-0 right-0
            z-[100]
            bg-amber-500
            text-white
            text-center
            text-sm
            px-4 py-2
        ">

        Anda sedang offline. Beberapa fitur mungkin tidak tersedia.

    </div>



    {{-- ============================================================= --}}
    {{-- NAVBAR --}}
    {{-- ============================================================= --}}

    <header
        class="
            fixed
            top-0 left-0 right-0
            z-50
            bg-white/95
            backdrop-blur
            border-b
            border-slate-200
        ">

        <div
            class="
                max-w-7xl
                mx-auto
                px-5
                lg:px-8
                h-20
                flex
                items-center
                justify-between
            ">


            {{-- LOGO --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3">

                <img src="{{ asset('logo.png') }}" alt="Logo SMP Al-Qadri" class="w-12 h-12 object-contain">

                <div>

                    <h1
                        class="
                            text-sm
                            sm:text-base
                            font-bold
                            text-slate-900
                            leading-tight
                        ">

                        SMP AL-QADRI

                    </h1>

                    <p
                        class="
                            text-xs
                            text-emerald-600
                            font-medium
                        ">

                        Islamic School

                    </p>

                </div>

            </a>



            {{-- DESKTOP MENU --}}
            <nav
                class="
                    hidden
                    lg:flex
                    items-center
                    gap-7
                    text-sm
                    font-medium
                    text-slate-600
                ">

                <a href="{{ route('home') }}" class="hover:text-emerald-600 transition">

                    Beranda

                </a>

                <a href="{{ route('tentang') }}" class="hover:text-emerald-600 transition">

                    Tentang

                </a>

                <a href="{{ route('layanan') }}" class="hover:text-emerald-600 transition">

                    Layanan

                </a>

                <a href="{{ route('pengumuman') }}" class="hover:text-emerald-600 transition">

                    Pengumuman

                </a>

                <a href="#fitur" class="hover:text-emerald-600 transition">

                    Sistem Informasi

                </a>

            </nav>



            {{-- PORTAL BUTTON --}}
            <div class="hidden lg:block">

                @auth

                    @php
                        $dashboardRoute = match (auth()->user()->role) {
                            'admin' => route('admin.dashboard'),
                            'guru' => route('guru.dashboard'),
                            'orang_tua' => route('ortu.dashboard'),
                            default => route('home'),
                        };
                    @endphp

                    <a href="{{ $dashboardRoute }}"
                        class="
                            inline-flex
                            items-center
                            gap-2
                            bg-emerald-600
                            hover:bg-emerald-700
                            text-white
                            px-5 py-2.5
                            rounded-xl
                            font-semibold
                            text-sm
                            transition
                        ">

                        Dashboard

                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="
                            inline-flex
                            items-center
                            gap-2
                            bg-emerald-600
                            hover:bg-emerald-700
                            text-white
                            px-5 py-2.5
                            rounded-xl
                            font-semibold
                            text-sm
                            transition
                        ">

                        Login Portal

                    </a>

                @endauth

            </div>



            {{-- MOBILE MENU BUTTON --}}
            <button id="mobile-menu-button" type="button"
                class="
                    lg:hidden
                    w-10 h-10
                    rounded-xl
                    border border-slate-200
                    flex items-center justify-center
                    text-slate-700
                ">

                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />

                </svg>

            </button>

        </div>


        {{-- MOBILE MENU --}}
        <div id="mobile-menu"
            class="
                hidden
                lg:hidden
                border-t
                border-slate-200
                bg-white
            ">

            <div
                class="
                    px-5
                    py-5
                    flex
                    flex-col
                    gap-2
                ">

                <a href="{{ route('home') }}"
                    class="
                        px-4 py-3
                        rounded-xl
                        hover:bg-slate-50
                    ">

                    Beranda

                </a>

                <a href="{{ route('tentang') }}"
                    class="
                        px-4 py-3
                        rounded-xl
                        hover:bg-slate-50
                    ">

                    Tentang Sekolah

                </a>

                <a href="{{ route('layanan') }}"
                    class="
                        px-4 py-3
                        rounded-xl
                        hover:bg-slate-50
                    ">

                    Layanan

                </a>

                <a href="{{ route('pengumuman') }}"
                    class="
                        px-4 py-3
                        rounded-xl
                        hover:bg-slate-50
                    ">

                    Pengumuman

                </a>

                <a href="#fitur"
                    class="
                        px-4 py-3
                        rounded-xl
                        hover:bg-slate-50
                    ">

                    Sistem Informasi

                </a>


                @auth

                    <a href="{{ $dashboardRoute }}"
                        class="
                            mt-2
                            bg-emerald-600
                            text-white
                            text-center
                            px-4 py-3
                            rounded-xl
                            font-semibold
                        ">

                        Dashboard

                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="
                            mt-2
                            bg-emerald-600
                            text-white
                            text-center
                            px-4 py-3
                            rounded-xl
                            font-semibold
                        ">

                        Login Portal

                    </a>

                @endauth

            </div>

        </div>

    </header>



    {{-- ============================================================= --}}
    {{-- HERO --}}
    {{-- ============================================================= --}}

    <section
        class="
            hero-gradient
            relative
            overflow-hidden
            pt-32
            pb-20
            lg:pt-44
            lg:pb-32
        ">


        <div
            class="
                absolute
                -top-20
                -right-20
                w-96 h-96
                rounded-full
                bg-white/10
                blur-3xl
            ">
        </div>


        <div
            class="
                absolute
                bottom-0
                -left-20
                w-96 h-96
                rounded-full
                bg-emerald-300/10
                blur-3xl
            ">
        </div>


        <div
            class="
                max-w-7xl
                mx-auto
                px-5
                lg:px-8
                relative
                z-10
            ">


            <div
                class="
                    grid
                    lg:grid-cols-2
                    gap-14
                    items-center
                ">


                {{-- HERO TEXT --}}
                <div class="text-white">


                    <div
                        class="
                            inline-flex
                            items-center
                            gap-2
                            glass
                            px-4 py-2
                            rounded-full
                            text-sm
                            mb-6
                        ">

                        <span
                            class="
                                w-2 h-2
                                bg-emerald-300
                                rounded-full
                            ">
                        </span>

                        Website Resmi SMP Al-Qadri Islamic School

                    </div>



                    <h2
                        class="
                            text-4xl
                            sm:text-5xl
                            lg:text-6xl
                            font-extrabold
                            leading-tight
                        ">

                        Pendidikan Islami untuk

                        <span
                            class="
                                block
                                text-emerald-200
                                mt-2
                            ">

                            Generasi Berilmu dan Berakhlak

                        </span>

                    </h2>



                    <p
                        class="
                            mt-6
                            text-lg
                            lg:text-xl
                            text-emerald-50
                            leading-relaxed
                            max-w-2xl
                        ">

                        Selamat datang di website SMP Al-Qadri Islamic School.
                        Website ini menjadi pusat informasi sekolah sekaligus
                        akses menuju sistem layanan digital sekolah untuk
                        mendukung komunikasi antara sekolah, guru, dan
                        orang tua siswa.

                    </p>



                    <div
                        class="
                            mt-8
                            flex
                            flex-col
                            sm:flex-row
                            gap-4
                        ">


                        <a href="{{ route('tentang') }}"
                            class="
                                inline-flex
                                justify-center
                                items-center
                                px-7 py-4
                                bg-white
                                text-emerald-700
                                rounded-xl
                                font-semibold
                                hover:bg-emerald-50
                                transition
                                shadow-lg
                            ">

                            Tentang Sekolah

                        </a>


                        <a href="{{ route('pengumuman') }}"
                            class="
                                inline-flex
                                justify-center
                                items-center
                                px-7 py-4
                                glass
                                text-white
                                rounded-xl
                                font-semibold
                                hover:bg-white/20
                                transition
                            ">

                            Lihat Pengumuman

                        </a>

                    </div>



                    <div
                        class="
                            mt-8
                            flex
                            items-center
                            gap-3
                            text-sm
                            text-emerald-100
                        ">

                        <span>✓ Informasi Sekolah</span>

                        <span>•</span>

                        <span>✓ Portal Guru & Orang Tua</span>

                    </div>

                </div>



                {{-- HERO CARD --}}
                <div class="hidden lg:block">

                    <div
                        class="
                            glass
                            rounded-3xl
                            p-8
                            shadow-2xl
                        ">


                        <div
                            class="
                                bg-white
                                rounded-2xl
                                p-8
                                text-slate-800
                            ">


                            <div
                                class="
                                    flex
                                    justify-center
                                    mb-6
                                ">

                                <img src="{{ asset('logo.png') }}" alt="Logo SMP Al-Qadri"
                                    class="
                                        w-28
                                        h-28
                                        object-contain
                                    ">

                            </div>


                            <div class="text-center">

                                <h3
                                    class="
                                        text-2xl
                                        font-bold
                                        text-slate-900
                                    ">

                                    SMP Al-Qadri

                                </h3>

                                <p
                                    class="
                                        text-emerald-600
                                        font-semibold
                                        mt-1
                                    ">

                                    Islamic School

                                </p>


                                <p
                                    class="
                                        text-slate-500
                                        mt-4
                                        leading-relaxed
                                    ">

                                    Membangun lingkungan pendidikan
                                    yang mendukung perkembangan akademik,
                                    karakter, kedisiplinan, dan kebajikan siswa.

                                </p>

                            </div>


                            <div
                                class="
                                    grid
                                    grid-cols-3
                                    gap-3
                                    mt-8
                                ">

                                <div
                                    class="
                                        bg-emerald-50
                                        rounded-xl
                                        p-4
                                        text-center
                                    ">

                                    <div class="text-2xl">
                                        📚
                                    </div>

                                    <p
                                        class="
                                            text-xs
                                            font-semibold
                                            mt-2
                                        ">

                                        Pendidikan

                                    </p>

                                </div>


                                <div
                                    class="
                                        bg-blue-50
                                        rounded-xl
                                        p-4
                                        text-center
                                    ">

                                    <div class="text-2xl">
                                        👨‍🏫
                                    </div>

                                    <p
                                        class="
                                            text-xs
                                            font-semibold
                                            mt-2
                                        ">

                                        Pembinaan

                                    </p>

                                </div>


                                <div
                                    class="
                                        bg-amber-50
                                        rounded-xl
                                        p-4
                                        text-center
                                    ">

                                    <div class="text-2xl">
                                        ⭐
                                    </div>

                                    <p
                                        class="
                                            text-xs
                                            font-semibold
                                            mt-2
                                        ">

                                        Karakter

                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>



    {{-- ============================================================= --}}
    {{-- AKSES CEPAT --}}
    {{-- ============================================================= --}}

    <section class="py-16 bg-white">

        <div
            class="
                max-w-7xl
                mx-auto
                px-5
                lg:px-8
            ">


            <div class="text-center mb-10">

                <p
                    class="
                        text-emerald-600
                        font-semibold
                        text-sm
                        uppercase
                        tracking-wider
                    ">

                    Akses Cepat

                </p>

                <h2
                    class="
                        text-3xl
                        lg:text-4xl
                        font-bold
                        text-slate-900
                        mt-2
                    ">

                    Informasi Sekolah

                </h2>


                <p
                    class="
                        text-slate-500
                        max-w-2xl
                        mx-auto
                        mt-3
                    ">

                    Temukan informasi penting tentang sekolah
                    melalui halaman yang telah tersedia.

                </p>

            </div>



            <div
                class="
                    grid
                    md:grid-cols-3
                    gap-6
                ">


                {{-- TENTANG --}}
                <a href="{{ route('tentang') }}"
                    class="
                        group
                        bg-white
                        border
                        border-slate-200
                        rounded-2xl
                        p-7
                        card-hover
                    ">

                    <div
                        class="
                            w-14 h-14
                            rounded-2xl
                            bg-emerald-100
                            text-emerald-700
                            flex
                            items-center
                            justify-center
                            text-2xl
                        ">

                        🏫

                    </div>


                    <h3
                        class="
                            text-xl
                            font-bold
                            mt-5
                            text-slate-900
                        ">

                        Tentang Sekolah

                    </h3>


                    <p
                        class="
                            text-slate-500
                            mt-2
                            leading-relaxed
                        ">

                        Mengenal SMP Al-Qadri Islamic School
                        dan informasi mengenai sekolah.

                    </p>


                    <div
                        class="
                            mt-5
                            text-emerald-600
                            font-semibold
                            text-sm
                        ">

                        Selengkapnya →

                    </div>

                </a>



                {{-- PENGUMUMAN --}}
                <a href="{{ route('pengumuman') }}"
                    class="
                        group
                        bg-white
                        border
                        border-slate-200
                        rounded-2xl
                        p-7
                        card-hover
                    ">

                    <div
                        class="
                            w-14 h-14
                            rounded-2xl
                            bg-blue-100
                            text-blue-700
                            flex
                            items-center
                            justify-center
                            text-2xl
                        ">

                        📢

                    </div>


                    <h3
                        class="
                            text-xl
                            font-bold
                            mt-5
                            text-slate-900
                        ">

                        Pengumuman

                    </h3>


                    <p
                        class="
                            text-slate-500
                            mt-2
                            leading-relaxed
                        ">

                        Akses informasi dan pengumuman terbaru
                        yang disampaikan oleh sekolah.

                    </p>


                    <div
                        class="
                            mt-5
                            text-blue-600
                            font-semibold
                            text-sm
                        ">

                        Lihat Pengumuman →

                    </div>

                </a>



                {{-- LAYANAN --}}
                <a href="{{ route('layanan') }}"
                    class="
                        group
                        bg-white
                        border
                        border-slate-200
                        rounded-2xl
                        p-7
                        card-hover
                    ">

                    <div
                        class="
                            w-14 h-14
                            rounded-2xl
                            bg-amber-100
                            text-amber-700
                            flex
                            items-center
                            justify-center
                            text-2xl
                        ">

                        🤝

                    </div>


                    <h3
                        class="
                            text-xl
                            font-bold
                            mt-5
                            text-slate-900
                        ">

                        Layanan Sekolah

                    </h3>


                    <p
                        class="
                            text-slate-500
                            mt-2
                            leading-relaxed
                        ">

                        Informasi mengenai layanan sekolah
                        yang dapat dimanfaatkan oleh siswa
                        dan orang tua.

                    </p>


                    <div
                        class="
                            mt-5
                            text-amber-600
                            font-semibold
                            text-sm
                        ">

                        Lihat Layanan →

                    </div>

                </a>

            </div>

        </div>

    </section>



    {{-- ============================================================= --}}
    {{-- FITUR SISTEM --}}
    {{-- ============================================================= --}}

    <section id="fitur" class="py-20 bg-slate-50">

        <div
            class="
                max-w-7xl
                mx-auto
                px-5
                lg:px-8
            ">


            <div class="text-center mb-14">

                <p
                    class="
                        text-emerald-600
                        font-semibold
                        text-sm
                        uppercase
                        tracking-wider
                    ">

                    Sistem Informasi Sekolah

                </p>


                <h2
                    class="
                        text-3xl
                        lg:text-4xl
                        font-bold
                        text-slate-900
                        mt-2
                    ">

                    Fitur Portal Sekolah

                </h2>


                <p
                    class="
                        text-slate-500
                        mt-4
                        max-w-3xl
                        mx-auto
                        leading-relaxed
                    ">

                    Portal sekolah membantu pengelolaan data siswa,
                    pencatatan pelanggaran dan kebajikan,
                    serta memudahkan orang tua memantau perkembangan
                    putra-putrinya.

                </p>

            </div>



            <div
                class="
                    grid
                    sm:grid-cols-2
                    lg:grid-cols-3
                    gap-6
                ">


                {{-- DATA SEKOLAH --}}
                <div
                    class="
                        bg-white
                        border
                        border-slate-200
                        rounded-2xl
                        p-7
                        card-hover
                    ">

                    <div
                        class="
                            w-12 h-12
                            bg-blue-100
                            text-blue-700
                            rounded-xl
                            flex
                            items-center
                            justify-center
                            text-xl
                        ">

                        🗂️

                    </div>


                    <h3
                        class="
                            font-bold
                            text-lg
                            mt-5
                        ">

                        Manajemen Data Sekolah

                    </h3>


                    <p
                        class="
                            text-slate-500
                            text-sm
                            leading-relaxed
                            mt-2
                        ">

                        Admin dapat mengelola data guru,
                        kelas, siswa, serta akun orang tua
                        dalam satu sistem.

                    </p>

                </div>



                {{-- PELANGGARAN --}}
                <div
                    class="
                        bg-white
                        border
                        border-slate-200
                        rounded-2xl
                        p-7
                        card-hover
                    ">

                    <div
                        class="
                            w-12 h-12
                            bg-red-100
                            text-red-700
                            rounded-xl
                            flex
                            items-center
                            justify-center
                            text-xl
                        ">

                        ⚠️

                    </div>


                    <h3
                        class="
                            font-bold
                            text-lg
                            mt-5
                        ">

                        Pencatatan Pelanggaran

                    </h3>


                    <p
                        class="
                            text-slate-500
                            text-sm
                            leading-relaxed
                            mt-2
                        ">

                        Guru dapat mencatat pelanggaran siswa
                        berdasarkan jenis dan skor pelanggaran
                        yang telah ditentukan sekolah.

                    </p>

                </div>



                {{-- KEBAJIKAN --}}
                <div
                    class="
                        bg-white
                        border
                        border-slate-200
                        rounded-2xl
                        p-7
                        card-hover
                    ">

                    <div
                        class="
                            w-12 h-12
                            bg-emerald-100
                            text-emerald-700
                            rounded-xl
                            flex
                            items-center
                            justify-center
                            text-xl
                        ">

                        ⭐

                    </div>


                    <h3
                        class="
                            font-bold
                            text-lg
                            mt-5
                        ">

                        Poin Kebajikan

                    </h3>


                    <p
                        class="
                            text-slate-500
                            text-sm
                            leading-relaxed
                            mt-2
                        ">

                        Perilaku positif siswa dapat dicatat
                        melalui sistem poin kebajikan sebagai
                        bentuk pembinaan karakter.

                    </p>

                </div>



                {{-- MONITORING ORTU --}}
                <div
                    class="
                        bg-white
                        border
                        border-slate-200
                        rounded-2xl
                        p-7
                        card-hover
                    ">

                    <div
                        class="
                            w-12 h-12
                            bg-purple-100
                            text-purple-700
                            rounded-xl
                            flex
                            items-center
                            justify-center
                            text-xl
                        ">

                        👪

                    </div>


                    <h3
                        class="
                            font-bold
                            text-lg
                            mt-5
                        ">

                        Portal Orang Tua

                    </h3>


                    <p
                        class="
                            text-slate-500
                            text-sm
                            leading-relaxed
                            mt-2
                        ">

                        Orang tua dapat melihat informasi anak,
                        riwayat pelanggaran, skor,
                        dan kebajikan yang telah diberikan.

                    </p>

                </div>



                {{-- DASHBOARD GURU --}}
                <div
                    class="
                        bg-white
                        border
                        border-slate-200
                        rounded-2xl
                        p-7
                        card-hover
                    ">

                    <div
                        class="
                            w-12 h-12
                            bg-amber-100
                            text-amber-700
                            rounded-xl
                            flex
                            items-center
                            justify-center
                            text-xl
                        ">

                        👨‍🏫

                    </div>


                    <h3
                        class="
                            font-bold
                            text-lg
                            mt-5
                        ">

                        Dashboard Guru

                    </h3>


                    <p
                        class="
                            text-slate-500
                            text-sm
                            leading-relaxed
                            mt-2
                        ">

                        Guru dapat melihat riwayat pelanggaran
                        dan kebajikan yang telah diberikan
                        kepada siswa.

                    </p>

                </div>



                {{-- REKAP --}}
                <div
                    class="
                        bg-white
                        border
                        border-slate-200
                        rounded-2xl
                        p-7
                        card-hover
                    ">

                    <div
                        class="
                            w-12 h-12
                            bg-cyan-100
                            text-cyan-700
                            rounded-xl
                            flex
                            items-center
                            justify-center
                            text-xl
                        ">

                        📊

                    </div>


                    <h3
                        class="
                            font-bold
                            text-lg
                            mt-5
                        ">

                        Rekap & Laporan

                    </h3>


                    <p
                        class="
                            text-slate-500
                            text-sm
                            leading-relaxed
                            mt-2
                        ">

                        Admin dapat melakukan filter,
                        melihat rekap pelanggaran dan kebajikan,
                        serta mengunduh laporan dalam format PDF.

                    </p>

                </div>

            </div>

        </div>

    </section>



    {{-- ============================================================= --}}
    {{-- ROLE SECTION --}}
    {{-- ============================================================= --}}

    <section class="py-20 bg-white">

        <div
            class="
                max-w-7xl
                mx-auto
                px-5
                lg:px-8
            ">


            <div
                class="
                    grid
                    lg:grid-cols-2
                    gap-14
                    items-center
                ">


                <div>

                    <p
                        class="
                            text-emerald-600
                            uppercase
                            font-semibold
                            tracking-wider
                            text-sm
                        ">

                        Portal Terintegrasi

                    </p>


                    <h2
                        class="
                            text-3xl
                            lg:text-4xl
                            font-bold
                            text-slate-900
                            mt-3
                        ">

                        Satu Sistem untuk Sekolah,
                        Guru, dan Orang Tua

                    </h2>


                    <p
                        class="
                            text-slate-500
                            leading-relaxed
                            mt-5
                        ">

                        Setiap pengguna memiliki akses yang
                        disesuaikan dengan perannya sehingga
                        informasi sekolah dapat dikelola dan
                        dipantau dengan lebih terstruktur.

                    </p>


                    <div class="mt-8">

                        @auth

                            <a href="{{ $dashboardRoute }}"
                                class="
                                    inline-flex
                                    items-center
                                    gap-2
                                    bg-emerald-600
                                    hover:bg-emerald-700
                                    text-white
                                    px-7 py-3.5
                                    rounded-xl
                                    font-semibold
                                    transition
                                ">

                                Buka Dashboard →

                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="
                                    inline-flex
                                    items-center
                                    gap-2
                                    bg-emerald-600
                                    hover:bg-emerald-700
                                    text-white
                                    px-7 py-3.5
                                    rounded-xl
                                    font-semibold
                                    transition
                                ">

                                Masuk ke Portal →

                            </a>

                        @endauth

                    </div>

                </div>



                <div class="space-y-4">


                    {{-- ADMIN --}}
                    <div
                        class="
                            bg-slate-50
                            border
                            border-slate-200
                            p-5
                            rounded-2xl
                            flex
                            gap-4
                        ">

                        <div
                            class="
                                w-12 h-12
                                shrink-0
                                bg-blue-100
                                rounded-xl
                                flex items-center justify-center
                                text-xl
                            ">

                            🛡️

                        </div>


                        <div>

                            <h3 class="font-bold">
                                Administrator
                            </h3>

                            <p
                                class="
                                    text-sm
                                    text-slate-500
                                    mt-1
                                ">

                                Mengelola guru, kelas, siswa,
                                orang tua, jenis pelanggaran,
                                kebajikan, skorsing, dan laporan.

                            </p>

                        </div>

                    </div>



                    {{-- GURU --}}
                    <div
                        class="
                            bg-slate-50
                            border
                            border-slate-200
                            p-5
                            rounded-2xl
                            flex
                            gap-4
                        ">

                        <div
                            class="
                                w-12 h-12
                                shrink-0
                                bg-amber-100
                                rounded-xl
                                flex items-center justify-center
                                text-xl
                            ">

                            👨‍🏫

                        </div>


                        <div>

                            <h3 class="font-bold">
                                Guru
                            </h3>

                            <p
                                class="
                                    text-sm
                                    text-slate-500
                                    mt-1
                                ">

                                Mencatat pelanggaran,
                                memberikan kebajikan,
                                melihat riwayat,
                                dan mengelola profil.

                            </p>

                        </div>

                    </div>



                    {{-- ORANG TUA --}}
                    <div
                        class="
                            bg-slate-50
                            border
                            border-slate-200
                            p-5
                            rounded-2xl
                            flex
                            gap-4
                        ">

                        <div
                            class="
                                w-12 h-12
                                shrink-0
                                bg-emerald-100
                                rounded-xl
                                flex items-center justify-center
                                text-xl
                            ">

                            👪

                        </div>


                        <div>

                            <h3 class="font-bold">
                                Orang Tua
                            </h3>

                            <p
                                class="
                                    text-sm
                                    text-slate-500
                                    mt-1
                                ">

                                Memantau perkembangan anak,
                                riwayat pelanggaran,
                                serta kebajikan yang diperoleh.

                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>



    {{-- ============================================================= --}}
    {{-- NILAI SEKOLAH --}}
    {{-- ============================================================= --}}

    <section class="py-20 bg-emerald-50">

        <div
            class="
                max-w-7xl
                mx-auto
                px-5
                lg:px-8
            ">


            <div class="text-center">

                <p
                    class="
                        arabic
                        text-3xl
                        text-emerald-800
                    ">

                    وَقُل رَّبِّ زِدْنِي عِلْمًا

                </p>


                <h2
                    class="
                        text-3xl
                        font-bold
                        text-slate-900
                        mt-5
                    ">

                    Pendidikan yang Membentuk Ilmu dan Akhlak

                </h2>


                <p
                    class="
                        max-w-2xl
                        mx-auto
                        text-slate-600
                        mt-4
                        leading-relaxed
                    ">

                    “Dan katakanlah: Ya Tuhanku,
                    tambahkanlah kepadaku ilmu pengetahuan.”

                </p>


                <p
                    class="
                        text-sm
                        text-emerald-700
                        font-medium
                        mt-2
                    ">

                    QS. Taha: 114

                </p>

            </div>

        </div>

    </section>



    {{-- ============================================================= --}}
    {{-- CTA --}}
    {{-- ============================================================= --}}

    <section
        class="
            hero-gradient
            py-20
            relative
            overflow-hidden
        ">


        <div
            class="
                max-w-4xl
                mx-auto
                px-5
                text-center
                text-white
                relative
                z-10
            ">


            <h2
                class="
                    text-3xl
                    lg:text-4xl
                    font-bold
                ">

                Akses Sistem Informasi SMP Al-Qadri

            </h2>


            <p
                class="
                    text-emerald-100
                    mt-4
                    text-lg
                    leading-relaxed
                ">

                Gunakan portal sekolah sesuai akun yang telah
                diberikan untuk mengakses informasi dan layanan
                yang tersedia.

            </p>


            <div
                class="
                    mt-8
                    flex
                    flex-col
                    sm:flex-row
                    justify-center
                    gap-4
                ">


                @auth

                    <a href="{{ $dashboardRoute }}"
                        class="
                            px-8 py-4
                            bg-white
                            text-emerald-700
                            rounded-xl
                            font-semibold
                            hover:bg-emerald-50
                            transition
                        ">

                        Buka Dashboard

                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="
                            px-8 py-4
                            bg-white
                            text-emerald-700
                            rounded-xl
                            font-semibold
                            hover:bg-emerald-50
                            transition
                        ">

                        Login Portal

                    </a>

                @endauth


                <button id="install-button" onclick="installSchoolApp()"
                    class="
                        hidden
                        px-8 py-4
                        glass
                        text-white
                        rounded-xl
                        font-semibold
                        transition
                    ">

                    Install Aplikasi

                </button>

            </div>

        </div>

    </section>



    {{-- ============================================================= --}}
    {{-- FOOTER --}}
    {{-- ============================================================= --}}

    <footer class="bg-slate-950 text-white">

        <div
            class="
                max-w-7xl
                mx-auto
                px-5
                lg:px-8
                py-12
            ">


            <div
                class="
                    grid
                    md:grid-cols-3
                    gap-10
                ">


                {{-- SCHOOL --}}
                <div>

                    <div
                        class="
                            flex
                            items-center
                            gap-3
                        ">

                        <img src="{{ asset('logo.png') }}" alt="Logo"
                            class="
                                w-12 h-12
                                object-contain
                            ">

                        <div>

                            <h3 class="font-bold">
                                SMP AL-QADRI
                            </h3>

                            <p
                                class="
                                    text-sm
                                    text-emerald-400
                                ">

                                Islamic School

                            </p>

                        </div>

                    </div>


                    <p
                        class="
                            text-slate-400
                            text-sm
                            leading-relaxed
                            mt-5
                        ">

                        Website resmi dan portal sistem informasi
                        SMP Al-Qadri Islamic School.

                    </p>

                </div>



                {{-- NAV --}}
                <div>

                    <h4 class="font-semibold mb-4">
                        Informasi
                    </h4>

                    <div
                        class="
                            flex
                            flex-col
                            gap-3
                            text-sm
                            text-slate-400
                        ">

                        <a href="{{ route('tentang') }}" class="hover:text-white">

                            Tentang Sekolah

                        </a>

                        <a href="{{ route('layanan') }}" class="hover:text-white">

                            Layanan

                        </a>

                        <a href="{{ route('pengumuman') }}" class="hover:text-white">

                            Pengumuman

                        </a>

                    </div>

                </div>



                {{-- PORTAL --}}
                <div>

                    <h4 class="font-semibold mb-4">
                        Portal Sekolah
                    </h4>

                    <p
                        class="
                            text-sm
                            text-slate-400
                            leading-relaxed
                        ">

                        Portal digunakan oleh administrator,
                        guru, dan orang tua sesuai hak akses
                        masing-masing.

                    </p>


                    <a href="{{ route('login') }}"
                        class="
                            inline-flex
                            mt-4
                            text-emerald-400
                            hover:text-emerald-300
                            text-sm
                            font-semibold
                        ">

                        Masuk Portal →

                    </a>

                </div>

            </div>



            <div
                class="
                    border-t
                    border-slate-800
                    mt-10
                    pt-6
                    flex
                    flex-col
                    md:flex-row
                    gap-3
                    justify-between
                    text-sm
                    text-slate-500
                ">

                <p>
                    &copy; {{ date('Y') }}
                    SMP Al-Qadri Islamic School.
                </p>

                <p>
                    Sistem Informasi Sekolah
                </p>

            </div>

        </div>

    </footer>



    {{-- ============================================================= --}}
    {{-- SCRIPT --}}
    {{-- ============================================================= --}}

    <script>
        /*
            |--------------------------------------------------------------------------
            | MOBILE MENU
            |--------------------------------------------------------------------------
            */

        const mobileButton =
            document.getElementById('mobile-menu-button');

        const mobileMenu =
            document.getElementById('mobile-menu');


        mobileButton?.addEventListener('click', function() {

            mobileMenu.classList.toggle('hidden');

        });



        /*
        |--------------------------------------------------------------------------
        | PWA INSTALL
        |--------------------------------------------------------------------------
        */

        let deferredPrompt = null;

        const installButton =
            document.getElementById('install-button');


        window.addEventListener(
            'beforeinstallprompt',
            function(event) {

                event.preventDefault();

                deferredPrompt = event;

                installButton?.classList.remove('hidden');

            }
        );


        async function installSchoolApp() {

            if (!deferredPrompt) {
                return;
            }

            deferredPrompt.prompt();

            await deferredPrompt.userChoice;

            deferredPrompt = null;

            installButton?.classList.add('hidden');

        }



        /*
        |--------------------------------------------------------------------------
        | SERVICE WORKER
        |--------------------------------------------------------------------------
        */

        if ('serviceWorker' in navigator) {

            window.addEventListener(
                'load',
                function() {

                    navigator.serviceWorker
                        .register('/serviceworker.js')
                        .catch(function(error) {

                            console.error(
                                'Service Worker gagal:',
                                error
                            );

                        });

                }
            );

        }



        /*
        |--------------------------------------------------------------------------
        | ONLINE / OFFLINE
        |--------------------------------------------------------------------------
        */

        function updateConnectionStatus() {

            const status =
                document.getElementById('offline-status');

            if (!status) {
                return;
            }


            if (navigator.onLine) {

                status.classList.add('hidden');

            } else {

                status.classList.remove('hidden');

            }

        }


        window.addEventListener(
            'online',
            updateConnectionStatus
        );

        window.addEventListener(
            'offline',
            updateConnectionStatus
        );

        document.addEventListener(
            'DOMContentLoaded',
            updateConnectionStatus
        );
    </script>

</body>

</html>
