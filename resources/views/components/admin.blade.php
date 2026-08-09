<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#172554">
    <link rel="manifest" href="{{ route('pwa.manifest') }}">
    <title>@yield('title', 'SMP AL QADRI ISLAMIC SCHOOL') - SMP AL QADRI ISLAMIC SCHOOL</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] {
            display: none !important
        }
    </style>
    @stack('head')
</head>

<body class="min-h-screen bg-slate-50 text-slate-900">
    @include('components.sidebar')

    <main class="pt-16 lg:pt-0 lg:pl-64 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>

    @stack('scripts')
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => navigator.serviceWorker.register('{{ route('pwa.serviceworker') }}'));
        }
    </script>
</body>

</html>
