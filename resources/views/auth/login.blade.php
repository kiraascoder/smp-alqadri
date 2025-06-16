<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Siswa - SMP Alqadri BK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        * {
            font-family: 'Inter', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .input-focus {
            transition: all 0.3s ease;
        }

        .input-focus:focus {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        .btn-hover {
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .btn-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }

        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 6s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            right: 10%;
            animation-delay: 2s;
        }

        .shape:nth-child(3) {
            width: 60px;
            height: 60px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        .pulse-animation {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.7);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(102, 126, 234, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(102, 126, 234, 0);
            }
        }
    </style>
</head>

<body class="min-h-screen gradient-bg">
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-md w-full space-y-8">
            <!-- Header Section -->
            <div class="text-center">
                <div
                    class="mx-auto h-20 w-20 bg-white rounded-full flex items-center justify-center mb-6 pulse-animation shadow-lg">
                    <i class="fas fa-graduation-cap text-3xl text-indigo-600"></i>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">SMP Alqadri Islamic School</h1>
                <p class="text-indigo-100 text-lg font-medium">Sistem Bimbingan & Konseling</p>
                <p class="text-indigo-200 text-sm mt-2">Masuk untuk mengakses layanan konseling</p>
            </div>

            <!-- Login Form -->
            <div class="glass-effect rounded-2xl shadow-2xl p-8 transform transition-all duration-300 hover:scale-105">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 text-center mb-2">Selamat Datang</h2>
                    <p class="text-gray-600 text-center text-sm">Silakan masuk </p>
                </div>

                <form action="{{ route('login.submit') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Email Input -->
                    <div class="relative">
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-2 text-indigo-500"></i>Email
                        </label>
                        <div class="relative">
                            <input type="email" name="email" id="email" required
                                class="input-focus block w-full px-4 py-3 pl-12 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 bg-white transition-all duration-300"
                                placeholder="Email">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div class="relative">
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2 text-indigo-500"></i>Kata Sandi
                        </label>
                        <div class="relative">
                            <input type="password" name="password" id="password" required
                                class="input-focus block w-full px-4 py-3 pl-12 pr-12 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 bg-white transition-all duration-300"
                                placeholder="Masukkan kata sandi">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-key text-gray-400"></i>
                            </div>
                            <button type="button" onclick="togglePassword()"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i id="eyeIcon"
                                    class="fas fa-eye text-gray-400 hover:text-indigo-500 transition-colors"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Login Button -->
                    <button type="submit"
                        class="btn-hover w-full text-white py-3 px-6 rounded-xl font-semibold text-lg shadow-lg">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Masuk ke Sistem
                    </button>
                </form>

                <!-- Divider -->
                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">atau</span>
                        </div>
                    </div>
                </div>

                <!-- Register Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Belum memiliki akun siswa?
                        <a href="{{ route('register') }}"
                            class="font-semibold text-indigo-600 hover:text-indigo-800 transition-colors ml-1">
                            <i class="fas fa-user-plus mr-1"></i>Daftar di sini
                        </a>
                    </p>
                </div>

                <!-- Help Section -->
                <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-blue-500 mt-1 mr-3"></i>
                        <div>
                            <h3 class="text-sm font-semibold text-blue-800 mb-1">Butuh Bantuan?</h3>
                            <p class="text-xs text-blue-600">
                                Hubungi guru BK atau admin sekolah jika mengalami kesulitan login.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-8">
                <p class="text-sm text-indigo-200">
                    © 2025 SMP Alqadri Islamic School - Sistem Bimbingan & Konseling
                </p>

            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }

        // Add smooth animations when page loads
        document.addEventListener('DOMContentLoaded', function() {
            const formContainer = document.querySelector('.glass-effect');
            formContainer.style.opacity = '0';
            formContainer.style.transform = 'translateY(30px)';

            setTimeout(() => {
                formContainer.style.transition = 'all 0.6s ease';
                formContainer.style.opacity = '1';
                formContainer.style.transform = 'translateY(0)';
            }, 200);
        });

        // Add input focus effects
        const inputs = document.querySelectorAll('input[type="email"], input[type="password"]');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });

            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
    </script>
</body>

</html>
