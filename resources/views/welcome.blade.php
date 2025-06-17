<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bimbingan Konseling - SMP AL QADRI Islamic School</title>

    <!-- PWA Meta Tags untuk Landing Page BK -->
    <meta name="description"
        content="Bimbingan dan Konseling SMP AL QADRI Islamic School - Layanan konseling Islami terpadu untuk mendampingi prestasi akademik dan pembentukan akhlaq mulia siswa">
    <meta name="keywords"
        content="bimbingan konseling islami, SMP AL QADRI, konseling siswa, pendidikan islam, akhlaq mulia">
    <meta name="author" content="SMP AL QADRI Islamic School">
    <meta name="theme-color" content="#059669">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="BK AL QADRI">
    <meta name="msapplication-TileImage" content="/images/icons/icon-144x144.png">
    <meta name="msapplication-TileColor" content="#059669">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="Bimbingan Konseling SMP AL QADRI Islamic School">
    <meta property="og:description"
        content="Layanan Bimbingan dan Konseling berbasis nilai-nilai Islam untuk mendukung prestasi akademik dan pembentukan akhlaq mulia">
    <meta property="og:image" content="/images/icons/icon-512x512.png">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:type" content="website">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="BK SMP AL QADRI Islamic School">
    <meta name="twitter:description" content="Bimbingan Konseling Islami terpadu">
    <meta name="twitter:image" content="/images/icons/icon-512x512.png">

    <!-- PWA Manifest -->
    <link rel="manifest" href="/manifest.json">

    <!-- PWA Icons -->
    <link rel="apple-touch-icon" sizes="152x152" href="/images/icons/icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/icons/icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/icons/icon-72x72.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/icons/icon-72x72.png">
    <link rel="shortcut icon" href="/images/icons/icon-72x72.png">

    <!-- Preload critical resources -->
    <link rel="preload" href="/images/icons/icon-192x192.png" as="image" type="image/png">
    <link rel="preload"
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Amiri:wght@400;700&display=swap"
        as="style">

    <!-- External Resources -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Amiri:wght@400;700&display=swap"
        rel="stylesheet">

    <!-- Service Worker Registration -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/serviceworker.js')
                    .then(function(registration) {
                        console.log('✅ [BK Landing PWA] Service Worker registered successfully');

                        registration.addEventListener('updatefound', () => {
                            console.log('🔄 New version available');
                            const newWorker = registration.installing;
                            newWorker.addEventListener('statechange', () => {
                                if (newWorker.state === 'installed') {
                                    showUpdateAvailable();
                                }
                            });
                        });
                    })
                    .catch(function(error) {
                        console.log('❌ Service Worker registration failed:', error);
                    });

                // PWA Install Prompt
                let deferredPrompt;
                window.addEventListener('beforeinstallprompt', (e) => {
                    e.preventDefault();
                    deferredPrompt = e;
                    window.deferredPrompt = deferredPrompt;
                    showInstallPromotion();
                });

                window.addEventListener('appinstalled', () => {
                    console.log('🎉 BK App installed successfully');
                    hideInstallPromotion();
                    showThankYouMessage();
                });
            });
        }

        // Show update notification
        function showUpdateAvailable() {
            const updateDiv = document.createElement('div');
            updateDiv.innerHTML = `
                <div class="fixed top-0 left-0 right-0 bg-emerald-600 text-white px-4 py-3 z-50 shadow-lg">
                    <div class="max-w-4xl mx-auto flex items-center justify-between">
                        <span>✨ Versi baru aplikasi BK tersedia!</span>
                        <button onclick="window.location.reload()" class="bg-white text-emerald-600 px-3 py-1 rounded text-sm font-medium hover:bg-emerald-50 transition-colors">
                            Perbarui Sekarang
                        </button>
                    </div>
                </div>
            `;
            document.body.insertBefore(updateDiv, document.body.firstChild);
        }

        // Show install promotion
        function showInstallPromotion() {
            setTimeout(() => {
                const installModal = document.getElementById('install-modal');
                if (installModal) {
                    installModal.classList.remove('hidden');
                }
            }, 3000); // Show after 3 seconds
        }

        // Hide install promotion
        function hideInstallPromotion() {
            const installModal = document.getElementById('install-modal');
            if (installModal) {
                installModal.classList.add('hidden');
            }
        }

        // Install the app
        function installBKApp() {
            const deferredPrompt = window.deferredPrompt;
            if (deferredPrompt) {
                deferredPrompt.prompt();
                deferredPrompt.userChoice.then((choiceResult) => {
                    if (choiceResult.outcome === 'accepted') {
                        console.log('✅ User accepted the install prompt');
                    } else {
                        console.log('❌ User dismissed the install prompt');
                    }
                    window.deferredPrompt = null;
                    hideInstallPromotion();
                });
            }
        }

        // Show thank you message
        function showThankYouMessage() {
            const thankYouDiv = document.createElement('div');
            thankYouDiv.innerHTML = `
                <div class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white rounded-lg shadow-xl p-6 z-50 max-w-sm text-center">
                    <div class="text-4xl mb-3">🎉</div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Barakallahu fiik!</h3>
                    <p class="text-gray-600 text-sm">Aplikasi BK AL QADRI berhasil diinstall. Semoga bermanfaat untuk pendampingan prestasi dan akhlaq mulia.</p>
                    <button onclick="this.parentElement.parentElement.remove()" class="mt-4 bg-emerald-600 text-white px-4 py-2 rounded text-sm hover:bg-emerald-700 transition-colors">
                        Alhamdulillah
                    </button>
                </div>
                <div class="fixed inset-0 bg-black bg-opacity-50 z-40"></div>
            `;
            document.body.appendChild(thankYouDiv);

            setTimeout(() => {
                thankYouDiv.remove();
            }, 5000);
        }

        // Check connection status
        function updateConnectionStatus() {
            const offline = !navigator.onLine;
            const statusBar = document.getElementById('offline-status');

            if (offline && statusBar) {
                statusBar.classList.remove('hidden');
            } else if (statusBar) {
                statusBar.classList.add('hidden');
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

        .gradient-bg {
            background: linear-gradient(135deg, #065f46 0%, #059669 50%, #10b981 100%);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .hover-lift {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .pulse-slow {
            animation: pulse 3s infinite;
        }

        .fade-in {
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .service-icon {
            transition: all 0.3s ease;
        }

        .service-card:hover .service-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .floating {
            animation: floating 6s ease-in-out infinite;
        }

        @keyframes floating {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .text-gradient {
            background: linear-gradient(135deg, #065f46, #10b981);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .install-pulse {
            animation: pulse 2s infinite;
        }

        .islamic-pattern {
            background-image: radial-gradient(circle at 1px 1px, rgba(5, 150, 105, 0.1) 1px, transparent 0);
            background-size: 25px 25px;
        }
    </style>
</head>

<body class="bg-gray-50 overflow-x-hidden islamic-pattern">

    <!-- Offline Status Bar -->
    <div id="offline-status" class="hidden fixed top-0 left-0 right-0 bg-amber-500 text-white text-center py-2 z-50">
        ⚠️ Mode Offline - Beberapa fitur mungkin terbatas
    </div>

    <!-- PWA Install Modal -->
    <div id="install-modal"
        class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl max-w-md w-full p-6 text-center glass-card">
            <div class="text-6xl mb-4 install-pulse">🕌</div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Install Aplikasi BK AL QADRI</h3>
            <p class="text-gray-600 mb-6">
                Dapatkan akses lebih mudah ke layanan Bimbingan Konseling dengan menginstall aplikasi di perangkat Anda.
            </p>
            <div class="flex gap-3">
                <button onclick="installBKApp()"
                    class="flex-1 bg-emerald-600 text-white py-3 rounded-lg font-medium hover:bg-emerald-700 transition-colors">
                    📱 Install Sekarang
                </button>
                <button onclick="hideInstallPromotion()"
                    class="px-4 py-3 text-gray-500 hover:text-gray-700 transition-colors">
                    Nanti Saja
                </button>
            </div>
        </div>
    </div>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center gradient-bg">
        <!-- Decorative Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-10 -right-10 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 -left-20 w-96 h-96 bg-emerald-400/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-1/4 w-64 h-64 bg-green-300/10 rounded-full blur-2xl floating"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Content -->
                <div class="text-white fade-in">
                    <div
                        class="inline-flex items-center px-4 py-2 bg-white/20 rounded-full text-sm font-medium mb-6 glass-card">
                        <div class="w-2 h-2 bg-emerald-400 rounded-full mr-2 pulse-slow"></div>
                        SMP AL QADRI Islamic School
                    </div>

                    <h1 class="text-4xl lg:text-6xl font-bold mb-6 leading-tight">
                        Bimbingan
                        <span class="block text-transparent bg-clip-text bg-gradient-to-r from-emerald-300 to-white">
                            Konseling
                        </span>
                        Islami Terpadu
                    </h1>

                    <p class="text-xl text-emerald-100 mb-8 leading-relaxed max-w-lg">
                        Layanan Bimbingan dan Konseling berbasis nilai-nilai Islam untuk mendukung prestasi akademik,
                        akhlaq mulia, dan pengembangan karakter siswa SMP AL QADRI Islamic School.
                    </p>

                    <!-- PWA Install CTA -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center px-8 py-4 bg-white text-emerald-600 rounded-2xl font-semibold hover:bg-emerald-50 transition-all duration-300 hover:scale-105 shadow-lg">
                            🚀 Akses Portal BK
                        </a>
                        <button onclick="installBKApp()"
                            class="inline-flex items-center px-8 py-4 bg-emerald-800/50 text-white rounded-2xl font-semibold hover:bg-emerald-800/70 transition-all duration-300 glass-card">
                            📱 Install Aplikasi
                        </button>
                    </div>

                    <!-- Islamic Quote -->
                    <div class="mt-8 p-4 glass-card rounded-lg">
                        <p class="arabic-text text-lg mb-2">بِسْمِ اللّهِ الرَّحْمَنِ الرَّحِيْمِ</p>
                        <p class="text-emerald-200 text-sm italic">"Dengan nama Allah Yang Maha Pengasih lagi Maha
                            Penyayang"</p>
                    </div>
                </div>

                <!-- App Preview -->
                <div class="relative lg:block hidden">
                    <div class="relative w-full h-96 rounded-3xl overflow-hidden glass-card">
                        <div class="absolute inset-0 bg-gradient-to-br from-emerald-400/20 to-green-400/20"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center text-white">
                                <div
                                    class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 floating">
                                    <span class="text-3xl">🕌</span>
                                </div>
                                <h3 class="text-2xl font-semibold mb-2">Konseling Islami</h3>
                                <p class="text-emerald-100">Bimbingan dengan pendekatan Islamic Values</p>
                                <div class="mt-4 flex justify-center">
                                    <button onclick="installBKApp()"
                                        class="px-4 py-2 bg-white/20 rounded-lg text-sm hover:bg-white/30 transition-colors install-pulse">
                                        Install PWA
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-20 bg-white relative">
        <div class="container mx-auto px-6">
            <!-- Section Header -->
            <div class="text-center mb-16 fade-in">
                <div
                    class="inline-flex items-center px-4 py-2 bg-emerald-100 text-emerald-600 rounded-full text-sm font-medium mb-4">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    Program Unggulan BK
                </div>
                <h2 class="text-4xl lg:text-5xl font-bold text-gradient mb-4">
                    Layanan BK SMP AL QADRI Islamic School
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Program bimbingan konseling yang mengintegrasikan nilai-nilai Islam dalam setiap layanan untuk
                    membentuk generasi berakhlaq mulia
                </p>
            </div>

            <!-- Services Grid -->
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Service 1 -->
                <div class="service-card bg-white p-8 rounded-3xl shadow-lg hover-lift border border-gray-100 group">
                    <div
                        class="service-icon w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-gray-800">Bimbingan Akademik Islami</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Membantu siswa mengoptimalkan prestasi belajar dengan metode yang sejalan dengan ajaran Islam.
                        Mencakup strategi belajar efektif dan manajemen waktu sesuai adab menuntut ilmu.
                    </p>
                    <div class="text-emerald-600 text-sm font-medium">
                        🎯 Prestasi • 📚 Adab Ilmu • ⏰ Manajemen Waktu
                    </div>
                </div>

                <!-- Service 2 -->
                <div class="service-card bg-white p-8 rounded-3xl shadow-lg hover-lift border border-gray-100 group">
                    <div
                        class="service-icon w-16 h-16 bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-gray-800">Konseling Pribadi & Sosial</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Layanan konseling individual untuk membantu siswa mengatasi masalah pribadi, sosial, dan
                        emosional dengan pendekatan Islami yang penuh kasih sayang dan hikmah.
                    </p>
                    <div class="text-amber-600 text-sm font-medium">
                        💝 Empati • 🤝 Hubungan Sosial • 🧘‍♀️ Ketenangan Jiwa
                    </div>
                </div>

                <!-- Service 3 -->
                <div class="service-card bg-white p-8 rounded-3xl shadow-lg hover-lift border border-gray-100 group">
                    <div
                        class="service-icon w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-gray-800">Bimbingan Karir & Masa Depan</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Membantu siswa merencanakan karir dan melanjutkan pendidikan dengan mempertimbangkan bakat,
                        minat, dan kesesuaian dengan nilai-nilai Islam dalam berkarya.
                    </p>
                    <div class="text-blue-600 text-sm font-medium">
                        🚀 Karir • 🎓 Pendidikan • 🌟 Potensi Diri
                    </div>
                </div>
            </div>

            <!-- PWA Features Section -->
            <div class="mt-16 bg-gradient-to-r from-emerald-600 to-green-600 rounded-3xl p-8 text-white">
                <div class="text-center mb-8">
                    <h3 class="text-3xl font-bold mb-4">📱 Aplikasi BK dalam Genggaman</h3>
                    <p class="text-emerald-100 text-lg">
                        Install aplikasi untuk pengalaman yang lebih baik dan akses offline
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="text-4xl mb-3">⚡</div>
                        <h4 class="font-semibold mb-2">Akses Cepat</h4>
                        <p class="text-emerald-100 text-sm">Buka aplikasi langsung dari home screen tanpa browser</p>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl mb-3">📱</div>
                        <h4 class="font-semibold mb-2">Mode Offline</h4>
                        <p class="text-emerald-100 text-sm">Akses data penting meski tidak ada koneksi internet</p>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl mb-3">🔔</div>
                        <h4 class="font-semibold mb-2">Notifikasi</h4>
                        <p class="text-emerald-100 text-sm">Dapatkan update konseling dan pengumuman secara real-time
                        </p>
                    </div>
                </div>

                <div class="text-center mt-8">
                    <button onclick="installBKApp()"
                        class="inline-flex items-center px-8 py-4 bg-white text-emerald-600 rounded-2xl font-semibold hover:bg-emerald-50 transition-all duration-300 hover:scale-105 shadow-lg install-pulse">
                        📲 Install Aplikasi BK
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Islamic Values Section -->
    <section class="py-20 bg-emerald-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gradient mb-4">Nilai-Nilai Islam dalam BK</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Setiap layanan konseling kami dilandasi dengan nilai-nilai mulia dari Al-Qur'an dan As-Sunnah
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-2xl shadow-lg text-center hover-lift">
                    <div class="text-3xl mb-4">🤲</div>
                    <h3 class="font-bold text-gray-800 mb-2">Tawakal</h3>
                    <p class="text-gray-600 text-sm">Menyerahkan hasil akhir kepada Allah setelah berusaha maksimal</p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-lg text-center hover-lift">
                    <div class="text-3xl mb-4">💝</div>
                    <h3 class="font-bold text-gray-800 mb-2">Rahmah</h3>
                    <p class="text-gray-600 text-sm">Kasih sayang dan kelembutan dalam setiap proses konseling</p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-lg text-center hover-lift">
                    <div class="text-3xl mb-4">⚖️</div>
                    <h3 class="font-bold text-gray-800 mb-2">Adil</h3>
                    <p class="text-gray-600 text-sm">Memberikan pelayanan yang sama tanpa membeda-bedakan</p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-lg text-center hover-lift">
                    <div class="text-3xl mb-4">🤝</div>
                    <h3 class="font-bold text-gray-800 mb-2">Ukhuwah</h3>
                    <p class="text-gray-600 text-sm">Membangun persaudaraan dan kebersamaan antar siswa</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="py-20 bg-gradient-to-r from-emerald-600 to-green-600 relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute -top-20 -right-20 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-20 -left-20 w-96 h-96 bg-emerald-300/10 rounded-full blur-3xl"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center text-white">
                <div class="text-6xl mb-6 floating">🕌</div>
                <h2 class="text-4xl lg:text-5xl font-bold mb-6">
                    Bergabunglah dengan Program BK Kami
                </h2>
                <p class="text-xl text-emerald-100 mb-8 max-w-2xl mx-auto">
                    Tim Guru BK SMP AL QADRI Islamic School siap mendampingi perjalanan akademik dan spiritual
                    putra-putri Anda dengan penuh amanah dan profesionalisme.
                </p>

                <div class="arabic-text text-2xl mb-4 opacity-90">
                    وَقُل رَّبِّ زِدْنِي عِلْمًا
                </div>
                <p class="text-emerald-200 mb-8 italic">
                    "Dan katakanlah: Ya Tuhanku, tambahkanlah kepadaku ilmu pengetahuan" (QS. Taha: 114)
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('login') }}">
                        <button
                            class="px-8 py-4 bg-white text-emerald-600 rounded-2xl font-semibold hover:bg-emerald-50 transition-all duration-300 hover:scale-105 shadow-lg">
                            🚀 Akses Portal BK
                        </button>
                    </a>
                    <button onclick="installBKApp()"
                        class="px-8 py-4 bg-emerald-800/50 text-white rounded-2xl font-semibold hover:bg-emerald-800/70 transition-all duration-300 glass-card install-pulse">
                        📱 Install Aplikasi
                    </button>
                </div>

                <div class="mt-8 text-emerald-200 text-sm">
                    <p>✨ Aplikasi dapat diinstall di Android, iOS, dan Desktop</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-emerald-900 text-white py-8">
        <div class="container mx-auto px-6 text-center">
            <div class="mb-4">
                <span class="text-3xl">🕌</span>
                <h3 class="text-xl font-bold mt-2">SMP AL QADRI Islamic School</h3>
                <p class="text-emerald-200">Bimbingan & Konseling Islami</p>
            </div>

            <div class="border-t border-emerald-800 pt-6">
                <p class="text-emerald-300">&copy; 2025 SMP AL QADRI Islamic School - Bimbingan & Konseling.
                    Barakallahu fiikum.</p>
                <div class="flex justify-center gap-4 mt-4 text-sm">
                    <a href="#" class="hover:text-emerald-200 transition-colors">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-emerald-200 transition-colors">Tentang Kami</a>
                    <a href="#" class="hover:text-emerald-200 transition-colors">Kontak</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating Install Button (Mobile) -->
    <div class="fixed bottom-6 right-6 z-40 lg:hidden">
        <button onclick="installBKApp()"
            class="bg-emerald-600 text-white p-4 rounded-full shadow-lg hover:bg-emerald-700 transition-all duration-300 install-pulse">
            <span class="text-xl">📱</span>
        </button>
    </div>

</body>

</html>
