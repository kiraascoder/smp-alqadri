@extends('components.admin')
@section('title', 'Master Kelas')
@section('content')
<div class="py-8 space-y-6">
    <div><h1 class="text-3xl font-bold">Master Kelas</h1><p class="text-slate-500 mt-1">Kelas harus tersedia sebelum data siswa dibuat.</p></div>
    @if(session('success'))<div class="rounded-xl bg-emerald-50 p-4 text-emerald-700">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="rounded-xl bg-red-50 p-4 text-red-700">{{ session('error') }}</div>@endif
    @if($errors->any())<div class="rounded-xl bg-red-50 p-4 text-red-700">{{ $errors->first() }}</div>@endif

    <section class="bg-white rounded-2xl border shadow-sm p-6">
        <form method="POST" action="{{ route('admin.kelas.store') }}" class="flex flex-col sm:flex-row gap-3">@csrf
            <input name="nama_kelas" value="{{ old('nama_kelas') }}" required class="flex-1 border rounded-xl px-4 py-3" placeholder="Contoh: VII A">
            <button class="bg-blue-700 text-white rounded-xl px-6 py-3 font-semibold">Tambah Kelas</button>
        </form>
    </section>

    <section class="bg-white rounded-2xl border shadow-sm overflow-hidden">
        <table class="w-full text-sm"><thead class="bg-slate-50"><tr><th class="p-4 text-left">Nama Kelas</th><th class="p-4 text-left">Jumlah Siswa</th><th class="p-4 text-center">Aksi</th></tr></thead><tbody>
        @forelse($kelasList as $kelas)
            <tr class="border-t"><td class="p-4 font-medium">{{ $kelas->nama_kelas }}</td><td class="p-4">{{ $kelas->siswa_count }}</td><td class="p-4"><div class="flex justify-center gap-3" x-data="{edit:false}"><button type="button" @click="edit=true" class="text-blue-700">Edit</button><form method="POST" action="{{ route('admin.kelas.delete',$kelas) }}" onsubmit="return confirm('Hapus kelas ini?')">@csrf @method('DELETE')<button class="text-red-600">Hapus</button></form><div x-show="edit" x-cloak class="fixed inset-0 z-[70] flex items-center justify-center bg-black/40 p-4"><form @click.outside="edit=false" method="POST" action="{{ route('admin.kelas.update',$kelas) }}" class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl">@csrf @method('PUT')<h3 class="font-semibold text-lg mb-4 text-left">Edit Kelas</h3><input name="nama_kelas" value="{{ $kelas->nama_kelas }}" required class="w-full border rounded-xl px-4 py-3"><div class="flex gap-3 mt-4"><button type="button" @click="edit=false" class="flex-1 border rounded-xl py-3">Batal</button><button class="flex-1 bg-blue-700 text-white rounded-xl py-3">Simpan</button></div></form></div></div></td></tr>
        @empty<tr><td colspan="3" class="p-8 text-center text-slate-500">Belum ada kelas.</td></tr>@endforelse
        </tbody></table>
        <div class="p-4">{{ $kelasList->links() }}</div>
    </section>
</div>
@endsection
