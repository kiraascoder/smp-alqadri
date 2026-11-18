<article class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg">
    <a href="{{ route('berita.show', $item->slug) }}" class="block">
        @if($item->gambar)
            <img src="{{ Storage::disk('public')->url($item->gambar) }}" alt="{{ $item->judul }}"
                 loading="lazy" class="h-52 w-full object-cover">
        @else
            <div class="flex h-52 items-center justify-center bg-gradient-to-br from-emerald-700 to-teal-500 text-lg font-semibold text-white">SMP AL-QADRI</div>
        @endif
        <div class="p-5">
            <div class="mb-3 flex flex-wrap items-center gap-2 text-xs text-slate-500">
                <span class="rounded-full bg-emerald-50 px-3 py-1 font-semibold text-emerald-800">{{ $item->kategori ?: 'Berita Sekolah' }}</span>
                <time datetime="{{ $item->published_at?->toDateString() }}">{{ $item->published_at?->timezone('Asia/Makassar')->format('d M Y') }}</time>
            </div>
            <h2 class="line-clamp-2 text-lg font-bold text-slate-900">{{ $item->judul }}</h2>
            <p class="mt-2 line-clamp-3 text-sm leading-6 text-slate-600">{{ $item->ringkasan }}</p>
            <span class="mt-4 inline-block text-sm font-bold text-emerald-700">Baca selengkapnya →</span>
        </div>
    </a>
</article>
