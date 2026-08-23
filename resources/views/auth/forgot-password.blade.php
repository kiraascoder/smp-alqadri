<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Lupa Password - SMP Al-Qadri Islamic School
    </title>

    <meta name="description" content="Pemulihan password Portal SMP Al-Qadri Islamic School">

    <link rel="icon" href="{{ asset('logo.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        .page-background {
            background:
                radial-gradient(circle at top left,
                    rgba(16, 185, 129, .18),
                    transparent 35%),
                radial-gradient(circle at bottom right,
                    rgba(59, 130, 246, .20),
                    transparent 35%),
                linear-gradient(135deg,
                    #0f172a 0%,
                    #1e3a8a 50%,
                    #047857 100%);
        }
    </style>

</head>


<body
    class="
        min-h-screen
        page-background
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



    {{-- CARD --}}
    <div
        class="
            w-full
            max-w-lg
            bg-white
            rounded-3xl
            shadow-2xl
            overflow-hidden
            relative
            z-10
        ">


        {{-- ACCENT TOP --}}
        <div
            class="
                h-2
                bg-gradient-to-r
                from-blue-700
                via-blue-600
                to-emerald-500
            ">
        </div>



        <div class="p-6 sm:p-10">


            {{-- LOGO --}}
            <div class="text-center">

                <a href="{{ route('home') }}"
                    class="
                        inline-flex
                        flex-col
                        items-center
                    ">

                    <img src="{{ asset('logo-baru.png') }}" alt="Logo SMP Al-Qadri"
                        class="
                            w-24
                            h-24
                            object-contain
                        ">


                    <p
                        class="
                            mt-3
                            text-sm
                            font-bold
                            text-slate-900
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



            {{-- ICON --}}
            <div
                class="
                    w-14
                    h-14
                    mx-auto
                    mt-7
                    bg-blue-50
                    text-blue-600
                    rounded-2xl
                    flex
                    items-center
                    justify-center
                ">

                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 12H8m8 0l-4-4m4 4l-4 4m7-7v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2z" />

                </svg>

            </div>



            {{-- HEADER --}}
            <div
                class="
                    text-center
                    mt-5
                    mb-8
                ">

                <h1
                    class="
                        text-3xl
                        font-bold
                        text-slate-900
                    ">

                    Lupa Password?

                </h1>


                <p
                    class="
                        text-slate-500
                        mt-3
                        leading-relaxed
                    ">

                    Masukkan alamat email yang terdaftar.
                    Kami akan mengirimkan tautan untuk
                    membuat password baru.

                </p>

            </div>



            {{-- SUCCESS --}}
            @if (session('success'))
                <div
                    class="
                        mb-5
                        flex
                        items-start
                        gap-3
                        p-4
                        rounded-xl
                        bg-emerald-50
                        border
                        border-emerald-200
                        text-emerald-700
                        text-sm
                    ">

                    <div
                        class="
                            w-6
                            h-6
                            shrink-0
                            rounded-full
                            bg-emerald-100
                            flex
                            items-center
                            justify-center
                            font-bold
                        ">

                        ✓

                    </div>


                    <div>

                        {{ session('success') }}

                    </div>

                </div>
            @endif



            {{-- STATUS --}}
            @if (session('status'))
                <div
                    class="
                        mb-5
                        flex
                        items-start
                        gap-3
                        p-4
                        rounded-xl
                        bg-emerald-50
                        border
                        border-emerald-200
                        text-emerald-700
                        text-sm
                    ">

                    <div
                        class="
                            w-6
                            h-6
                            shrink-0
                            rounded-full
                            bg-emerald-100
                            flex
                            items-center
                            justify-center
                            font-bold
                        ">

                        ✓

                    </div>


                    <div>

                        {{ session('status') }}

                    </div>

                </div>
            @endif



            {{-- EMAIL ERROR --}}
            @error('email')
                <div
                    class="
                        mb-5
                        flex
                        items-start
                        gap-3
                        p-4
                        rounded-xl
                        bg-red-50
                        border
                        border-red-200
                        text-red-700
                        text-sm
                    ">

                    <div
                        class="
                            w-6
                            h-6
                            shrink-0
                            rounded-full
                            bg-red-100
                            flex
                            items-center
                            justify-center
                            font-bold
                        ">

                        !

                    </div>


                    <div>

                        {{ $message }}

                    </div>

                </div>
            @enderror



            {{-- FORM --}}
            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">

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
                                    d="M3 8l9 6 9-6M5 6h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z" />

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
                                outline-none
                                text-slate-800
                                placeholder:text-slate-400
                                transition
                                focus:border-blue-500
                                focus:ring-4
                                focus:ring-blue-100
                            ">

                    </div>

                </div>



                {{-- SUBMIT --}}
                <button type="submit"
                    class="
                        w-full
                        flex
                        items-center
                        justify-center
                        gap-2
                        bg-gradient-to-r
                        from-blue-700
                        to-emerald-600
                        hover:from-blue-800
                        hover:to-emerald-700
                        text-white
                        py-3.5
                        px-5
                        rounded-xl
                        font-semibold
                        shadow-lg
                        shadow-blue-900/10
                        transition
                        active:scale-[0.99]
                    ">

                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l9 6 9-6M5 6h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z" />

                    </svg>

                    Kirim Link Reset Password

                </button>

            </form>



            {{-- INFORMATION --}}
            <div
                class="
                    mt-6
                    bg-blue-50
                    border
                    border-blue-100
                    rounded-xl
                    p-4
                ">

                <div class="flex gap-3">

                    <div
                        class="
                            w-9
                            h-9
                            shrink-0
                            rounded-lg
                            bg-blue-100
                            text-blue-600
                            flex
                            items-center
                            justify-center
                            font-bold
                            text-sm
                        ">

                        i

                    </div>


                    <div
                        class="
                            text-xs
                            text-blue-700
                            leading-relaxed
                        ">

                        <p
                            class="
                                font-semibold
                                mb-1
                            ">

                            Tidak menerima email?

                        </p>


                        <p>

                            Pastikan email sesuai dengan akun
                            yang terdaftar. Periksa juga folder
                            spam atau junk pada email Anda.

                        </p>

                    </div>

                </div>

            </div>



            {{-- BACK LOGIN --}}
            <div
                class="
                    mt-8
                    pt-6
                    border-t
                    border-slate-200
                    text-center
                ">

                <a href="{{ route('login') }}"
                    class="
                        inline-flex
                        items-center
                        gap-2
                        text-sm
                        font-semibold
                        text-blue-600
                        hover:text-blue-700
                        transition
                    ">

                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />

                    </svg>

                    Kembali ke Login

                </a>

            </div>



            {{-- BACK HOME --}}
            <div class="text-center mt-4">

                <a href="{{ route('home') }}"
                    class="
                        text-xs
                        text-slate-400
                        hover:text-emerald-600
                        transition
                    ">

                    Kembali ke Website Sekolah

                </a>

            </div>



            {{-- COPYRIGHT --}}
            <p
                class="
                    text-center
                    text-xs
                    text-slate-400
                    mt-6
                ">

                © {{ date('Y') }}
                SMP Al-Qadri Islamic School

            </p>

        </div>

    </div>

</body>

</html>
