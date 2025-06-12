<!-- resources/views/admin/login.blade.php -->

<!DOCTYPE html>
<html>

<head>
    <title>Login Siswa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <section class="min-h-screen flex items-center justify-center bg-blue-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full bg-white p-8 rounded-xl shadow-lg">
            <h2 class="text-2xl font-bold text-center text-blue-900 mb-6">Masuk ke Akun Anda</h2>
            <form action="{{ route('login.submit') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" required
                        class="mt-1 block w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        placeholder="you@example.com">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" required
                        class="mt-1 block w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        placeholder="********">
                </div>


                <button type="submit"
                    class="w-full bg-blue-700 text-white py-2 px-4 rounded-lg hover:bg-blue-800 transition">
                    Masuk
                </button>

                <p class="mt-4 text-center text-sm text-gray-600">Belum punya akun?
                    <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-medium">Daftar</a>
                </p>
            </form>
        </div>
    </section>
</body>

</html>
