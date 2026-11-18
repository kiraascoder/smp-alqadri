@extends('pengumuman.layout')
@section('page_title', 'Pengumuman Sekolah')
@section('content')
<section class="bg-gradient-to-br from-emerald-950 via-emerald-800 to-teal-700 px-5 py-16 text-white">
    <div class="mx-auto max-w-7xl lg:px-8">
        <span class="rounded-full border border-white/20 bg-white/10 px-4 py-1.5 text-xs font-semibold uppercase tracking-wider">Informasi Resmi</span>
        <h1 class="mt-5 text-3xl font-extrabold sm:text-5xl">Pengumuman Sekolah</h1>
        <p class="mt-4 max-w-2xl text-sm leading-7 text-emerald-50 sm:text-base">Jadwal, pemberitahuan akademik, informasi kegiatan, dan pengumuman penting SMP Al-Qadri Islamic School.</p>
    </div>
</section>

<section class="mx-auto max-w-7xl px-5 py-10 lg:px-8">
    <form method="GET" action="{{ route('pengumuman') }}" class="mb-8 grid gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:grid-cols-[1fr_auto_auto]">
        <input type="search" name="search" maxlength="100" value="{{ $search }}"
               placeholder="Cari pengumuman..." aria-label="Cari pengumuman"
               class="min-w-0 rounded-xl border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-emerald-500">
        <select name="kategori" aria-label="Kategori" class="rounded-xl border border-slate-300 px-4 py-3">
            <option value="">Semua kategori</option>
            @foreach($kategoriList as $namaKategori)
                <option value="{{ $namaKategori }}" @selected($kategori === $namaKategori)>{{ $namaKategori }}</option>
            @endforeach
        </select>
        <button class="rounded-xl bg-emerald-700 px-6 py-3 font-semibold text-white hover:bg-emerald-800">Cari</button>
    </form>

    @if($pengumumanList->count())
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($pengumumanList as $item)
                @include('pengumuman._card', ['item' => $item])
            @endforeach
        </div>
        <div class="mt-10">{{ $pengumumanList->links() }}</div>
    @else
        <div class="rounded-2xl border border-slate-200 bg-white px-6 py-16 text-center text-slate-500">
            {{ ($search !== '' || $kategori !== '') ? 'Tidak ada pengumuman yang cocok dengan pencarian.' : 'Belum ada pengumuman aktif yang diterbitkan.' }}
        </div>
    @endif
</section>
@endsection
