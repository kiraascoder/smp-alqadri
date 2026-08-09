@extends('components.admin')
@section('title', 'Dashboard Admin')
@section('content')
<div class="py-8 space-y-6">
    <div class="bg-white rounded-2xl shadow p-6"><h1 class="text-3xl font-bold">Dashboard Admin</h1><p class="text-gray-500 mt-1">Ringkasan data SMP Al Qadri.</p></div>
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        @foreach ([['Guru',$guruCount,'blue'],['Siswa',$siswaCount,'green'],['Orang Tua',$orangTuaCount,'purple'],['Skorsing Bulan Ini',$skorsingBulanIniCount,'red']] as [$label,$value,$color])
        <div class="bg-white rounded-2xl shadow p-6"><p class="text-gray-500 text-sm">{{ $label }}</p><p class="text-3xl font-bold mt-2">{{ $value }}</p></div>
        @endforeach
    </div>
    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <div class="p-6 border-b"><h2 class="text-xl font-semibold">Skorsing Terbaru</h2></div>
        <div class="overflow-x-auto"><table class="w-full text-sm"><thead class="bg-gray-50"><tr><th class="p-4 text-left">Tanggal</th><th class="p-4 text-left">Siswa</th><th class="p-4 text-left">Kelas</th><th class="p-4 text-left">Pelanggaran</th><th class="p-4 text-left">Oleh</th></tr></thead><tbody>
        @forelse($riwayat as $item)<tr class="border-t"><td class="p-4">{{ $item->tanggal?->format('d/m/Y') }}</td><td class="p-4 font-medium">{{ $item->siswa?->nama }}</td><td class="p-4">{{ $item->siswa?->kelas?->nama_kelas }}</td><td class="p-4">{{ $item->pelanggaran?->deskripsi }}</td><td class="p-4">{{ $item->creator?->name ?? 'User dihapus' }}</td></tr>@empty<tr><td colspan="5" class="p-8 text-center text-gray-500">Belum ada skorsing.</td></tr>@endforelse
        </tbody></table></div>
    </div>
</div>
@endsection
