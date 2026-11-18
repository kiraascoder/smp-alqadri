@extends('berita.layout')
@section('page_title', 'Berita Sekolah')
@section('content')
<section class="bg-gradient-to-br from-emerald-900 via-emerald-700 to-teal-600 px-5 py-16 text-white">
    <div class="mx-auto max-w-7xl lg:px-8">
        <span class="rounded-full border border-white/20 bg-white/10 px-4 py-1.5 text-xs font-semibold uppercase tracking-wide">Kabar Sekolah</span>
        <h1 class="mt-5 text-3xl font-extrabold sm:text-5xl">Berita & Kegiatan Sekolah</h1>
        <p class="mt-4 max-w-2xl text-emerald-50">Informasi terbaru tentang kegiatan, prestasi, dan perkembangan SMP Al-Qadri Islamic School.</p>
    </div>
</section>
<section class="mx-auto max-w-7xl px-5 py-10 lg:px-8">
    <form method="GET" action="{{ route('berita.index') }}" class="mb-8 flex max-w-xl gap-2">
        <input type="search" name="search" value="{{ $search }}" maxlength="100"
               placeholder="Cari berita atau kategori..." aria-label="Cari berita"
               class="min-w-0 flex-1 rounded-xl border border-slate-300 bg-white px-4 py-3 outline-none focus:ring-2 focus:ring-emerald-500">
        <button class="rounded-xl bg-emerald-700 px-5 py-3 font-semibold text-white hover:bg-emerald-800">Cari</button>
    </form>
    @if($beritaList->count())
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($beritaList as $item)
                @include('berita._card', ['item' => $item])
            @endforeach
        </div>
        <div class="mt-10">{{ $beritaList->links() }}</div>
    @else
        <div class="rounded-2xl border border-slate-200 bg-white px-6 py-16 text-center text-slate-500">
            {{ $search ? 'Tidak ada berita yang cocok dengan pencarian.' : 'Belum ada berita yang diterbitkan.' }}
        </div>
    @endif
</section>
@endsection
