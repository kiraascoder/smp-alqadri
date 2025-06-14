<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - SMP Al Qadri</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gradient-to-tr from-blue-50 to-white min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-2xl">
        <div class="mb-6 text-center">
            <h1 class="text-3xl font-extrabold text-blue-900">Buat Akun Siswa</h1>
            <p class="text-sm text-gray-500 mt-1">Silakan isi data diri Anda dengan benar</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-300 text-red-700 p-3 rounded mb-4 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.submit') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm"
                    placeholder="Nama Lengkap">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                    class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm"
                    placeholder="email@example.com">
            </div>

            <div>
                <label for="nisn" class="block text-sm font-medium text-gray-700">NISN</label>
                <input type="text" name="nisn" id="nisn" value="{{ old('nisn') }}" required
                    class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm"
                    placeholder="1234567890">
            </div>

            <div>
                <label for="kelas_id" class="block text-sm font-medium text-gray-700">Kelas</label>
                <select name="kelas_id" id="kelas_id" required
                    class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach ($kelas as $k)
                        <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" required
                    class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm"
                    placeholder="********">
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi
                    Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm"
                    placeholder="********">
            </div>

            <div>
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-all duration-200">
                    Daftar Akun
                </button>
            </div>

            <p class="text-sm text-center text-gray-600">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-blue-600 font-medium hover:underline">Masuk di sini</a>
            </p>
        </form>
    </div>

</body>

</html>
