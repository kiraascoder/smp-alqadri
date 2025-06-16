@extends('components.admin')

@section('title', 'Daftar Laporan')

@section('content')
    <div class="bg-gray-100 min-h-screen p-6" x-data="{ modalTambah: false }">
        <div class="max-w-6xl mx-auto space-y-6">
            {{-- Header --}}
            <div class="flex justify-between items-center">
                <h1 class="text-4xl font-bold text-gray-800">💻Daftar Laporan</h1>
                <button @click="modalTambah = true"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow transition duration-200 transform hover:scale-105">
                    <i class="fas fa-plus mr-2"></i>Tambah Laporan
                </button>
            </div>

            {{-- Success Message --}}
            @if (session('success'))
                <div class="p-4 bg-green-100 text-green-800 rounded-lg border border-green-300 shadow-sm">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            {{-- Error Message --}}
            @if ($errors->any())
                <div class="p-4 bg-red-100 text-red-800 rounded-lg border border-red-300 shadow-sm">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-triangle mr-2 mt-0.5"></i>
                        <div>
                            <strong>Terjadi kesalahan:</strong>
                            <ul class="mt-2 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Table --}}
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto">
                        <thead class="bg-gradient-to-r from-blue-50 to-indigo-50">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <i class="fas fa-user-graduate mr-2"></i>Siswa
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <i class="fas fa-chalkboard-teacher mr-2"></i>Nama Pelapor
                                </th>

                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <i class="fas fa-file-alt mr-2"></i>Deskripsi
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <i class="fas fa-cogs mr-2"></i>Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($laporans as $laporan)
                                @php $modalId = 'detail_' . $laporan->id; @endphp
                                <tr class="hover:bg-blue-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                <i class="fas fa-user text-blue-600"></i>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $laporan->siswa->name ?? '-' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $laporan->pelapor->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700 max-w-xs truncate">
                                        {{ Str::limit($laporan->deskripsi, 30) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        <button onclick="document.getElementById('{{ $modalId }}').showModal()"
                                            class="text-blue-600 hover:text-blue-900 hover:bg-blue-100 px-3 py-1 rounded-lg transition-all duration-200">
                                            <i class="fas fa-eye mr-1"></i>Detail
                                        </button>
                                        <button
                                            onclick="document.getElementById('modalHapus{{ $laporan->id }}').showModal()"
                                            class="text-red-600 hover:text-red-900 hover:bg-red-100 px-3 py-1 rounded-lg transition-all duration-200">
                                            <i class="fas fa-trash mr-1"></i>Hapus
                                        </button>
                                    </td>
                                </tr>

                                {{-- Modal Detail --}}
                                <dialog id="{{ $modalId }}" class="modal">
                                    <div class="modal-box max-w-2xl bg-white rounded-xl p-0 shadow-2xl">
                                        <div class="p-6">
                                            <div class="flex items-center justify-between mb-4">
                                                <h3 class="text-xl font-bold text-gray-800">
                                                    <i class="fas fa-file-alt text-blue-600 mr-2"></i>Detail Laporan
                                                </h3>
                                                <form method="dialog">
                                                    <button
                                                        class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2 transition-colors">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="space-y-4">
                                                <div class="bg-gray-50 p-4 rounded-lg">
                                                    <div class="grid grid-cols-1 gap-3">
                                                        <div>
                                                            <label
                                                                class="text-xs font-semibold text-gray-500 uppercase">Siswa</label>
                                                            <p class="text-sm font-medium text-gray-900">
                                                                {{ $laporan->siswa->name ?? '-' }}</p>
                                                        </div>
                                                        <div>
                                                            <label
                                                                class="text-xs font-semibold text-gray-500 uppercase">Nama
                                                                Pelapor</label>
                                                            <p class="text-sm font-medium text-gray-900">
                                                                {{ $laporan->pelapor->name ?? '-' }}
                                                        </div>
                                                        <div>
                                                            <label
                                                                class="text-xs font-semibold text-gray-500 uppercase">Pelanggaran</label>
                                                            <p class="text-sm font-medium text-red-600">
                                                                {{ $laporan->pelanggaran->deskripsi ?? '-' }}</p>
                                                        </div>
                                                        <div>
                                                            <label
                                                                class="text-xs font-semibold text-gray-500 uppercase">Deskripsi</label>
                                                            <p class="text-sm text-gray-700 leading-relaxed">
                                                                {{ $laporan->deskripsi ?? '-' }}</p>
                                                        </div>
                                                        <div>
                                                            <label
                                                                class="text-xs font-semibold text-gray-500 uppercase">Tanggal
                                                                Laporan</label>
                                                            <p class="text-sm font-medium text-gray-900">
                                                                {{ $laporan->created_at->format('d F Y, H:i') ?? '-' }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-action px-6 pb-6 pt-0">
                                            <form method="dialog">
                                                <button
                                                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-lg transition-colors duration-200">
                                                    <i class="fas fa-times mr-2"></i>Tutup
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </dialog>

                                {{-- Modal Hapus --}}
                                <dialog id="modalHapus{{ $laporan->id }}" class="modal">
                                    <div class="modal-box max-w-md bg-white rounded-xl p-6 shadow-2xl mx-auto">
                                        <div class="text-center">
                                            <div
                                                class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                                                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                                            </div>
                                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Konfirmasi Hapus</h3>
                                            <p class="text-sm text-gray-600 mb-6">
                                                Yakin ingin menghapus laporan untuk siswa
                                                <span
                                                    class="font-semibold text-gray-900">{{ $laporan->siswa->name ?? '-' }}</span>?
                                                <br><span class="text-red-500">Tindakan ini tidak dapat dibatalkan.</span>
                                            </p>
                                        </div>
                                        <div class="modal-action justify-center">
                                            <form method="dialog">
                                                <button
                                                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-lg transition-colors duration-200 mr-3">
                                                    <i class="fas fa-times mr-2"></i>Batal
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('laporan.hapus', $laporan->id) }}"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg transition-colors duration-200">
                                                    <i class="fas fa-trash mr-2"></i>Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </dialog>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-12">
                                        <div class="flex flex-col items-center">
                                            <i class="fas fa-inbox text-gray-300 text-4xl mb-4"></i>
                                            <p class="text-gray-500 text-lg font-medium">Belum ada data laporan</p>
                                            <p class="text-gray-400 text-sm">Klik tombol "Tambah Laporan" untuk membuat
                                                laporan baru</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Modal Tambah Laporan --}}
        <div x-show="modalTambah" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90"
            class="fixed inset-0 z-50 bg-black/20 backdrop-blur-sm flex items-center justify-center p-4"
            style="display: none;">
            <div @click.away="modalTambah = false"
                class="bg-white w-full max-w-2xl rounded-xl shadow-2xl max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-800">
                            <i class="fas fa-plus-circle text-blue-600 mr-2"></i>Tambah Laporan Baru
                        </h3>
                        <button @click="modalTambah = false"
                            class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2 transition-colors">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <!-- Form Tambah -->
                    <form method="POST" action="{{ route('laporan.tambah') }}" class="space-y-6">
                        @csrf


                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-user-graduate text-blue-500 mr-2"></i>Pilih Siswa
                            </label>
                            <select name="user_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <option value="">-- Pilih Siswa --</option>
                                @if (isset($siswas))
                                    @foreach ($siswas as $siswa)
                                        @if ($siswa->id !== auth()->user()->id)
                                            <option value="{{ $siswa->id }}">{{ $siswa->name }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <!-- Pilih Pelanggaran -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>Jenis Pelanggaran
                            </label>
                            <select name="pelanggaran_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <option value="">-- Pilih Pelanggaran --</option>
                                {{-- Isi dengan data pelanggaran dari controller --}}
                                @if (isset($pelanggarans))
                                    @foreach ($pelanggarans as $pelanggaran)
                                        <option value="{{ $pelanggaran->id }}">{{ $pelanggaran->deskripsi }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-file-alt text-purple-500 mr-2"></i>Deskripsi Lengkap
                            </label>
                            <textarea name="deskripsi" rows="4" required
                                placeholder="Jelaskan detail kejadian, waktu, tempat, dan tindakan yang diambil..."
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"></textarea>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end gap-3 pt-4 border-t">
                            <button type="button" @click="modalTambah = false"
                                class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                                <i class="fas fa-times mr-2"></i>Batal
                            </button>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                                <i class="fas fa-save mr-2"></i>Simpan Laporan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Tambahkan FontAwesome jika belum ada --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    {{-- Custom CSS untuk Modal Dialog --}}
    <style>
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            margin: 0;
            padding: 0;
        }

        .modal[open] {
            opacity: 1;
            visibility: visible;
        }

        .modal::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            z-index: -1;
        }

        .modal-box {
            position: relative;
            transform: scale(0.9);
            transition: transform 0.3s ease;
            z-index: 1;
        }

        .modal[open] .modal-box {
            transform: scale(1);
        }

        .modal-action {
            display: flex;
            gap: 0.75rem;
            margin-top: 1rem;
        }

        /* Backdrop click to close - full coverage */
        .modal::backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
        }

        /* Ensure modal covers entire viewport */
        dialog.modal {
            max-width: 100vw;
            max-height: 100vh;
            border: none;
            outline: none;
        }
    </style>
@endsection
