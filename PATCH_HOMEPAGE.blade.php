{{-- Tempelkan pada resources/views/welcome.blade.php di bagian yang diinginkan,
     SEBELUM footer (jangan hapus isi homepage lama). --}}
<section id="berita" class="bg-slate-50 py-16">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">
        <div class="mb-8 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wider text-emerald-700">Kabar Terbaru</p>
                <h2 class="mt-2 text-3xl font-bold text-slate-900">Berita SMP Al-Qadri</h2>
                <p class="mt-2 text-slate-500">Kegiatan, prestasi, dan informasi terbaru dari sekolah.</p>
            </div>
            <a href="{{ route('berita.index') }}" class="font-semibold text-emerald-700 hover:underline">Semua Berita →</a>
        </div>
        @if($beritaTerbaru->isNotEmpty())
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($beritaTerbaru as $item)
                    @include('berita._card', ['item' => $item])
                @endforeach
            </div>
        @else
            <div class="rounded-2xl border border-slate-200 bg-white px-6 py-10 text-center text-slate-500">
                Berita terbaru akan tampil di sini setelah diterbitkan oleh admin.
            </div>
        @endif
    </div>
</section>
