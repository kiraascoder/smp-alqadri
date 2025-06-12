<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - SMP AL QADRI</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

</head>

<body class="bg-gray-100 text-gray-800">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        @include('components.sidebar')

        {{-- Main content --}}
        <div class="flex-1">
            <!-- Header -->
            @include('components.sidebar') {{-- Atau paste header di sini --}}

            <main class="pt-16 lg:pt-0 px-6">
                @yield('content')
            </main>

        </div>
    </div>
</body>


</html>
