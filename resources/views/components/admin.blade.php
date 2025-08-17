<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard BK') - SMP AL QADRI Islamic School</title>

    <!-- PWA Meta Tags untuk Aplikasi BK -->
    <meta name="description"
        content="Aplikasi Bimbingan dan Konseling SMP AL QADRI Islamic School - Mendampingi prestasi akademik dan pembentukan akhlaq mulia siswa">
    <meta name="theme-color" content="#059669">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="BK AL QADRI">
    <meta name="msapplication-TileImage" content="/images/icons/icon-144x144.png">
    <meta name="msapplication-TileColor" content="#059669">
    <meta name="msapplication-navbutton-color" content="#059669">

    <!-- PWA Manifest -->
    <link rel="manifest" href="{{ route('pwa.manifest') }}">

    <!-- PWA Icons -->
    <link rel="apple-touch-icon" sizes="152x152" href="/images/icons/icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/icons/icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/icons/icon-72x72.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/icons/icon-72x72.png">
    <link rel="mask-icon" href="/images/icons/icon-192x192.png" color="#059669">

    <!-- Preload critical resources -->
    <link rel="preload" href="/images/icons/icon-192x192.png" as="image" type="image/png">

    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Service Worker Registration -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/serviceworker.js')
                    .then(function(registration) {
                        console.log('✅ [BK PWA] Service Worker registered successfully:', registration.scope);

                        // Check for updates
                        registration.addEventListener('updatefound', () => {
                            console.log('🔄 [BK PWA] New version available');
                            const newWorker = registration.installing;
                            newWorker.addEventListener('statechange', () => {
                                if (newWorker.state === 'installed' && navigator.serviceWorker
                                    .controller) {
                                    showUpdateAvailable();
                                }
                            });
                        });
                    })
                    .catch(function(error) {
                        console.log('❌ [BK PWA] Service Worker registration failed:', error);
                    });

                // Listen for app install prompt
                let deferredPrompt;
                window.addEventListener('beforeinstallprompt', (e) => {
                    e.preventDefault();
                    deferredPrompt = e;
                    showInstallButton();
                });

                // Handle app installed
                window.addEventListener('appinstalled', () => {
                    console.log('🎉 [BK PWA] App installed successfully');
                    hideInstallButton();
                });
            });
        }

        // Show update notification
        function showUpdateAvailable() {
            if (confirm('✨ Versi baru aplikasi BK tersedia! Perbarui sekarang?')) {
                window.location.reload();
            }
        }

        // Show install button
        function showInstallButton() {
            const installButton = document.getElementById('install-button');
            if (installButton) {
                installButton.style.display = 'block';
            }
        }

        // Hide install button
        function hideInstallButton() {
            const installButton = document.getElementById('install-button');
            if (installButton) {
                installButton.style.display = 'none';
            }
        }

        // Install app function
        function installApp() {
            const deferredPrompt = window.deferredPrompt;
            if (deferredPrompt) {
                deferredPrompt.prompt();
                deferredPrompt.userChoice.then((choiceResult) => {
                    if (choiceResult.outcome === 'accepted') {
                        console.log('✅ [BK PWA] User accepted the install prompt');
                    } else {
                        console.log('❌ [BK PWA] User dismissed the install prompt');
                    }
                    window.deferredPrompt = null;
                });
            }
        }

        // Connection status monitoring
        function updateConnectionStatus() {
            const statusEl = document.getElementById('connection-status');
            if (statusEl) {
                if (navigator.onLine) {
                    statusEl.className = 'hidden';
                } else {
                    statusEl.className = 'fixed top-0 left-0 right-0 bg-red-500 text-white text-center py-2 z-50';
                    statusEl.textContent = '⚠️ Aplikasi BK sedang offline - Beberapa fitur terbatas';
                }
            }
        }

        window.addEventListener('online', updateConnectionStatus);
        window.addEventListener('offline', updateConnectionStatus);
        document.addEventListener('DOMContentLoaded', updateConnectionStatus);
    </script>

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

        .islamic-pattern {
            background-image: radial-gradient(circle at 1px 1px, rgba(5, 150, 105, 0.1) 1px, transparent 0);
            background-size: 20px 20px;
        }

        .pwa-install-button {
            background: linear-gradient(135deg, #059669, #065f46);
            transition: all 0.3s ease;
        }

        .pwa-install-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(5, 150, 105, 0.3);
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800 islamic-pattern">
    <!-- Connection Status Bar -->
    <div id="connection-status" class="hidden"></div>

    <!-- PWA Install Button -->
    <button id="install-button" onclick="installApp()"
        class="fixed bottom-4 right-4 pwa-install-button text-white px-4 py-2 rounded-full shadow-lg z-40 hidden">
        📱 Install App BK
    </button>

    <div class="flex min-h-screen">
        @include('components.sidebar')

        {{-- Main content --}}
        <div class="flex-1 lg:ml-64">
            <main class="pt-16 lg:pt-0 px-6">
                @yield('content')
            </main>
        </div>
    </div>

</body>

</html>
