@extends('components.admin')

@section('title', 'Jenis Pelanggaran')

@section('content')
<div class="py-8 space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-slate-900">Jenis Pelanggaran</h1>
        <p class="mt-1 text-slate-500">Daftar kategori dan bobot poin pelanggaran sekolah.</p>
    </div>

    <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="p-4 text-left font-semibold text-slate-700">Kategori</th>
                        <th class="p-4 text-left font-semibold text-slate-700">Jenis Pelanggaran</th>
                        <th class="p-4 text-center font-semibold text-slate-700">Poin</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pelanggarans as $item)
                        <tr class="border-t border-slate-100 hover:bg-slate-50">
                            <td class="p-4 whitespace-nowrap">
                                @php
                                    $badge = match($item->kategori) {
                                        'Ringan' => 'bg-emerald-100 text-emerald-700',
                                        'Sedang' => 'bg-amber-100 text-amber-700',
                                        'Sangat Berat' => 'bg-red-100 text-red-700',
                                        default => 'bg-slate-100 text-slate-700',
                                    };
                                @endphp
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-medium {{ $badge }}">
                                    {{ $item->kategori }}
                                </span>
                            </td>
                            <td class="p-4 text-slate-700">{{ $item->deskripsi }}</td>
                            <td class="p-4 text-center font-bold text-red-600">{{ $item->skor }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="p-10 text-center text-slate-500">Belum ada data pelanggaran.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($pelanggarans->hasPages())
            <div class="border-t border-slate-200 p-4">{{ $pelanggarans->links() }}</div>
        @endif
    </section>
</div>
@endsection
