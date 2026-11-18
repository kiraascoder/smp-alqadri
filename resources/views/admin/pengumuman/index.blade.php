@extends('components.admin')
@section('title', 'Pengumuman Sekolah')
@section('content')
<div class="space-y-6 py-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Pengumuman Sekolah</h1>
            <p class="mt-1 text-sm text-slate-500">Kelola informasi resmi, jadwal, dan pemberitahuan sekolah.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('pengumuman') }}" target="_blank" rel="noopener"
               class="rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">Lihat Publik</a>
            <a href="{{ route('admin.pengumuman.create') }}"
               class="rounded-xl bg-blue-700 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-800">+ Buat Pengumuman</a>
        </div>
    </div>

    @if(session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">{{ $errors->first() }}</div>
    @endif

    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <form action="{{ route('admin.pengumuman.index') }}" method="GET" class="flex flex-col gap-3 sm:flex-row">
            <input name="search" type="search" maxlength="100" value="{{ $search }}"
                   placeholder="Cari judul atau kategori pengumuman..."
                   class="min-w-0 flex-1 rounded-xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500">
            <select name="status" class="rounded-xl border border-slate-300 px-4 py-3 text-sm">
                <option value="">Semua status</option>
                <option value="draft" @selected($status === 'draft')>Draft</option>
                <option value="published" @selected($status === 'published')>Terbit</option>
            </select>
            <button class="rounded-xl bg-blue-700 px-6 py-3 text-sm font-semibold text-white hover:bg-blue-800">Cari</button>
            @if($search !== '' || $status !== '')
                <a href="{{ route('admin.pengumuman.index') }}" class="rounded-xl bg-slate-100 px-6 py-3 text-center text-sm font-semibold">Reset</a>
            @endif
        </form>
    </section>

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px] text-left text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="p-4">Pengumuman</th>
                        <th class="p-4">Kategori</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Publikasi</th>
                        <th class="p-4">Berakhir</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengumumanList as $item)
                        <tr class="border-t border-slate-100 align-middle hover:bg-slate-50">
                            <td class="p-4">
                                <div class="flex min-w-[260px] items-center gap-3">
                                    @if($item->gambar)
                                        <img src="{{ Storage::disk('public')->url($item->gambar) }}" alt="" loading="lazy" class="h-16 w-20 rounded-xl object-cover">
                                    @else
                                        <div class="flex h-16 w-20 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-xl text-emerald-700">📢</div>
                                    @endif
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $item->judul }}</p>
                                        <p class="mt-1 text-xs text-slate-500">{{ Str::limit($item->ringkasan, 92) }}</p>
                                        @if($item->is_pinned)
                                            <span class="mt-1 inline-block text-xs font-semibold text-amber-700">Prioritas penting</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 text-slate-600">{{ $item->kategori ?: 'Umum' }}</td>
                            <td class="p-4">
                                @if($item->status === 'draft')
                                    <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">Draft</span>
                                @elseif(!$item->isVisible())
                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">Tidak aktif</span>
                                @else
                                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">Terbit</span>
                                @endif
                            </td>
                            <td class="p-4 text-slate-500">{{ $item->published_at?->copy()->timezone('Asia/Makassar')->format('d/m/Y H:i') ?? '-' }}</td>
                            <td class="p-4 text-slate-500">{{ $item->expires_on?->format('d/m/Y') ?? 'Tanpa batas' }}</td>
                            <td class="p-4">
                                <div class="flex justify-end gap-3">
                                    @if($item->isVisible())
                                        <a href="{{ route('pengumuman.show', $item->slug) }}" target="_blank" rel="noopener" class="font-medium text-emerald-700">Lihat</a>
                                    @endif
                                    <a href="{{ route('admin.pengumuman.edit', $item) }}" class="font-medium text-blue-700">Edit</a>
                                    <form action="{{ route('admin.pengumuman.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus pengumuman dan seluruh berkasnya?')">
                                        @csrf @method('DELETE')
                                        <button class="font-medium text-red-600">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="p-12 text-center text-slate-500">Belum ada pengumuman yang sesuai.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-100 p-4">{{ $pengumumanList->links() }}</div>
    </section>
</div>
@endsection
