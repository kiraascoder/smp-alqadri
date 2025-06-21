@extends('components.admin')

@section('content')
    <div x-data="{
        showDetail: false,
        selectedSiswa: null,
        searchTerm: '',
        showFilters: false,
        siswas: @js($siswas->toArray()),
        openDetail(siswaId) {
            this.selectedSiswa = siswaId;
            this.showDetail = true;
        },
        closeDetail() {
            this.showDetail = false;
            this.selectedSiswa = null;
        },
        getSelectedSiswa() {
            return this.siswas.find(siswa => siswa.id === this.selectedSiswa);
        }
    }" class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 p-4 md:p-6">
        <div class="max-w-7xl mx-auto space-y-6">

            {{-- Header Section --}}
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-3xl opacity-10"></div>
                <div class="relative bg-white/80 backdrop-blur-sm rounded-3xl p-8 shadow-xl border border-white/50">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                        <div class="space-y-2">
                            <h1
                                class="text-4xl md:text-5xl font-black bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                                👥 Daftar Siswa
                            </h1>
                            <p class="text-gray-600 text-lg">Kelola data siswa dengan mudah dan efisien</p>
                        </div>

                        {{-- Search and Filter --}}
                        <div class="flex flex-col sm:flex-row gap-3">
                            <div class="relative">
                                <input x-model="searchTerm" type="text" placeholder="Cari siswa..."
                                    class="w-full sm:w-64 pl-12 pr-4 py-3 bg-white/90 border border-gray-200 rounded-2xl 
                                              focus:outline-none focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 
                                              transition-all duration-300 shadow-lg">
                                <div class="absolute left-4 top-1/2 transform -translate-y-1/2">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
            {{-- Table Container --}}
            <div class="bg-white/80 backdrop-blur-sm shadow-2xl rounded-3xl overflow-hidden border border-white/50">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr>
                                <th class="px-8 py-6 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center gap-2">
                                        👤 Nama Siswa
                                    </div>
                                </th>
                                <th class="px-8 py-6 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center gap-2">
                                        🏫 Kelas
                                    </div>
                                </th>
                                <th class="px-8 py-6 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center gap-2">
                                        🔢 NISN
                                    </div>
                                </th>
                                <th class="px-8 py-6 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center gap-2">
                                        ⚡ Aksi
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white/50 backdrop-blur-sm divide-y divide-gray-100">
                            @forelse ($siswas as $index => $siswa)
                                <tr class="group hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 
                                          transition-all duration-300 transform hover:scale-[1.01]"
                                    x-show="searchTerm === '' || '{{ strtolower($siswa->user->name ?? '') }}'.includes(searchTerm.toLowerCase()) || 
                                            '{{ strtolower($siswa->kelas->nama_kelas) }}'.includes(searchTerm.toLowerCase()) || 
                                            '{{ $siswa->nisn }}'.includes(searchTerm)"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 transform translate-y-4"
                                    x-transition:enter-end="opacity-100 transform translate-y-0">

                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="w-12 h-12 bg-gradient-to-br from-blue-400 to-indigo-500 
                                                        rounded-2xl flex items-center justify-center text-white font-bold text-lg
                                                        shadow-lg group-hover:shadow-xl transition-all duration-300">
                                                {{ substr($siswa->user->name ?? 'N', 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="text-lg font-semibold text-gray-900">
                                                    {{ $siswa->user->name ?? '-' }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $siswa->user->email ?? 'Email tidak tersedia' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-8 py-6">
                                        <span
                                            class="inline-flex items-center px-4 py-2 rounded-2xl text-sm font-semibold
                                                     bg-gradient-to-r from-emerald-100 to-emerald-200 text-emerald-800
                                                     shadow-sm group-hover:shadow-md transition-all duration-300">
                                            {{ $siswa->kelas->nama_kelas }}
                                        </span>
                                    </td>

                                    <td class="px-8 py-6">
                                        <span class="font-mono text-gray-700 bg-gray-100 px-3 py-1 rounded-xl">
                                            {{ $siswa->nisn }}
                                        </span>
                                    </td>

                                    <td class="px-8 py-6">
                                        <button @click="openDetail({{ $siswa->id }})"
                                            class="group inline-flex items-center gap-2 px-6 py-3 text-sm font-semibold 
                                                       text-white bg-gradient-to-r from-blue-500 to-indigo-500 
                                                       hover:from-blue-600 hover:to-indigo-600 rounded-2xl
                                                       shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 
                                                       transition-all duration-300">
                                            <svg class="w-4 h-4 group-hover:rotate-12 transition-transform duration-300"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z">
                                                </path>
                                            </svg>
                                            Detail
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-16 text-center">
                                        <div class="flex flex-col items-center gap-4">
                                            <div class="w-20 h-20 bg-gray-100 rounded-3xl flex items-center justify-center">
                                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div class="text-center">
                                                <h3 class="text-lg font-semibold text-gray-900 mb-1">Belum ada data siswa
                                                </h3>
                                                <p class="text-gray-500">Data siswa akan muncul di sini setelah ditambahkan
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Enhanced Modal --}}
            <div x-show="showDetail" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

                {{-- Backdrop --}}
                <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="closeDetail()"></div>

                {{-- Modal Content --}}
                <div class="relative bg-white rounded-3xl max-w-3xl w-full shadow-2xl transform max-h-[90vh] overflow-y-auto"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                    x-transition:leave-end="opacity-0 scale-95 translate-y-4">

                    <template x-if="selectedSiswa">
                        <div class="p-8">
                            {{-- Modal Header --}}
                            <div class="flex items-center justify-between mb-8">
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 
                                                rounded-3xl flex items-center justify-center text-white font-bold text-2xl
                                                shadow-lg"
                                        x-text="getSelectedSiswa()?.user?.name ? getSelectedSiswa().user.name.charAt(0) : 'N'">
                                    </div>
                                    <div>
                                        <h3
                                            class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                                            Detail Siswa
                                        </h3>
                                        <p class="text-gray-500 mt-1">Informasi lengkap siswa</p>
                                    </div>
                                </div>
                                <button @click="closeDetail()"
                                    class="w-12 h-12 bg-gray-100 hover:bg-gray-200 rounded-2xl 
                                               flex items-center justify-center transition-all duration-200
                                               hover:scale-110">
                                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>

                            {{-- Modal Body --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-6">
                                    <div
                                        class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-100">
                                        <h4 class="text-lg font-semibold text-blue-900 mb-4 flex items-center gap-2">
                                            👤 Informasi Pribadi
                                        </h4>
                                        <div class="space-y-4">
                                            <div class="flex justify-between items-center">
                                                <span class="text-gray-600 font-medium">Nama Lengkap</span>
                                                <span class="text-gray-900 font-semibold"
                                                    x-text="getSelectedSiswa()?.user?.name || '-'"></span>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <span class="text-gray-600 font-medium">NISN</span>
                                                <span class="font-mono bg-white px-3 py-1 rounded-lg"
                                                    x-text="getSelectedSiswa()?.nisn || '-'"></span>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <span class="text-gray-600 font-medium">Nomor HP</span>
                                                <span class="text-gray-900 font-semibold"
                                                    x-text="getSelectedSiswa()?.user?.no_hp || '-'"></span>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <span class="text-gray-600 font-medium">Jenis Kelamin</span>
                                                <span class="text-gray-900 font-semibold"
                                                    x-text="getSelectedSiswa()?.user?.jenis_kelamin || '-'"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-6">
                                    <div
                                        class="bg-gradient-to-br from-emerald-50 to-green-50 rounded-2xl p-6 border border-emerald-100">
                                        <h4 class="text-lg font-semibold text-emerald-900 mb-4 flex items-center gap-2">
                                            🏫 Informasi Akademik
                                        </h4>
                                        <div class="space-y-4">
                                            <div class="flex justify-between items-center">
                                                <span class="text-gray-600 font-medium">Kelas</span>
                                                <span
                                                    class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-lg font-semibold"
                                                    x-text="getSelectedSiswa()?.kelas?.nama_kelas || '-'"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Score BK Section dengan Peringatan --}}
                            <div class="mt-8">
                                <div class="bg-white rounded-2xl p-6 border-2"
                                    :class="{
                                        'border-red-200 bg-gradient-to-br from-red-50 to-pink-50': (getSelectedSiswa()
                                            ?.score_bk || 0) >= 150,
                                        'border-orange-200 bg-gradient-to-br from-orange-50 to-yellow-50': (
                                            getSelectedSiswa()?.score_bk || 0) >= 100 && (getSelectedSiswa()
                                            ?.score_bk || 0) < 150,
                                        'border-yellow-200 bg-gradient-to-br from-yellow-50 to-amber-50': (
                                            getSelectedSiswa()?.score_bk || 0) >= 50 && (getSelectedSiswa()
                                            ?.score_bk || 0) < 100,
                                        'border-green-200 bg-gradient-to-br from-green-50 to-emerald-50': (
                                            getSelectedSiswa()?.score_bk || 0) < 50
                                    }">

                                    {{-- Header dengan Icon Peringatan --}}
                                    <div class="flex items-center gap-4 mb-6">
                                        <div class="w-12 h-12 rounded-full flex items-center justify-center shadow-lg"
                                            :class="{
                                                'bg-red-500 animate-pulse': (getSelectedSiswa()?.score_bk || 0) >= 150,
                                                'bg-orange-500': (getSelectedSiswa()?.score_bk || 0) >= 100 && (
                                                    getSelectedSiswa()?.score_bk || 0) < 150,
                                                'bg-yellow-500': (getSelectedSiswa()?.score_bk || 0) >= 50 && (
                                                    getSelectedSiswa()?.score_bk || 0) < 100,
                                                'bg-green-500': (getSelectedSiswa()?.score_bk || 0) < 50
                                            }">
                                            <template x-if="(getSelectedSiswa()?.score_bk || 0) >= 150">
                                                <span class="text-white text-xl">🚨</span>
                                            </template>
                                            <template
                                                x-if="(getSelectedSiswa()?.score_bk || 0) >= 100 && (getSelectedSiswa()?.score_bk || 0) < 150">
                                                <span class="text-white text-xl">⚠️</span>
                                            </template>
                                            <template
                                                x-if="(getSelectedSiswa()?.score_bk || 0) >= 50 && (getSelectedSiswa()?.score_bk || 0) < 100">
                                                <span class="text-white text-xl">⚡</span>
                                            </template>
                                            <template x-if="(getSelectedSiswa()?.score_bk || 0) < 50">
                                                <span class="text-white text-xl">✅</span>
                                            </template>
                                        </div>

                                        <div class="flex-1">
                                            <h4 class="text-xl font-bold text-gray-800">Status Bimbingan Konseling</h4>
                                            <p class="text-gray-600">Evaluasi perilaku dan kedisiplinan siswa</p>
                                        </div>

                                        {{-- Badge Kritis untuk skor tinggi --}}
                                        <template x-if="(getSelectedSiswa()?.score_bk || 0) >= 150">
                                            <div class="animate-bounce">
                                                <span
                                                    class="bg-red-600 text-white px-3 py-1 rounded-full text-sm font-bold uppercase tracking-wider shadow-lg">
                                                    KRITIS!
                                                </span>
                                            </div>
                                        </template>
                                    </div>

                                    {{-- Skor dan Progress Bar --}}
                                    <div class="space-y-6">
                                        {{-- Skor Utama --}}
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-700 font-semibold text-lg">Skor Pelanggaran</span>
                                            <div class="flex items-center gap-3">
                                                <span class="px-4 py-2 rounded-xl font-bold text-2xl shadow-lg"
                                                    :class="{
                                                        'bg-red-100 text-red-800 animate-pulse': (getSelectedSiswa()
                                                            ?.score_bk || 0) >= 150,
                                                        'bg-orange-100 text-orange-800': (getSelectedSiswa()
                                                            ?.score_bk || 0) >= 100 && (getSelectedSiswa()
                                                            ?.score_bk || 0) < 150,
                                                        'bg-yellow-100 text-yellow-800': (getSelectedSiswa()
                                                            ?.score_bk || 0) >= 50 && (getSelectedSiswa()
                                                            ?.score_bk || 0) < 100,
                                                        'bg-green-100 text-green-800': (getSelectedSiswa()?.score_bk ||
                                                            0) < 50
                                                    }"
                                                    x-text="(getSelectedSiswa()?.score_bk || 0) + '/200'"></span>
                                            </div>
                                        </div>

                                        {{-- Progress Bar dengan Animasi --}}
                                        <div class="space-y-3">
                                            <div class="flex justify-between text-sm text-gray-600">
                                                <span>Progress Pelanggaran</span>
                                                <span
                                                    x-text="Math.round(((getSelectedSiswa()?.score_bk || 0) / 200) * 100) + '%'"></span>
                                            </div>

                                            <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden shadow-inner">
                                                <div class="h-4 rounded-full transition-all duration-1000 ease-out relative"
                                                    :style="`width: ${Math.min(((getSelectedSiswa()?.score_bk || 0) / 200) * 100, 100)}%`"
                                                    :class="{
                                                        'bg-gradient-to-r from-red-500 to-red-600': (getSelectedSiswa()
                                                            ?.score_bk || 0) >= 150,
                                                        'bg-gradient-to-r from-orange-500 to-orange-600': (
                                                            getSelectedSiswa()?.score_bk || 0) >= 100 && (
                                                            getSelectedSiswa()?.score_bk || 0) < 150,
                                                        'bg-gradient-to-r from-yellow-500 to-yellow-600': (
                                                            getSelectedSiswa()?.score_bk || 0) >= 50 && (
                                                            getSelectedSiswa()?.score_bk || 0) < 100,
                                                        'bg-gradient-to-r from-green-500 to-green-600': (
                                                            getSelectedSiswa()?.score_bk || 0) < 50
                                                    }">
                                                    {{-- Shimmer effect untuk skor tinggi --}}
                                                    <template x-if="(getSelectedSiswa()?.score_bk || 0) >= 100">
                                                        <div
                                                            class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-30 animate-pulse">
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>

                                            {{-- Marker Progress --}}
                                            <div class="flex justify-between text-xs text-gray-500 px-1">
                                                <span class="text-green-600 font-medium">0 (Baik)</span>
                                                <span class="text-yellow-600 font-medium">50</span>
                                                <span class="text-orange-600 font-medium">100</span>
                                                <span class="text-red-600 font-medium">150</span>
                                                <span class="text-red-800 font-bold">200 (Max)</span>
                                            </div>
                                        </div>

                                        {{-- Status dan Kategori --}}
                                        <div class="text-center">
                                            <span
                                                class="inline-flex items-center px-4 py-2 rounded-full text-lg font-bold shadow-lg"
                                                :class="{
                                                    'bg-red-100 text-red-800 border-2 border-red-200': (
                                                        getSelectedSiswa()?.score_bk || 0) >= 150,
                                                    'bg-orange-100 text-orange-800 border-2 border-orange-200': (
                                                        getSelectedSiswa()?.score_bk || 0) >= 100 && (
                                                        getSelectedSiswa()?.score_bk || 0) < 150,
                                                    'bg-yellow-100 text-yellow-800 border-2 border-yellow-200': (
                                                        getSelectedSiswa()?.score_bk || 0) >= 50 && (
                                                        getSelectedSiswa()?.score_bk || 0) < 100,
                                                    'bg-green-100 text-green-800 border-2 border-green-200': (
                                                        getSelectedSiswa()?.score_bk || 0) < 50
                                                }">
                                                <template x-if="(getSelectedSiswa()?.score_bk || 0) >= 150">
                                                    <span>🚨 Sangat Memerlukan Perhatian Khusus</span>
                                                </template>
                                                <template
                                                    x-if="(getSelectedSiswa()?.score_bk || 0) >= 100 && (getSelectedSiswa()?.score_bk || 0) < 150">
                                                    <span>⚠️ Perlu Perhatian Khusus</span>
                                                </template>
                                                <template
                                                    x-if="(getSelectedSiswa()?.score_bk || 0) >= 50 && (getSelectedSiswa()?.score_bk || 0) < 100">
                                                    <span>⚡ Perlu Bimbingan</span>
                                                </template>
                                                <template x-if="(getSelectedSiswa()?.score_bk || 0) < 50">
                                                    <span>✅ Kondisi Baik</span>
                                                </template>
                                            </span>
                                        </div>

                                        {{-- Peringatan dan Rekomendasi --}}
                                        <template x-if="(getSelectedSiswa()?.score_bk || 0) >= 50">
                                            <div class="mt-6 p-5 rounded-xl border-l-4 shadow-lg"
                                                :class="{
                                                    'bg-red-50 border-red-500': (getSelectedSiswa()?.score_bk || 0) >=
                                                        150,
                                                    'bg-orange-50 border-orange-500': (getSelectedSiswa()?.score_bk ||
                                                        0) >= 100 && (getSelectedSiswa()?.score_bk || 0) < 150,
                                                    'bg-yellow-50 border-yellow-500': (getSelectedSiswa()?.score_bk ||
                                                        0) >= 50 && (getSelectedSiswa()?.score_bk || 0) < 100
                                                }">

                                                <template x-if="(getSelectedSiswa()?.score_bk || 0) >= 150">
                                                    <div>
                                                        <div class="flex items-center gap-3 mb-3">
                                                            <span class="text-2xl animate-bounce">🚨</span>
                                                            <h5 class="font-bold text-red-800 text-lg">PERINGATAN KRITIS!
                                                            </h5>
                                                        </div>
                                                        <p class="text-red-700 mb-4 leading-relaxed">
                                                            Siswa memiliki skor pelanggaran sangat tinggi (≥150). Diperlukan
                                                            tindakan segera dan intensif.
                                                        </p>
                                                        <div class="bg-red-100 rounded-lg p-4">
                                                            <h6 class="font-semibold text-red-800 mb-2">Tindakan Segera:
                                                            </h6>
                                                            <ul class="text-red-700 text-sm space-y-1">
                                                                <li>• Konseling intensif segera dengan guru BK</li>
                                                                <li>• Melibatkan orang tua/wali murid</li>
                                                                <li>• Evaluasi harian dan monitoring ketat</li>
                                                                <li>• Pertimbangan tindakan disipliner khusus</li>
                                                                <li>• Rujukan ke ahli jika diperlukan</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </template>

                                                <template
                                                    x-if="(getSelectedSiswa()?.score_bk || 0) >= 100 && (getSelectedSiswa()?.score_bk || 0) < 150">
                                                    <div>
                                                        <div class="flex items-center gap-3 mb-3">
                                                            <span class="text-2xl">⚠️</span>
                                                            <h5 class="font-bold text-orange-800 text-lg">Perlu Perhatian
                                                                Khusus</h5>
                                                        </div>
                                                        <p class="text-orange-700 mb-4 leading-relaxed">
                                                            Skor pelanggaran tinggi (100-149). Diperlukan bimbingan intensif
                                                            dan monitoring ketat.
                                                        </p>
                                                        <div class="bg-orange-100 rounded-lg p-4">
                                                            <h6 class="font-semibold text-orange-800 mb-2">Rekomendasi:
                                                            </h6>
                                                            <ul class="text-orange-700 text-sm space-y-1">
                                                                <li>• Konseling rutin mingguan</li>
                                                                <li>• Monitoring ketat oleh wali kelas</li>
                                                                <li>• Komunikasi intensif dengan orang tua</li>
                                                                <li>• Program bimbingan khusus</li>
                                                                <li>• Evaluasi berkala setiap bulan</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </template>

                                                <template
                                                    x-if="(getSelectedSiswa()?.score_bk || 0) >= 50 && (getSelectedSiswa()?.score_bk || 0) < 100">
                                                    <div>
                                                        <div class="flex items-center gap-3 mb-3">
                                                            <span class="text-2xl">⚡</span>
                                                            <h5 class="font-bold text-yellow-800 text-lg">Perlu Bimbingan
                                                            </h5>
                                                        </div>
                                                        <p class="text-yellow-700 mb-4 leading-relaxed">
                                                            Skor pelanggaran sedang (50-99). Diperlukan bimbingan dan
                                                            monitoring reguler.
                                                        </p>
                                                        <div class="bg-yellow-100 rounded-lg p-4">
                                                            <h6 class="font-semibold text-yellow-800 mb-2">Tindakan:</h6>
                                                            <ul class="text-yellow-700 text-sm space-y-1">
                                                                <li>• Bimbingan konseling berkala</li>
                                                                <li>• Monitoring reguler</li>
                                                                <li>• Pembinaan karakter dan kedisiplinan</li>
                                                                <li>• Komunikasi dengan orang tua</li>
                                                                <li>• Program pengembangan diri</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </template>

                                        {{-- Pesan Positif untuk skor baik --}}
                                        <template x-if="(getSelectedSiswa()?.score_bk || 0) < 50">
                                            <div
                                                class="mt-6 p-5 bg-green-50 border-l-4 border-green-500 rounded-xl shadow-lg">
                                                <div class="flex items-center gap-3 mb-3">
                                                    <span class="text-2xl">✅</span>
                                                    <h5 class="font-bold text-green-800 text-lg">Kondisi Baik</h5>
                                                </div>
                                                <p class="text-green-700 leading-relaxed">
                                                    Siswa memiliki skor pelanggaran rendah (0-49). Terus pertahankan
                                                    perilaku positif dan kedisiplinan yang baik.
                                                </p>
                                                <div class="bg-green-100 rounded-lg p-4 mt-4">
                                                    <h6 class="font-semibold text-green-800 mb-2">Apresiasi:</h6>
                                                    <ul class="text-green-700 text-sm space-y-1">
                                                        <li>• Siswa menunjukkan perilaku yang baik</li>
                                                        <li>• Patuhi terus aturan sekolah</li>
                                                        <li>• Jadilah contoh untuk teman-teman</li>
                                                        <li>• Lanjutkan prestasi positif</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            {{-- Modal Footer --}}
                            <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-gray-200">
                                <button @click="closeDetail()"
                                    class="px-8 py-3 text-gray-700 bg-gray-100 hover:bg-gray-200 
                                               rounded-2xl font-semibold transition-all duration-200
                                               hover:scale-105 shadow-md hover:shadow-lg">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

        </div>
    </div>

    {{-- Custom Styles --}}
    <style>
        [x-cloak] {
            display: none !important;
        }

        .group:hover .group-hover\:rotate-12 {
            transform: rotate(12deg);
        }

        /* Smooth scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #3b82f6, #6366f1);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, #2563eb, #4f46e5);
        }
    </style>
@endsection
