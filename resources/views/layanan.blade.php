<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Layanan - SMP Al-Qadri Islamic School</title>

    <meta name="description" content="Layanan dan sistem informasi SMP Al-Qadri Islamic School.">

    <link rel="icon" href="{{ asset('logo-baru.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        .hero-gradient {
            background: linear-gradient(135deg,
                    #064e3b,
                    #047857,
                    #059669);
        }

        .service-card {
            transition: .3s ease;
        }

        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 30px rgba(15, 23, 42, .08);
        }
    </style>

</head>


<body class="bg-slate-50 text-slate-800">


    {{-- NAVBAR --}}
    <header
        class="
            fixed top-0 left-0 right-0
            z-50
            bg-white/95
            border-b border-slate-200
            backdrop-blur
        ">

        <div
            class="
                max-w-7xl
                mx-auto
                px-5 lg:px-8
                h-20
                flex
                items-center
                justify-between
            ">

            <a href="{{ route('home') }}" class="flex items-center gap-3">

                <img src="{{ asset('logo-baru.png') }}" class="w-12 h-12 object-contain" alt="Logo">

                <div>
                    <h1 class="font-bold">
                        SMP AL-QADRI
                    </h1>

                    <p class="text-xs text-emerald-600 font-semibold">
                        Islamic School
                    </p>
                </div>

            </a>


            <nav class="hidden lg:flex gap-7 text-sm font-medium">

                <a href="{{ route('home') }}" class="text-slate-600 hover:text-emerald-600">
                    Beranda
                </a>

                <a href="{{ route('tentang') }}" class="text-slate-600 hover:text-emerald-600">
                    Tentang
                </a>

                <a href="{{ route('layanan') }}" class="text-emerald-600 font-semibold">
                    Layanan
                </a>

                <a href="{{ route('pengumuman') }}" class="text-slate-600 hover:text-emerald-600">
                    Pengumuman
                </a>

            </nav>


            <a href="{{ route('login') }}"
                class="
                    bg-emerald-600
                    hover:bg-emerald-700
                    text-white
                    px-5 py-2.5
                    rounded-xl
                    text-sm
                    font-semibold
                ">
                Portal Sekolah
            </a>

        </div>

    </header>


    {{-- HERO --}}
    <section class="hero-gradient pt-36 pb-20">

        <div class="max-w-7xl mx-auto px-5 lg:px-8 text-center text-white">

            <p class="font-semibold text-emerald-200">
                Layanan Sekolah
            </p>

            <h1 class="text-4xl lg:text-5xl font-extrabold mt-4">
                Layanan SMP Al-Qadri Islamic School
            </h1>

            <p
                class="
                    max-w-3xl
                    mx-auto
                    text-emerald-100
                    text-lg
                    leading-relaxed
                    mt-5
                ">
                Layanan sekolah dan sistem informasi yang mendukung
                proses pembinaan, komunikasi, dan pemantauan siswa.
            </p>

        </div>

    </section>


    {{-- LAYANAN --}}
    <section class="py-20 bg-white">

        <div class="max-w-7xl mx-auto px-5 lg:px-8">

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

                <div class="service-card border rounded-2xl p-7">

                    <div
                        class="
                            w-14 h-14
                            bg-blue-100
                            rounded-xl
                            flex items-center justify-center
                            text-2xl
                        ">
                        🏫
                    </div>

                    <h2 class="font-bold text-xl mt-5">
                        Informasi Sekolah
                    </h2>

                    <p class="text-slate-500 leading-relaxed mt-2">
                        Website menyediakan informasi mengenai sekolah,
                        layanan, dan pengumuman yang dapat diakses
                        masyarakat maupun orang tua siswa.
                    </p>

                </div>


                <div class="service-card border rounded-2xl p-7">

                    <div
                        class="
                            w-14 h-14
                            bg-red-100
                            rounded-xl
                            flex items-center justify-center
                            text-2xl
                        ">
                        ⚠️
                    </div>

                    <h2 class="font-bold text-xl mt-5">
                        Pembinaan Kedisiplinan
                    </h2>

                    <p class="text-slate-500 leading-relaxed mt-2">
                        Sistem membantu guru mencatat pelanggaran siswa
                        berdasarkan jenis pelanggaran dan skor yang telah
                        ditetapkan sekolah.
                    </p>

                </div>


                <div class="service-card border rounded-2xl p-7">

                    <div
                        class="
                            w-14 h-14
                            bg-emerald-100
                            rounded-xl
                            flex items-center justify-center
                            text-2xl
                        ">
                        ⭐
                    </div>

                    <h2 class="font-bold text-xl mt-5">
                        Pembinaan Kebajikan
                    </h2>

                    <p class="text-slate-500 leading-relaxed mt-2">
                        Perilaku positif siswa dicatat melalui
                        poin kebajikan sebagai bagian dari pembinaan
                        karakter dan apresiasi siswa.
                    </p>

                </div>


                <div class="service-card border rounded-2xl p-7">

                    <div
                        class="
                            w-14 h-14
                            bg-amber-100
                            rounded-xl
                            flex items-center justify-center
                            text-2xl
                        ">
                        👨‍🏫
                    </div>

                    <h2 class="font-bold text-xl mt-5">
                        Portal Guru
                    </h2>

                    <p class="text-slate-500 leading-relaxed mt-2">
                        Guru dapat mengelola pencatatan pelanggaran,
                        memberikan poin kebajikan, serta melihat
                        riwayat data yang telah diinput.
                    </p>

                </div>


                <div class="service-card border rounded-2xl p-7">

                    <div
                        class="
                            w-14 h-14
                            bg-purple-100
                            rounded-xl
                            flex items-center justify-center
                            text-2xl
                        ">
                        👪
                    </div>

                    <h2 class="font-bold text-xl mt-5">
                        Portal Orang Tua
                    </h2>

                    <p class="text-slate-500 leading-relaxed mt-2">
                        Orang tua dapat memantau informasi anak,
                        riwayat pelanggaran, serta kebajikan
                        yang diperoleh siswa.
                    </p>

                </div>


                <div class="service-card border rounded-2xl p-7">

                    <div
                        class="
                            w-14 h-14
                            bg-cyan-100
                            rounded-xl
                            flex items-center justify-center
                            text-2xl
                        ">
                        📊
                    </div>

                    <h2 class="font-bold text-xl mt-5">
                        Rekap dan Laporan
                    </h2>

                    <p class="text-slate-500 leading-relaxed mt-2">
                        Administrator dapat melihat rekap pelanggaran
                        dan kebajikan berdasarkan siswa, kelas,
                        periode, dan pembuat data.
                    </p>

                </div>

            </div>

        </div>

    </section>


    {{-- PORTAL --}}
    <section class="py-20 bg-emerald-50">

        <div class="max-w-4xl mx-auto px-5 text-center">

            <h2 class="text-3xl font-bold text-slate-900">
                Akses Portal Sekolah
            </h2>

            <p class="text-slate-600 mt-4">
                Portal hanya dapat diakses oleh pengguna yang telah
                memiliki akun sesuai dengan perannya.
            </p>


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
                        mt-7
                        bg-emerald-600
                        text-white
                        px-7 py-3
                        rounded-xl
                        font-semibold
                    ">
                    Buka Dashboard
                </a>
            @else
                <a href="{{ route('login') }}"
                    class="
                        inline-flex
                        mt-7
                        bg-emerald-600
                        text-white
                        px-7 py-3
                        rounded-xl
                        font-semibold
                    ">
                    Login Portal
                </a>

            @endauth

        </div>

    </section>


    <footer class="bg-slate-950 text-white py-10">

        <div
            class="
                max-w-7xl mx-auto
                px-5 lg:px-8
                flex flex-col
                md:flex-row
                justify-between
                gap-4
            ">

            <p class="font-semibold">
                SMP Al-Qadri Islamic School
            </p>

            <p class="text-sm text-slate-500">
                &copy; {{ date('Y') }} Sistem Informasi Sekolah
            </p>

        </div>

    </footer>

</body>

</html>
