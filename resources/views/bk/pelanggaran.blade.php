@extends('components.admin')

@section('content')
    <div class="max-w-6xl mx-auto py-10 px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-semibold text-gray-800">Daftar Pelanggaran</h1>

        </div>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium">Kategori</th>
                        <th class="px-6 py-3 text-left font-medium">Deskripsi</th>
                        <th class="px-6 py-3 text-left font-medium">Skor</th>
                        <th class="px-6 py-3 text-left font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pelanggarans as $pelanggaran)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-6 py-4 capitalize">{{ $pelanggaran->kategori }}</td>
                            <td class="px-6 py-4">{{ Str::limit($pelanggaran->deskripsi, 50) }}</td>
                            <td class="px-6 py-4">{{ $pelanggaran->skor }}</td>
                            <td class="px-6 py-4 space-x-2">
                                <button
                                    onclick="showDetailModal(`{{ $pelanggaran->kategori }}`, `{{ $pelanggaran->deskripsi }}`, `{{ $pelanggaran->skor }}`)"
                                    class="text-blue-600 hover:underline">
                                    Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">Tidak ada data pelanggaran.</td>
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
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-xl font-bold mb-4">Detail Pelanggaran</h3>
            <p><strong>Kategori:</strong> <span id="modalKategori"></span></p>
            <p><strong>Deskripsi:</strong> <span id="modalDeskripsi"></span></p>
            <p><strong>Skor:</strong> <span id="modalSkor"></span></p>
            <div class="mt-6 text-right">
                <button onclick="tutupModalDetail()" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Tutup</button>
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
