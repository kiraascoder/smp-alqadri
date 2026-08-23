<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - SMP Al-Qadri Islamic School</title>

    <meta name="description" content="Portal Sistem Informasi SMP Al-Qadri Islamic School">

    <link rel="icon" href="{{ asset('logo.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        .login-background {
            background:
                radial-gradient(circle at top left, rgba(16, 185, 129, .20), transparent 35%),
                radial-gradient(circle at bottom right, rgba(59, 130, 246, .20), transparent 35%),
                linear-gradient(135deg, #0f172a 0%, #1e3a8a 50%, #047857 100%);
        }

        .glass {
            background: rgba(255, 255, 255, .08);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, .12);
        }
    </style>
</head>


<body
    class="
        min-h-screen
        login-background
        flex
        items-center
        justify-center
        px-4
        py-10
        relative
        overflow-x-hidden
    ">


    {{-- DECORATION --}}
    <div
        class="
            fixed
            -top-24
            -right-24
            w-80
            h-80
            bg-white/10
            rounded-full
            blur-3xl
            pointer-events-none
        ">
    </div>

    <div
        class="
            fixed
            -bottom-24
            -left-24
            w-96
            h-96
            bg-emerald-400/10
            rounded-full
            blur-3xl
            pointer-events-none
        ">
    </div>



    <div
        class="
            w-full
            max-w-5xl
            grid
            lg:grid-cols-2
            bg-white
            rounded-3xl
            overflow-hidden
            shadow-2xl
            relative
            z-10
        ">


        {{-- LEFT SIDE --}}
        <div
            class="
                hidden
                lg:flex
                flex-col
                justify-between
                bg-gradient-to-br
                from-blue-900
                via-blue-800
                to-emerald-700
                text-white
                p-10
                relative
                overflow-hidden
            ">


            <div
                class="
                    absolute
                    -top-16
                    -right-16
                    w-64
                    h-64
                    bg-white/10
                    rounded-full
                    blur-3xl
                ">
            </div>


            <div class="relative z-10">

                <a href="{{ route('home') }}"
                    class="
                        inline-flex
                        items-center
                        gap-3
                    ">

                    <div
                        class="
                            w-14
                            h-14
                            bg-white
                            rounded-2xl
                            flex
                            items-center
                            justify-center
                            shadow-lg
                        ">

                        <img src="{{ asset('logo-baru.png') }}" alt="Logo SMP Al-Qadri"
                            class="
                                w-11
                                h-11
                                object-contain
                            ">

                    </div>


                    <div>

                        <h2
                            class="
                                text-lg
                                font-bold
                            ">

                            SMP AL-QADRI

                        </h2>

                        <p
                            class="
                                text-sm
                                text-blue-100
                            ">

                            Islamic School

                        </p>

                    </div>

                </a>


                <div class="mt-16">

                    <span
                        class="
                            inline-flex
                            px-4
                            py-2
                            rounded-full
                            bg-white/10
                            border
                            border-white/10
                            text-xs
                            font-semibold
                        ">

                        Sistem Informasi Sekolah

                    </span>


                    <h1
                        class="
                            text-4xl
                            font-bold
                            leading-tight
                            mt-6
                        ">

                        Portal Sekolah
                        <span class="block text-emerald-200">
                            SMP Al-Qadri
                        </span>

                    </h1>


                    <p
                        class="
                            mt-5
                            text-blue-100
                            leading-relaxed
                            max-w-md
                        ">

                        Akses layanan sekolah untuk mengelola dan
                        memantau data siswa, pelanggaran, kebajikan,
                        serta informasi perkembangan siswa.

                    </p>


                    <div
                        class="
                            mt-8
                            space-y-4
                            text-sm
                            text-blue-50
                        ">

                        <div class="flex items-center gap-3">
                            <span class="text-emerald-300">✓</span>
                            Portal Administrator
                        </div>

                        <div class="flex items-center gap-3">
                            <span class="text-emerald-300">✓</span>
                            Portal Guru
                        </div>

                        <div class="flex items-center gap-3">
                            <span class="text-emerald-300">✓</span>
                            Portal Orang Tua
                        </div>

                    </div>

                </div>

            </div>


            <div
                class="
                    relative
                    z-10
                    text-xs
                    text-blue-200
                ">

                © {{ date('Y') }} SMP Al-Qadri Islamic School

            </div>

        </div>



        {{-- RIGHT SIDE --}}
        <div
            class="
                p-6
                sm:p-10
                lg:p-12
                flex
                items-center
            ">

            <div class="w-full max-w-md mx-auto">


                {{-- MOBILE LOGO --}}
                <div
                    class="
                        lg:hidden
                        text-center
                        mb-8
                    ">

                    <a href="{{ route('home') }}" class="inline-flex flex-col items-center">

                        <img src="{{ asset('logo-baru.png') }}" alt="Logo SMP Al-Qadri"
                            class="
                                w-24
                                h-24
                                object-contain
                            ">

                        <p
                            class="
                                text-lg
                                font-bold
                                text-slate-900
                                mt-3
                            ">

                            SMP AL-QADRI

                        </p>

                        <p
                            class="
                                text-xs
                                font-semibold
                                text-emerald-600
                            ">

                            Islamic School

                        </p>

                    </a>

                </div>



                {{-- HEADER --}}
                <div class="mb-8">

                    <p
                        class="
                            text-sm
                            font-semibold
                            text-blue-600
                            mb-2
                        ">

                        Selamat datang kembali

                    </p>


                    <h1
                        class="
                            text-3xl
                            font-bold
                            text-slate-900
                        ">

                        Masuk ke Portal

                    </h1>


                    <p
                        class="
                            text-slate-500
                            mt-2
                            leading-relaxed
                        ">

                        Masukkan email dan password akun Anda untuk
                        mengakses sistem informasi sekolah.

                    </p>

                </div>



                {{-- SUCCESS --}}
                @if (session('success'))
                    <div
                        class="
                            mb-5
                            flex
                            gap-3
                            p-4
                            rounded-xl
                            bg-emerald-50
                            border
                            border-emerald-200
                            text-emerald-700
                            text-sm
                        ">

                        <span>✓</span>

                        <span>
                            {{ session('success') }}
                        </span>

                    </div>
                @endif



                {{-- ERROR --}}
                @if ($errors->any())
                    <div
                        class="
                            mb-5
                            flex
                            gap-3
                            p-4
                            rounded-xl
                            bg-red-50
                            border
                            border-red-200
                            text-red-700
                            text-sm
                        ">

                        <span>!</span>

                        <span>
                            {{ $errors->first() }}
                        </span>

                    </div>
                @endif



                <form method="POST" action="{{ route('login.submit') }}" class="space-y-5">

                    @csrf


                    {{-- EMAIL --}}
                    <div>

                        <label for="email"
                            class="
                                block
                                text-sm
                                font-semibold
                                text-slate-700
                                mb-2
                            ">

                            Email

                        </label>


                        <div class="relative">

                            <div
                                class="
                                    absolute
                                    left-4
                                    top-1/2
                                    -translate-y-1/2
                                    text-slate-400
                                    pointer-events-none
                                ">

                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 12H8m8 0l-4-4m4 4l-4 4m8-8v8a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2h12a2 2 0 012 2z" />

                                </svg>

                            </div>


                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                autofocus autocomplete="email" placeholder="nama@email.com"
                                class="
                                    w-full
                                    pl-12
                                    pr-4
                                    py-3.5
                                    border
                                    border-slate-300
                                    rounded-xl
                                    text-slate-800
                                    placeholder:text-slate-400
                                    outline-none
                                    transition
                                    focus:border-blue-500
                                    focus:ring-4
                                    focus:ring-blue-100
                                ">

                        </div>

                    </div>



                    {{-- PASSWORD --}}
                    <div>

                        <div
                            class="
                                flex
                                items-center
                                justify-between
                                gap-4
                                mb-2
                            ">

                            <label for="password"
                                class="
                                    text-sm
                                    font-semibold
                                    text-slate-700
                                ">

                                Password

                            </label>


                            <a href="{{ route('password.request') }}"
                                class="
                                    text-sm
                                    font-semibold
                                    text-blue-600
                                    hover:text-blue-700
                                ">

                                Lupa password?

                            </a>

                        </div>


                        <div class="relative">

                            <div
                                class="
                                    absolute
                                    left-4
                                    top-1/2
                                    -translate-y-1/2
                                    text-slate-400
                                    pointer-events-none
                                ">

                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 11c1.105 0 2 .895 2 2s-.895 2-2 2-2-.895-2-2 .895-2 2-2zm6-2V7a6 6 0 10-12 0v2m-1 0h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2v-8a2 2 0 012-2z" />

                                </svg>

                            </div>


                            <input id="password" type="password" name="password" required
                                autocomplete="current-password" placeholder="Masukkan password"
                                class="
                                    w-full
                                    pl-12
                                    pr-12
                                    py-3.5
                                    border
                                    border-slate-300
                                    rounded-xl
                                    text-slate-800
                                    placeholder:text-slate-400
                                    outline-none
                                    transition
                                    focus:border-blue-500
                                    focus:ring-4
                                    focus:ring-blue-100
                                ">


                            <button type="button" id="password-toggle" onclick="togglePassword()"
                                class="
                                    absolute
                                    right-4
                                    top-1/2
                                    -translate-y-1/2
                                    text-slate-400
                                    hover:text-slate-700
                                    transition
                                "
                                aria-label="Tampilkan password">

                                <svg id="eye-open" class="w-5 h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0c-1.5-4-5-7-9-7s-7.5 3-9 7c1.5 4 5 7 9 7s7.5-3 9-7z" />

                                </svg>


                                <svg id="eye-close" class="w-5 h-5 hidden" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3l18 18M10.5 10.7A3 3 0 0013.3 13.5M9.9 4.2A10.5 10.5 0 0112 4c4 0 7.5 3 9 8a13 13 0 01-2.1 3.8M6.2 6.2A13.2 13.2 0 003 12c1.5 5 5 8 9 8a10.5 10.5 0 005-1.2" />

                                </svg>

                            </button>

                        </div>

                    </div>





                    {{-- SUBMIT --}}
                    <button type="submit"
                        class="
                            w-full
                            bg-gradient-to-r
                            from-blue-700
                            to-emerald-600
                            hover:from-blue-800
                            hover:to-emerald-700
                            text-white
                            rounded-xl
                            py-3.5
                            font-semibold
                            shadow-lg
                            shadow-blue-900/10
                            transition
                            active:scale-[0.99]
                        ">

                        Masuk ke Portal

                    </button>

                </form>



                {{-- BACK HOME --}}
                <div
                    class="
                        mt-8
                        pt-6
                        border-t
                        border-slate-200
                        text-center
                    ">

                    <a href="{{ route('home') }}"
                        class="
                            inline-flex
                            items-center
                            gap-2
                            text-sm
                            font-medium
                            text-slate-500
                            hover:text-blue-600
                            transition
                        ">

                        ← Kembali ke Website Sekolah

                    </a>

                </div>

            </div>

        </div>

    </div>



    <script>
        function togglePassword() {

            const password =
                document.getElementById('password');

            const eyeOpen =
                document.getElementById('eye-open');

            const eyeClose =
                document.getElementById('eye-close');


            if (password.type === 'password') {

                password.type = 'text';

                eyeOpen.classList.add('hidden');

                eyeClose.classList.remove('hidden');

            } else {

                password.type = 'password';

                eyeOpen.classList.remove('hidden');

                eyeClose.classList.add('hidden');
            }
        }
    </script>

</body>

</html>
