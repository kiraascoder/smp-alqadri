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

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="p-4 bg-red-100 text-red-800 border border-red-300 rounded-lg shadow-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
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
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($konseling->tanggal)->format('d/m/Y') }}</td>
                                <td class="px-6 py-4">{{ $konseling->waktu }}</td>
                                <td class="px-6 py-4">{{ $konseling->tempat }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2 py-1 text-xs font-medium rounded-full 
                                        {{ $konseling->status === 'dijadwalkan'
                                            ? 'bg-yellow-100 text-yellow-800'
                                            : ($konseling->status === 'selesai'
                                                ? 'bg-green-100 text-green-800'
                                                : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($konseling->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center space-x-2">
                                    <button onclick="bukaModal('modalDetail{{ $konseling->id }}')"
                                        class="text-blue-600 hover:underline">Detail</button>

                                    @if ($konseling->status === 'dijadwalkan')
                                        <button onclick="bukaModal('modalHapus{{ $konseling->id }}')"
                                            class="text-red-600 hover:underline">Hapus</button>
                                    @endif
                                </td>
                            </tr>

                            <!-- Modal Detail -->
                            <div id="modalDetail{{ $konseling->id }}"
                                class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm flex items-center justify-center">
                                <div class="bg-white max-w-md w-full rounded-xl p-6 shadow-xl relative animate-scale-in">
                                    <button onclick="tutupModal('modalDetail{{ $konseling->id }}')"
                                        class="absolute top-3 right-3 text-gray-400 hover:text-red-500 text-lg font-bold">×</button>
                                    <h3 class="text-xl font-bold mb-4">📄 Detail Konseling</h3>
                                    <div class="space-y-3 text-sm text-gray-700">
                                        <div class="flex justify-between">
                                            <span class="font-medium">Guru BK:</span>
                                            <span>{{ $konseling->guruBk->name ?? '-' }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="font-medium">Tanggal:</span>
                                            <span>{{ \Carbon\Carbon::parse($konseling->tanggal)->format('d/m/Y') }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="font-medium">Waktu:</span>
                                            <span>{{ $konseling->waktu }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="font-medium">Tempat:</span>
                                            <span>{{ $konseling->tempat }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="font-medium">Status:</span>
                                            <span
                                                class="px-2 py-1 text-xs font-medium rounded-full 
                                                {{ $konseling->status === 'dijadwalkan'
                                                    ? 'bg-yellow-100 text-yellow-800'
                                                    : ($konseling->status === 'selesai'
                                                        ? 'bg-green-100 text-green-800'
                                                        : 'bg-red-100 text-red-800') }}">
                                                {{ ucfirst($konseling->status) }}
                                            </span>
                                        </div>
                                        @if ($konseling->topik)
                                            <div class="border-t pt-3">
                                                <span class="font-medium block mb-1">Topik:</span>
                                                <p class="text-gray-600">{{ $konseling->topik }}</p>
                                            </div>
                                        @endif
                                        @if ($konseling->catatan)
                                            <div class="border-t pt-3">
                                                <span class="font-medium block mb-1">Catatan:</span>
                                                <p class="text-gray-600">{{ $konseling->catatan }}</p>
                                            </div>
                                        @endif
                                        @if ($konseling->alasan_batal)
                                            <div class="border-t pt-3">
                                                <span class="font-medium block mb-1">Alasan Batal:</span>
                                                <p class="text-red-600">{{ $konseling->alasan_batal }}</p>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="mt-6 text-right">
                                        <button onclick="tutupModal('modalDetail{{ $konseling->id }}')"
                                            class="bg-gray-200 hover:bg-gray-300 text-sm px-4 py-2 rounded-lg">Tutup</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Hapus -->
                            @if ($konseling->status === 'dijadwalkan')
                                <div id="modalHapus{{ $konseling->id }}"
                                    class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm flex items-center justify-center">
                                    <div
                                        class="bg-white max-w-md w-full rounded-xl p-6 shadow-xl relative animate-scale-in">
                                        <button onclick="tutupModal('modalHapus{{ $konseling->id }}')"
                                            class="absolute top-3 right-3 text-gray-400 hover:text-red-500 text-lg font-bold">×</button>
                                        <h3 class="text-lg font-bold text-gray-800 mb-2">⚠️ Konfirmasi Hapus</h3>
                                        <p class="text-sm text-gray-700 mb-4">
                                            Yakin ingin menghapus konseling dengan Guru BK
                                            <strong>{{ $konseling->guruBk->name ?? '-' }}</strong>
                                            pada tanggal
                                            <strong>{{ \Carbon\Carbon::parse($konseling->tanggal)->format('d/m/Y') }}</strong>?
                                        </p>
                                        <div class="mt-6 flex justify-end gap-3">
                                            <button onclick="tutupModal('modalHapus{{ $konseling->id }}')"
                                                class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg transition">Batal</button>
                                            <form method="POST" action="{{ route('konseling.hapus', $konseling->id) }}"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center space-y-2">
                                        <span class="text-4xl">📋</span>
                                        <p class="font-medium">Belum ada data konseling</p>
                                        <p class="text-sm">Klik tombol "Tambah Konseling" untuk membuat permohonan konseling
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Modal Tambah --}}
        <div id="modalTambah"
            class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm flex items-center justify-center">
            <div class="bg-white w-full max-w-xl rounded-xl p-6 shadow-2xl relative animate-scale-in">
                <!-- Close Button -->
                <button onclick="tutupModalTambah()"
                    class="absolute top-3 right-3 text-gray-400 hover:text-red-500 text-lg font-bold">×</button>

                <!-- Header -->
                <h3 class="text-xl font-bold mb-4 text-gray-800">📝 Tambah Permohonan Konseling</h3>

                <!-- Form -->
                <form method="POST" action="{{ route('konseling.tambah') }}">
                    @csrf
                    <div class="grid grid-cols-1 gap-4">
                        <!-- Guru BK -->
                        <div>
                            <label class="block mb-2 font-medium text-gray-700">Guru BK <span
                                    class="text-red-500">*</span></label>
                            <select name="guru_bk_id" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition">
                                <option value="" disabled selected>Pilih Guru BK</option>
                                @foreach ($guruBkList as $guru)
                                    <option value="{{ $guru->id }}"
                                        {{ old('guru_bk_id') == $guru->id ? 'selected' : '' }}>
                                        {{ $guru->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tanggal -->
                        <div>
                            <label class="block mb-2 font-medium text-gray-700">Tanggal <span
                                    class="text-red-500">*</span></label>
                            <input type="date" name="tanggal" required value="{{ old('tanggal') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition">
                        </div>

                        <!-- Waktu -->
                        <div>
                            <label class="block mb-2 font-medium text-gray-700">Waktu <span
                                    class="text-red-500">*</span></label>
                            <input type="time" name="waktu" required value="{{ old('waktu') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition">
                        </div>

                        <!-- Tempat -->
                        <div>
                            <label class="block mb-2 font-medium text-gray-700">Tempat <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="tempat" value="{{ old('tempat', 'Ruang BK') }}" required
                                placeholder="Masukkan lokasi konseling"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition">
                        </div>

                        <!-- Topik -->
                        <div>
                            <label class="block mb-2 font-medium text-gray-700">Topik Konseling</label>
                            <textarea name="topik" rows="3"
                                placeholder="Jelaskan topik atau masalah yang ingin dikonsultasikan (opsional)"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition resize-none">{{ old('topik') }}</textarea>
                        </div>
                    </div>

                    <!-- Informasi Tambahan -->
                    <div class="mt-4 p-3 bg-blue-50 rounded-lg border border-blue-200">
                        <p class="text-xs text-blue-700">
                            <strong>Info:</strong> Setelah permohonan dikirim, status akan menjadi "dijadwalkan" dan
                            menunggu konfirmasi dari Guru BK.
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" onclick="tutupModalTambah()"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium px-5 py-2.5 rounded-lg transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2.5 rounded-lg transition shadow">
                            Kirim Permohonan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk membuka modal berdasarkan ID
        function bukaModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        // Fungsi untuk menutup modal berdasarkan ID
        function tutupModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        // Fungsi khusus untuk membuka modal tambah konseling
        function bukaModalTambah() {
            document.getElementById('modalTambah').classList.remove('hidden');

            // Set minimum date to today untuk mencegah pilih tanggal lampau
            const today = new Date().toISOString().split('T')[0];
            const dateInput = document.querySelector('#modalTambah input[name="tanggal"]');
            if (dateInput) {
                dateInput.setAttribute('min', today);
            }

            // Focus ke field pertama
            const firstInput = document.querySelector('#modalTambah select[name="guru_bk_id"]');
            if (firstInput) {
                setTimeout(() => firstInput.focus(), 100);
            }
        }

        // Fungsi khusus untuk menutup modal tambah konseling
        function tutupModalTambah() {
            document.getElementById('modalTambah').classList.add('hidden');

            // Reset form jika tidak ada error
            @if (!$errors->any())
                const form = document.querySelector('#modalTambah form');
                if (form) {
                    form.reset();
                }
            @endif
        }

        // Event listeners untuk menutup modal saat klik di luar atau tekan Escape
        document.addEventListener('DOMContentLoaded', function() {
            // Close modal when clicking outside
            document.getElementById('modalTambah').addEventListener('click', function(e) {
                if (e.target === this) {
                    tutupModalTambah();
                }
            });

            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    // Close any open modal
                    const openModals = document.querySelectorAll('.fixed:not(.hidden)');
                    openModals.forEach(modal => {
                        if (modal.id === 'modalTambah') {
                            tutupModalTambah();
                        } else {
                            tutupModal(modal.id);
                        }
                    });
                }
            });

            // Auto open modal tambah if there are validation errors
            @if ($errors->any())
                bukaModalTambah();
            @endif
        });
    </script>

    <style>
        .animate-scale-in {
            animation: scaleIn 0.2s ease-out;
        }

        @keyframes scaleIn {
            from {
                transform: scale(0.95);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>
@endsection
