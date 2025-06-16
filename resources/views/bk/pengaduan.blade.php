@extends('components.admin')

@section('title', 'Daftar Laporan')

@section('content')
    <div class="bg-gray-100 min-h-screen p-6" x-data="{ modalTambah: false }">
        <div class="max-w-6xl mx-auto space-y-6">
            {{-- Header --}}
            <div class="flex justify-between items-center">
                <h1 class="text-4xl font-bold text-gray-800">💻Daftar Pengaduan</h1>
            </div>
            {{-- Table --}}
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto">
                        <thead class="bg-gradient-to-r from-blue-50 to-indigo-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <i class="fas fa-user-graduate mr-2"></i>Nama Pelapor Siswa
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <i class="fas fa-user-graduate mr-2"></i>Yang Dilaporkan
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
                                                    {{ $laporan->pelapor->name ?? '-' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $laporan->siswa->name ?? '-' }}
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
                                                                {{ $laporan->pelapor->name ?? '-' }}</p>
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
                                            <form method="POST" action="{{ route('pengaduan.hapus', $laporan->id) }}"
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
                                    <td colspan="4" class="text-center py-12">
                                        <div class="flex flex-col items-center">
                                            <i class="fas fa-inbox text-gray-300 text-4xl mb-4"></i>
                                            <p class="text-gray-500 text-lg font-medium">Belum ada data laporan</p>
                                            <p class="text-gray-400 text-sm">Tidak ada data pengaduan yang tersedia</p>
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
