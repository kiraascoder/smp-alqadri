@extends('components.admin')

@section('content')
    <div class="bg-gray-100 min-h-screen p-6">
        <div class="max-w-6xl mx-auto space-y-6">
            {{-- Header --}}
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-semibold text-gray-800">📋 Daftar Siswa</h1>
            </div>

            {{-- Success Message --}}
            @if (session('success'))
                <div class="p-4 bg-green-100 text-green-800 rounded-md border border-green-300">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Table --}}
            <div class="bg-white rounded-xl shadow-md overflow-x-auto">
                <table class="min-w-full table-auto text-sm">
                    <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-semibold">
                        <tr>
                            <th class="p-4 text-left">No</th>
                            <th class="p-4 text-left">Nama</th>
                            <th class="p-4 text-left">Kelas</th>
                            <th class="p-4 text-left">NISN</th>
                            <th class="p-4 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @forelse ($siswas as $siswa)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="p-4">{{ $loop->iteration }}</td>
                                <td class="p-4">{{ $siswa->user->name ?? '-' }}</td>
                                <td class="p-4">{{ $siswa->kelas->nama_kelas }}</td>
                                <td class="p-4">{{ $siswa->nisn }}</td>
                                <td class="p-4 space-x-2">
                                    <button onclick="document.getElementById('modalDetail{{ $siswa->id }}').showModal()"
                                        class="text-blue-600 hover:underline">Detail</button>
                                </td>
                            </tr>
                            <dialog id="modalDetail{{ $siswa->id }}" class="modal">
                                <div class="modal-box max-w-md bg-white rounded-xl p-6 shadow-lg">
                                    <h3 class="text-lg font-bold mb-4">Detail siswa</h3>
                                    <div class="space-y-2 text-sm text-gray-700">
                                        <p><strong>Nama Siswa:</strong> {{ $siswa->user->name ?? '-' }}</p>
                                        <p><strong>Kelas:</strong> {{ $siswa->kelas->nama_kelas ?? '-' }}</p>
                                        <p><strong>NISN:</strong> {{ $siswa->nisn ?? '-' }}</p>
                                        <p><strong>No HP:</strong> {{ $siswa->user->no_hp ?? '-' }}</p>
                                        <p><strong>Skor:</strong> {{ $siswa->score_bk ?? '-' }}</p>
                                    </div>
                                    <div class="modal-action mt-4">
                                        <form method="dialog">
                                            <button class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">
                                                Tutup
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </dialog>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-6 text-gray-500">Belum ada data Siswa.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>


    </div>
@endsection
