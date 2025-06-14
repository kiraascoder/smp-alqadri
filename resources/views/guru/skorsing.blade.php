@extends('components.admin')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 p-4 sm:p-6 lg:p-8">
        <div class="max-w-7xl mx-auto space-y-8">

            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="space-y-2">
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                        Manajemen Skorsing
                    </h1>
                    <p class="text-gray-600 text-lg">Kelola data skorsing dan riwayat pelanggaran siswa</p>
                </div>

                <button onclick="openModal()"
                    class="group relative inline-flex items-center gap-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 font-semibold">
                    <div
                        class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center group-hover:rotate-90 transition-transform duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    Tambah Skorsing
                </button>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div
                    class="relative overflow-hidden bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-green-800 font-semibold text-lg">Berhasil!</h3>
                            <p class="text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-green-200/30 rounded-full -translate-y-16 translate-x-16">
                    </div>
                </div>
            @endif

            <!-- Modern Data Table -->
            <div class="bg-white/80 backdrop-blur-lg border border-white/20 rounded-2xl shadow-xl overflow-hidden">
                <!-- Table Header -->
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-8 py-6 border-b border-gray-200">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Riwayat Pelanggaran</h2>
                            <p class="text-gray-600">Daftar lengkap pelanggaran dan skorsing siswa</p>
                        </div>
                    </div>
                </div>

                <!-- Table Content -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50/80">
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    No</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Siswa</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    NISN</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Pelanggaran</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Skor</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($riwayat as $item)
                                <tr class="hover:bg-blue-50/50 transition-colors duration-200 group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div
                                            class="w-8 h-8 bg-gray-100 group-hover:bg-blue-100 rounded-lg flex items-center justify-center text-sm font-semibold text-gray-600 transition-colors duration-200">
                                            {{ $loop->iteration }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-full flex items-center justify-center">
                                                <span class="text-sm font-semibold text-blue-600">
                                                    {{ substr($item->siswa->user->name ?? '-', 0, 1) }}
                                                </span>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900">
                                                    {{ $item->siswa->user->name ?? '-' }}</p>
                                                <p class="text-xs text-gray-500">Siswa</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ $item->siswa->nisn ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="max-w-xs">
                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                {{ $item->pelanggaran->deskripsi ?? '-' }}</p>
                                            <p class="text-xs text-gray-500">Pelanggaran</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold 
                                            @if (($item->pelanggaran->skor ?? 0) >= 50) bg-red-100 text-red-800
                                            @elseif(($item->pelanggaran->skor ?? 0) >= 25) bg-yellow-100 text-yellow-800
                                            @else bg-green-100 text-green-800 @endif">
                                            {{ $item->pelanggaran->skor ?? '-' }} poin
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
                                            <span class="text-sm text-gray-600">
                                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center gap-4">
                                            <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </div>
                                            <div class="text-center">
                                                <h3 class="text-lg font-semibold text-gray-900">Belum ada data</h3>
                                                <p class="text-gray-500">Belum ada riwayat pelanggaran yang tercatat</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Overlay -->
    <div id="modalOverlay"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 hidden opacity-0 transition-opacity duration-300"></div>

    <!-- Modal -->
    <div id="modalTambahSkorsing" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
        <div class="max-w-2xl w-full bg-white/95 backdrop-blur-lg border border-white/20 shadow-2xl rounded-2xl overflow-hidden transform transition-all duration-300 scale-95 opacity-0"
            id="modalContent">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-6">
                <h3 class="text-2xl font-bold text-white flex items-center gap-3">
                    <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    Tambah Data Skorsing
                </h3>
                <p class="text-blue-100 mt-2">Lengkapi form berikut untuk menambah data skorsing siswa</p>
            </div>

            <!-- Modal Content -->
            <div class="p-8">
                <form action="{{ route('skorsing.tambah') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Student Selection -->
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                            <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                            Pilih Siswa
                        </label>
                        <div class="relative">
                            <select name="siswa_id"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 appearance-none"
                                required>
                                <option value="">Pilih siswa yang akan di-skorsing...</option>
                                @foreach ($siswas as $siswa)
                                    <option value="{{ $siswa->id }}">{{ $siswa->user->name ?? '-' }} -
                                        {{ $siswa->nisn }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Violation Selection -->
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                            <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                            Jenis Pelanggaran
                        </label>
                        <div class="relative">
                            <select name="pelanggarans_id"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 appearance-none"
                                required>
                                <option value="">Pilih jenis pelanggaran...</option>
                                @foreach ($pelanggarans as $pelanggaran)
                                    <option value="{{ $pelanggaran->id }}">
                                        {{ $pelanggaran->deskripsi }}
                                        <span class="text-red-600">({{ $pelanggaran->skor }} poin)</span>
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Date Input -->
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                            Tanggal Kejadian
                        </label>
                        <input type="date" name="tanggal"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                            required>
                    </div>

                    <!-- Description -->
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                            <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                            Keterangan Tambahan
                        </label>
                        <textarea name="keterangan" rows="4"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 resize-none"
                            placeholder="Tambahkan keterangan detail mengenai pelanggaran..."></textarea>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-100">
                        <button type="button" onclick="closeModal()"
                            class="px-6 py-3 bg-gray-100 text-gray-600 rounded-xl hover:bg-gray-200 transition-all duration-200 font-medium">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk Modal -->
    <script>
        function openModal() {
            const modal = document.getElementById('modalTambahSkorsing');
            const modalContent = document.getElementById('modalContent');
            const overlay = document.getElementById('modalOverlay');

            // Show modal and overlay
            modal.classList.remove('hidden');
            overlay.classList.remove('hidden');

            // Trigger animations
            setTimeout(() => {
                overlay.classList.remove('opacity-0');
                overlay.classList.add('opacity-100');
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);

            // Prevent body scroll
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            const modal = document.getElementById('modalTambahSkorsing');
            const modalContent = document.getElementById('modalContent');
            const overlay = document.getElementById('modalOverlay');

            // Start close animation
            overlay.classList.remove('opacity-100');
            overlay.classList.add('opacity-0');
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');

            // Hide modal after animation
            setTimeout(() => {
                modal.classList.add('hidden');
                overlay.classList.add('hidden');

                // Reset form
                const form = modal.querySelector('form');
                if (form) form.reset();

                // Restore body scroll
                document.body.style.overflow = '';
            }, 300);
        }

        // Close modal when clicking overlay
        document.getElementById('modalOverlay').addEventListener('click', function() {
            closeModal();
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('modalTambahSkorsing');
                if (!modal.classList.contains('hidden')) {
                    closeModal();
                }
            }
        });
    </script>

    <style>
        /* Custom scrollbar */
        .overflow-x-auto::-webkit-scrollbar {
            height: 8px;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Smooth transitions */
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Modal backdrop blur effect */
        .backdrop-blur-sm {
            backdrop-filter: blur(4px);
        }
    </style>
@endsection
