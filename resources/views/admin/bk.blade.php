@extends('components.admin')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 p-4 sm:p-6 lg:p-8">
        <div class="max-w-7xl mx-auto space-y-8">

            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="space-y-2">
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                        Daftar Guru BK
                    </h1>
                    <p class="text-gray-600 text-lg">Kelola data guru dengan mudah dan efisien</p>
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
                    Tambah Guru BK
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

            <!-- Error Message -->
            @if (session('error'))
                <div
                    class="relative overflow-hidden bg-gradient-to-r from-red-50 to-pink-50 border border-red-200 rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-red-800 font-semibold text-lg">Error!</h3>
                            <p class="text-red-700">{{ session('error') }}</p>
                        </div>
                    </div>
                    <div class="absolute top-0 right-0 w-32 h-32 bg-red-200/30 rounded-full -translate-y-16 translate-x-16">
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
                                        d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-800">Data Guru BK</h2>
                                <p class="text-gray-600">Daftar lengkap guru sekolah</p>
                            </div>
                        </div>

                        <!-- Data Count Info -->
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <span>Total: {{ $gurus->total() }} data</span>
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
                                    Nama Guru</th>

                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    No HP</th>
                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($gurus as $item)
                                <tr class="hover:bg-blue-50/50 transition-colors duration-200 group"
                                    data-id="{{ $item->id }}" data-name="{{ $item->user->name ?? '-' }}"
                                    data-kelas="{{ $item->kelas->nama_kelas ?? '-' }}"
                                    data-email="{{ $item->user->email ?? '-' }}"
                                    data-no-hp="{{ $item->user->no_hp ?? '-' }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div
                                            class="w-8 h-8 bg-gray-100 group-hover:bg-blue-100 rounded-lg flex items-center justify-center text-sm font-semibold text-gray-600 transition-colors duration-200">
                                            {{ ($gurus->currentPage() - 1) * $gurus->perPage() + $loop->iteration }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-full flex items-center justify-center">
                                                <span class="text-sm font-semibold text-blue-600">
                                                    {{ substr($item->user->name ?? '-', 0, 1) }}
                                                </span>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900">
                                                    {{ $item->user->name ?? '-' }}</p>
                                                <p class="text-xs text-gray-500">Guru BK</p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $item->user->no_hp ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center justify-center gap-2">
                                            <!-- Tombol Detail -->
                                            <button onclick="showDetail(this)"
                                                class="group inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white px-3 py-2 rounded-lg text-xs font-medium hover:from-blue-600 hover:to-blue-700 transform hover:-translate-y-0.5 transition-all duration-200 shadow-sm hover:shadow-md">
                                                <svg class="w-4 h-4 group-hover:scale-110 transition-transform duration-200"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                Detail
                                            </button>

                                            <!-- Tombol Hapus -->
                                            <button
                                                onclick="confirmDelete({{ $item->id }}, '{{ $item->user->name ?? 'Guru' }}')"
                                                class="group inline-flex items-center gap-2 bg-gradient-to-r from-red-500 to-red-600 text-white px-3 py-2 rounded-lg text-xs font-medium hover:from-red-600 hover:to-red-700 transform hover:-translate-y-0.5 transition-all duration-200 shadow-sm hover:shadow-md">
                                                <svg class="w-4 h-4 group-hover:scale-110 transition-transform duration-200"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center gap-4">
                                            <div
                                                class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 14l9-5-9-5-9 5 9 5z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                                </svg>
                                            </div>
                                            <div class="text-center">
                                                <h3 class="text-lg font-semibold text-gray-900">Belum ada data</h3>
                                                <p class="text-gray-500">Belum ada Guru yang terdaftar</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Section -->
                @if ($gurus->total() > 0)
                    <div class="bg-gray-50/50 px-6 py-4 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                            <!-- Info Text -->
                            <div class="text-sm text-gray-600">
                                Menampilkan <span class="font-semibold text-gray-900">{{ $gurus->firstItem() }}</span>
                                sampai <span class="font-semibold text-gray-900">{{ $gurus->lastItem() }}</span>
                                dari <span class="font-semibold text-gray-900">{{ $gurus->total() }}</span> hasil
                            </div>

                            <!-- Pagination Links -->
                            <div class="flex items-center gap-2">
                                <!-- Previous Page Link -->
                                @if ($gurus->onFirstPage())
                                    <span
                                        class="px-3 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-200 rounded-lg cursor-not-allowed">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </span>
                                @else
                                    <a href="{{ $gurus->previousPageUrl() }}"
                                        class="px-3 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 hover:text-gray-800 transition-all duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </a>
                                @endif

                                <!-- Page Numbers -->
                                @foreach ($gurus->getUrlRange(1, $gurus->lastPage()) as $page => $url)
                                    @if ($page == $gurus->currentPage())
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
                                @if ($gurus->hasMorePages())
                                    <a href="{{ $gurus->nextPageUrl() }}"
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
                                        </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Tambah Guru -->
    <div id="addModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[95vh] flex flex-col transform transition-all duration-300 scale-95 opacity-0"
            id="addModalContent">
            <!-- Modal Header - Fixed -->
            <div class="bg-gradient-to-r from-green-600 to-emerald-600 text-white p-6 rounded-t-2xl flex-shrink-0">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">Tambah Guru Baru</h3>
                            <p class="text-green-100">Daftarkan Guru baru ke sistem</p>
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

            <!-- Modal Body - Scrollable -->
            <div class="flex-1 overflow-y-auto p-6">
                <form id="addGuruForm" action="{{ route('admin-bk.tambah') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Personal Information Section -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 pb-3 border-b border-gray-200">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900">Informasi Pribadi</h4>
                        </div>

                        <!-- Nama Lengkap -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                placeholder="Masukkan nama lengkap Guru">
                            <div class="text-red-500 text-sm mt-1 hidden" id="name-error"></div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="email" name="email" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                placeholder="contoh@email.com">
                            <div class="text-red-500 text-sm mt-1 hidden" id="email-error"></div>
                        </div>
                        <div>
                            <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-2">
                                No HP <span class="text-red-500">*</span>
                            </label>
                            <input type="no_hp" id="no_hp" name="no_hp" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                placeholder="08xxxxxxxx">
                            <div class="text-red-500 text-sm mt-1 hidden" id="no_hp-error"></div>
                        </div>
                    </div>

                    <!-- Security Information Section -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 pb-3 border-b border-gray-200">
                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900">Keamanan Akun</h4>
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" id="password" name="password" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 pr-12"
                                    placeholder="Minimal 6 karakter">
                                <button type="button" onclick="togglePassword('password')"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        id="password-icon">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="text-red-500 text-sm mt-1 hidden" id="password-error"></div>
                        </div>

                        <!-- Konfirmasi Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                Konfirmasi Password <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" id="password_confirmation" name="password_confirmation" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 pr-12"
                                    placeholder="Ulangi password">
                                <button type="button" onclick="togglePassword('password_confirmation')"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        id="password_confirmation-icon">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="text-red-500 text-sm mt-1 hidden" id="password_confirmation-error"></div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex gap-3 pt-6 border-t border-gray-200">
                        <button type="button" onclick="closeAddModal()"
                            class="flex-1 px-6 py-3 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200 font-medium">
                            Batal
                        </button>
                        <button type="submit"
                            class="flex-1 px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg hover:from-green-700 hover:to-emerald-700 transition-all duration-200 font-medium shadow-lg hover:shadow-xl">
                            <span class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Tambah Guru
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Detail Guru -->
    <div id="detailModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[95vh] flex flex-col transform transition-all duration-300 scale-95 opacity-0"
            id="detailModalContent">
            <!-- Modal Header - Fixed -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-6 rounded-t-2xl flex-shrink-0">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">Detail Guru</h3>
                            <p class="text-blue-100">Informasi lengkap data Guru</p>
                        </div>
                    </div>
                    <button onclick="closeDetailModal()"
                        class="text-white hover:bg-white/20 rounded-lg p-2 transition-colors duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Body - Scrollable -->
            <div class="flex-1 overflow-y-auto p-6" id="detailContent">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all duration-300 scale-95 opacity-0"
            id="deleteModalContent">
            <div class="p-6">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Konfirmasi Hapus</h3>
                        <p class="text-gray-600">Apakah Anda yakin ingin menghapus data Guru ini?</p>
                    </div>
                </div>

                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.98-.833-2.75 0L4.064 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                        <div>
                            <p class="text-yellow-800 font-medium">Peringatan!</p>
                            <p class="text-yellow-700 text-sm">Data yang dihapus tidak dapat dikembalikan.</p>
                            <p class="font-semibold text-yellow-900 mt-2" id="deleteItemName">-</p>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 justify-end">
                    <button onclick="closeDeleteModal()"
                        class="px-4 py-2 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                        Batal
                    </button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200">
                            Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom scrollbar for detail modal only */
        #detailContent::-webkit-scrollbar {
            width: 6px;
        }

        #detailContent::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }

        #detailContent::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        #detailContent::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Custom scrollbar for table */
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

        /* Modal animation */
        #detailModal.show,
        #deleteModal.show,
        #addModal.show {
            display: flex !important;
        }

        #detailModal.show #detailModalContent,
        #deleteModal.show #deleteModalContent,
        #addModal.show #addModalContent {
            transform: scale(1);
            opacity: 1;
        }
    </style>

    <script>
        function confirmDelete(id, name) {
            currentDeleteId = id;
            document.getElementById('deleteItemName').textContent = name;
            document.getElementById('deleteForm').action = `/admin/gurubk/${id}`;
            document.getElementById('deleteModal').classList.add('show');
        }
        let currentDeleteId = null;

        // Function untuk membuka modal detail dengan data dari tabel
        function showDetail(button) {
            const row = button.closest('tr');
            const data = {
                id: row.dataset.id,
                name: row.dataset.name,
                email: row.dataset.email,
                telepon: row.dataset.telepon,
            };

            // Format tanggal lahir
            let formattedDate = '-';
            if (data.tanggalLahir && data.tanggalLahir !== '-') {
                try {
                    const date = new Date(data.tanggalLahir);
                    formattedDate = date.toLocaleDateString('id-ID', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                } catch (e) {
                    formattedDate = data.tanggalLahir;
                }
            }

            // Tentukan warna skor
            const score = parseInt(data.score) || 0;
            let scoreColor = 'text-green-600 bg-green-100';
            if (score >= 80) scoreColor = 'text-red-600 bg-red-100';
            else if (score >= 50) scoreColor = 'text-yellow-600 bg-yellow-100';

            const detailContent = `
                <div class="space-y-6">
                    <!-- Profile Section -->
                    <div class="flex items-center gap-6 p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-200">
                        <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center">
                            <span class="text-2xl font-bold text-white">${data.name.charAt(0).toUpperCase()}</span>
                        </div>
                        <div>
                            <h4 class="text-2xl font-bold text-gray-900">${data.name}</h4>                            
                        </div>                        
                    </div>

                    <!-- Information Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Personal Information -->
                        <div class="space-y-4">
                            <h5 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">Informasi Pribadi</h5>
                            
                            <div class="bg-gray-50 rounded-lg p-4">
                                <label class="text-sm font-medium text-gray-500">Nama Lengkap</label>
                                <p class="text-gray-900 font-semibold mt-1">${data.name}</p>
                            </div>                                                                                                    
                        </div>

                        <!-- Contact & Academic Information -->
                        <div class="space-y-4">
                            <h5 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">Kontak & Akademik</h5>
                            
                            <div class="bg-gray-50 rounded-lg p-4">
                                <label class="text-sm font-medium text-gray-500">Email</label>
                                <p class="text-gray-900 font-semibold mt-1">${data.email}</p>
                            </div>                                                                                
                        </div>
                    </div>

                    

                    
                </div>
            `;

            document.getElementById('detailContent').innerHTML = detailContent;
            document.getElementById('detailModal').classList.add('show');
        }

        // Function untuk menutup modal detail
        function closeDetailModal() {
            document.getElementById('detailModal').classList.remove('show');
        }

        // Function untuk konfirmasi hapus
        function confirmDelete(id, name) {
            currentDeleteId = id;
            document.getElementById('deleteItemName').textContent = name;
            document.getElementById('deleteForm').action = `/admin/guru/${id}`;
            document.getElementById('deleteModal').classList.add('show');
        }

        // Function untuk menutup modal hapus
        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('show');
            currentDeleteId = null;
        }

        // Function untuk membuka modal tambah Guru
        function openModal() {
            // Reset form
            document.getElementById('addGuruForm').reset();

            // Hide all error messages
            const errorElements = document.querySelectorAll('[id$="-error"]');
            errorElements.forEach(el => el.classList.add('hidden'));

            // Reset input borders
            const inputs = document.querySelectorAll('#addModal input, #addModal select');
            inputs.forEach(input => {
                input.classList.remove('border-red-500');
                input.classList.add('border-gray-300');
            });

            document.getElementById('addModal').classList.add('show');
        }

        // Function untuk menutup modal tambah Guru
        function closeAddModal() {
            document.getElementById('addModal').classList.remove('show');
        }

        // Function untuk toggle password visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + '-icon');

            if (field.type === 'password') {
                field.type = 'text';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                `;
            } else {
                field.type = 'password';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                `;
            }
        }

        // Form validation
        document.getElementById('addGuruForm').addEventListener('submit', function(e) {
            let isValid = true;

            // Clear previous errors
            const errorElements = document.querySelectorAll('[id$="-error"]');
            errorElements.forEach(el => el.classList.add('hidden'));

            const inputs = document.querySelectorAll('#addModal input, #addModal select');
            inputs.forEach(input => {
                input.classList.remove('border-red-500');
                input.classList.add('border-gray-300');
            });

            // Validate required fields
            const requiredFields = ['name', 'email', 'nisn', 'kelas_id', 'password', 'password_confirmation'];

            requiredFields.forEach(fieldName => {
                const field = document.getElementById(fieldName);
                const errorEl = document.getElementById(fieldName + '-error');

                if (!field.value.trim()) {
                    showError(field, errorEl, 'Field ini wajib diisi');
                    isValid = false;
                }
            });

            // Validate email format
            const email = document.getElementById('email');
            const emailError = document.getElementById('email-error');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (email.value && !emailRegex.test(email.value)) {
                showError(email, emailError, 'Format email tidak valid');
                isValid = false;
            }

            // Validate password length
            const password = document.getElementById('password');
            const passwordError = document.getElementById('password-error');

            if (password.value && password.value.length < 6) {
                showError(password, passwordError, 'Password minimal 6 karakter');
                isValid = false;
            }

            // Validate password confirmation
            const passwordConfirmation = document.getElementById('password_confirmation');
            const passwordConfirmationError = document.getElementById('password_confirmation-error');

            if (password.value !== passwordConfirmation.value) {
                showError(passwordConfirmation, passwordConfirmationError, 'Konfirmasi password tidak sesuai');
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
        document.getElementById('detailModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDetailModal();
            }
        });

        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        document.getElementById('addModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAddModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDetailModal();
                closeDeleteModal();
                closeAddModal();
            }
        });
    </script>
@endsection
