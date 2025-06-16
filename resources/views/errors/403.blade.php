<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-orange-50 via-red-50 to-pink-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full text-center">
        <!-- Error Icon -->
        <div class="mb-8">
            <div
                class="w-32 h-32 mx-auto bg-gradient-to-br from-orange-100 to-red-100 rounded-full flex items-center justify-center shadow-lg">
                <svg class="w-16 h-16 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364L18.364 5.636" />
                </svg>
            </div>
        </div>

        <!-- Error Content -->
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-white/20 p-8">
            <h1
                class="text-6xl font-bold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent mb-4">
                403
            </h1>
            <h2 class="text-2xl font-bold text-gray-800 mb-3">
                Akses Ditolak
            </h2>
            <p class="text-gray-600 mb-6 leading-relaxed">
                Anda tidak memiliki izin untuk mengakses halaman ini. Hubungi administrator jika Anda merasa ini adalah
                kesalahan.
            </p>

            <!-- Action Buttons -->
            <div class="space-y-3">
                <button onclick="history.back()"
                    class="block w-full bg-gradient-to-r from-orange-600 to-red-600 text-white py-3 px-6 rounded-xl font-semibold hover:from-orange-700 hover:to-red-700 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                    <span class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali
                    </span>
                </button>
                <a href="{{ url('/') }}"
                    class="block w-full bg-gray-100 text-gray-700 py-3 px-6 rounded-xl font-medium hover:bg-gray-200 transition-all duration-300">
                    Ke Halaman Utama
                </a>
            </div>
        </div>

        <!-- Footer -->
        <p class="text-gray-500 text-sm mt-6">
            Masalah persisten? <a href="mailto:admin@example.com" class="text-orange-600 hover:underline">Hubungi
                Admin</a>
        </p>
    </div>
</body>

</html>
