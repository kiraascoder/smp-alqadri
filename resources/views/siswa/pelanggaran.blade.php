<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Daftar Pelanggaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800">
    <a href="{{ route('siswa.dashboard') }}">Dashboard</a>
    <div class="max-w-5xl mx-auto py-8 px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Daftar Pelanggaran</h1>
            <button onclick="document.getElementById('modalTambah').showModal()"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Tambah Pelanggaran
            </button>
        </div>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded shadow overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left">Kategori</th>
                        <th class="p-3 text-left">Deskripsi</th>
                        <th class="p-3 text-left">Skor</th>
                        <th class="p-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pelanggarans as $pelanggaran)
                        <tr class="border-t">
                            <td class="p-3">{{ $pelanggaran->kategori }}</td>
                            <td class="p-3">{{ Str::limit($pelanggaran->deskripsi, 50) }}</td>
                            <td class="p-3">{{ $pelanggaran->skor }}</td>
                            <td class="p-3 space-x-2">
                                <button
                                    onclick="document.getElementById('modalDetail{{ $pelanggaran->id }}').showModal()"
                                    class="text-blue-600 hover:underline">Detail</button>
                                <button
                                    onclick="document.getElementById('modalHapus{{ $pelanggaran->id }}').showModal()"
                                    class="text-red-600 hover:underline">Hapus</button>
                            </td>
                        </tr>

                        <!-- Modal Detail -->
                        <dialog id="modalDetail{{ $pelanggaran->id }}" class="modal">
                            <div class="modal-box w-96 max-w-full bg-white p-6 rounded shadow">
                                <h3 class="font-bold text-lg mb-4">Detail Pelanggaran</h3>
                                <p><strong>Kategori:</strong> {{ $pelanggaran->kategori }}</p>
                                <p><strong>Deskripsi:</strong> {{ $pelanggaran->deskripsi }}</p>
                                <p><strong>Skor:</strong> {{ $pelanggaran->skor }}</p>
                                <div class="modal-action mt-4 text-right">
                                    <form method="dialog">
                                        <button class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Tutup</button>
                                    </form>
                                </div>
                            </div>
                        </dialog>

                        <!-- Modal Hapus -->
                        <dialog id="modalHapus{{ $pelanggaran->id }}" class="modal">
                            <div class="modal-box w-96 max-w-full bg-white p-6 rounded shadow">
                                <h3 class="font-bold text-lg mb-2">Konfirmasi Hapus</h3>
                                <p>Yakin ingin menghapus pelanggaran kategori
                                    <strong>{{ $pelanggaran->kategori }}</strong>?
                                </p>
                                <div class="modal-action mt-4 flex justify-end gap-2">
                                    <form method="dialog">
                                        <button class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Batal</button>
                                    </form>
                                    <form method="POST" action="{{ route('pelanggaran.hapus', $pelanggaran->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </dialog>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Tambah Pelanggaran -->
    <dialog id="modalTambah" class="modal">
        <div class="modal-box w-full max-w-xl bg-white p-6 rounded shadow">
            <h3 class="font-bold text-lg mb-4">Tambah Pelanggaran</h3>
            <form method="POST" action="{{ route('pelanggaran.tambah') }}">
                @csrf
                <div class="mb-4">
                    <label class="block mb-1">Kategori</label>
                    <input type="text" name="kategori" required
                        class="w-full border border-gray-300 rounded px-3 py-2" />
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" class="w-full border border-gray-300 rounded px-3 py-2"></textarea>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Skor</label>
                    <input type="number" name="skor" required min="0" step="1"
                        class="w-full border border-gray-300 rounded px-3 py-2" />
                </div>
                <div class="modal-action mt-4 flex justify-end gap-2">
                    <form method="dialog">
                        <button type="button" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Batal</button>
                    </form>
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </dialog>

</body>

</html>
