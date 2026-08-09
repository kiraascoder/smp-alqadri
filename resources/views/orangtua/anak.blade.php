@extends('components.admin')
@section('title', 'Anak Saya')
@section('content')
<div class="py-8 space-y-6">
    <div><h1 class="text-3xl font-bold">Anak Saya</h1><p class="text-slate-500 mt-1">Data siswa yang terhubung dengan akun Anda.</p></div>
    <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
        @forelse($anak as $siswa)
            <article class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                <h2 class="text-xl font-semibold">{{ $siswa->nama }}</h2>
                <dl class="mt-5 space-y-3 text-sm">
                    <div class="flex justify-between gap-4"><dt class="text-slate-500">Kelas</dt><dd class="font-medium">{{ $siswa->kelas?->nama_kelas ?? '-' }}</dd></div>
                    <div class="flex justify-between gap-4"><dt class="text-slate-500">Tanggal Lahir</dt><dd class="font-medium">{{ $siswa->tanggal_lahir?->format('d/m/Y') }}</dd></div>
                    <div class="flex justify-between gap-4 border-t pt-3"><dt class="text-slate-500">Skor Pelanggaran</dt><dd class="font-bold text-red-600">{{ $siswa->score_bk }}</dd></div>
                </dl>
            </article>
        @empty
            <div class="md:col-span-2 xl:col-span-3 rounded-2xl bg-white border p-8 text-center text-slate-500">Belum ada anak yang ditautkan ke akun ini.</div>
        @endforelse
    </div>
</div>
@endsection
