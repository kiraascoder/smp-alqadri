@extends('components.admin')

@section('title', 'Dashboard Admin SMP')
@section('page_title', 'Dashboard Admin SMP')

@section('content')
    <!-- Welcome Section -->
    <div class="bg-white shadow rounded-lg p-4 sm:p-6 mb-6 mt-6">
        <h2 class="text-xl sm:text-2xl font-semibold mb-4">Selamat Datang, {{ Auth::user()->name }} 👋</h2>
        <p class="text-gray-600">Selamat datang di dashboard admin SMP. Kelola data guru, siswa, guru BK, dan riwayat
            pelanggaran siswa dengan mudah.</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
        <!-- Total Guru -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-lg p-4 sm:p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Guru</p>
                    <p class="text-2xl sm:text-3xl font-bold">{{ $guruCount ?? 45 }}</p>
                </div>
                <div class="bg-blue-400 bg-opacity-30 rounded-full p-2 sm:p-3">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Siswa -->
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg shadow-lg p-4 sm:p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Total Siswa</p>
                    <p class="text-2xl sm:text-3xl font-bold">{{ $siswaCount ?? 680 }}</p>
                </div>
                <div class="bg-green-400 bg-opacity-30 rounded-full p-2 sm:p-3">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Guru BK -->
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg shadow-lg p-4 sm:p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Guru BK</p>
                    <p class="text-2xl sm:text-3xl font-bold">{{ $guruBkCount ?? 5 }}</p>
                </div>
                <div class="bg-purple-400 bg-opacity-30 rounded-full p-2 sm:p-3">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Pelanggaran -->
        <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-lg shadow-lg p-4 sm:p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium">Pelanggaran Bulan Ini</p>
                    <p class="text-2xl sm:text-3xl font-bold">{{ $pelanggaranCount ?? 12 }}</p>
                </div>
                <div class="bg-red-400 bg-opacity-30 rounded-full p-2 sm:p-3">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Violations Table -->
    <div class="bg-white shadow rounded-lg p-4 sm:p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Pelanggaran Terbaru</h3>
            <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Siswa</th>
                        <th class="px-3 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Pelanggaran</th>
                        <th class="px-3 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($riwayat as $item)
                        <tr>
                            <td class="px-3 sm:px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $item->siswa->user->name ?? '-' }}
                            </td>
                            <td class="px-3 sm:px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $item->pelanggaran->deskripsi ?? '-' }}
                            </td>
                            <td class="px-3 sm:px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
