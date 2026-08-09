@extends('components.admin')
@section('title', 'Data Siswa')
@section('content')
<div class="py-8 space-y-6">
    <div><h1 class="text-3xl font-bold">Data Siswa</h1><p class="text-slate-500 mt-1">Siswa adalah data akademik dan tidak memiliki akun login.</p></div>
    @if(session('success'))<div class="p-4 bg-emerald-50 text-emerald-700 rounded-xl">{{ session('success') }}</div>@endif
    @if($errors->any())<div class="p-4 bg-red-50 text-red-700 rounded-xl">{{ $errors->first() }}</div>@endif

    <section class="bg-white rounded-2xl border shadow-sm p-6">
        <h2 class="font-semibold text-lg mb-4">Tambah Siswa</h2>
        <form method="POST" action="{{ route('admin.siswa.register') }}" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">@csrf
            <input name="nama" value="{{ old('nama') }}" required class="border rounded-xl px-4 py-3" placeholder="Nama siswa">
            <select name="kelas_id" required class="border rounded-xl px-4 py-3"><option value="">Pilih kelas</option>@foreach($kelasList as $kelas)<option value="{{ $kelas->id }}" @selected(old('kelas_id')==$kelas->id)>{{ $kelas->nama_kelas }}</option>@endforeach</select>
            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required class="border rounded-xl px-4 py-3">
            <select name="orang_tua_id" class="border rounded-xl px-4 py-3"><option value="">Belum ditautkan</option>@foreach($orangTuaList as $ortu)<option value="{{ $ortu->id }}" @selected(old('orang_tua_id')==$ortu->id)>{{ $ortu->user?->name }}</option>@endforeach</select>
            <button class="md:col-span-2 xl:col-span-4 bg-blue-700 text-white rounded-xl py-3 font-semibold">Tambah Siswa</button>
        </form>
    </section>

    <section class="bg-white rounded-2xl border shadow-sm overflow-hidden">
        <div class="overflow-x-auto"><table class="w-full text-sm"><thead class="bg-slate-50"><tr><th class="p-4 text-left">Nama</th><th class="p-4 text-left">Kelas</th><th class="p-4 text-left">Tanggal Lahir</th><th class="p-4 text-left">Orang Tua</th><th class="p-4 text-left">Skor</th><th class="p-4 text-center">Aksi</th></tr></thead><tbody>
        @forelse($siswas as $item)
            <tr class="border-t"><td class="p-4 font-medium">{{ $item->nama }}</td><td class="p-4">{{ $item->kelas?->nama_kelas }}</td><td class="p-4">{{ $item->tanggal_lahir?->format('d/m/Y') }}</td><td class="p-4">{{ $item->orangTua?->user?->name ?? '-' }}</td><td class="p-4 font-semibold text-red-600">{{ $item->score_bk }}</td><td class="p-4"><div class="flex justify-center gap-3" x-data="{edit:false}"><button type="button" @click="edit=true" class="text-blue-700">Edit</button><form method="POST" action="{{ route('admin.siswa.delete',$item->id) }}" onsubmit="return confirm('Hapus siswa ini beserta riwayat skorsingnya?')">@csrf @method('DELETE')<button class="text-red-600">Hapus</button></form>
            <div x-show="edit" x-cloak class="fixed inset-0 z-[70] flex items-center justify-center bg-black/40 p-4"><form @click.outside="edit=false" method="POST" action="{{ route('admin.siswa.update',$item->id) }}" class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-xl text-left">@csrf @method('PUT')<div class="flex justify-between mb-4"><h3 class="font-semibold text-lg">Edit Siswa</h3><button type="button" @click="edit=false">✕</button></div><div class="space-y-4"><input name="nama" value="{{ $item->nama }}" required class="w-full border rounded-xl px-4 py-3"><select name="kelas_id" required class="w-full border rounded-xl px-4 py-3">@foreach($kelasList as $kelas)<option value="{{ $kelas->id }}" @selected($item->kelas_id==$kelas->id)>{{ $kelas->nama_kelas }}</option>@endforeach</select><input type="date" name="tanggal_lahir" value="{{ $item->tanggal_lahir?->format('Y-m-d') }}" required class="w-full border rounded-xl px-4 py-3"><select name="orang_tua_id" class="w-full border rounded-xl px-4 py-3"><option value="">Belum ditautkan</option>@foreach($orangTuaList as $ortu)<option value="{{ $ortu->id }}" @selected($item->orang_tua_id==$ortu->id)>{{ $ortu->user?->name }}</option>@endforeach</select><button class="w-full bg-blue-700 text-white rounded-xl py-3">Simpan Perubahan</button></div></form></div></div></td></tr>
        @empty<tr><td colspan="6" class="p-8 text-center text-slate-500">Belum ada siswa.</td></tr>@endforelse
        </tbody></table></div><div class="p-4">{{ $siswas->links() }}</div>
    </section>
</div>
@endsection
