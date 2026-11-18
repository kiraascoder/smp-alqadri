@extends('berita.layout')
@section('page_title', $berita->judul)
@section('content')
<div class="mx-auto max-w-5xl px-5 pt-9 lg:px-8">
    <nav class="mb-6 text-sm text-slate-500"><a href="{{ route('home') }}" class="hover:text-emerald-700">Beranda</a> / <a href="{{ route('berita.index') }}" class="hover:text-emerald-700">Berita</a> / <span class="text-slate-700">Detail</span></nav>
    <article class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
        @if($berita->gambar)
            <img src="{{ Storage::disk('public')->url($berita->gambar) }}" alt="{{ $berita->judul }}" class="max-h-[480px] w-full object-cover">
        @endif
        <div class="p-6 sm:p-10">
            <div class="mb-4 flex flex-wrap items-center gap-3 text-sm text-slate-500">
                <span class="rounded-full bg-emerald-50 px-3 py-1 font-semibold text-emerald-800">{{ $berita->kategori ?: 'Berita Sekolah' }}</span>
                <time datetime="{{ $berita->published_at?->toDateString() }}">{{ $berita->published_at?->timezone('Asia/Makassar')->format('d F Y') }}</time>
            </div>
            <h1 class="text-3xl font-extrabold leading-tight text-slate-900 sm:text-4xl">{{ $berita->judul }}</h1>
            @if($berita->ringkasan)
                <p class="mt-5 border-l-4 border-emerald-500 pl-4 text-lg leading-8 text-slate-600">{{ $berita->ringkasan }}</p>
            @endif
            {{-- Teks berita di-escape oleh Blade; whitespace-pre-line menjaga paragraf. --}}
            <div class="mt-8 whitespace-pre-line break-words text-base leading-8 text-slate-700">{{ $berita->isi }}</div>
            <div class="mt-10 border-t border-slate-100 pt-5">
                <a href="{{ route('berita.index') }}" class="font-semibold text-emerald-700 hover:underline">← Kembali ke semua berita</a>
            </div>
        </div>
    </article>
    @if($related->isNotEmpty())
        <section class="mt-12">
            <h2 class="mb-6 text-2xl font-bold text-slate-900">Berita Lainnya</h2>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($related as $item) @include('berita._card', ['item' => $item]) @endforeach
            </div>
        </section>
    @endif
</div>
@endsection
