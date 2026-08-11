<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SMP Al Qadri</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body
    class="min-h-screen bg-gradient-to-br from-blue-950 via-blue-800 to-indigo-700 flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8">
        <div class="text-center mb-8">
            <div class="text-5xl mb-3">🎓</div>
            <h1 class="text-2xl font-bold text-gray-900">SMP Al Qadri</h1>
            <p class="text-gray-500 mt-1">Masuk sebagai Admin, Guru, atau Orang Tua</p>
        </div>

        @if (session('success'))
            <div class="mb-4 p-3 rounded-lg bg-green-50 text-green-700">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-red-50 text-red-700">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500"
                    placeholder="email@contoh.com">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Password</label>
                <input type="password" name="password" required
                    class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500" placeholder="Password">
            </div>
            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center gap-2"><input type="checkbox" name="remember"> Ingat saya</label>
                <a href="{{ route('password.request') }}" class="text-blue-700 hover:underline">Lupa password?</a>
            </div>
            <button class="w-full bg-blue-700 hover:bg-blue-800 text-white rounded-xl py-3 font-semibold">Masuk</button>
        </form>
    </div>
</body>

</html>
