@extends('components.admin')

@section('content')
    <div class="max-w-7xl mx-auto py-10 px-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-4xl font-bold text-gray-800">📋 Daftar Pelanggaran</h1>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-emerald-100 border border-emerald-300 text-emerald-800 rounded-lg shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-xl rounded-xl overflow-hidden ring-1 ring-gray-200">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
                <thead class="bg-gray-50 text-gray-700 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Deskripsi</th>
                        <th class="px-6 py-4">Skor</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse ($pelanggarans as $pelanggaran)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 capitalize font-medium text-gray-900">{{ $pelanggaran->kategori }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ Str::limit($pelanggaran->deskripsi, 50) }}</td>
                            <td class="px-6 py-4 font-semibold text-blue-600">{{ $pelanggaran->skor }}</td>
                            <td class="px-6 py-4 text-center">
                                <button
                                    onclick="showDetailModal(`{{ $pelanggaran->kategori }}`, `{{ $pelanggaran->deskripsi }}`, `{{ $pelanggaran->skor }}`)"
                                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-600 hover:text-white hover:bg-blue-600 border border-blue-600 rounded-lg transition">
                                    Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500 italic">Belum ada data
                                pelanggaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6 flex justify-center">
            {{ $pelanggarans->links('vendor.pagination.tailwind') }}
        </div>
    </div>

    <!-- Modal Detail -->
    <div id="modal-detail" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">📌 Detail Pelanggaran</h2>
            <div class="space-y-4 text-gray-700">
                <p><strong>Kategori:</strong> <span id="modalKategori"></span></p>
                <p><strong>Deskripsi:</strong> <span id="modalDeskripsi"></span></p>
                <p><strong>Skor:</strong> <span id="modalSkor"></span></p>
            </div>
            <div class="mt-8 text-right">
                <button onclick="tutupModalDetail()"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-lg transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
        function showDetailModal(kategori, deskripsi, skor) {
            document.getElementById('modalKategori').textContent = kategori;
            document.getElementById('modalDeskripsi').textContent = deskripsi;
            document.getElementById('modalSkor').textContent = skor;
            document.getElementById('modal-detail').classList.remove('hidden');
        }

        function tutupModalDetail() {
            document.getElementById('modal-detail').classList.add('hidden');
        }
    </script>
@endsection
