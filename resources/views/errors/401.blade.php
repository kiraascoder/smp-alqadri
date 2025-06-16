<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>401 - Tidak Diizinkan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-red-50 via-orange-50 to-yellow-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full text-center">
        <!-- Error Icon -->
        <div class="mb-8">
            <div
                class="w-32 h-32 mx-auto bg-gradient-to-br from-red-100 to-orange-100 rounded-full flex items-center justify-center shadow-lg">
                <svg class="w-16 h-16 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 0h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
        </div>

        <!-- Error Content -->
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-white/20 p-8">
            <h1
                class="text-6xl font-bold bg-gradient-to-r from-red-600 to-orange-600 bg-clip-text text-transparent mb-4">
                401
            </h1>
            <h2 class="text-2xl font-bold text-gray-800 mb-3">
                Akses Tidak Diizinkan
            </h2>
            <p class="text-gray-600 mb-6 leading-relaxed">
                Anda perlu login untuk mengakses halaman ini. Silakan masuk dengan akun yang valid.
            </p>

            <!-- Action Buttons -->
            <div class="space-y-3">
                <a href="{{ route('login') }}"
                    class="block w-full bg-gradient-to-r from-red-600 to-orange-600 text-white py-3 px-6 rounded-xl font-semibold hover:from-red-700 hover:to-orange-700 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                    <span class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Login Sekarang
                    </span>
                </a>
                <a href="{{ url('/') }}"
                    class="block w-full bg-gray-100 text-gray-700 py-3 px-6 rounded-xl font-medium hover:bg-gray-200 transition-all duration-300">
                    Kembali ke Beranda
                </a>
            </div>
        </div>

        <!-- Footer -->
        <p class="text-gray-500 text-sm mt-6">
            Butuh bantuan? <a href="mailto:support@example.com" class="text-red-600 hover:underline">Hubungi Support</a>
        </p>
    </div>
</body>

</html>
