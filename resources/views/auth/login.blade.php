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

        .input-error {
            border-color: #ef4444 !important;
            background-color: #fef2f2;
            animation: shake 0.5s ease-in-out;
        }

        .btn-hover {
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .btn-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }

        .btn-loading {
            opacity: 0.7;
            cursor: not-allowed;
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

        @keyframes shake {

            0%,
            20%,
            40%,
            60%,
            80%,
            100% {
                transform: translateX(0);
            }

            10%,
            30%,
            50%,
            70%,
            90% {
                transform: translateX(-5px);
            }
        }

        @keyframes slideDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(0);
                opacity: 1;
            }

            to {
                transform: translateY(-100%);
                opacity: 0;
            }
        }

        .alert-enter {
            animation: slideDown 0.5s ease-out;
        }

        .alert-exit {
            animation: slideUp 0.3s ease-in;
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

        .spinner {
            border: 2px solid #f3f3f3;
            border-top: 2px solid #667eea;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
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

    <!-- Alert Container -->
    <div id="alertContainer" class="fixed top-0 left-0 right-0 z-50">
        <!-- Success Alert -->
        @if (session('success'))
            <div id="successAlert"
                class="alert-enter bg-green-500 text-white px-6 py-4 mx-4 mt-4 rounded-lg shadow-lg flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-3 text-xl"></i>
                    <div>
                        <p class="font-semibold">Berhasil!</p>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
                <button onclick="closeAlert('successAlert')" class="text-white hover:text-gray-200 ml-4">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <!-- Error Alert -->
        @if ($errors->any() || session('error'))
            <div id="errorAlert"
                class="alert-enter bg-red-500 text-white px-6 py-4 mx-4 mt-4 rounded-lg shadow-lg flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle mr-3 text-xl"></i>
                    <div>
                        <p class="font-semibold">Terjadi Kesalahan!</p>
                        @if (session('error'))
                            <p class="text-sm">{{ session('error') }}</p>
                        @endif
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <p class="text-sm">{{ $error }}</p>
                            @endforeach
                        @endif
                    </div>
                </div>
                <button onclick="closeAlert('errorAlert')" class="text-white hover:text-gray-200 ml-4">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <!-- Warning Alert -->
        @if (session('warning'))
            <div id="warningAlert"
                class="alert-enter bg-yellow-500 text-white px-6 py-4 mx-4 mt-4 rounded-lg shadow-lg flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-3 text-xl"></i>
                    <div>
                        <p class="font-semibold">Peringatan!</p>
                        <p class="text-sm">{{ session('warning') }}</p>
                    </div>
                </div>
                <button onclick="closeAlert('warningAlert')" class="text-white hover:text-gray-200 ml-4">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <!-- Info Alert -->
        @if (session('info'))
            <div id="infoAlert"
                class="alert-enter bg-blue-500 text-white px-6 py-4 mx-4 mt-4 rounded-lg shadow-lg flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-info-circle mr-3 text-xl"></i>
                    <div>
                        <p class="font-semibold">Informasi</p>
                        <p class="text-sm">{{ session('info') }}</p>
                    </div>
                </div>
                <button onclick="closeAlert('infoAlert')" class="text-white hover:text-gray-200 ml-4">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif
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
                    <p class="text-gray-600 text-center text-sm">Silakan masuk untuk melanjutkan</p>
                </div>

                <form id="loginForm" action="{{ route('login.submit') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Email Input -->
                    <div class="relative">
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-2 text-indigo-500"></i>Email
                        </label>
                        <div class="relative">
                            <input type="email" name="email" id="email" required value="{{ old('email') }}"
                                class="input-focus block w-full px-4 py-3 pl-12 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 bg-white transition-all duration-300 @error('email') input-error @enderror"
                                placeholder="contoh@email.com">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                        </div>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                        <div id="emailError" class="text-red-500 text-xs mt-1 hidden flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            <span id="emailErrorText"></span>
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div class="relative">
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2 text-indigo-500"></i>Kata Sandi
                        </label>
                        <div class="relative">
                            <input type="password" name="password" id="password" required
                                class="input-focus block w-full px-4 py-3 pl-12 pr-12 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 bg-white transition-all duration-300 @error('password') input-error @enderror"
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
                        @error('password')
                            <p class="text-red-500 text-xs mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                        <div id="passwordError" class="text-red-500 text-xs mt-1 hidden flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            <span id="passwordErrorText"></span>
                        </div>
                    </div>
                    <!-- Login Button -->
                    <button type="submit" id="loginButton"
                        class="btn-hover w-full text-white py-3 px-6 rounded-xl font-semibold text-lg shadow-lg">
                        <span id="loginButtonText">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Masuk ke Sistem
                        </span>
                        <span id="loginSpinner" class="hidden">
                            <div class="spinner inline-block mr-2"></div>
                            Sedang masuk...
                        </span>
                    </button>
                </form>

                <!-- Help Section -->
                <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-blue-500 mt-1 mr-3"></i>
                        <div>
                            <h3 class="text-sm font-semibold text-blue-800 mb-1">Butuh Bantuan?</h3>
                            <p class="text-xs text-blue-600">
                                Hubungi guru BK atau admin sekolah jika mengalami kesulitan login.
                            </p>
                            <button onclick="showHelpModal()"
                                class="text-xs text-blue-700 underline mt-1 hover:text-blue-800">
                                Lihat panduan login
                            </button>
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

    <!-- Forgot Password Modal -->
    <div id="forgotPasswordModal"
        class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 transform transition-all duration-300 scale-95 opacity-0"
            id="forgotPasswordContent">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800">Lupa Kata Sandi</h3>
                <button onclick="closeForgotPasswordModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <p class="text-gray-600 mb-4">Hubungi guru BK atau admin sekolah untuk reset password.</p>
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <p class="text-yellow-800 text-sm">
                    <i class="fas fa-phone mr-2"></i>Kontak: (0411) 123-4567<br>
                    <i class="fas fa-envelope mr-2"></i>Email: admin@smpqadri.edu
                </p>
            </div>
            <button onclick="closeForgotPasswordModal()"
                class="w-full mt-4 bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700">
                Tutup
            </button>
        </div>
    </div>

    <!-- Help Modal -->
    <div id="helpModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 transform transition-all duration-300 scale-95 opacity-0"
            id="helpContent">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800">Panduan Login</h3>
                <button onclick="closeHelpModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="space-y-4 text-sm text-gray-600">
                <div>
                    <h4 class="font-semibold text-gray-800 mb-2">Cara Login:</h4>
                    <ol class="list-decimal list-inside space-y-1">
                        <li>Masukkan email yang terdaftar</li>
                        <li>Masukkan password yang benar</li>
                        <li>Klik tombol "Masuk ke Sistem"</li>
                    </ol>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800 mb-2">Jika Lupa Password:</h4>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Hubungi guru BK</li>
                        <li>Atau kontak admin sekolah</li>
                        <li>Siapkan NISN untuk verifikasi</li>
                    </ul>
                </div>
            </div>
            <button onclick="closeHelpModal()"
                class="w-full mt-4 bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700">
                Mengerti
            </button>
        </div>
    </div>

    <script>
        // Password toggle
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

        // Form validation
        function validateForm() {
            let isValid = true;
            const email = document.getElementById('email');
            const password = document.getElementById('password');

            // Reset errors
            clearErrors();

            // Email validation
            if (!email.value.trim()) {
                showError('email', 'Email harus diisi');
                isValid = false;
            } else if (!isValidEmail(email.value)) {
                showError('email', 'Format email tidak valid');
                isValid = false;
            }

            // Password validation
            if (!password.value.trim()) {
                showError('password', 'Password harus diisi');
                isValid = false;
            } else if (password.value.length < 6) {
                showError('password', 'Password minimal 6 karakter');
                isValid = false;
            }

            return isValid;
        }

        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        function showError(fieldName, message) {
            const field = document.getElementById(fieldName);
            const errorDiv = document.getElementById(fieldName + 'Error');
            const errorText = document.getElementById(fieldName + 'ErrorText');

            field.classList.add('input-error');
            errorDiv.classList.remove('hidden');
            errorText.textContent = message;
        }

        function clearErrors() {
            const fields = ['email', 'password'];
            fields.forEach(fieldName => {
                const field = document.getElementById(fieldName);
                const errorDiv = document.getElementById(fieldName + 'Error');

                field.classList.remove('input-error');
                errorDiv.classList.add('hidden');
            });
        }

        // Form submission
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
                return;
            }

            // Show loading state
            const loginButton = document.getElementById('loginButton');
            const loginButtonText = document.getElementById('loginButtonText');
            const loginSpinner = document.getElementById('loginSpinner');

            loginButton.classList.add('btn-loading');
            loginButton.disabled = true;
            loginButtonText.classList.add('hidden');
            loginSpinner.classList.remove('hidden');
        });

        // Alert functions
        function closeAlert(alertId) {
            const alert = document.getElementById(alertId);
            if (alert) {
                alert.classList.remove('alert-enter');
                alert.classList.add('alert-exit');
                setTimeout(() => {
                    alert.remove();
                }, 300);
            }
        }

        // Auto close alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('[id$="Alert"]');
            alerts.forEach(alert => {
                setTimeout(() => {
                    if (alert && alert.parentNode) {
                        closeAlert(alert.id);
                    }
                }, 5000);
            });
        });

        // Modal functions
        function showForgotPasswordModal() {
            const modal = document.getElementById('forgotPasswordModal');
            const content = document.getElementById('forgotPasswordContent');

            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeForgotPasswordModal() {
            const modal = document.getElementById('forgotPasswordModal');
            const content = document.getElementById('forgotPasswordContent');

            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        function showHelpModal() {
            const modal = document.getElementById('helpModal');
            const content = document.getElementById('helpContent');

            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeHelpModal() {
            const modal = document.getElementById('helpModal');
            const content = document.getElementById('helpContent');

            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
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

            // Clear errors on input
            input.addEventListener('input', function() {
                if (this.classList.contains('input-error')) {
                    this.classList.remove('input-error');
                    const errorDiv = document.getElementById(this.name + 'Error');
                    if (errorDiv) {
                        errorDiv.classList.add('hidden');
                    }
                }
            });
        });

        // Close modals when clicking outside
        document.addEventListener('click', function(e) {
            const forgotModal = document.getElementById('forgotPasswordModal');
            const helpModal = document.getElementById('helpModal');

            if (e.target === forgotModal) {
                closeForgotPasswordModal();
            }
            if (e.target === helpModal) {
                closeHelpModal();
            }
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Close modals with Escape key
            if (e.key === 'Escape') {
                closeForgotPasswordModal();
                closeHelpModal();
            }
        });
    </script>
</body>

</html>
