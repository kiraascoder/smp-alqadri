@extends('components.admin')

@section('title', 'Daftar Laporan')

@section('content')
    <div class="bg-gray-100 min-h-screen p-6">
        <div class="max-w-6xl mx-auto space-y-6">
            {{-- Header --}}
            <div class="flex justify-between items-center">
                <h1 class="text-4xl font-bold text-gray-800">💻 Daftar Laporan</h1>
                <button onclick="bukaModalTambah()"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow transition">
                    + Tambah Laporan
                </button>
            </div>

            {{-- Success Message --}}
            @if (session('success'))
                <div class="p-4 bg-green-100 text-green-800 rounded-md border border-green-300">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Error Message --}}
            @if ($errors->any())
                <div class="p-4 bg-red-100 text-red-800 rounded-md border border-red-300">
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Table --}}
            <div class="bg-white rounded-xl shadow-md overflow-x-auto">
                <table class="min-w-full table-auto text-sm">
                    <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-semibold">
                        <tr>
                            <th class="p-4 text-left">Siswa</th>
                            <th class="p-4 text-left">Guru BK</th>
                            <th class="p-4 text-left">Pelanggaran</th>
                            <th class="p-4 text-left">Deskripsi</th>
                            <th class="p-4 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @forelse ($laporans as $laporan)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="p-4">{{ $laporan->siswa->name ?? '-' }}</td>
                                <td class="p-4">{{ $laporan->guru->name ?? '-' }}</td>
                                <td class="p-4">{{ $laporan->pelanggaran->deskripsi ?? '-' }}</td>
                                <td class="p-4">{{ Str::limit($laporan->deskripsi, 30) }}</td>
                                <td class="p-4 space-x-2">
                                    <button onclick="document.getElementById('modalDetail{{ $laporan->id }}').showModal()"
                                        class="text-blue-600 hover:underline">Detail</button>
                                    <button onclick="document.getElementById('modalHapus{{ $laporan->id }}').showModal()"
                                        class="text-red-600 hover:underline">Hapus</button>
                                </td>
                            </tr>

                            {{-- Modal Detail --}}
                            <dialog id="modalDetail{{ $laporan->id }}" class="modal">
                                <div class="modal-box max-w-md bg-white rounded-xl p-6 shadow-lg">
                                    <h3 class="text-lg font-bold mb-4">Detail Laporan</h3>
                                    <div class="space-y-2 text-sm text-gray-700">
                                        <p><strong>Siswa:</strong> {{ $laporan->siswa->name ?? '-' }}</p>
                                        <p><strong>Guru BK:</strong> {{ $laporan->guru->name ?? '-' }}</p>
                                        <p><strong>Pelanggaran:</strong> {{ $laporan->pelanggaran->deskripsi ?? '-' }}</p>
                                        <p><strong>Deskripsi:</strong> {{ $laporan->deskripsi ?? '-' }}</p>
                                    </div>
                                    <div class="modal-action mt-4">
                                        <form method="dialog">
                                            <button class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Tutup</button>
                                        </form>
                                    </div>
                                </div>
                            </dialog>

                            {{-- Modal Hapus --}}
                            <dialog id="modalHapus{{ $laporan->id }}" class="modal">
                                <div class="modal-box max-w-md bg-white rounded-xl p-6 shadow-lg">
                                    <h3 class="text-lg font-semibold mb-2">Konfirmasi Hapus</h3>
                                    <p class="text-sm text-gray-700">Yakin ingin menghapus laporan untuk
                                        <strong>{{ $laporan->siswa->name ?? '-' }}</strong>?
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
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-6 text-gray-500">Belum ada data laporan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Modal Tambah --}}
        <div id="modalTambah" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white w-full max-w-xl rounded-xl p-6 shadow-xl">
                <h3 class="text-lg font-bold mb-4">Tambah Laporan</h3>

                <form method="POST" action="{{ route('laporan.tambah') }}">
                    @csrf
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block mb-1 font-medium">Siswa</label>
                            <select name="user_id" required
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200">
                                <option value="" disabled selected>Pilih Siswa</option>
                                @foreach ($siswaList as $siswa)
                                    <option value="{{ $siswa->id }}">{{ $siswa->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block mb-1 font-medium">Guru BK</label>
                            <select name="guru_id" required
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200">
                                <option value="" disabled selected>Pilih Guru BK</option>
                                @foreach ($guruList as $guru)
                                    <option value="{{ $guru->id }}">{{ $guru->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block mb-1 font-medium">Pelanggaran</label>
                            <select name="pelanggaran_id" required
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200">
                                <option value="" disabled selected>Pilih Pelanggaran</option>
                                @foreach ($pelanggaranList as $pelanggaran)
                                    <option value="{{ $pelanggaran->id }}">{{ $pelanggaran->deskripsi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block mb-1 font-medium">Deskripsi</label>
                            <textarea name="deskripsi" rows="3"
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200"></textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end gap-2">
                        <button type="button" onclick="tutupModalTambah()"
                            class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Batal</button>
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function bukaModalTambah() {
            document.getElementById('modalTambah').classList.remove('hidden');
        }

        function tutupModalTambah() {
            document.getElementById('modalTambah').classList.add('hidden');
        }
    </script>
@endsection
