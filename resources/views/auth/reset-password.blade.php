<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Reset Password - SMP Al-Qadri Islamic School
    </title>

    <meta name="description" content="Reset password Portal SMP Al-Qadri Islamic School">

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


        {{-- TOP ACCENT --}}
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

                <a href="{{ route('home') }}" class="inline-flex flex-col items-center">

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
                    rounded-2xl
                    bg-blue-50
                    text-blue-600
                    flex
                    items-center
                    justify-center
                ">

                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 11c1.105 0 2 .895 2 2s-.895 2-2 2-2-.895-2-2 .895-2 2-2zm6-2V7a6 6 0 10-12 0v2m-1 0h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2v-8a2 2 0 012-2z" />

                </svg>

            </div>



            {{-- HEADER --}}
            <div class="text-center mt-5 mb-8">

                <h1
                    class="
                        text-3xl
                        font-bold
                        text-slate-900
                    ">

                    Buat Password Baru

                </h1>


                <p
                    class="
                        text-slate-500
                        leading-relaxed
                        mt-3
                    ">

                    Silakan buat password baru untuk akun Anda.
                    Gunakan password yang kuat dan mudah Anda ingat.

                </p>

            </div>



            {{-- ERROR --}}
            @if ($errors->any())
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
                        {{ $errors->first() }}
                    </div>

                </div>
            @endif



            {{-- FORM --}}
            <form method="POST" action="{{ route('password.update') }}" class="space-y-5">

                @csrf


                <input type="hidden" name="token" value="{{ $token }}">



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


                        <input id="email" type="email" name="email" value="{{ old('email', $email) }}" required
                            autocomplete="email"
                            class="
                                w-full
                                pl-12
                                pr-4
                                py-3.5
                                border
                                border-slate-300
                                rounded-xl
                                bg-slate-50
                                text-slate-700
                                outline-none
                                transition
                                focus:bg-white
                                focus:border-blue-500
                                focus:ring-4
                                focus:ring-blue-100
                            ">

                    </div>

                </div>



                {{-- PASSWORD BARU --}}
                <div>

                    <label for="password"
                        class="
                            block
                            text-sm
                            font-semibold
                            text-slate-700
                            mb-2
                        ">

                        Password Baru

                    </label>


                    <div class="relative">

                        <div
                            class="
                                absolute
                                left-4
                                top-1/2
                                -translate-y-1/2
                                text-slate-400
                            ">

                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 11c1.105 0 2 .895 2 2s-.895 2-2 2-2-.895-2-2 .895-2 2-2zm6-2V7a6 6 0 10-12 0v2m-1 0h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2v-8a2 2 0 012-2z" />

                            </svg>

                        </div>


                        <input id="password" type="password" name="password" required autocomplete="new-password"
                            placeholder="Minimal 8 karakter"
                            class="
                                w-full
                                pl-12
                                pr-12
                                py-3.5
                                border
                                border-slate-300
                                rounded-xl
                                outline-none
                                transition
                                placeholder:text-slate-400
                                focus:border-blue-500
                                focus:ring-4
                                focus:ring-blue-100
                            ">


                        <button type="button" onclick="togglePassword('password', 'eye-password', 'eye-password-off')"
                            class="
                                absolute
                                right-4
                                top-1/2
                                -translate-y-1/2
                                text-slate-400
                                hover:text-slate-700
                            ">

                            <svg id="eye-password" class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0c-1.5-4-5-7-9-7s-7.5 3-9 7c1.5 4 5 7 9 7s7.5-3 9-7z" />

                            </svg>


                            <svg id="eye-password-off" class="w-5 h-5 hidden" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3l18 18M10.5 10.7A3 3 0 0013.3 13.5M9.9 4.2A10.5 10.5 0 0112 4c4 0 7.5 3 9 8a13 13 0 01-2.1 3.8M6.2 6.2A13.2 13.2 0 003 12c1.5 5 5 8 9 8a10.5 10.5 0 005-1.2" />

                            </svg>

                        </button>

                    </div>

                </div>



                {{-- KONFIRMASI PASSWORD --}}
                <div>

                    <label for="password_confirmation"
                        class="
                            block
                            text-sm
                            font-semibold
                            text-slate-700
                            mb-2
                        ">

                        Konfirmasi Password Baru

                    </label>


                    <div class="relative">

                        <div
                            class="
                                absolute
                                left-4
                                top-1/2
                                -translate-y-1/2
                                text-slate-400
                            ">

                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5-3A9 9 0 1112 3a9 9 0 018 4z" />

                            </svg>

                        </div>


                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            autocomplete="new-password" placeholder="Ulangi password baru"
                            class="
                                w-full
                                pl-12
                                pr-12
                                py-3.5
                                border
                                border-slate-300
                                rounded-xl
                                outline-none
                                transition
                                placeholder:text-slate-400
                                focus:border-blue-500
                                focus:ring-4
                                focus:ring-blue-100
                            ">


                        <button type="button"
                            onclick="togglePassword(
                                'password_confirmation',
                                'eye-confirmation',
                                'eye-confirmation-off'
                            )"
                            class="
                                absolute
                                right-4
                                top-1/2
                                -translate-y-1/2
                                text-slate-400
                                hover:text-slate-700
                            ">

                            <svg id="eye-confirmation" class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0c-1.5-4-5-7-9-7s-7.5 3-9 7c1.5 4 5 7 9 7s7.5-3 9-7z" />

                            </svg>


                            <svg id="eye-confirmation-off" class="w-5 h-5 hidden" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3l18 18M10.5 10.7A3 3 0 0013.3 13.5M9.9 4.2A10.5 10.5 0 0112 4c4 0 7.5 3 9 8a13 13 0 01-2.1 3.8M6.2 6.2A13.2 13.2 0 003 12c1.5 5 5 8 9 8a10.5 10.5 0 005-1.2" />

                            </svg>

                        </button>

                    </div>

                </div>



                {{-- PASSWORD INFO --}}
                <div
                    class="
                        bg-blue-50
                        border
                        border-blue-100
                        rounded-xl
                        p-4
                    ">

                    <div class="flex gap-3">

                        <div
                            class="
                                w-8
                                h-8
                                shrink-0
                                rounded-lg
                                bg-blue-100
                                text-blue-600
                                flex
                                items-center
                                justify-center
                                text-sm
                                font-bold
                            ">

                            i

                        </div>


                        <div
                            class="
                                text-xs
                                text-blue-700
                                leading-relaxed
                            ">

                            <p class="font-semibold mb-1">
                                Gunakan password yang aman
                            </p>

                            <p>
                                Disarankan minimal 8 karakter dan
                                menggunakan kombinasi huruf serta angka.
                            </p>

                        </div>

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

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />

                    </svg>

                    Simpan Password Baru

                </button>

            </form>



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

                    ← Kembali ke Login

                </a>

            </div>


            <p
                class="
                    text-center
                    text-xs
                    text-slate-400
                    mt-6
                ">

                © {{ date('Y') }} SMP Al-Qadri Islamic School

            </p>

        </div>

    </div>



    <script>
        function togglePassword(
            inputId,
            openIconId,
            closedIconId
        ) {

            const input =
                document.getElementById(inputId);

            const openIcon =
                document.getElementById(openIconId);

            const closedIcon =
                document.getElementById(closedIconId);


            if (input.type === 'password') {

                input.type = 'text';

                openIcon.classList.add('hidden');

                closedIcon.classList.remove('hidden');

            } else {

                input.type = 'password';

                openIcon.classList.remove('hidden');

                closedIcon.classList.add('hidden');

            }

        }
    </script>

</body>

</html>
