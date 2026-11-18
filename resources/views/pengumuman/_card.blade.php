<article class="group overflow-hidden rounded-2xl border border-emerald-100 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
    <a href="{{ route('pengumuman.show', $item->slug) }}" class="block h-full">
        <div class="relative h-48 overflow-hidden bg-gradient-to-br from-emerald-900 to-teal-700">
            @if($item->gambar)
                <img src="{{ Storage::disk('public')->url($item->gambar) }}" alt="Foto: {{ $item->judul }}"
                     loading="lazy" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
            @else
                <div class="flex h-full items-center justify-center">
                    <span class="text-6xl text-white/70" aria-hidden="true">📢</span>
                </div>
            @endif
            @if($item->is_pinned)
                <span class="absolute left-4 top-4 rounded-full bg-amber-400 px-3 py-1.5 text-xs font-bold text-emerald-950">Penting</span>
            @endif
        </div>
        <div class="p-6">
            <div class="flex flex-wrap items-center gap-2 text-xs text-slate-500">
                <span class="rounded-full bg-emerald-50 px-3 py-1 font-semibold text-emerald-700">{{ $item->kategori ?: 'Umum' }}</span>
                <time datetime="{{ $item->published_at?->toDateString() }}">{{ $item->published_at?->copy()->timezone('Asia/Makassar')->format('d/m/Y') }}</time>
            </div>
            <h2 class="mt-4 line-clamp-2 text-lg font-extrabold leading-7 text-slate-900">{{ $item->judul }}</h2>
            <p class="mt-3 line-clamp-3 text-sm leading-6 text-slate-600">{{ $item->ringkasan }}</p>
            <span class="mt-6 inline-flex text-sm font-bold text-emerald-700">Baca pengumuman →</span>
        </div>
    </a>
</article>
