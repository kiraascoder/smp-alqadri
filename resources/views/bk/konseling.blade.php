@extends('components.admin')

@section('content')
    <div class="bg-gray-100 min-h-screen p-6">
        <div class="max-w-6xl mx-auto space-y-6">
            {{-- Header --}}
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-semibold text-gray-800">📋 Daftar Konseling</h1>
                <button onclick="bukaModalTambah()"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2 rounded-lg transition">
                    + Tambah Konseling
                </button>

            </div>

            {{-- Success Message --}}
            @if (session('success'))
                <div class="p-4 bg-green-100 text-green-800 rounded-md border border-green-300">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Table --}}
            <div class="bg-white rounded-xl shadow-md overflow-x-auto">
                <table class="min-w-full table-auto text-sm">
                    <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-semibold">
                        <tr>
                            <th class="p-4 text-left">Guru BK</th>
                            <th class="p-4 text-left">Tanggal</th>
                            <th class="p-4 text-left">Waktu</th>
                            <th class="p-4 text-left">Tempat</th>
                            <th class="p-4 text-left">Status</th>
                            <th class="p-4 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @forelse ($konselings as $konseling)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="p-4">{{ $konseling->guruBk->name ?? '-' }}</td>
                                <td class="p-4">{{ $konseling->tanggal }}</td>
                                <td class="p-4">{{ $konseling->waktu }}</td>
                                <td class="p-4">{{ $konseling->tempat }}</td>
                                <td class="p-4 capitalize">{{ $konseling->status }}</td>
                                <td class="p-4 space-x-2">
                                    <button onclick="document.getElementById('modalDetail{{ $konseling->id }}').showModal()"
                                        class="text-blue-600 hover:underline">Detail</button>
                                    <button onclick="document.getElementById('modalHapus{{ $konseling->id }}').showModal()"
                                        class="text-red-600 hover:underline">Hapus</button>
                                </td>
                            </tr>

                            {{-- Modal Detail --}}
                            <dialog id="modalDetail{{ $konseling->id }}" class="modal">
                                <div class="modal-box max-w-md bg-white rounded-xl p-6 shadow-lg">
                                    <h3 class="text-lg font-bold mb-4">Detail Konseling</h3>
                                    <div class="space-y-2 text-sm text-gray-700">
                                        <p><strong>Guru BK:</strong> {{ $konseling->guruBk->name ?? '-' }}</p>
                                        <p><strong>Tanggal:</strong> {{ $konseling->tanggal }}</p>
                                        <p><strong>Waktu:</strong> {{ $konseling->waktu }}</p>
                                        <p><strong>Tempat:</strong> {{ $konseling->tempat }}</p>
                                        <p><strong>Topik:</strong> {{ $konseling->topik ?? '-' }}</p>
                                        <p><strong>Status:</strong> {{ $konseling->status }}</p>
                                        <p><strong>Catatan:</strong> {{ $konseling->catatan ?? '-' }}</p>
                                    </div>
                                    <div class="modal-action mt-4">
                                        <form method="dialog">
                                            <button class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">
                                                Tutup
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </dialog>

                            {{-- Modal Hapus --}}
                            <dialog id="modalHapus{{ $konseling->id }}" class="modal">
                                <div class="modal-box max-w-md bg-white rounded-xl p-6 shadow-lg">
                                    <h3 class="text-lg font-semibold mb-2">Konfirmasi Hapus</h3>
                                    <p class="text-sm text-gray-700">Yakin ingin menghapus konseling tanggal
                                        <strong>{{ $konseling->tanggal }}</strong>?
                                    </p>
                                    <div class="modal-action mt-4 flex justify-end gap-2">
                                        <form method="dialog">
                                            <button class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Batal</button>
                                        </form>
                                        <form method="POST" action="{{ route('konseling.hapus', $konseling->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </dialog>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-6 text-gray-500">Belum ada data konseling.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Modal Tambah --}}
        {{-- Modal Tambah Konseling --}}
        <div id="modalTambah" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white w-full max-w-xl rounded-xl p-6 shadow-xl">
                <h3 class="text-lg font-bold mb-4">Tambah Konseling</h3>
                @if (session('error'))
                    <div class="p-4 bg-red-100 text-red-800 rounded-md border border-red-300 mt-2">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('konseling-Bktambah') }}">
                    @csrf
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block mb-1 font-medium">Siswa</label>
                            <select name="siswa_id" required
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200">
                                <option value="" disabled selected>Pilih Siswa</option>
                                @foreach ($siswas as $siswa)
                                    <option value="{{ $siswa->id }}">{{ $siswa->user->name }} ({{ $siswa->nisn }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block mb-1 font-medium">Tanggal</label>
                            <input type="date" name="tanggal" required
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200">
                        </div>
                        <div>
                            <label class="block mb-1 font-medium">Waktu</label>
                            <input type="time" name="waktu" required
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200">
                        </div>
                        <div>
                            <label class="block mb-1 font-medium">Tempat</label>
                            <input type="text" name="tempat" value="Ruang BK" required
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200">
                        </div>
                        <div>
                            <label class="block mb-1 font-medium">Topik</label>
                            <textarea name="topik" rows="3"
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
