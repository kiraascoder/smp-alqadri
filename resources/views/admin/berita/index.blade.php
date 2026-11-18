@extends('components.admin')
@section('title', 'Kelola Berita')
@section('content')
<div class="py-8 space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Kelola Berita Sekolah</h1>
            <p class="mt-1 text-slate-500">Publikasikan kegiatan, prestasi, dan informasi sekolah.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('berita.index') }}" target="_blank" rel="noopener"
               class="rounded-xl border border-slate-200 bg-white px-5 py-3 font-semibold text-slate-700 hover:bg-slate-50">
                Lihat Publik
            </a>
            <a href="{{ route('admin.berita.create') }}"
               class="rounded-xl bg-blue-700 px-5 py-3 font-semibold text-white hover:bg-blue-800">
                + Tambah Berita
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-700">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">{{ $errors->first() }}</div>
    @endif

    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <form method="GET" action="{{ route('admin.berita.index') }}" class="flex flex-col gap-3 md:flex-row">
            <input name="search" type="search" maxlength="100" value="{{ $search }}"
                   placeholder="Cari judul atau kategori berita..."
                   class="min-w-0 flex-1 rounded-xl border border-slate-300 px-4 py-3">
            <select name="status" class="rounded-xl border border-slate-300 px-4 py-3">
                <option value="">Semua status</option>
                <option value="draft" @selected($status === 'draft')>Draft</option>
                <option value="published" @selected($status === 'published')>Terbit</option>
            </select>
            <button class="rounded-xl bg-blue-700 px-6 py-3 font-semibold text-white hover:bg-blue-800">Cari</button>
            @if($search !== '' || $status !== '')
                <a href="{{ route('admin.berita.index') }}" class="rounded-xl bg-slate-100 px-6 py-3 text-center font-medium">Reset</a>
            @endif
        </form>
    </section>

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[860px] text-left text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="p-4">Berita</th>
                        <th class="p-4">Kategori</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Tanggal</th>
                        <th class="p-4">Penulis</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($beritaList as $item)
                        <tr class="border-t border-slate-100 align-middle hover:bg-slate-50">
                            <td class="p-4">
                                <div class="flex min-w-[240px] items-center gap-3">
                                    @if($item->gambar)
                                        <img src="{{ Storage::disk('public')->url($item->gambar) }}"
                                             alt="" loading="lazy" class="h-16 w-20 rounded-lg object-cover">
                                    @else
                                        <div class="flex h-16 w-20 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-xs text-slate-400">Tanpa foto</div>
                                    @endif
                                    <div class="max-w-xs">
                                        <p class="font-semibold text-slate-900">{{ $item->judul }}</p>
                                        <p class="mt-1 line-clamp-2 text-xs text-slate-500">{{ Str::limit($item->ringkasan, 100) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4">{{ $item->kategori ?: '-' }}</td>
                            <td class="p-4">
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $item->status === 'published' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                                    {{ $item->status === 'published' ? 'Terbit' : 'Draft' }}
                                </span>
                            </td>
                            <td class="p-4 text-slate-500">
                                {{ $item->published_at?->timezone('Asia/Makassar')->format('d/m/Y H:i') ?? '-' }}
                            </td>
                            <td class="p-4">{{ $item->creator?->name ?? '-' }}</td>
                            <td class="p-4">
                                <div class="flex justify-end gap-3">
                                    @if($item->status === 'published')
                                        <a href="{{ route('berita.show', $item->slug) }}" target="_blank" rel="noopener" class="font-medium text-emerald-700">Lihat</a>
                                    @endif
                                    <a href="{{ route('admin.berita.edit', $item) }}" class="font-medium text-blue-700">Edit</a>
                                    <form method="POST" action="{{ route('admin.berita.destroy', $item) }}" onsubmit="return confirm('Hapus berita ini beserta foto sampulnya?')">
                                        @csrf @method('DELETE')
                                        <button class="font-medium text-red-600">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="p-12 text-center text-slate-500">Belum ada berita yang sesuai.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-100 p-4">{{ $beritaList->links() }}</div>
    </section>
</div>
@endsection
