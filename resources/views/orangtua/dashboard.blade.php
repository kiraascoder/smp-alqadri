@extends('components.admin')
@section('title', 'Dashboard Orang Tua')
@section('content')
    <div class="py-8 space-y-6">
        <div>
            <h1 class="text-3xl font-bold">Dashboard Orang Tua</h1>
            <p class="text-slate-500 mt-1">Pantau skor dan riwayat skorsing anak Anda.</p>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            <div class="bg-white border rounded-2xl p-5 shadow-sm">
                <p class="text-sm text-slate-500">Jumlah Anak</p>
                <p class="text-3xl font-bold mt-2">{{ $anak->count() }}</p>
            </div>
            <div class="bg-white border rounded-2xl p-5 shadow-sm">
                <p class="text-sm text-slate-500">Total Skor Pelanggaran</p>
                <p class="text-3xl font-bold mt-2 text-red-600">{{ $totalSkor }}</p>
            </div>
            <div class="bg-white border rounded-2xl p-5 shadow-sm">
                <p class="text-sm text-slate-500">Total Skorsing</p>
                <p class="text-3xl font-bold mt-2">{{ $totalSkorsing }}</p>
            </div>
        </div>

        <section class="bg-white border rounded-2xl p-6 shadow-sm">
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                @forelse($anak as $siswa)
                    <div class="rounded-xl border border-slate-200 p-4">
                        <p class="font-semibold text-lg">{{ $siswa->nama }}</p>
                        <p class="text-sm text-slate-500">{{ $siswa->kelas?->nama_kelas ?? '-' }}</p>
                        <div class="mt-3 flex justify-between"><span class="text-sm text-slate-500">Skor</span><span
                                class="font-bold text-red-600">{{ $siswa->score_bk }}</span></div>
                    </div>
                @empty
                    <p class="text-slate-500">Belum ada siswa yang ditautkan ke akun ini.</p>
                @endforelse
            </div>
        </section>

        <section class="bg-white border rounded-2xl shadow-sm overflow-hidden">
            <div class="p-6 border-b">
                <h2 class="font-semibold text-lg">Skorsing Terbaru</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="p-4 text-left">Tanggal</th>
                            <th class="p-4 text-left">Anak</th>
                            <th class="p-4 text-left">Pelanggaran</th>
                            <th class="p-4 text-left">Skor</th>
                            <th class="p-4 text-left">Dibuat Oleh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat as $item)
                            <tr class="border-t">
                                <td class="p-4">{{ $item->tanggal?->format('d/m/Y') }}</td>
                                <td class="p-4">{{ $item->siswa?->nama }}</td>
                                <td class="p-4">{{ $item->pelanggaran?->deskripsi }}</td>
                                <td class="p-4">+{{ $item->skor }}</td>
                                <td class="p-4">{{ $item->creator?->name ?? '-' }}</td>
                        </tr>@empty<tr>
                                <td colspan="5" class="p-8 text-center text-slate-500">Belum ada riwayat skorsing.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
