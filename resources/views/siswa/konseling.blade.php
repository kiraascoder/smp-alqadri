@extends('components.admin')

@section('content')
    <div class="bg-gray-100 min-h-screen p-6">
        <div class="max-w-7xl mx-auto space-y-8">
            {{-- Header --}}
            <div class="flex justify-between items-center">
                <h1 class="text-4xl font-bold text-gray-800">🧠 Daftar Konseling</h1>
                <button onclick="bukaModalTambah()"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow transition">
                    + Tambah Konseling
                </button>
            </div>

            {{-- Success Message --}}
            @if (session('success'))
                <div class="p-4 bg-emerald-100 text-emerald-800 border border-emerald-300 rounded-lg shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Table --}}
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden ring-1 ring-gray-200">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-700 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="px-6 py-4">Guru BK</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Waktu</th>
                            <th class="px-6 py-4">Tempat</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse ($konselings as $konseling)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">{{ $konseling->guruBk->name ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $konseling->tanggal }}</td>
                                <td class="px-6 py-4">{{ $konseling->waktu }}</td>
                                <td class="px-6 py-4">{{ $konseling->tempat }}</td>
                                <td class="px-6 py-4 capitalize">{{ $konseling->status }}</td>
                                <td class="px-6 py-4 text-center space-x-2">
                                    <button onclick="document.getElementById('modalDetail{{ $konseling->id }}').showModal()"
                                        class="text-blue-600 hover:underline">Detail</button>
                                    <button onclick="document.getElementById('modalHapus{{ $konseling->id }}').showModal()"
                                        class="text-red-600 hover:underline">Hapus</button>
                                </td>
                            </tr>

                            {{-- Modal Detail --}}
                            <dialog id="modalDetail{{ $konseling->id }}" class="modal">
                                <div class="modal-box max-w-md bg-white rounded-xl p-6 shadow-xl">
                                    <h3 class="text-xl font-bold mb-4">📄 Detail Konseling</h3>
                                    <div class="space-y-2 text-sm text-gray-700">
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
                                            <button
                                                class="bg-gray-200 hover:bg-gray-300 text-sm px-4 py-2 rounded-lg">Tutup</button>
                                        </form>
                                    </div>
                                </div>
                            </dialog>

                            {{-- Modal Hapus --}}
                            <dialog id="modalHapus{{ $konseling->id }}" class="modal">
                                <div class="modal-box max-w-md bg-white rounded-xl p-6 shadow-xl">
                                    <h3 class="text-lg font-bold text-gray-800 mb-2">Konfirmasi Hapus</h3>
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
                                <td colspan="6" class="px-6 py-6 text-center text-gray-500 italic">Belum ada data
                                    konseling.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Modal Tambah --}}
        <div id="modalTambah" class="fixed inset-0 z-50 hidden bg-black/50 flex items-center justify-center">
            <div class="bg-white w-full max-w-xl rounded-xl p-6 shadow-2xl">
                <h3 class="text-xl font-bold mb-4">📝 Tambah Konseling</h3>
                <form method="POST" action="{{ route('konseling.tambah') }}">
                    @csrf
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block mb-1 font-medium">Guru BK</label>
                            <select name="guru_bk_id" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
                                <option value="" disabled selected>Pilih Guru BK</option>
                                @foreach ($guruBkList as $guru)
                                    <option value="{{ $guru->id }}">{{ $guru->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block mb-1 font-medium">Tanggal</label>
                            <input type="date" name="tanggal" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
                        </div>
                        <div>
                            <label class="block mb-1 font-medium">Waktu</label>
                            <input type="time" name="waktu" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
                        </div>
                        <div>
                            <label class="block mb-1 font-medium">Tempat</label>
                            <input type="text" name="tempat" value="Ruang BK" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
                        </div>
                        <div>
                            <label class="block mb-1 font-medium">Topik</label>
                            <textarea name="topik" rows="3"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200"></textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end gap-2">
                        <button type="button" onclick="tutupModalTambah()"
                            class="bg-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300">Batal</button>
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Simpan</button>
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
