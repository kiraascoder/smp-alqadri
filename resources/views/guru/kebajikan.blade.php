@extends('components.admin')

@section('title', 'Poin Kebajikan')

@section('content')
<div class="py-8 space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-slate-900">Poin Kebajikan</h1>
        <p class="mt-1 text-slate-500">Berikan apresiasi positif kepada peserta didik dan lihat riwayat yang Anda buat.</p>
    </div>

    @if (session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
        <div class="mb-5">
            <h2 class="text-lg font-semibold text-slate-900">Berikan Poin Kebajikan</h2>
            <p class="text-sm text-slate-500">Pilih siswa dan bentuk kebajikan atau prestasi yang telah dilakukan.</p>
        </div>

        <form method="POST" action="{{ route('guru.kebajikan.store') }}" class="grid grid-cols-1 gap-4 md:grid-cols-2">
            @csrf

            <div>
                <label class="block mb-2 text-sm font-medium text-slate-700">Peserta Didik</label>
                <select name="siswa_id" required class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500">
                    <option value="">Pilih siswa</option>
                    @foreach ($siswas as $siswa)
                        <option value="{{ $siswa->id }}" @selected(old('siswa_id') == $siswa->id)>
                            {{ $siswa->nama ?? $siswa->user?->name ?? 'Siswa' }} — {{ $siswa->kelas?->nama_kelas ?? '-' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-slate-700">Bentuk Kebajikan / Prestasi</label>
                <select name="kebajikan_id" required class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500">
                    <option value="">Pilih kebajikan</option>
                    @foreach ($kebajikans as $kebajikan)
                        <option value="{{ $kebajikan->id }}" @selected(old('kebajikan_id') == $kebajikan->id)>
                            {{ $kebajikan->deskripsi }} (+{{ $kebajikan->skor }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-slate-700">Tanggal</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', now()->toDateString()) }}" required
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500">
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-slate-700">Keterangan</label>
                <input name="keterangan" value="{{ old('keterangan') }}" placeholder="Keterangan tambahan (opsional)"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500">
            </div>

            <div class="md:col-span-2 flex justify-end">
                <button type="submit" class="rounded-xl bg-emerald-600 px-6 py-3 font-medium text-white hover:bg-emerald-700">
                    Berikan Poin Kebajikan
                </button>
            </div>
        </form>
    </section>

    <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="border-b border-slate-200 px-6 py-5">
            <h2 class="text-lg font-semibold text-slate-900">Riwayat Poin Kebajikan Saya</h2>
            <p class="text-sm text-slate-500">Riwayat di bawah hanya menampilkan poin kebajikan yang Anda berikan.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="p-4 text-left font-semibold text-slate-700">Tanggal</th>
                        <th class="p-4 text-left font-semibold text-slate-700">Siswa</th>
                        <th class="p-4 text-left font-semibold text-slate-700">Kebajikan</th>
                        <th class="p-4 text-center font-semibold text-slate-700">Poin</th>
                        <th class="p-4 text-left font-semibold text-slate-700">Keterangan</th>
                        <th class="p-4 text-center font-semibold text-slate-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($riwayat as $item)
                        <tr class="border-t border-slate-100 hover:bg-slate-50">
                            <td class="p-4 whitespace-nowrap">{{ $item->tanggal?->format('d/m/Y') }}</td>
                            <td class="p-4">
                                <div class="font-medium text-slate-900">{{ $item->siswa?->nama ?? $item->siswa?->user?->name ?? '-' }}</div>
                                <div class="text-xs text-slate-500">{{ $item->siswa?->kelas?->nama_kelas ?? '-' }}</div>
                            </td>
                            <td class="p-4 max-w-lg text-slate-700">{{ $item->kebajikan?->deskripsi ?? '-' }}</td>
                            <td class="p-4 text-center">
                                <span class="inline-flex min-w-[54px] justify-center rounded-full bg-emerald-100 px-3 py-1 font-bold text-emerald-700">
                                    +{{ $item->skor }}
                                </span>
                            </td>
                            <td class="p-4 text-slate-600">{{ $item->keterangan ?: '-' }}</td>
                            <td class="p-4 text-center">
                                <form method="POST" action="{{ route('guru.kebajikan.delete', $item) }}" onsubmit="return confirm('Hapus riwayat poin kebajikan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-medium text-red-600 hover:text-red-800">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-10 text-center text-slate-500">Belum ada poin kebajikan yang Anda berikan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($riwayat->hasPages())
            <div class="border-t border-slate-200 p-4">{{ $riwayat->links() }}</div>
        @endif
    </section>
</div>
@endsection
