@extends('components.admin')

@section('content')
    <!-- Tambahkan CSRF token untuk AJAX -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
                                <tr class="hover:bg-blue-50/50 transition-colors duration-200 group"
                                    data-id="{{ $item->id }}">
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

                <!-- Pagination Section tetap sama -->
                @if ($riwayat->total() > 0)
                    <div class="bg-gray-50/50 px-6 py-4 border-t border-gray-200">
                        <!-- Pagination content tetap sama seperti sebelumnya -->
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
                <form action="{{ route('skorsing.guru') }}" method="POST" class="space-y-6">
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
                            <select name="pelanggaran_id"
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


    <!-- JavaScript untuk Modal -->
    <script>
        // Modal Tambah Skorsing
        function openModal() {
            const modal = document.getElementById('modalTambahSkorsing');
            const modalContent = document.getElementById('modalContent');
            const overlay = document.getElementById('modalOverlay');

            console.log('Opening modal...'); // Debug

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

        // Modal Detail - Update fetch URL
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

            // Loading state
            document.getElementById('detailContent').innerHTML = `
                <div class="flex items-center justify-center py-8">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                    <span class="ml-3 text-gray-600">Memuat data...</span>
                </div>
            `;

            // Fetch detail data - Update URL to match route
            fetch(`/guru/skorsing/detail/${id}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    // Render detail content - same as before
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
                                                    ${(data.siswa?.user?.name || 'N').charAt(0).toUpperCase()}
                                                </span>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-900">${data.siswa?.user?.name || 'Nama tidak tersedia'}</p>
                                                <p class="text-sm text-gray-600">NISN: ${data.siswa?.nisn || 'Tidak tersedia'}</p>                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bg-red-50 rounded-xl p-4">
                                    <h4 class="font-semibold text-red-800 mb-2">Detail Pelanggaran</h4>
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-600">Jenis Pelanggaran:</p>
                                        <p class="font-medium text-gray-900">${data.pelanggaran?.deskripsi || 'Tidak tersedia'}</p>
                                        <div class="flex items-center gap-2 mt-2">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold ${
                                                (data.pelanggaran?.skor || 0) >= 50 ? 'bg-red-100 text-red-800' :
                                                (data.pelanggaran?.skor || 0) >= 25 ? 'bg-yellow-100 text-yellow-800' :
                                                'bg-green-100 text-green-800'
                                            }">
                                                ${data.pelanggaran?.skor || 0} poin
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
                                            <p class="font-medium text-gray-900">${formatDate(data.tanggal, 'full')}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">Dicatat pada:</p>
                                            <p class="font-medium text-gray-900">${formatDate(data.created_at, 'datetime')}</p>
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
                    console.error('Error fetching detail:', error);
                    document.getElementById('detailContent').innerHTML = `
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Gagal Memuat Data</h3>
                        <p class="text-gray-600">Terjadi kesalahan saat memuat detail pelanggaran.</p>
                        <button onclick="openDetailModal(${id})" 
                                class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            Coba Lagi
                        </button>
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

        // Modal Konfirmasi Hapus - Updated dengan AJAX
        function confirmDelete(id, studentName) {
            const modal = document.getElementById('modalConfirmDelete');
            const modalContent = document.getElementById('modalConfirmContent');
            const overlay = document.getElementById('modalOverlay');
            const deleteMessage = document.getElementById('deleteMessage');

            // Set message
            deleteMessage.textContent = `Apakah Anda yakin ingin menghapus data pelanggaran siswa "${studentName}"?`;

            // Show modal
            modal.classList.remove('hidden');
            overlay.classList.remove('hidden');

            setTimeout(() => {
                overlay.classList.remove('opacity-0');
                overlay.classList.add('opacity-100');
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);

            document.body.style.overflow = 'hidden';

            // Setup delete action
            setupDeleteAction(id);
        }

        function setupDeleteAction(id) {
            // Remove existing event listeners
            const deleteBtn = document.getElementById('confirmDeleteBtn');
            if (deleteBtn) {
                // Clone node to remove all event listeners
                const newDeleteBtn = deleteBtn.cloneNode(true);
                deleteBtn.parentNode.replaceChild(newDeleteBtn, deleteBtn);

                // Add new event listener
                newDeleteBtn.addEventListener('click', function() {
                    performDelete(id);
                });
            }
        }

        async function performDelete(id) {
            const deleteBtn = document.getElementById('confirmDeleteBtn');
            const originalText = deleteBtn.innerHTML;

            try {
                // Show loading state
                deleteBtn.disabled = true;
                deleteBtn.innerHTML = `
                    <div class="flex items-center justify-center gap-2">
                        <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>
                        <span>Menghapus...</span>
                    </div>
                `;

                // Get CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                if (!csrfToken) {
                    throw new Error('CSRF token tidak ditemukan');
                }

                // Perform delete request
                const response = await fetch(`guru/skorsing/hapus/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const result = await response.json();

                if (result.success) {
                    // Close modal
                    closeConfirmModal();

                    // Show success notification
                    showSuccessNotification(result.message);

                    // Remove row from table
                    removeTableRow(id);

                } else {
                    throw new Error(result.message || 'Gagal menghapus data');
                }

            } catch (error) {
                console.error('Error deleting:', error);
                showErrorNotification(error.message || 'Terjadi kesalahan saat menghapus data');

            } finally {
                // Restore button
                deleteBtn.disabled = false;
                deleteBtn.innerHTML = originalText;
            }
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

        // Remove row from table after successful delete
        function removeTableRow(id) {
            // Cari row berdasarkan data-id attribute
            const row = document.querySelector(`tr[data-id="${id}"]`);

            if (row) {
                // Add fade out animation
                row.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                row.style.opacity = '0';
                row.style.transform = 'translateX(-20px)';

                setTimeout(() => {
                    row.remove();

                    // Update row numbers
                    updateTableNumbers();

                    // Check if table is empty
                    checkEmptyTable();
                }, 300);
            } else {
                // If row selector not working, reload page after short delay
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            }
        }

        // Update table row numbers after deletion
        function updateTableNumbers() {
            const rows = document.querySelectorAll('tbody tr:not(.empty-row)');
            rows.forEach((row, index) => {
                const numberCell = row.querySelector(
                    'td:first-child .bg-gray-100, td:first-child .bg-gray-100.group-hover\\:bg-blue-100');
                if (numberCell) {
                    // Calculate correct number based on pagination
                    const currentPage = getCurrentPage();
                    const perPage = getPerPage();
                    const actualNumber = ((currentPage - 1) * perPage) + (index + 1);
                    numberCell.textContent = actualNumber;
                }
            });
        }

        // Check if table is empty and show empty state
        function checkEmptyTable() {
            const tbody = document.querySelector('tbody');
            const rows = tbody.querySelectorAll('tr:not(.empty-row)');

            if (rows.length === 0) {
                tbody.innerHTML = `
                    <tr class="empty-row">
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                `;
            }
        }

        // Helper functions
        function getCurrentPage() {
            const urlParams = new URLSearchParams(window.location.search);
            return parseInt(urlParams.get('page')) || 1;
        }

        function getPerPage() {
            // Default Laravel pagination per page
            return {{ $riwayat->perPage() }};
        }

        // Helper function untuk format tanggal
        function formatDate(dateString, format = 'full') {
            if (!dateString) return 'Tidak tersedia';

            try {
                const date = new Date(dateString);

                if (format === 'full') {
                    return date.toLocaleDateString('id-ID', {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                } else if (format === 'datetime') {
                    return date.toLocaleDateString('id-ID', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                }

                return date.toLocaleDateString('id-ID');
            } catch (error) {
                return 'Format tanggal tidak valid';
            }
        }

        // Success notification
        function showSuccessNotification(message) {
            showNotification('success', message);
        }

        // Error notification  
        function showErrorNotification(message) {
            showNotification('error', message);
        }

        // Generic notification function
        function showNotification(type, message) {
            // Remove existing notifications
            const existingNotifications = document.querySelectorAll('.notification-toast');
            existingNotifications.forEach(notification => notification.remove());

            // Create notification element
            const notification = document.createElement('div');
            notification.className = `notification-toast fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full max-w-sm ${
                type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
            }`;

            notification.innerHTML = `
                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            ${type === 'success' ? 
                                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />' :
                                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />'
                            }
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium">${message}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 ml-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            `;

            document.body.appendChild(notification);

            // Show animation
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);

            // Auto hide after 5 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.classList.add('translate-x-full');
                    setTimeout(() => {
                        if (notification.parentNode) {
                            notification.remove();
                        }
                    }, 300);
                }
            }, 5000);
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

        /* Notification animation */
        .notification-toast {
            transition: transform 0.3s ease-in-out;
        }
    </style>
@endsection
