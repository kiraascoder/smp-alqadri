@extends('components.admin')
@section('title', 'Jenis Pelanggaran')
@section('content')
    <div class="py-8 space-y-6">
        <div>
            <h1 class="text-3xl font-bold">Jenis Pelanggaran</h1>
            <p class="text-gray-500">Referensi pelanggaran dan skor.</p>
        </div>
        <div class="bg-white rounded-2xl shadow overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-4 text-left">Kategori</th>
                        <th class="p-4 text-left">Deskripsi</th>
                        <th class="p-4 text-left">Skor</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelanggarans as $p)
                        <tr class="border-t">
                            <td class="p-4 capitalize">{{ $p->kategori }}</td>
                            <td class="p-4">{{ $p->deskripsi }}</td>
                            <td class="p-4 font-semibold">{{ $p->skor }}</td>
                    </tr>@empty<tr>
                            <td colspan="3" class="p-8 text-center text-gray-500">Belum ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="p-4">{{ $pelanggarans->links() }}</div>
        </div>
    </div>
@endsection
