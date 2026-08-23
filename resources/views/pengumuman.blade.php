<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pengumuman - SMP Al-Qadri Islamic School</title>

    <meta name="description" content="Pengumuman resmi SMP Al-Qadri Islamic School.">

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
    </style>
</head>


<body class="bg-slate-50 text-slate-800">


    {{-- NAVBAR --}}
    <header
        class="
            fixed top-0 left-0 right-0
            z-50
            bg-white/95
            backdrop-blur
            border-b border-slate-200
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

                    <p class="text-xs font-semibold text-emerald-600">
                        Islamic School
                    </p>

                </div>

            </a>


            <nav class="hidden lg:flex items-center gap-7 text-sm font-medium">

                <a href="{{ route('home') }}" class="text-slate-600 hover:text-emerald-600">
                    Beranda
                </a>

                <a href="{{ route('tentang') }}" class="text-slate-600 hover:text-emerald-600">
                    Tentang
                </a>

                <a href="{{ route('layanan') }}" class="text-slate-600 hover:text-emerald-600">
                    Layanan
                </a>

                <a href="{{ route('pengumuman') }}" class="text-emerald-600 font-semibold">
                    Pengumuman
                </a>

            </nav>


            <a href="{{ route('login') }}"
                class="
                    bg-emerald-600
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

            <p class="text-emerald-200 font-semibold">
                Informasi Sekolah
            </p>

            <h1
                class="
                    text-4xl
                    lg:text-5xl
                    font-extrabold
                    mt-4
                ">
                Pengumuman
            </h1>

            <p
                class="
                    max-w-2xl
                    mx-auto
                    mt-5
                    text-lg
                    text-emerald-100
                ">
                Informasi dan pengumuman resmi
                SMP Al-Qadri Islamic School.
            </p>

        </div>

    </section>


    {{-- CONTENT --}}
    <section class="py-20">

        <div class="max-w-5xl mx-auto px-5">


            {{-- EMPTY STATE --}}
            <div
                class="
                    bg-white
                    border border-slate-200
                    rounded-3xl
                    shadow-sm
                    p-10
                    md:p-16
                    text-center
                ">


                <div
                    class="
                        w-20 h-20
                        mx-auto
                        rounded-full
                        bg-emerald-100
                        flex
                        items-center
                        justify-center
                        text-4xl
                    ">

                    📢

                </div>


                <h2
                    class="
                        text-2xl
                        font-bold
                        text-slate-900
                        mt-6
                    ">

                    Belum Ada Pengumuman

                </h2>


                <p
                    class="
                        max-w-xl
                        mx-auto
                        text-slate-500
                        mt-3
                        leading-relaxed
                    ">

                    Saat ini belum terdapat pengumuman yang dipublikasikan.
                    Informasi terbaru dari sekolah akan ditampilkan pada
                    halaman ini.

                </p>


                <a href="{{ route('home') }}"
                    class="
                        inline-flex
                        mt-7
                        px-6 py-3
                        bg-emerald-600
                        hover:bg-emerald-700
                        text-white
                        rounded-xl
                        font-semibold
                    ">

                    Kembali ke Beranda

                </a>

            </div>

        </div>

    </section>


    {{-- INFORMATION --}}
    <section class="pb-20">

        <div class="max-w-5xl mx-auto px-5">

            <div
                class="
                    bg-emerald-50
                    border border-emerald-100
                    rounded-2xl
                    p-6
                    flex
                    gap-4
                ">

                <div
                    class="
                        w-12 h-12
                        shrink-0
                        rounded-xl
                        bg-emerald-100
                        flex items-center justify-center
                        text-xl
                    ">
                    ℹ️
                </div>


                <div>

                    <h3 class="font-bold text-slate-900">
                        Informasi Pengumuman
                    </h3>

                    <p class="text-sm text-slate-600 mt-1 leading-relaxed">
                        Pastikan selalu memeriksa informasi terbaru yang
                        dipublikasikan melalui website resmi SMP Al-Qadri
                        Islamic School.
                    </p>

                </div>

            </div>

        </div>

    </section>


    {{-- FOOTER --}}
    <footer class="bg-slate-950 text-white py-10">

        <div
            class="
                max-w-7xl
                mx-auto
                px-5 lg:px-8
                flex
                flex-col
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
