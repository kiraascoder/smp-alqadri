<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tentang Sekolah - SMP Al-Qadri Islamic School</title>

    <meta name="description"
        content="Tentang SMP Al-Qadri Islamic School, sekolah Islam yang berkomitmen membentuk generasi berilmu, berkarakter, disiplin, dan berakhlak mulia.">

    <link rel="icon" href="{{ asset('logo-baru.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Amiri:wght@400;700&display=swap"
        rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }

        .arabic {
            font-family: 'Amiri', serif;
        }

        .hero-gradient {
            background: linear-gradient(135deg,
                    #064e3b 0%,
                    #047857 50%,
                    #059669 100%);
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
                max-w-7xl mx-auto
                h-20
                px-5 lg:px-8
                flex items-center justify-between
            ">

            <a href="{{ route('home') }}" class="flex items-center gap-3">

                <img src="{{ asset('logo-baru.png') }}" class="w-12 h-12 object-contain" alt="Logo SMP Al-Qadri">

                <div>
                    <h1 class="font-bold text-slate-900">
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

                <a href="{{ route('tentang') }}" class="text-emerald-600 font-semibold">
                    Tentang
                </a>

                <a href="{{ route('layanan') }}" class="text-slate-600 hover:text-emerald-600">
                    Layanan
                </a>

                <a href="{{ route('pengumuman') }}" class="text-slate-600 hover:text-emerald-600">
                    Pengumuman
                </a>

            </nav>


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
                        bg-emerald-600
                        hover:bg-emerald-700
                        text-white
                        px-5 py-2.5
                        rounded-xl
                        text-sm font-semibold
                    ">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}"
                    class="
                        bg-emerald-600
                        hover:bg-emerald-700
                        text-white
                        px-5 py-2.5
                        rounded-xl
                        text-sm font-semibold
                    ">
                    Login Portal
                </a>
            @endauth

        </div>

    </header>


    {{-- HERO --}}
    <section class="hero-gradient pt-36 pb-20">

        <div class="max-w-7xl mx-auto px-5 lg:px-8 text-center text-white">

            <span
                class="
                    inline-flex
                    px-4 py-2
                    rounded-full
                    bg-white/10
                    border border-white/20
                    text-sm font-semibold
                ">
                Profil Sekolah
            </span>

            <h1
                class="
                    text-4xl
                    lg:text-5xl
                    font-extrabold
                    mt-6
                ">
                Tentang SMP Al-Qadri Islamic School
            </h1>

            <p
                class="
                    max-w-3xl
                    mx-auto
                    mt-5
                    text-lg
                    text-emerald-100
                    leading-relaxed
                ">
                Sekolah yang mengintegrasikan pendidikan akademik,
                pembinaan karakter, kedisiplinan, serta nilai-nilai Islam
                untuk membentuk generasi yang berilmu dan berakhlak mulia.
            </p>

        </div>

    </section>


    {{-- TENTANG --}}
    <section class="py-20 bg-white">

        <div
            class="
                max-w-7xl
                mx-auto
                px-5 lg:px-8
                grid lg:grid-cols-2
                gap-14
                items-center
            ">

            <div
                class="
                    bg-emerald-50
                    rounded-3xl
                    p-10
                    flex items-center justify-center
                ">

                <img src="{{ asset('logo-baru.png') }}" alt="SMP Al-Qadri" class="w-64 h-64 object-contain">

            </div>


            <div>

                <p
                    class="
                        text-sm
                        uppercase
                        tracking-wider
                        font-bold
                        text-emerald-600
                    ">
                    SMP Al-Qadri
                </p>

                <h2
                    class="
                        text-3xl
                        font-bold
                        text-slate-900
                        mt-3
                    ">
                    Pendidikan Berbasis Ilmu dan Akhlak
                </h2>

                <p
                    class="
                        text-slate-600
                        mt-5
                        leading-relaxed
                    ">
                    SMP Al-Qadri Islamic School merupakan lembaga pendidikan
                    yang berupaya menciptakan lingkungan belajar yang aman,
                    nyaman, disiplin, dan mendukung perkembangan siswa secara
                    akademik maupun karakter.
                </p>

                <p
                    class="
                        text-slate-600
                        mt-4
                        leading-relaxed
                    ">
                    Proses pendidikan tidak hanya berfokus pada pencapaian
                    akademik, tetapi juga pada pembentukan sikap, tanggung jawab,
                    kedisiplinan, kebajikan, serta hubungan yang baik antara
                    siswa, guru, sekolah, dan orang tua.
                </p>

            </div>

        </div>

    </section>


    {{-- NILAI --}}
    <section class="py-20 bg-slate-50">

        <div class="max-w-7xl mx-auto px-5 lg:px-8">

            <div class="text-center max-w-3xl mx-auto">

                <p
                    class="
                        text-emerald-600
                        text-sm
                        font-bold
                        uppercase
                        tracking-wider
                    ">
                    Nilai Pendidikan
                </p>

                <h2
                    class="
                        text-3xl
                        lg:text-4xl
                        font-bold
                        text-slate-900
                        mt-3
                    ">
                    Nilai yang Kami Kembangkan
                </h2>

            </div>


            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-12">

                <div class="bg-white border rounded-2xl p-7 text-center">

                    <div class="text-4xl">
                        📚
                    </div>

                    <h3 class="font-bold text-lg mt-4">
                        Berilmu
                    </h3>

                    <p class="text-sm text-slate-500 mt-2">
                        Mendorong siswa memiliki semangat belajar dan
                        meningkatkan pengetahuan.
                    </p>

                </div>


                <div class="bg-white border rounded-2xl p-7 text-center">

                    <div class="text-4xl">
                        🤲
                    </div>

                    <h3 class="font-bold text-lg mt-4">
                        Berakhlak
                    </h3>

                    <p class="text-sm text-slate-500 mt-2">
                        Membentuk perilaku yang baik berdasarkan
                        nilai-nilai Islam.
                    </p>

                </div>


                <div class="bg-white border rounded-2xl p-7 text-center">

                    <div class="text-4xl">
                        ⏱️
                    </div>

                    <h3 class="font-bold text-lg mt-4">
                        Disiplin
                    </h3>

                    <p class="text-sm text-slate-500 mt-2">
                        Membiasakan siswa untuk bertanggung jawab
                        terhadap aturan dan kewajibannya.
                    </p>

                </div>


                <div class="bg-white border rounded-2xl p-7 text-center">

                    <div class="text-4xl">
                        🤝
                    </div>

                    <h3 class="font-bold text-lg mt-4">
                        Peduli
                    </h3>

                    <p class="text-sm text-slate-500 mt-2">
                        Mengembangkan kepedulian dan hubungan sosial
                        yang baik di lingkungan sekolah.
                    </p>

                </div>

            </div>

        </div>

    </section>


    {{-- AYAT --}}
    <section class="py-20 bg-emerald-50">

        <div class="max-w-3xl mx-auto px-5 text-center">

            <p class="arabic text-4xl text-emerald-800">
                وَقُل رَّبِّ زِدْنِي عِلْمًا
            </p>

            <p class="text-slate-600 mt-5">
                “Dan katakanlah: Ya Tuhanku, tambahkanlah kepadaku ilmu pengetahuan.”
            </p>

            <p class="text-sm font-semibold text-emerald-700 mt-2">
                QS. Taha: 114
            </p>

        </div>

    </section>


    {{-- FOOTER --}}
    <footer class="bg-slate-950 text-white py-10">

        <div
            class="
                max-w-7xl
                mx-auto
                px-5 lg:px-8
                flex flex-col
                md:flex-row
                gap-5
                justify-between
                items-center
            ">

            <div class="flex items-center gap-3">

                <img src="{{ asset('logo-baru.png') }}" class="w-10 h-10 object-contain" alt="Logo">

                <div>
                    <p class="font-bold">
                        SMP Al-Qadri Islamic School
                    </p>

                    <p class="text-xs text-slate-400">
                        Sistem Informasi Sekolah
                    </p>
                </div>

            </div>

            <p class="text-sm text-slate-500">
                &copy; {{ date('Y') }} SMP Al-Qadri Islamic School
            </p>

        </div>

    </footer>

</body>

</html>
