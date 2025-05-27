<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Konseling</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800">

    <a href="{{ route('siswa.dashboard') }}">Dashboard</a>

    <div class="max-w-6xl mx-auto py-8 px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Daftar Konseling</h1>
            <button onclick="document.getElementById('modalTambah').showModal()"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Tambah Konseling</button>
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
                        <th class="p-3 text-left">Guru BK</th>
                        <th class="p-3 text-left">Tanggal</th>
                        <th class="p-3 text-left">Waktu</th>
                        <th class="p-3 text-left">Tempat</th>
                        <th class="p-3 text-left">Status</th>
                        <th class="p-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($konselings as $konseling)
                        <tr class="border-t">
                            <td class="p-3">{{ $konseling->guruBk->name ?? '-' }}</td>
                            <td class="p-3">{{ $konseling->tanggal }}</td>
                            <td class="p-3">{{ $konseling->waktu }}</td>
                            <td class="p-3">{{ $konseling->tempat }}</td>
                            <td class="p-3 capitalize">{{ $konseling->status }}</td>
                            <td class="p-3 space-x-2">
                                <button onclick="document.getElementById('modalDetail{{ $konseling->id }}').showModal()"
                                    class="text-blue-600 hover:underline">Detail</button>
                                <button onclick="document.getElementById('modalHapus{{ $konseling->id }}').showModal()"
                                    class="text-red-600 hover:underline">Hapus</button>
                            </td>
                        </tr>

                        <!-- Modal Detail -->
                        <dialog id="modalDetail{{ $konseling->id }}" class="modal">
                            <div class="modal-box w-96 max-w-full bg-white p-6 rounded shadow">
                                <h3 class="font-bold text-lg mb-4">Detail Konseling</h3>
                                <div class="space-y-2 text-sm">
                                    <p><strong>Guru BK:</strong> {{ $konseling->guruBk->name ?? '-' }}</p>
                                    <p><strong>Tanggal:</strong> {{ $konseling->tanggal }}</p>
                                    <p><strong>Waktu:</strong> {{ $konseling->waktu }}</p>
                                    <p><strong>Tempat:</strong> {{ $konseling->tempat }}</p>
                                    <p><strong>Topik:</strong> {{ $konseling->topik ?? '-' }}</p>
                                    <p><strong>Status:</strong> {{ $konseling->status }}</p>
                                    <p><strong>Catatan:</strong> {{ $konseling->catatan ?? '-' }}</p>
                                </div>
                                <div class="modal-action mt-4 text-right">
                                    <form method="dialog">
                                        <button class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Tutup</button>
                                    </form>
                                </div>
                            </div>
                        </dialog>

                        <!-- Modal Hapus -->
                        <dialog id="modalHapus{{ $konseling->id }}" class="modal">
                            <div class="modal-box w-96 max-w-full bg-white p-6 rounded shadow">
                                <h3 class="font-bold text-lg mb-2">Konfirmasi Hapus</h3>
                                <p>Yakin ingin menghapus konseling tanggal <strong>{{ $konseling->tanggal }}</strong>?
                                </p>
                                <div class="modal-action mt-4 flex justify-end gap-2">
                                    <form method="dialog">
                                        <button class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Batal</button>
                                    </form>
                                    <form method="POST" action="{{ route('konseling.hapus', $konseling->id) }}">
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

    <!-- Modal Tambah -->
    <dialog id="modalTambah" class="modal">
        <div class="modal-box w-full max-w-xl bg-white p-6 rounded shadow">
            <h3 class="font-bold text-lg mb-4">Tambah Konseling</h3>
            <form method="POST" action="{{ route('konseling.tambah') }}">
                @csrf
                <div class="mb-4">
                    <label class="block mb-1">Guru BK</label>
                    <select name="guru_bk_id" required class="w-full border border-gray-300 rounded px-3 py-2">
                        <option value="" disabled selected>Pilih Guru BK</option>
                        @foreach ($guruBkList as $guru)
                            <option value="{{ $guru->id }}">{{ $guru->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Tanggal</label>
                    <input type="date" name="tanggal" required
                        class="w-full border border-gray-300 rounded px-3 py-2">
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Waktu</label>
                    <input type="time" name="waktu" required
                        class="w-full border border-gray-300 rounded px-3 py-2">
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Tempat</label>
                    <input type="text" name="tempat" value="Ruang BK" required
                        class="w-full border border-gray-300 rounded px-3 py-2">
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Topik</label>
                    <textarea name="topik" rows="2" class="w-full border border-gray-300 rounded px-3 py-2"></textarea>
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
