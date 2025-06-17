@extends('components.admin')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 p-4 sm:p-6 lg:p-8">
        <div class="max-w-7xl mx-auto space-y-8">

            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="space-y-2">
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                        Skorsing Siswa
                    </h1>
                    <p class="text-gray-600 text-lg">Kelola data skorsing dan riwayat pelanggaran siswa</p>
                </div>
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
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
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

                        <!-- Data Count Info -->
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <span>Total: {{ $riwayat->total() }} data</span>
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
                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($riwayat as $item)
                                <tr class="hover:bg-blue-50/50 transition-colors duration-200 group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div
                                            class="w-8 h-8 bg-gray-100 group-hover:bg-blue-100 rounded-lg flex items-center justify-center text-sm font-semibold text-gray-600 transition-colors duration-200">
                                            {{ ($riwayat->currentPage() - 1) * $riwayat->perPage() + $loop->iteration }}
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
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center justify-center gap-2">
                                            <!-- Tombol Detail -->
                                            <button onclick="openDetailModal({{ $item->id }})"
                                                class="group relative inline-flex items-center justify-center w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200"
                                                title="Lihat Detail">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>

                                            <!-- Tombol Hapus -->
                                            <button
                                                onclick="confirmDelete({{ $item->id }}, '{{ $item->siswa->user->name ?? 'Siswa' }}')"
                                                class="group relative inline-flex items-center justify-center w-10 h-10 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200"
                                                title="Hapus Data">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center gap-4">
                                            <div
                                                class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center">
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

                <!-- Pagination Section -->
                @if ($riwayat->total() > 0)
                    <div class="bg-gray-50/50 px-6 py-4 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">

                            <!-- Info Text -->
                            <div class="text-sm text-gray-600">
                                Menampilkan
                                <span class="font-semibold text-gray-900">{{ $riwayat->firstItem() }}</span>
                                sampai
                                <span class="font-semibold text-gray-900">{{ $riwayat->lastItem() }}</span>
                                dari
                                <span class="font-semibold text-gray-900">{{ $riwayat->total() }}</span>
                                hasil
                            </div>

                            <!-- Pagination Links -->
                            <div class="flex items-center gap-2">
                                <!-- Previous Page Link -->
                                @if ($riwayat->onFirstPage())
                                    <span
                                        class="px-3 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-200 rounded-lg cursor-not-allowed">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </span>
                                @else
                                    <a href="{{ $riwayat->previousPageUrl() }}"
                                        class="px-3 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 hover:text-gray-800 transition-all duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </a>
                                @endif

                                <!-- Page Numbers -->
                                @foreach ($riwayat->getUrlRange(1, $riwayat->lastPage()) as $page => $url)
                                    @if ($page == $riwayat->currentPage())
                                        <span
                                            class="px-4 py-2 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-indigo-600 border border-blue-600 rounded-lg shadow-sm">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <a href="{{ $url }}"
                                            class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 hover:text-gray-800 transition-all duration-200">
                                            {{ $page }}
                                        </a>
                                    @endif
                                @endforeach

                                <!-- Next Page Link -->
                                @if ($riwayat->hasMorePages())
                                    <a href="{{ $riwayat->nextPageUrl() }}"
                                        class="px-3 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 hover:text-gray-800 transition-all duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                @else
                                    <span
                                        class="px-3 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-200 rounded-lg cursor-not-allowed">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Overlay -->
    <div id="modalOverlay"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 hidden opacity-0 transition-opacity duration-300"></div>

    <!-- Modal Tambah Skorsing -->
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
                <form action="{{ route('skorsing.tambah-bk') }}" method="POST" class="space-y-6">
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

    <!-- Modal Detail -->
    <div id="modalDetail" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
        <div class="max-w-2xl w-full bg-white/95 backdrop-blur-lg border border-white/20 shadow-2xl rounded-2xl overflow-hidden transform transition-all duration-300 scale-95 opacity-0"
            id="modalDetailContent">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-6">
                <h3 class="text-2xl font-bold text-white flex items-center gap-3">
                    <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    Detail Pelanggaran
                </h3>
                <p class="text-blue-100 mt-2">Informasi lengkap tentang pelanggaran siswa</p>
            </div>

            <!-- Modal Content -->
            <div class="p-8" id="detailContent">
                <!-- Content akan diisi via JavaScript -->
                <div class="flex items-center justify-center py-8">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="bg-gray-50/50 px-8 py-4 border-t border-gray-200">
                <div class="flex justify-end">
                    <button type="button" onclick="closeDetailModal()"
                        class="px-6 py-3 bg-gray-100 text-gray-600 rounded-xl hover:bg-gray-200 transition-all duration-200 font-medium">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="modalConfirmDelete" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
        <div class="max-w-md w-full bg-white/95 backdrop-blur-lg border border-white/20 shadow-2xl rounded-2xl overflow-hidden transform transition-all duration-300 scale-95 opacity-0"
            id="modalConfirmContent">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4">
                <h3 class="text-xl font-bold text-white flex items-center gap-3">
                    <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                    </div>
                    Konfirmasi Hapus
                </h3>
            </div>

            <!-- Modal Content -->
            <div class="p-6">
                <div class="text-center space-y-4">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900">Hapus Data Pelanggaran?</h4>
                        <p class="text-gray-600 mt-2" id="deleteMessage">
                            Apakah Anda yakin ingin menghapus data pelanggaran ini?
                        </p>
                        <p class="text-sm text-red-600 mt-2">
                            Tindakan ini tidak dapat dibatalkan.
                        </p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-center space-x-3 mt-6">
                    <button type="button" onclick="closeConfirmModal()"
                        class="px-6 py-3 bg-gray-100 text-gray-600 rounded-xl hover:bg-gray-200 transition-all duration-200 font-medium">
                        Batal
                    </button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk Modal -->
    <script>
        // Modal Tambah Skorsing
        function openModal() {
            const modal = document.getElementById('modalTambahSkorsing');
            const modalContent = document.getElementById('modalContent');
            const overlay = document.getElementById('modalOverlay');

            modal.classList.remove('hidden');
            overlay.classList.remove('hidden');

            setTimeout(() => {
                overlay.classList.remove('opacity-0');
                overlay.classList.add('opacity-100');
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);

            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            const modal = document.getElementById('modalTambahSkorsing');
            const modalContent = document.getElementById('modalContent');
            const overlay = document.getElementById('modalOverlay');

            overlay.classList.remove('opacity-100');
            overlay.classList.add('opacity-0');
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
                overlay.classList.add('hidden');

                const form = modal.querySelector('form');
                if (form) form.reset();

                document.body.style.overflow = '';
            }, 300);
        }

        // Modal Detail
        function openDetailModal(id) {
            const modal = document.getElementById('modalDetail');
            const modalContent = document.getElementById('modalDetailContent');
            const overlay = document.getElementById('modalOverlay');

            modal.classList.remove('hidden');
            overlay.classList.remove('hidden');

            setTimeout(() => {
                overlay.classList.remove('opacity-0');
                overlay.classList.add('opacity-100');
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);

            document.body.style.overflow = 'hidden';

            // Fetch detail data (you'll need to implement the route)
            fetch(`admin/skorsing/detail/${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('detailContent').innerHTML = `
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div class="bg-blue-50 rounded-xl p-4">
                                        <h4 class="font-semibold text-blue-800 mb-2">Informasi Siswa</h4>
                                        <div class="space-y-2">
                                            <div class="flex items-center gap-3">
                                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                                    <span class="text-lg font-semibold text-blue-600">
                                                        ${data.siswa.user.name.charAt(0)}
                                                    </span>
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-gray-900">${data.siswa.user.name}</p>
                                                    <p class="text-sm text-gray-600">NISN: ${data.siswa.nisn}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-red-50 rounded-xl p-4">
                                        <h4 class="font-semibold text-red-800 mb-2">Detail Pelanggaran</h4>
                                        <div class="space-y-2">
                                            <p class="text-sm text-gray-600">Jenis Pelanggaran:</p>
                                            <p class="font-medium text-gray-900">${data.pelanggaran.deskripsi}</p>
                                            <div class="flex items-center gap-2 mt-2">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold ${
                                                    data.pelanggaran.skor >= 50 ? 'bg-red-100 text-red-800' :
                                                    data.pelanggaran.skor >= 25 ? 'bg-yellow-100 text-yellow-800' :
                                                    'bg-green-100 text-green-800'
                                                }">
                                                    ${data.pelanggaran.skor} poin
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="space-y-4">
                                    <div class="bg-green-50 rounded-xl p-4">
                                        <h4 class="font-semibold text-green-800 mb-2">Informasi Waktu</h4>
                                        <div class="space-y-2">
                                            <div>
                                                <p class="text-sm text-gray-600">Tanggal Kejadian:</p>
                                                <p class="font-medium text-gray-900">${new Date(data.tanggal).toLocaleDateString('id-ID', {
                                                    weekday: 'long',
                                                    year: 'numeric',
                                                    month: 'long',
                                                    day: 'numeric'
                                                })}</p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-600">Dicatat pada:</p>
                                                <p class="font-medium text-gray-900">${new Date(data.created_at).toLocaleDateString('id-ID', {
                                                    year: 'numeric',
                                                    month: 'long',
                                                    day: 'numeric',
                                                    hour: '2-digit',
                                                    minute: '2-digit'
                                                })}</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    ${data.keterangan ? `
                                                            <div class="bg-yellow-50 rounded-xl p-4">
                                                                <h4 class="font-semibold text-yellow-800 mb-2">Keterangan</h4>
                                                                <p class="text-gray-700 text-sm leading-relaxed">${data.keterangan}</p>
                                                            </div>
                                                            ` : ''}
                                </div>
                            </div>
                        </div>
                    `;
                })
                .catch(error => {
                    document.getElementById('detailContent').innerHTML = `
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Gagal Memuat Data</h3>
                            <p class="text-gray-600">Terjadi kesalahan saat memuat detail pelanggaran.</p>
                        </div>
                    `;
                });
        }

        function closeDetailModal() {
            const modal = document.getElementById('modalDetail');
            const modalContent = document.getElementById('modalDetailContent');
            const overlay = document.getElementById('modalOverlay');

            overlay.classList.remove('opacity-100');
            overlay.classList.add('opacity-0');
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
                overlay.classList.add('hidden');
                document.body.style.overflow = '';
            }, 300);
        }

        // Modal Konfirmasi Hapus
        function confirmDelete(id, studentName) {
            const modal = document.getElementById('modalConfirmDelete');
            const modalContent = document.getElementById('modalConfirmContent');
            const overlay = document.getElementById('modalOverlay');
            const deleteForm = document.getElementById('deleteForm');
            const deleteMessage = document.getElementById('deleteMessage');

            // Set form action
            deleteForm.action = `admin/skorsing/hapus/${id}`;

            // Set message
            deleteMessage.textContent = `Apakah Anda yakin ingin menghapus data pelanggaran siswa "${studentName}"?`;

            modal.classList.remove('hidden');
            overlay.classList.remove('hidden');

            setTimeout(() => {
                overlay.classList.remove('opacity-0');
                overlay.classList.add('opacity-100');
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);

            document.body.style.overflow = 'hidden';
        }

        function closeConfirmModal() {
            const modal = document.getElementById('modalConfirmDelete');
            const modalContent = document.getElementById('modalConfirmContent');
            const overlay = document.getElementById('modalOverlay');

            overlay.classList.remove('opacity-100');
            overlay.classList.add('opacity-0');
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
                overlay.classList.add('hidden');
                document.body.style.overflow = '';
            }, 300);
        }

        // Close modal when clicking overlay
        document.getElementById('modalOverlay').addEventListener('click', function() {
            // Check which modal is open and close it
            if (!document.getElementById('modalTambahSkorsing').classList.contains('hidden')) {
                closeModal();
            } else if (!document.getElementById('modalDetail').classList.contains('hidden')) {
                closeDetailModal();
            } else if (!document.getElementById('modalConfirmDelete').classList.contains('hidden')) {
                closeConfirmModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                if (!document.getElementById('modalTambahSkorsing').classList.contains('hidden')) {
                    closeModal();
                } else if (!document.getElementById('modalDetail').classList.contains('hidden')) {
                    closeDetailModal();
                } else if (!document.getElementById('modalConfirmDelete').classList.contains('hidden')) {
                    closeConfirmModal();
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

        /* Action buttons hover effects */
        .group:hover .group-hover\:rotate-90 {
            transform: rotate(90deg);
        }

        /* Loading animation */
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .animate-spin {
            animation: spin 1s linear infinite;
        }
    </style>
@endsection
