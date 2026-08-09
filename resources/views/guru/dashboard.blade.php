@extends('components.admin')
@section('title', 'Dashboard Guru')
@section('content')
    <div class="py-8 space-y-6">
        <div class="bg-white rounded-2xl shadow p-6">
            <h1 class="text-3xl font-bold">Dashboard Guru</h1>
            <p class="text-gray-500 mt-1">Ringkasan skorsing yang Anda input.</p>
        </div>
        <div class="grid sm:grid-cols-2 gap-4">
            <div class="bg-white rounded-2xl shadow p-6">
                <p class="text-gray-500">Total Skorsing Saya</p>
                <p class="text-3xl font-bold">{{ $skorsingCount }}</p>
            </div>
            <div class="bg-white rounded-2xl shadow p-6">
                <p class="text-gray-500">Bulan Ini</p>
                <p class="text-3xl font-bold">{{ $skorsingBulanIni }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-4 text-left">Tanggal</th>
                        <th class="p-4 text-left">Siswa</th>
                        <th class="p-4 text-left">Pelanggaran</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $item)
                        <tr class="border-t">
                            <td class="p-4">{{ $item->tanggal?->format('d/m/Y') }}</td>
                            <td class="p-4">{{ $item->siswa?->nama }} — {{ $item->siswa?->kelas?->nama_kelas }}</td>
                            <td class="p-4">{{ $item->pelanggaran?->deskripsi }}</td>
                    </tr>@empty<tr>
                            <td colspan="3" class="p-8 text-center text-gray-500">Belum ada skorsing.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
