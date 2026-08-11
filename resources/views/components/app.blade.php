<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bimbingan Konseling') - SMP AL QADRI Islamic School</title>

    <!-- PWA Meta Tags untuk Portal BK -->
    <meta name="description"
        content="Portal Bimbingan dan Konseling SMP AL QADRI Islamic School - Layanan konseling Islami untuk prestasi akademik dan pembentukan akhlaq mulia">
    <meta name="keywords" content="bimbingan konseling, islamic school, SMP AL QADRI, konseling islami, pendidikan islam">
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

    <!-- External CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Amiri:wght@400;700&display=swap"
        rel="stylesheet">

    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    @vite('resources/css/app.css')

    <!-- Service Worker Registration -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/serviceworker.js')
                    .then(function(registration) {
                        console.log('✅ [BK Portal PWA] Service Worker registered:', registration.scope);

                        // Check for updates
                        registration.addEventListener('updatefound', () => {
                            const newWorker = registration.installing;
                            newWorker.addEventListener('statechange', () => {
                                if (newWorker.state === 'installed' && navigator.serviceWorker
                                    .controller) {
                                    showUpdateNotification();
                                }
                            });
                        });
                    })
                    .catch(function(error) {
                        console.log('❌ [BK Portal PWA] Service Worker registration failed:', error);
                    });

                // Handle PWA install prompt
                let deferredPrompt;
                window.addEventListener('beforeinstallprompt', (e) => {
                    e.preventDefault();
                    deferredPrompt = e;
                    window.deferredPrompt = deferredPrompt;
                    showInstallBanner();
                });

                window.addEventListener('appinstalled', () => {
                    console.log('🎉 [BK Portal PWA] App installed');
                    hideInstallBanner();
                    showInstalledMessage();
                });
            });
        }

        // Show update notification
        function showUpdateNotification() {
            const updateBanner = document.createElement('div');
            updateBanner.innerHTML = `
                <div class="fixed top-0 left-0 right-0 bg-emerald-600 text-white px-4 py-3 z-50 text-center">
                    <span class="mr-4">✨ Versi baru tersedia!</span>
                    <button onclick="window.location.reload()" class="bg-white text-emerald-600 px-3 py-1 rounded text-sm font-medium">
                        Perbarui
                    </button>
                    <button onclick="this.parentElement.remove()" class="ml-2 text-white hover:text-emerald-200">
                        ✕
                    </button>
                </div>
            `;
            document.body.prepend(updateBanner);
        }

        // Show install banner
        function showInstallBanner() {
            const installBanner = document.getElementById('install-banner');
            if (installBanner) {
                installBanner.classList.remove('hidden');
            }
        }

        // Hide install banner
        function hideInstallBanner() {
            const installBanner = document.getElementById('install-banner');
            if (installBanner) {
                installBanner.classList.add('hidden');
            }
        }

        // Install app
        function installBKApp() {
            const deferredPrompt = window.deferredPrompt;
            if (deferredPrompt) {
                deferredPrompt.prompt();
                deferredPrompt.userChoice.then((choiceResult) => {
                    if (choiceResult.outcome === 'accepted') {
                        console.log('✅ User installed BK app');
                    }
                    window.deferredPrompt = null;
                    hideInstallBanner();
                });
            }
        }

        // Show installed message
        function showInstalledMessage() {
            const message = document.createElement('div');
            message.innerHTML = `
                <div class="fixed top-4 right-4 bg-emerald-600 text-white px-6 py-3 rounded-lg shadow-lg z-50">
                    🎉 Aplikasi BK berhasil diinstall!
                </div>
            `;
            document.body.appendChild(message);
            setTimeout(() => message.remove(), 5000);
        }

        // Monitor connection status
        function updateConnectionStatus() {
            const statusEl = document.getElementById('connection-status');
            if (statusEl) {
                if (navigator.onLine) {
                    statusEl.classList.add('hidden');
                } else {
                    statusEl.classList.remove('hidden');
                }
            }
        }

        window.addEventListener('online', updateConnectionStatus);
        window.addEventListener('offline', updateConnectionStatus);
        document.addEventListener('DOMContentLoaded', updateConnectionStatus);
    </script>

    <style>
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .arabic-text {
            font-family: 'Amiri', serif;
            direction: rtl;
        }

        [x-data]::-webkit-scrollbar {
            display: none;
        }

        .islamic-gradient {
            background: linear-gradient(135deg, #065f46 0%, #059669 50%, #10b981 100%);
        }

        .install-bounce {
            animation: bounce 2s infinite;
        }

        @keyframes bounce {

            0%,
            20%,
            53%,
            80%,
            100% {
                transform: translateY(0);
            }

            40%,
            43% {
                transform: translateY(-10px);
            }

            70% {
                transform: translateY(-5px);
            }

            90% {
                transform: translateY(-2px);
            }
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>

<body class="font-sans text-gray-800 bg-gradient-to-b from-emerald-50 to-white min-h-screen flex flex-col">

    <!-- Connection Status Bar -->
    <div id="connection-status" class="hidden fixed top-0 left-0 right-0 bg-red-500 text-white text-center py-2 z-50">
        ⚠️ Tidak ada koneksi internet - Mode offline aktif
    </div>

    <!-- PWA Install Banner -->
    <div id="install-banner" class="hidden fixed top-0 left-0 right-0 bg-emerald-600 text-white px-4 py-3 z-40">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <div class="flex items-center">
                <span class="text-2xl mr-3 install-bounce">📱</span>
                <div>
                    <div class="font-semibold">Install Aplikasi BK AL QADRI</div>
                    <div class="text-sm opacity-90">Akses lebih cepat dengan install di perangkat Anda</div>
                </div>
            </div>
            <div class="flex gap-2">
                <button onclick="installBKApp()"
                    class="bg-white text-emerald-600 px-4 py-2 rounded font-medium text-sm hover:bg-emerald-50 transition-colors">
                    Install
                </button>
                <button onclick="hideInstallBanner()" class="text-white hover:text-emerald-200 px-2">
                    ✕
                </button>
            </div>
        </div>
    </div>

    @include('components.navbar')

    <main>
        @yield('content')
    </main>

    @include('components.footer')

    <!-- PWA Install Button (Mobile) -->
    <button id="mobile-install-btn" onclick="installBKApp()"
        class="fixed bottom-4 right-4 bg-emerald-600 text-white p-3 rounded-full shadow-lg z-40 hidden lg:hidden install-bounce">
        📱
    </button>

</body>

</html>
