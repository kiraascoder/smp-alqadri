@extends('components.admin')

@section('content')
    <div class="max-w-7xl mx-auto py-10 px-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-4xl font-bold text-gray-800">📋 Daftar Pelanggaran</h1>

            <!-- Tombol Tambah Pelanggaran -->
            <button onclick="openModal()"
                class="group relative inline-flex items-center gap-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 font-semibold">
                <div
                    class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center group-hover:rotate-90 transition-transform duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
                Tambah Pelanggaran
            </button>
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

    <!-- Modal Tambah Pelanggaran -->
    <div id="addModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full max-h-[95vh] flex flex-col transform transition-all duration-300 scale-95 opacity-0"
            id="addModalContent">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-6 rounded-t-2xl flex-shrink-0">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">Tambah Pelanggaran Baru</h3>
                            <p class="text-blue-100">Daftarkan jenis pelanggaran baru</p>
                        </div>
                    </div>
                    <button onclick="closeAddModal()"
                        class="text-white hover:bg-white/20 rounded-lg p-2 transition-colors duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="flex-1 overflow-y-auto p-6">
                <form id="addPelanggaranForm" action="{{ route('admin.tambah.pelanggaran') }}" method="POST"
                    class="space-y-6">
                    @csrf

                    <!-- Kategori Pelanggaran -->
                    <div>
                        <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2">
                            Kategori Pelanggaran <span class="text-red-500">*</span>
                        </label>
                        <select id="kategori" name="kategori" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                            <option value="">Pilih Kategori</option>
                            <option value="ringan">Ringan</option>
                            <option value="sedang">Sedang</option>
                            <option value="berat">Berat</option>
                        </select>
                        <div class="text-red-500 text-sm mt-1 hidden" id="kategori-error"></div>
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi Pelanggaran
                        </label>
                        <textarea id="deskripsi" name="deskripsi" rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 resize-none"
                            placeholder="Jelaskan detail pelanggaran..."></textarea>
                        <div class="text-red-500 text-sm mt-1 hidden" id="deskripsi-error"></div>
                    </div>

                    <!-- Skor -->
                    <div>
                        <label for="skor" class="block text-sm font-medium text-gray-700 mb-2">
                            Skor Pelanggaran <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="skor" name="skor" min="0" max="100" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                            placeholder="Masukkan skor (0-100)">
                        <div class="text-red-500 text-sm mt-1 hidden" id="skor-error"></div>
                        <p class="text-xs text-gray-500 mt-1">Skor 0-25: Ringan, 26-50: Sedang, 51-75: Berat, 76-100: Sangat
                            Berat</p>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex gap-3 pt-6 border-t border-gray-200">
                        <button type="button" onclick="closeAddModal()"
                            class="flex-1 px-6 py-3 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200 font-medium">
                            Batal
                        </button>
                        <button type="submit"
                            class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 font-medium shadow-lg hover:shadow-xl">
                            <span class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Tambah Pelanggaran
                            </span>
                        </button>
                    </div>
                </form>
            </div>
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

    <style>
        /* Modal animation */
        #addModal.show,
        #modal-detail.show {
            display: flex !important;
        }

        #addModal.show #addModalContent {
            transform: scale(1);
            opacity: 1;
        }
    </style>

    <script>
        // Function untuk menampilkan modal detail
        function showDetailModal(kategori, deskripsi, skor) {
            document.getElementById('modalKategori').textContent = kategori;
            document.getElementById('modalDeskripsi').textContent = deskripsi;
            document.getElementById('modalSkor').textContent = skor;
            document.getElementById('modal-detail').classList.remove('hidden');
        }

        // Function untuk menutup modal detail
        function tutupModalDetail() {
            document.getElementById('modal-detail').classList.add('hidden');
        }

        // Function untuk membuka modal tambah pelanggaran
        function openModal() {
            // Reset form
            document.getElementById('addPelanggaranForm').reset();

            // Hide all error messages
            const errorElements = document.querySelectorAll('[id$="-error"]');
            errorElements.forEach(el => el.classList.add('hidden'));

            // Reset input borders
            const inputs = document.querySelectorAll('#addModal input, #addModal select, #addModal textarea');
            inputs.forEach(input => {
                input.classList.remove('border-red-500');
                input.classList.add('border-gray-300');
            });

            document.getElementById('addModal').classList.add('show');
        }

        // Function untuk menutup modal tambah pelanggaran
        function closeAddModal() {
            document.getElementById('addModal').classList.remove('show');
        }

        // Form validation
        document.getElementById('addPelanggaranForm').addEventListener('submit', function(e) {
            let isValid = true;

            // Clear previous errors
            const errorElements = document.querySelectorAll('[id$="-error"]');
            errorElements.forEach(el => el.classList.add('hidden'));

            const inputs = document.querySelectorAll('#addModal input, #addModal select, #addModal textarea');
            inputs.forEach(input => {
                input.classList.remove('border-red-500');
                input.classList.add('border-gray-300');
            });

            // Validate required fields
            const kategori = document.getElementById('kategori');
            const kategoriError = document.getElementById('kategori-error');
            const skor = document.getElementById('skor');
            const skorError = document.getElementById('skor-error');

            if (!kategori.value.trim()) {
                showError(kategori, kategoriError, 'Kategori wajib dipilih');
                isValid = false;
            }

            if (!skor.value.trim()) {
                showError(skor, skorError, 'Skor wajib diisi');
                isValid = false;
            } else if (parseInt(skor.value) < 0) {
                showError(skor, skorError, 'Skor tidak boleh negatif');
                isValid = false;
            } else if (parseInt(skor.value) > 100) {
                showError(skor, skorError, 'Skor maksimal 100');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
            }
        });

        function showError(field, errorEl, message) {
            field.classList.remove('border-gray-300');
            field.classList.add('border-red-500');
            errorEl.textContent = message;
            errorEl.classList.remove('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('addModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAddModal();
            }
        });

        document.getElementById('modal-detail').addEventListener('click', function(e) {
            if (e.target === this) {
                tutupModalDetail();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAddModal();
                tutupModalDetail();
            }
        });
    </script>
@endsection
