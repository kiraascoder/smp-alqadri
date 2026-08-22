<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - SMP AL QADRI ISLAMIC SCHOOL</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>


<body
    class="
    min-h-screen
    bg-gradient-to-br
    from-blue-950
    via-blue-800
    to-indigo-700

    flex
    items-center
    justify-center

    p-4">


    <div
        class="
        w-full
        max-w-md

        bg-white

        rounded-2xl

        shadow-2xl

        p-8">



        {{-- HEADER LOGIN --}}
        <div class="text-center mb-8">


            <div class="
                flex
                justify-center
                mb-5">

                <img src="{{ asset('logo.png') }}" alt="Logo SMP Al Qadri"
                    class="
                    w-32
                    h-32

                    object-contain">

            </div>



            <h1 class="
                text-2xl
                font-bold
                text-gray-900">

                SMP AL QADRI ISLAMIC SCHOOL

            </h1>



            <p class="
                text-gray-500
                mt-2">

                Masuk sebagai Admin, Guru, atau Orang Tua

            </p>


        </div>




        @if (session('success'))
            <div
                class="
                mb-4
                p-3

                rounded-lg

                bg-green-50

                text-green-700">

                {{ session('success') }}

            </div>
        @endif




        @if ($errors->any())
            <div
                class="
                mb-4

                p-3

                rounded-lg

                bg-red-50

                text-red-700">

                {{ $errors->first() }}

            </div>
        @endif






        <form method="POST" action="{{ route('login.submit') }}" class="space-y-5">


            @csrf



            {{-- EMAIL --}}
            <div>

                <label
                    class="
                    block
                    text-sm
                    font-medium
                    mb-2">

                    Email

                </label>


                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="
                    w-full

                    border

                    rounded-xl

                    px-4

                    py-3

                    focus:ring-2

                    focus:ring-blue-500"
                    placeholder="email@contoh.com">


            </div>




            {{-- PASSWORD --}}
            <div>


                <label
                    class="
                    block
                    text-sm
                    font-medium
                    mb-2">

                    Password

                </label>


                <div class="relative">


                    <input id="password" type="password" name="password" required
                        class="
                        w-full

                        border

                        rounded-xl

                        px-4

                        py-3

                        pr-12

                        focus:ring-2

                        focus:ring-blue-500"
                        placeholder="Password">



                    <button type="button" onclick="togglePassword()"
                        class="
                        absolute

                        right-4

                        top-1/2

                        -translate-y-1/2

                        text-gray-500">


                        👁️


                    </button>


                </div>


            </div>





            <div
                class="
                flex

                items-center

                justify-between

                text-sm">


                <label class="
                    flex

                    items-center

                    gap-2">


                    <input type="checkbox" name="remember">


                    Ingat saya


                </label>



                <a href="{{ route('password.request') }}"
                    class="
                    text-blue-700

                    hover:underline">


                    Lupa password?


                </a>


            </div>





            <button
                class="
                w-full

                bg-blue-700

                hover:bg-blue-800

                text-white

                rounded-xl

                py-3

                font-semibold">


                Masuk


            </button>




        </form>


    </div>





    <script>
        function togglePassword() {

            const password =
                document.getElementById('password');


            if (password.type === 'password') {

                password.type = 'text';

            } else {

                password.type = 'password';

            }

        }
    </script>


</body>

</html>
