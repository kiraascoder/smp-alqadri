<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Lupa Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow p-8">
        <h1 class="text-2xl font-bold mb-2">Lupa Password</h1>
        <p class="text-gray-500 mb-6">Masukkan email akun untuk menerima tautan reset password.</p>
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-50 text-green-700 rounded">{{ session('success') }}</div>
        @endif @error('email')
        <div class="mb-4 p-3 bg-red-50 text-red-700 rounded">{{ $message }}</div>
    @enderror
    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">@csrf<input type="email"
            name="email" value="{{ old('email') }}" required class="w-full border rounded-xl px-4 py-3"
            placeholder="Email"><button class="w-full bg-blue-700 text-white py-3 rounded-xl">Kirim Link
            Reset</button></form><a href="{{ route('login') }}" class="block text-center text-blue-700 mt-5">Kembali
        ke login</a>
</div>
</body>

</html>
