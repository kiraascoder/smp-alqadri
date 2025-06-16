<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .float-animation {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }
    </style>
</head>

<body
    class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full text-center">
        <!-- Error Icon -->
        <div class="mb-8">
            <div
                class="w-32 h-32 mx-auto bg-gradient-to-br from-blue-100 to-indigo-100 rounded-full flex items-center justify-center shadow-lg float-animation">
                <svg class="w-16 h-16 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
        </div>

        <!-- Error Content -->
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-white/20 p-8">
            <h1
                class="text-6xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-4">
                404
            </h1>
            <h2 class="text-2xl font-bold text-gray-800 mb-3">
                Halaman Tidak Ditemukan
            </h2>
            <p class="text-gray-600 mb-6 leading-relaxed">
                Oops! Halaman yang Anda cari tidak dapat ditemukan. Mungkin halaman telah dipindahkan atau URL salah.
            </p>

            <!-- Search Box -->
            <div class="mb-6">
                <div class="relative">
                    <input type="text" placeholder="Cari halaman..."
                        class="w-full px-4 py-3 pl-10 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3">
                <a href="{{ url('/') }}"
                    class="block w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 px-6 rounded-xl font-semibold hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                    <span class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Kembali ke Beranda
                    </span>
                </a>
                <button onclick="history.back()"
                    class="block w-full bg-gray-100 text-gray-700 py-3 px-6 rounded-xl font-medium hover:bg-gray-200 transition-all duration-300">
                    Halaman Sebelumnya
                </button>
            </div>
        </div>

        <!-- Footer -->
        <p class="text-gray-500 text-sm mt-6">
            Masih bermasalah? <a href="mailto:help@example.com" class="text-blue-600 hover:underline">Laporkan
                masalah</a>
        </p>
    </div>
</body>

</html>
