<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Kesalahan Server</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .pulse-animation {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }
        }
    </style>
</head>

<body class="bg-gradient-to-br from-red-50 via-pink-50 to-purple-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full text-center">
        <!-- Error Icon -->
        <div class="mb-8">
            <div
                class="w-32 h-32 mx-auto bg-gradient-to-br from-red-100 to-pink-100 rounded-full flex items-center justify-center shadow-lg pulse-animation">
                <svg class="w-16 h-16 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <!-- Error Content -->
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-white/20 p-8">
            <h1 class="text-6xl font-bold bg-gradient-to-r from-red-600 to-pink-600 bg-clip-text text-transparent mb-4">
                500
            </h1>
            <h2 class="text-2xl font-bold text-gray-800 mb-3">
                Kesalahan Server
            </h2>
            <p class="text-gray-600 mb-6 leading-relaxed">
                Terjadi kesalahan pada server kami. Tim teknis telah diberitahu dan sedang memperbaikinya. Mohon coba
                lagi nanti.
            </p>

            <!-- Status Info -->
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-3 h-3 bg-red-500 rounded-full pulse-animation"></div>
                    <span class="text-sm text-red-700 font-medium">Status: Sedang diperbaiki</span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3">
                <button onclick="location.reload()"
                    class="block w-full bg-gradient-to-r from-red-600 to-pink-600 text-white py-3 px-6 rounded-xl font-semibold hover:from-red-700 hover:to-pink-700 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                    <span class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Coba Lagi
                    </span>
                </button>
                <a href="{{ url('/') }}"
                    class="block w-full bg-gray-100 text-gray-700 py-3 px-6 rounded-xl font-medium hover:bg-gray-200 transition-all duration-300">
                    Kembali ke Beranda
                </a>
            </div>
        </div>

        <!-- Footer -->
        <p class="text-gray-500 text-sm mt-6">
            Error ID: <span class="font-mono">{{ uniqid() }}</span> •
            <a href="mailto:tech@example.com" class="text-red-600 hover:underline">Laporkan Bug</a>
        </p>
    </div>
</body>

</html>
