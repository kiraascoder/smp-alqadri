<!-- resources/views/admin/register.blade.php -->

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Halaman Guru</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="p-6 bg-gray-100 text-gray-900">

    <div class="mb-4">
        <a href="{{ route('admin.dashboard') }}" class="text-blue-500 hover:underline">← Kembali ke Dashboard</a>
    </div>

    <h2 class="text-xl font-bold mb-4">Register Guru</h2>

    @if ($errors->any())
        <ul class="text-red-500 mb-4">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('admin-guru.tambah') }}" class="mb-8 bg-white p-4 rounded shadow">
        @csrf
        <div class="mb-4">
            <label class="block">Nama:</label>
            <input type="text" name="name" required class="w-full p-2 border rounded">
        </div>

        <div class="mb-4">
            <label class="block">NIP:</label>
            <input type="text" name="nip" required class="w-full p-2 border rounded">
        </div>

        <div class="mb-4">
            <label class="block">Email:</label>
            <input type="email" name="email" required class="w-full p-2 border rounded">
        </div>

        <div class="mb-4">
            <label class="block">Password:</label>
            <input type="password" name="password" required class="w-full p-2 border rounded">
        </div>

        <div class="mb-4">
            <label class="block">Konfirmasi Password:</label>
            <input type="password" name="password_confirmation" required class="w-full p-2 border rounded">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Register</button>
    </form>

    <h3 class="text-lg font-semibold mb-4">Daftar Guru</h3>

    @foreach ($guru as $index)
        <div class="flex items-center gap-4 bg-white p-4 rounded shadow mb-2">
            <div class="flex-1">
                <p><strong>Nama:</strong> {{ $index->user->name }}</p>
                <p><strong>NIP:</strong> {{ $index->nip }}</p>
                <p><strong>Email:</strong> {{ $index->user->email }}</p>
            </div>
            <div class="flex gap-2">
                <button onclick="document.getElementById('modal-edit-{{ $index->id }}').style.display='flex'"
                    class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</button>

                <form action="{{ route('admin-guru.delete', $index->id) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus guru ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Hapus</button>
                </form>
            </div>
        </div>

        <!-- Modal Edit -->
        <div id="modal-edit-{{ $index->id }}"
            class="fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center hidden">
            <div class="bg-white p-6 rounded shadow w-full max-w-lg mx-auto relative">
                <h2 class="text-lg font-bold mb-4">Edit Guru</h2>
                <form action="{{ route('admin-guru.edit', $index->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="block">Nama:</label>
                        <input type="text" name="name" value="{{ $index->user->name }}" required
                            class="w-full p-2 border rounded">
                    </div>

                    <div class="mb-3">
                        <label class="block">NIP:</label>
                        <input type="text" name="nip" value="{{ $index->nip }}" required
                            class="w-full p-2 border rounded">
                    </div>

                    <div class="mb-3">
                        <label class="block">Email:</label>
                        <input type="email" name="email" value="{{ $index->user->email }}" required
                            class="w-full p-2 border rounded">
                    </div>

                    <div class="flex justify-end gap-2 mt-4">
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
                        <button type="button"
                            onclick="document.getElementById('modal-edit-{{ $index->id }}').style.display='none'"
                            class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach

</body>

</html>
