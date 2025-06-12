@extends('components.admin')

@section('content')
    <div class="bg-gray-100 min-h-screen p-6">
        <div class="max-w-6xl mx-auto space-y-6">
            <dialog id="modalTambahSkorsing" class="modal">
                <div class="modal-box max-w-lg bg-white rounded-xl p-6 shadow-lg">
                    <h3 class="text-xl font-bold mb-4 text-gray-800">Tambah Skorsing</h3>

                    <form action="{{ route('skorsing.tambah') }}" method="POST" class="space-y-4">
                        @csrf

                        {{-- Pilih Siswa --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Siswa</label>
                            <select name="siswa_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Siswa --</option>
                                @foreach ($siswas as $siswa)
                                    <option value="{{ $siswa->id }}">{{ $siswa->user->name ?? '-' }} -
                                        {{ $siswa->nisn }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Pilih Pelanggaran --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Pelanggaran</label>
                            <select name="pelanggarans_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                required>
                                <option value="">-- Pilih Pelanggaran --</option>
                                @foreach ($pelanggarans as $pelanggaran)
                                    <option value="{{ $pelanggaran->id }}">
                                        {{ $pelanggaran->deskripsi }} ({{ $pelanggaran->skor }} poin)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tanggal --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                            <input type="date" name="tanggal"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        {{-- Keterangan --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Keterangan</label>
                            <textarea name="keterangan" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                        </div>

                        <div class="modal-action flex justify-end space-x-2">
                            <form method="dialog">
                                <button type="submit"
                                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                                    Simpan
                                </button>
                            </form>
                            <form method="dialog">
                                <button class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">
                                    Batal
                                </button>
                            </form>
                        </div>
                    </form>
                </div>
            </dialog>

            {{-- Header --}}
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-semibold text-gray-800">📋 Riwayat Skorsing</h1>
                <button onclick="document.getElementById('modalTambahSkorsing').showModal()"
                    class="inline-block bg-blue-600 text-white px-4 py-2 rounded-md shadow hover:bg-blue-700 transition">
                    + Tambah Skorsing
                </button>

            </div>
            {{-- Success Message --}}
            @if (session('success'))
                <div class="p-4 bg-green-100 text-green-800 rounded-md border border-green-300">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Table --}}
            {{-- Riwayat Pelanggaran --}}
            <div class="bg-white rounded-xl shadow-md overflow-x-auto mt-10">
                <h2 class="text-xl font-semibold text-gray-800 px-4 pt-4">📄 Riwayat Pelanggaran Siswa</h2>
                <table class="min-w-full table-auto text-sm mt-2">
                    <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-semibold">
                        <tr>
                            <th class="p-4 text-left">No</th>
                            <th class="p-4 text-left">Nama Siswa</th>
                            <th class="p-4 text-left">NISN</th>
                            <th class="p-4 text-left">Pelanggaran</th>
                            <th class="p-4 text-left">Skor</th>
                            <th class="p-4 text-left">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @forelse ($riwayat as $item)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="p-4">{{ $loop->iteration }}</td>
                                <td class="p-4">{{ $item->siswa->user->name ?? '-' }}</td>
                                <td class="p-4">{{ $item->siswa->nisn ?? '-' }}</td>
                                <td class="p-4">{{ $item->pelanggaran->deskripsi ?? '-' }}</td>
                                <td class="p-4">{{ $item->pelanggaran->skor ?? '-' }} poin</td>
                                <td class="p-4">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-6 text-gray-500">Belum ada riwayat pelanggaran.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
