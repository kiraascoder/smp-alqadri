<p>Halaman Laporan</p>

<a href="{{ route('siswa.dashboard') }}">Dashboard</a>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Laporan </title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800">

    <div class="max-w-6xl mx-auto py-8 px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Daftar Laporan</h1>
            <button onclick="document.getElementById('modalTambah').showModal()"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Tambah Laporan</button>
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
                        <th class="p-3 text-left">Siswa</th>
                        <th class="p-3 text-left">Guru BK</th>
                        <th class="p-3 text-left">Pelanggaran</th>
                        <th class="p-3 text-left">Deskripsi</th>
                        <th class="p-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($laporans as $laporan)
                        <tr class="border-t">
                            <td class="p-3">{{ $laporan->siswa->name ?? '-' }}</td>
                            <td class="p-3">{{ $laporan->guru->name ?? '-' }}</td>
                            <td class="p-3">{{ $laporan->pelanggaran->deskripsi ?? '-' }}</td>
                            <td class="p-3">{{ Str::limit($laporan->deskripsi, 30) }}</td>
                            <td class="p-3 space-x-2">
                                <button onclick="document.getElementById('modalDetail{{ $laporan->id }}').showModal()"
                                    class="text-blue-600 hover:underline">Detail</button>
                                <button onclick="document.getElementById('modalHapus{{ $laporan->id }}').showModal()"
                                    class="text-red-600 hover:underline">Hapus</button>
                            </td>
                        </tr>

                        <!-- Modal Detail -->
                        <dialog id="modalDetail{{ $laporan->id }}" class="modal">
                            <div class="modal-box w-96 max-w-full bg-white p-6 rounded shadow">
                                <h3 class="font-bold text-lg mb-4">Detail Konseling</h3>
                                <div class="space-y-2 text-sm">
                                    <p><strong>Siswa:</strong> {{ $laporan->siswa->name ?? '-' }}</p>
                                    <p><strong>Guru BK:</strong> {{ $laporan->guru->name ?? '-' }}</p>
                                    <p><strong>Pelanggaran:</strong> {{ $laporan->pelanggaran->nama ?? '-' }}</p>
                                    <p><strong>Deskripsi:</strong> {{ $laporan->deskripsi ?? '-' }}</p>

                                    @if ($laporan->konseling)
                                        <hr>
                                        <p class="font-semibold mt-2">Data Konseling:</p>
                                        <p><strong>Tanggal:</strong> {{ $laporan->konseling->tanggal }}</p>
                                        <p><strong>Waktu:</strong> {{ $laporan->konseling->waktu }}</p>
                                        <p><strong>Tempat:</strong> {{ $laporan->konseling->tempat }}</p>
                                        <p><strong>Topik:</strong> {{ $laporan->konseling->topik }}</p>
                                        <p><strong>Status:</strong> {{ $laporan->konseling->status }}</p>
                                        <p><strong>Catatan:</strong> {{ $laporan->konseling->catatan }}</p>
                                    @else
                                        <p class="italic text-gray-500">Belum ada konseling.</p>
                                    @endif
                                </div>
                                <div class="modal-action mt-4 text-right">
                                    <form method="dialog">
                                        <button class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Tutup</button>
                                    </form>
                                </div>
                            </div>
                        </dialog>

                        <!-- Modal Hapus -->
                        <dialog id="modalHapus{{ $laporan->id }}" class="modal">
                            <div class="modal-box w-96 max-w-full bg-white p-6 rounded shadow">
                                <h3 class="font-bold text-lg mb-2">Konfirmasi Hapus</h3>
                                <p>Yakin ingin menghapus laporan siswa <strong>{{ $laporan->siswa->name }}</strong>?
                                </p>
                                <div class="modal-action mt-4 flex justify-end gap-2">
                                    <form method="dialog">
                                        <button class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Batal</button>
                                    </form>
                                    <form method="POST" action="{{ route('laporan.hapus', $laporan->id) }}">
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
            <h3 class="font-bold text-lg mb-4">Tambah Laporan</h3>
            <form method="POST" action="{{ route('laporan.tambah') }}">
                @csrf
                <div class="mb-4">
                    <label class="block mb-1">Siswa</label>
                    <select name="user_id" required class="w-full border border-gray-300 rounded px-3 py-2">
                        <option value="" disabled selected>Pilih Siswa</option>
                        @foreach ($siswaList as $siswa)
                            <option value="{{ $siswa->id }}">{{ $siswa->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Guru BK</label>
                    <select name="guru_id" required class="w-full border border-gray-300 rounded px-3 py-2">
                        <option value="" disabled selected>Pilih Guru BK</option>
                        @foreach ($guruList as $guru)
                            <option value="{{ $guru->id }}">{{ $guru->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Pelanggaran</label>
                    <select name="pelanggaran_id" required class="w-full border border-gray-300 rounded px-3 py-2">
                        <option value="" disabled selected>Pilih Pelanggaran</option>
                        @foreach ($pelanggaranList as $pel)
                            <option value="{{ $pel->id }}">{{ $pel->deskripsi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" class="w-full border border-gray-300 rounded px-3 py-2"></textarea>
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
