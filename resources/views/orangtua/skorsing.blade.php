@extends('components.admin')
@section('title', 'Skorsing Anak')
@section('content')
    <div class="py-8 space-y-6">
        <div>
            <h1 class="text-3xl font-bold">Riwayat Skorsing Anak</h1>
            <p class="text-slate-500 mt-1">Halaman ini hanya menampilkan skorsing dari anak yang terhubung dengan akun Anda.
            </p>
        </div>
        <div class="bg-white border rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="p-4 text-left">Tanggal</th>
                            <th class="p-4 text-left">Anak</th>
                            <th class="p-4 text-left">Kelas</th>
                            <th class="p-4 text-left">Pelanggaran</th>
                            <th class="p-4 text-left">Skor</th>
                            <th class="p-4 text-left">Keterangan</th>
                            <th class="p-4 text-left">Dibuat Oleh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat as $item)
                            <tr class="border-t">
                                <td class="p-4 whitespace-nowrap">{{ $item->tanggal?->format('d/m/Y') }}</td>
                                <td class="p-4 font-medium">{{ $item->siswa?->nama }}</td>
                                <td class="p-4">{{ $item->siswa?->kelas?->nama_kelas }}</td>
                                <td class="p-4">{{ $item->pelanggaran?->deskripsi }}</td>
                                <td class="p-4">+{{ $item->skor }}</td>
                                <td class="p-4">{{ $item->keterangan ?: '-' }}</td>
                                <td class="p-4">{{ $item->creator?->name ?? '-' }}</td>
                        </tr>@empty<tr>
                                <td colspan="7" class="p-8 text-center text-slate-500">Belum ada riwayat skorsing.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4">{{ $riwayat->links() }}</div>
        </div>
    </div>
@endsection
