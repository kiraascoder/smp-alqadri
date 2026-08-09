@extends('components.admin')
@section('title', 'Jenis Pelanggaran')
@section('content')
    <div class="py-8 space-y-6">
        <div>
            <h1 class="text-3xl font-bold">Jenis Pelanggaran</h1>
            <p class="text-slate-500 mt-1">Referensi pelanggaran dan skor yang berlaku.</p>
        </div>
        <div class="bg-white border rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="p-4 text-left">Kategori</th>
                            <th class="p-4 text-left">Pelanggaran</th>
                            <th class="p-4 text-left">Skor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pelanggarans as $item)
                            <tr class="border-t">
                                <td class="p-4 capitalize">{{ $item->kategori }}</td>
                                <td class="p-4">{{ $item->deskripsi }}</td>
                                <td class="p-4 font-semibold">{{ $item->skor }}</td>
                        </tr>@empty<tr>
                                <td colspan="3" class="p-8 text-center text-slate-500">Belum ada jenis pelanggaran.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4">{{ $pelanggarans->links() }}</div>
        </div>
    </div>
@endsection
