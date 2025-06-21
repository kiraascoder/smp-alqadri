@extends('components.admin')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 p-6">
        <div class="max-w-7xl mx-auto space-y-8">
            {{-- Header Section --}}
            <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-200">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div class="flex items-center gap-4">
                        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-3 rounded-xl">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Daftar Konseling</h1>
                            <p class="text-gray-600 mt-1">Kelola jadwal konseling siswa dengan mudah</p>
                        </div>
                    </div>
                    <button onclick="bukaModalTambah()"
                        class="group bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold px-6 py-3 rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Jadwalkan Konseling
                    </button>
                </div>
            </div>

            {{-- Success Message --}}
            @if (session('success'))
                <div
                    class="bg-gradient-to-r from-green-500 to-emerald-500 text-white p-4 rounded-xl shadow-lg border-l-4 border-green-600 animate-fade-in">
                    <div class="flex items-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            {{-- Error Messages --}}
            @if ($errors->any())
                <div class="bg-red-100 border border-red-300 text-red-800 p-4 rounded-xl shadow-sm">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <strong>Terjadi kesalahan:</strong>
                            <ul class="list-disc list-inside text-sm mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Statistics Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div
                    class="bg-white rounded-xl shadow-lg p-6 border border-gray-200 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Total Konseling</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $konselings->count() }}</p>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-xl">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-xl shadow-lg p-6 border border-gray-200 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Selesai</p>
                            <p class="text-3xl font-bold text-green-600 mt-2">
                                {{ $konselings->where('status', 'selesai')->count() }}</p>
                        </div>
                        <div class="bg-green-100 p-3 rounded-xl">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-xl shadow-lg p-6 border border-gray-200 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Dijadwalkan</p>
                            <p class="text-3xl font-bold text-yellow-600 mt-2">
                                {{ $konselings->where('status', 'dijadwalkan')->count() }}</p>
                        </div>
                        <div class="bg-yellow-100 p-3 rounded-xl">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Table Section --}}
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">Data Konseling</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gradient-to-r from-gray-100 to-gray-200">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Siswa</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Kelas</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Tanggal</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Waktu</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Tempat</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($konselings as $konseling)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="bg-gradient-to-r from-purple-500 to-pink-500 w-10 h-10 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                                {{ strtoupper(substr($konseling->siswa->name ?? 'N', 0, 2)) }}
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">
                                                    {{ $konseling->siswa->name ?? '-' }}</p>
                                                <p class="text-sm text-gray-500">{{ $konseling->siswa->email ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-2m-2 0H7m5 0v-5a2 2 0 00-2-2h-2a2 2 0 00-2 2v5m6-10a2 2 0 002-2V7a2 2 0 00-2-2H9a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2z">
                                                </path>
                                            </svg>
                                            <span class="text-sm font-medium text-gray-900">
                                                {{ $konseling->siswa->siswaProfile->kelas->nama_kelas ?? 'Tidak ada kelas' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            {{ \Carbon\Carbon::parse($konseling->tanggal)->format('d M Y') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">
                                                </path>
                                            </svg>
                                            {{ $konseling->waktu }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $konseling->tempat }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form method="POST"
                                            action="{{ route('guru.konseling.update-status', $konseling->id) }}"
                                            onchange="this.submit()" class="inline-block">
                                            @csrf
                                            @method('PUT')
                                            <select name="status"
                                                class="text-xs font-medium border-0 rounded-full px-3 py-1 focus:ring-2 focus:ring-blue-500
                                                {{ $konseling->status == 'selesai'
                                                    ? 'bg-green-100 text-green-800'
                                                    : ($konseling->status == 'dijadwalkan'
                                                        ? 'bg-yellow-100 text-yellow-800'
                                                        : ($konseling->status == 'batal'
                                                            ? 'bg-red-100 text-red-800'
                                                            : 'bg-gray-100 text-gray-800')) }}">
                                                <option value="dijadwalkan"
                                                    {{ $konseling->status == 'dijadwalkan' ? 'selected' : '' }}>
                                                    📅 Dijadwalkan
                                                </option>
                                                <option value="selesai"
                                                    {{ $konseling->status == 'selesai' ? 'selected' : '' }}>
                                                    ✅ Selesai
                                                </option>
                                                <option value="batal"
                                                    {{ $konseling->status == 'batal' ? 'selected' : '' }}>
                                                    ❌ Batal
                                                </option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center gap-2">
                                            <button onclick="bukaModal('modalDetail{{ $konseling->id }}')"
                                                class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                                Detail
                                            </button>

                                            @if ($konseling->status !== 'selesai')
                                                <button onclick="bukaModal('modalEdit{{ $konseling->id }}')"
                                                    class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors duration-200">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                        </path>
                                                    </svg>
                                                    Edit
                                                </button>
                                            @endif

                                            @if ($konseling->status === 'dijadwalkan')
                                                <button onclick="bukaModal('modalHapus{{ $konseling->id }}')"
                                                    class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors duration-200">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                    Hapus
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                {{-- Modal Detail --}}
                                <div id="modalDetail{{ $konseling->id }}"
                                    class="fixed inset-0 z-50 hidden bg-black/20 backdrop-blur-sm flex items-center justify-center p-4">
                                    <div class="bg-white max-w-2xl w-full rounded-2xl shadow-2xl border border-gray-200 max-h-[90vh] overflow-y-auto animate-scale-in"
                                        onclick="event.stopPropagation()">
                                        <div
                                            class="bg-gradient-to-r from-blue-600 to-indigo-600 p-6 text-white rounded-t-2xl">
                                            <div class="flex items-center justify-between">
                                                <h3 class="text-xl font-bold flex items-center gap-3">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                        </path>
                                                    </svg>
                                                    Detail Konseling
                                                </h3>
                                                <button onclick="tutupModal('modalDetail{{ $konseling->id }}')"
                                                    class="text-white/80 hover:text-white hover:bg-white/20 rounded-full p-2 transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="p-6">
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                                                <div class="space-y-4">
                                                    <div class="bg-gray-50 p-4 rounded-xl">
                                                        <label
                                                            class="block text-gray-500 font-medium mb-2 uppercase text-xs">Siswa</label>
                                                        <div class="flex items-center gap-3">
                                                            <div
                                                                class="bg-gradient-to-r from-purple-500 to-pink-500 w-10 h-10 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                                                {{ strtoupper(substr($konseling->siswa->name ?? 'N', 0, 2)) }}
                                                            </div>
                                                            <div>
                                                                <p class="text-gray-900 font-semibold">
                                                                    {{ $konseling->siswa->name ?? '-' }}
                                                                </p>
                                                                <p class="text-gray-500 text-xs">
                                                                    {{ $konseling->siswa->email ?? '-' }}
                                                                </p>
                                                                @if ($konseling->siswa->siswaProfile && $konseling->siswa->siswaProfile->nisn)
                                                                    <p class="text-gray-500 text-xs">
                                                                        NISN: {{ $konseling->siswa->siswaProfile->nisn }}
                                                                    </p>
                                                                @endif

                                                                <p class="text-blue-600 text-xs font-medium">
                                                                    <svg class="w-3 h-3 inline mr-1" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-2m-2 0H7m5 0v-5a2 2 0 00-2-2h-2a2 2 0 00-2 2v5m6-10a2 2 0 002-2V7a2 2 0 00-2-2H9a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2z">
                                                                        </path>
                                                                    </svg>
                                                                    Kelas:
                                                                    {{ $konseling->siswa->siswaProfile->kelas->nama_kelas ?? 'Tidak ada kelas' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="bg-gray-50 p-4 rounded-xl">
                                                        <label
                                                            class="block text-gray-500 font-medium mb-1 uppercase text-xs">Tanggal</label>
                                                        <p class="text-gray-900 font-semibold flex items-center gap-2">
                                                            <svg class="w-4 h-4 text-gray-500" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                                </path>
                                                            </svg>
                                                            {{ \Carbon\Carbon::parse($konseling->tanggal)->format('d F Y') }}
                                                        </p>
                                                    </div>

                                                    <div class="bg-gray-50 p-4 rounded-xl">
                                                        <label
                                                            class="block text-gray-500 font-medium mb-1 uppercase text-xs">Waktu</label>
                                                        <p class="text-gray-900 font-semibold flex items-center gap-2">
                                                            <svg class="w-4 h-4 text-gray-500" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">
                                                                </path>
                                                            </svg>
                                                            {{ $konseling->waktu }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="space-y-4">
                                                    <div class="bg-gray-50 p-4 rounded-xl">
                                                        <label
                                                            class="block text-gray-500 font-medium mb-1 uppercase text-xs">Tempat</label>
                                                        <p class="text-gray-900 font-semibold flex items-center gap-2">
                                                            <svg class="w-4 h-4 text-gray-500" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                                </path>
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z">
                                                                </path>
                                                            </svg>
                                                            {{ $konseling->tempat }}
                                                        </p>
                                                    </div>

                                                    <div class="bg-gray-50 p-4 rounded-xl">
                                                        <label
                                                            class="block text-gray-500 font-medium mb-1 uppercase text-xs">Status</label>
                                                        <span
                                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                                            {{ $konseling->status == 'selesai'
                                                                ? 'bg-green-100 text-green-800'
                                                                : ($konseling->status == 'dijadwalkan'
                                                                    ? 'bg-yellow-100 text-yellow-800'
                                                                    : 'bg-red-100 text-red-800') }}">
                                                            @if ($konseling->status == 'selesai')
                                                                ✅ Selesai
                                                            @elseif($konseling->status == 'dijadwalkan')
                                                                📅 Dijadwalkan
                                                            @else
                                                                ❌ {{ ucfirst($konseling->status) }}
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="md:col-span-2 space-y-4">
                                                    <div class="bg-gray-50 p-4 rounded-xl">
                                                        <label
                                                            class="block text-gray-500 font-medium mb-2 uppercase text-xs">Topik
                                                            Konseling</label>
                                                        <p class="text-gray-900 leading-relaxed">
                                                            {{ $konseling->topik ?? 'Tidak ada topik yang ditentukan.' }}
                                                        </p>
                                                    </div>

                                                    @if ($konseling->catatan)
                                                        <div class="bg-blue-50 border border-blue-200 p-4 rounded-xl">
                                                            <label
                                                                class="block text-blue-700 font-medium mb-2 uppercase text-xs">Catatan
                                                                Konseling</label>
                                                            <p class="text-blue-900 leading-relaxed">
                                                                {{ $konseling->catatan }}</p>
                                                        </div>
                                                    @endif

                                                    @if ($konseling->alasan_batal)
                                                        <div class="bg-red-50 border border-red-200 p-4 rounded-xl">
                                                            <label
                                                                class="block text-red-700 font-medium mb-2 uppercase text-xs">Alasan
                                                                Pembatalan</label>
                                                            <p class="text-red-900 leading-relaxed">
                                                                {{ $konseling->alasan_batal }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="flex justify-end mt-8 pt-6 border-t border-gray-200">
                                                <button onclick="tutupModal('modalDetail{{ $konseling->id }}')"
                                                    class="bg-gray-200 hover:bg-gray-300 px-6 py-2 rounded-xl font-medium transition-colors duration-200">
                                                    Tutup
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Modal Edit Status --}}
                                @if ($konseling->status !== 'selesai')
                                    <div id="modalEdit{{ $konseling->id }}"
                                        class="fixed inset-0 z-50 hidden bg-black/20 backdrop-blur-sm flex items-center justify-center p-4">
                                        <div class="bg-white max-w-md w-full rounded-2xl shadow-2xl border border-gray-200 max-h-[90vh] overflow-y-auto animate-scale-in"
                                            onclick="event.stopPropagation()">
                                            <div
                                                class="bg-gradient-to-r from-green-600 to-emerald-600 p-6 text-white rounded-t-2xl">
                                                <div class="flex items-center justify-between">
                                                    <h3 class="text-xl font-bold flex items-center gap-3">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                            </path>
                                                        </svg>
                                                        Update Status
                                                    </h3>
                                                    <button onclick="tutupModal('modalEdit{{ $konseling->id }}')"
                                                        class="text-white/80 hover:text-white hover:bg-white/20 rounded-full p-2 transition-colors">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="p-6">
                                                <form method="POST"
                                                    action="{{ route('guru.konseling.update-status', $konseling->id) }}"
                                                    class="space-y-6">
                                                    @csrf
                                                    @method('PUT')

                                                    <div>
                                                        <label class="block text-gray-700 font-semibold mb-3">Status
                                                            Konseling</label>
                                                        <div class="space-y-3">
                                                            <label
                                                                class="flex items-center p-3 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer">
                                                                <input type="radio" name="status" value="dijadwalkan"
                                                                    {{ $konseling->status == 'dijadwalkan' ? 'checked' : '' }}
                                                                    class="text-yellow-600 focus:ring-yellow-500">
                                                                <span class="ml-3 flex items-center gap-2">
                                                                    <span class="text-xl">📅</span>
                                                                    <span class="font-medium">Dijadwalkan</span>
                                                                </span>
                                                            </label>

                                                            <label
                                                                class="flex items-center p-3 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer">
                                                                <input type="radio" name="status" value="selesai"
                                                                    {{ $konseling->status == 'selesai' ? 'checked' : '' }}
                                                                    class="text-green-600 focus:ring-green-500">
                                                                <span class="ml-3 flex items-center gap-2">
                                                                    <span class="text-xl">✅</span>
                                                                    <span class="font-medium">Selesai</span>
                                                                </span>
                                                            </label>

                                                            <label
                                                                class="flex items-center p-3 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer">
                                                                <input type="radio" name="status" value="batal"
                                                                    {{ $konseling->status == 'batal' ? 'checked' : '' }}
                                                                    class="text-red-600 focus:ring-red-500">
                                                                <span class="ml-3 flex items-center gap-2">
                                                                    <span class="text-xl">❌</span>
                                                                    <span class="font-medium">Batal</span>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <label class="block text-gray-700 font-semibold mb-2">Catatan
                                                            (Opsional)
                                                        </label>
                                                        <textarea name="catatan" rows="3" placeholder="Tambahkan catatan tentang konseling ini..."
                                                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 resize-none">{{ $konseling->catatan }}</textarea>
                                                    </div>

                                                    <div id="alasanBatal{{ $konseling->id }}"
                                                        style="display: {{ $konseling->status == 'batal' ? 'block' : 'none' }};">
                                                        <label class="block text-gray-700 font-semibold mb-2">Alasan
                                                            Pembatalan <span class="text-red-500">*</span></label>
                                                        <textarea name="alasan_batal" rows="3" placeholder="Jelaskan alasan pembatalan konseling..."
                                                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 resize-none">{{ $konseling->alasan_batal }}</textarea>
                                                    </div>

                                                    <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
                                                        <button type="button"
                                                            onclick="tutupModal('modalEdit{{ $konseling->id }}')"
                                                            class="bg-gray-200 hover:bg-gray-300 px-6 py-2 rounded-xl font-medium transition-colors duration-200">
                                                            Batal
                                                        </button>
                                                        <button type="submit"
                                                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-xl font-medium transition-colors duration-200">
                                                            Update Status
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                {{-- Modal Hapus --}}
                                @if ($konseling->status === 'dijadwalkan')
                                    <div id="modalHapus{{ $konseling->id }}"
                                        class="fixed inset-0 z-50 hidden bg-black/20 backdrop-blur-sm flex items-center justify-center p-4">
                                        <div class="bg-white max-w-md w-full rounded-2xl shadow-2xl border border-gray-200 animate-scale-in"
                                            onclick="event.stopPropagation()">
                                            <div class="p-6">
                                                <div class="text-center">
                                                    <div
                                                        class="bg-red-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                                        <svg class="w-8 h-8 text-red-600" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Konfirmasi Hapus
                                                    </h3>
                                                    <p class="text-gray-600 mb-6">
                                                        Yakin ingin menghapus konseling dengan siswa
                                                        <strong
                                                            class="text-gray-900">{{ $konseling->siswa->name ?? '-' }}</strong>
                                                        pada tanggal <strong
                                                            class="text-gray-900">{{ \Carbon\Carbon::parse($konseling->tanggal)->format('d F Y') }}</strong>?
                                                        <br><span class="text-red-500 text-sm">Tindakan ini tidak dapat
                                                            batal.</span>
                                                    </p>
                                                </div>

                                                <div class="flex justify-center gap-4">
                                                    <button onclick="tutupModal('modalHapus{{ $konseling->id }}')"
                                                        class="bg-gray-200 hover:bg-gray-300 px-6 py-2 rounded-xl font-medium transition-colors duration-200">
                                                        Batal
                                                    </button>
                                                    <form method="POST"
                                                        action="{{ route('konseling-Bkhapus', $konseling->id) }}"
                                                        class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button
                                                            class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-xl font-medium transition-colors duration-200">
                                                            Hapus Konseling
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-400 mb-4" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                            <p class="text-gray-500 text-lg font-medium">Belum ada data konseling</p>
                                            <p class="text-gray-400 text-sm">Klik tombol "Jadwalkan Konseling" untuk
                                                menambah data</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Modal Tambah --}}
        <div id="modalTambah"
            class="fixed inset-0 z-50 hidden bg-black/20 backdrop-blur-sm flex items-center justify-center p-4 animate-fade-in">
            <div class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl border border-gray-200 max-h-[90vh] overflow-y-auto animate-scale-in"
                onclick="event.stopPropagation()">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-6 text-white rounded-t-2xl">
                    <h3 class="text-xl font-bold flex items-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Jadwalkan Konseling Baru
                    </h3>
                    <p class="text-blue-100 text-sm mt-1">Isi form berikut untuk menjadwalkan konseling dengan siswa</p>
                </div>

                <div class="p-6">
                    <form method="POST" action="{{ route('konseling-Bktambah') }}" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Pilih Siswa -->
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 font-semibold mb-2">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                    Pilih Siswa <span class="text-red-500">*</span>
                                </label>
                                <select name="user_id" required
                                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                    <option value="">-- Pilih Siswa --</option>
                                    @foreach ($siswas as $siswa)
                                        <option value="{{ $siswa->id }}"
                                            {{ old('user_id') == $siswa->id ? 'selected' : '' }}>
                                            {{ $siswa->name }} - {{ $siswa->email }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tanggal -->
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    Tanggal <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal" required value="{{ old('tanggal') }}"
                                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                @error('tanggal')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Waktu -->
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                    Waktu <span class="text-red-500">*</span>
                                </label>
                                <input type="time" name="waktu" required value="{{ old('waktu') }}"
                                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                @error('waktu')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tempat -->
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 font-semibold mb-2">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Tempat <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="tempat" value="{{ old('tempat', 'Ruang BK') }}" required
                                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                    placeholder="Contoh: Ruang BK, Ruang Kelas, dll.">
                                @error('tempat')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Topik -->
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 font-semibold mb-2">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                                        </path>
                                    </svg>
                                    Topik Konseling
                                </label>
                                <textarea name="topik" rows="4"
                                    placeholder="Masukkan topik konseling yang akan dibahas, misalnya: masalah akademik, sosial, emosional, dll."
                                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-none">{{ old('topik') }}</textarea>
                                @error('topik')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Info Box -->
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                                <div class="text-sm text-blue-800">
                                    <p class="font-medium mb-1">Informasi:</p>
                                    <ul class="list-disc list-inside space-y-1">
                                        <li>Konseling akan dijadwalkan dengan status "dijadwalkan"</li>
                                        <li>Siswa akan menerima notifikasi tentang jadwal konseling</li>
                                        <li>Pastikan waktu dan tempat tidak bertabrakan dengan jadwal lain</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
                            <button type="button" onclick="tutupModalTambah()"
                                class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-xl transition-all duration-200 transform hover:scale-105">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl transition-all duration-200 transform hover:scale-105 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Jadwalkan Konseling
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom CSS -->
    <style>
        .animate-fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

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

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>

    <!-- JavaScript -->
    <script>
        // Fungsi untuk membuka modal
        function bukaModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        // Fungsi untuk menutup modal
        function tutupModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function bukaModalTambah() {
            const modal = document.getElementById('modalTambah');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Set minimum date to today
            const today = new Date().toISOString().split('T')[0];
            const dateInput = document.querySelector('input[name="tanggal"]');
            if (dateInput) {
                dateInput.setAttribute('min', today);
            }
        }

        function tutupModalTambah() {
            const modal = document.getElementById('modalTambah');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';

            // Reset form if no errors
            @if (!$errors->any())
                const form = modal.querySelector('form');
                if (form) {
                    form.reset();
                }
            @endif
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(e) {
            // Close modal tambah
            const modalTambah = document.getElementById('modalTambah');
            if (e.target === modalTambah) {
                tutupModalTambah();
            }

            // Close other modals
            const modals = document.querySelectorAll('[id^="modal"]:not(#modalTambah)');
            modals.forEach(modal => {
                if (e.target === modal) {
                    tutupModal(modal.id);
                }
            });
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                // Close any open modal
                const openModals = document.querySelectorAll('[id^="modal"]:not(.hidden)');
                openModals.forEach(modal => {
                    if (modal.id === 'modalTambah') {
                        tutupModalTambah();
                    } else {
                        tutupModal(modal.id);
                    }
                });
            }
        });

        // Initialize and handle radio button changes
        document.addEventListener('DOMContentLoaded', function() {
            // Auto open modal if there are validation errors
            @if ($errors->any())
                bukaModalTambah();
            @endif

            // Handle radio button changes for status update modals
            document.querySelectorAll('input[name="status"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    const modal = this.closest('[id^="modalEdit"]');
                    const alasanDiv = modal.querySelector('[id^="alasanBatal"]');

                    if (this.value === 'batal') {
                        alasanDiv.style.display = 'block';
                        alasanDiv.querySelector('textarea').required = true;
                    } else {
                        alasanDiv.style.display = 'none';
                        alasanDiv.querySelector('textarea').required = false;
                    }
                });
            });
        });
    </script>
@endsection
