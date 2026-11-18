@extends('pengumuman.layout')
@section('page_title', $pengumuman->judul)
@section('content')
<section class="bg-gradient-to-br from-emerald-950 to-emerald-800 px-5 py-12 text-white">
    <div class="mx-auto max-w-4xl lg:px-8">
        <a href="{{ route('pengumuman') }}" class="text-sm font-semibold text-emerald-100 hover:underline">← Semua Pengumuman</a>
        <div class="mt-6 flex flex-wrap items-center gap-3 text-xs">
            <span class="rounded-full bg-white/15 px-3 py-1.5 font-semibold">{{ $pengumuman->kategori ?: 'Umum' }}</span>
            @if($pengumuman->is_pinned)<span class="rounded-full bg-amber-400 px-3 py-1.5 font-bold text-emerald-950">Pengumuman Penting</span>@endif
        </div>
        <h1 class="mt-5 text-3xl font-extrabold leading-tight sm:text-5xl">{{ $pengumuman->judul }}</h1>
        <p class="mt-5 text-sm text-emerald-100">Diterbitkan {{ $pengumuman->published_at?->copy()->timezone('Asia/Makassar')->translatedFormat('d F Y, H:i') }} WITA</p>
    </div>
</section>
<section class="mx-auto max-w-4xl space-y-10 px-5 py-10 lg:px-8">
    <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        @if($pengumuman->gambar)
            <img src="{{ Storage::disk('public')->url($pengumuman->gambar) }}" alt="Foto: {{ $pengumuman->judul }}" class="max-h-[500px] w-full object-cover">
        @endif
        <div class="p-6 sm:p-10">
            @if($pengumuman->ringkasan)
                <p class="mb-7 border-l-4 border-emerald-600 pl-5 text-lg font-medium leading-8 text-slate-700">{{ $pengumuman->ringkasan }}</p>
            @endif
            <div class="whitespace-pre-line break-words text-base leading-8 text-slate-700">{{ $pengumuman->isi }}</div>
            @if($pengumuman->lampiran)
                <div class="mt-10 rounded-2xl border border-emerald-100 bg-emerald-50 p-5">
                    <p class="text-sm font-bold text-emerald-900">Lampiran Dokumen</p>
                    <a href="{{ Storage::disk('public')->url($pengumuman->lampiran) }}" target="_blank" rel="noopener"
                       class="mt-2 inline-flex max-w-full break-all text-sm font-semibold text-emerald-700 hover:underline">
                        Buka PDF: {{ $pengumuman->nama_lampiran ?: 'Lampiran Pengumuman' }} ↗
                    </a>
                </div>
            @endif
            @if($pengumuman->expires_on)
                <p class="mt-8 text-xs text-slate-500">Berlaku hingga {{ $pengumuman->expires_on->translatedFormat('d F Y') }}.</p>
            @endif
        </div>
    </article>

    @if($terbaru->isNotEmpty())
        <div>
            <h2 class="mb-5 text-xl font-extrabold text-slate-900">Pengumuman Lainnya</h2>
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($terbaru as $item)
                    @include('pengumuman._card', ['item' => $item])
                @endforeach
            </div>
        </div>
    @endif
</section>
@endsection
