<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMP AL QADRI ISLAMIC SCHOOL - Bimbingan dan Konseling</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        * {
            font-family: 'Inter', sans-serif;
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
    </style>
</head>

<body class="bg-gray-50 overflow-x-hidden">
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
                        SMP Al Qadri Islamic School
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
                        akhlak mulia, dan pengembangan karakter siswa SMP Al Qadri Islamic School.
                    </p>

                </div>

                <!-- Image/Illustration -->
                <div class="relative lg:block hidden">
                    <div class="relative w-full h-96 rounded-3xl overflow-hidden glass-card">
                        <div class="absolute inset-0 bg-gradient-to-br from-emerald-400/20 to-green-400/20"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center text-white">
                                <div
                                    class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 floating">
                                    <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm3.5 6L12 10.5 8.5 8 12 6.5 15.5 8zM12 13c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z" />
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-semibold mb-2">Konseling Islami</h3>
                                <p class="text-emerald-100">Bimbingan dengan pendekatan Islamic Values</p>
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
                    Layanan BK SMP Al Qadri Islamic School
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Program bimbingan konseling yang mengintegrasikan nilai-nilai Islam dalam setiap layanan untuk
                    membentuk generasi berakhlak mulia
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
                        emosional
                        dengan pendekatan Islami yang penuh kasih sayang dan hikmah.
                    </p>
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
                        minat,
                        dan kesesuaian dengan nilai-nilai Islam dalam berkarya.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section class="py-20 bg-gradient-to-r from-emerald-600 to-green-600 relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute -top-20 -right-20 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-20 -left-20 w-96 h-96 bg-emerald-300/10 rounded-full blur-3xl"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center text-white">
                <h2 class="text-4xl lg:text-5xl font-bold mb-6">
                    Bergabunglah dengan Program BK Kami
                </h2>
                <p class="text-xl text-emerald-100 mb-8 max-w-2xl mx-auto">
                    Tim Guru BK SMP Al Qadri Islamic School siap mendampingi perjalanan akademik dan spiritual
                    putra-putri Anda
                    dengan penuh amanah dan profesionalisme.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('login') }}">
                        <button
                            class="px-8 py-4 bg-white text-emerald-600 rounded-2xl font-semibold hover:bg-emerald-50 transition-all duration-300 hover:scale-105 shadow-lg">
                            Akses Portal BK
                        </button>
                    </a>

                </div>
            </div>
        </div>
    </section>
</body>

</html>
