<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Informasi UKM UMPAR')</title>
    <link rel="icon" href="{{ asset('umpar.png') }}" type="image/png">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link
        href="https://fonts.googleapis.com/css2?family=Fira+Code&family=Merriweather&family=Open+Sans&family=Oswald&display=swap"
        rel="stylesheet">
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    @vite('resources/css/app.css')

    <style>
        [x-data]::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>

<body class="font-sans text-gray-800 bg-gradient-to-b from-sky-50 to-white min-h-screen flex flex-col">

    @include('components.navbar')

    <main>
        @yield('content')
    </main>

    @include('components.footer')

</body>

</html>
