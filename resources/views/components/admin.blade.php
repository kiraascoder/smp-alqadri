<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - SMP AL QADRI</title>

    @vite('resources/css/app.css')

    <!-- Hanya satu script Alpine.js (hindari duplikasi) -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        .sidebar-transition {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-overlay {
            transition: opacity 0.3s ease-in-out;
        }

        .no-scroll {
            overflow: hidden;
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        @include('components.sidebar')

        {{-- Main content --}}
        <div class="flex-1">
            <main class="pt-16 lg:pt-0 px-6">
                @yield('content')
            </main>
        </div>
    </div>

</body>

</html>
