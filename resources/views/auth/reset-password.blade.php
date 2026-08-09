<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow p-8">
        <h1 class="text-2xl font-bold mb-6">Reset Password</h1>
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-50 text-red-700 rounded">{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">@csrf<input type="hidden"
                name="token" value="{{ $token }}"><input type="email" name="email"
                value="{{ old('email', $email) }}" required class="w-full border rounded-xl px-4 py-3"
                placeholder="Email"><input type="password" name="password" required
                class="w-full border rounded-xl px-4 py-3" placeholder="Password baru"><input type="password"
                name="password_confirmation" required class="w-full border rounded-xl px-4 py-3"
                placeholder="Konfirmasi password"><button class="w-full bg-blue-700 text-white py-3 rounded-xl">Simpan
                Password Baru</button></form>
    </div>
</body>

</html>
