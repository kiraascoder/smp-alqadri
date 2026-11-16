@extends('components.admin')
@section('title', 'Struktur Organisasi')
@section('content')
<div class="py-8 space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Struktur Organisasi Sekolah</h1>
            <p class="text-slate-500 mt-1">Kelola jabatan dan personel yang ditampilkan kepada publik.</p>
        </div>
        <a href="{{ route('struktur.index') }}" target="_blank" rel="noopener"
           class="px-5 py-3 rounded-xl bg-emerald-600 text-white font-semibold hover:bg-emerald-700 text-center">
            Lihat halaman publik
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-100">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="p-4 rounded-xl bg-red-50 text-red-800 border border-red-100">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="p-4 rounded-xl bg-red-50 text-red-800 border border-red-100">
            <strong>Periksa isian:</strong> {{ $errors->first() }}
        </div>
    @endif

    <section class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
        <h2 class="text-lg font-semibold mb-1">Tambah Jabatan atau Kelompok</h2>
        <p class="text-sm text-slate-500 mb-5">Induk jabatan menentukan garis hirarki. Kosongkan untuk jabatan tingkat teratas.</p>
        <form method="POST" action="{{ route('admin.struktur.positions.store') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
            @csrf
            <label class="block text-sm font-medium">Nama jabatan / kelompok
                <input required name="title" value="{{ old('title') }}" maxlength="150" placeholder="Contoh: Kepala Sekolah"
                       class="mt-2 block w-full rounded-xl border border-slate-300 px-4 py-3">
            </label>
            <label class="block text-sm font-medium">Induk jabatan
                <select name="parent_id" class="mt-2 block w-full rounded-xl border border-slate-300 px-4 py-3">
                    <option value="">Tingkat teratas</option>
                    @foreach($positions as $p)
                        <option value="{{ $p->id }}" @selected(old('parent_id') == $p->id)>{{ $p->title }} (ID {{ $p->id }})</option>
                    @endforeach
                </select>
            </label>
            <label class="block text-sm font-medium">Urutan
                <input type="number" min="0" max="99999" name="sort_order" value="{{ old('sort_order', 0) }}"
                       class="mt-2 block w-full rounded-xl border border-slate-300 px-4 py-3">
            </label>
            <div class="flex flex-col gap-2 text-sm">
                <label><input name="is_active" type="checkbox" value="1" checked class="rounded"> Publikasikan jabatan</label>
                <label><input name="show_homepage" type="checkbox" value="1" class="rounded"> Tampilkan di homepage</label>
                <button class="rounded-xl bg-blue-700 hover:bg-blue-800 text-white px-5 py-3 font-semibold">Tambah Jabatan</button>
            </div>
        </form>
    </section>

    <section class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
        <h2 class="text-lg font-semibold mb-4">Daftar Jabatan ({{ $positions->count() }})</h2>
        <div class="space-y-3">
            @forelse($positions as $p)
                <details class="rounded-xl border border-slate-200 p-4 group">
                    <summary class="cursor-pointer flex flex-wrap justify-between gap-3 items-center list-none">
                        <div>
                            <span class="font-semibold text-slate-800">{{ $p->title }}</span>
                            <span class="block text-xs text-slate-500 mt-1">Induk: {{ $p->parent?->title ?? 'Tingkat teratas' }} · Urutan: {{ $p->sort_order }} · {{ $p->members->count() }} personel</span>
                        </div>
                        <div class="flex gap-2 text-xs">
                            <span class="rounded-full px-3 py-1 {{ $p->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">{{ $p->is_active ? 'Terbit' : 'Draft' }}</span>
                            @if($p->show_homepage)<span class="rounded-full px-3 py-1 bg-blue-50 text-blue-700">Homepage</span>@endif
                            <span class="text-blue-700">Edit</span>
                        </div>
                    </summary>
                    <form method="POST" action="{{ route('admin.struktur.positions.update', $p) }}" class="mt-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 items-end">
                        @csrf @method('PUT')
                        <label class="text-sm">Nama jabatan
                            <input name="title" required maxlength="150" value="{{ $p->title }}" class="mt-1 w-full border rounded-xl px-4 py-3">
                        </label>
                        <label class="text-sm">Induk
                            <select name="parent_id" class="mt-1 w-full border rounded-xl px-4 py-3">
                                <option value="">Tingkat teratas</option>
                                @foreach($positions as $parent)
                                    @if($parent->id !== $p->id)
                                        <option value="{{ $parent->id }}" @selected($p->parent_id == $parent->id)>{{ $parent->title }} ({{ $parent->id }})</option>
                                    @endif
                                @endforeach
                            </select>
                        </label>
                        <label class="text-sm">Urutan
                            <input type="number" name="sort_order" min="0" max="99999" required value="{{ $p->sort_order }}" class="mt-1 w-full border rounded-xl px-4 py-3">
                        </label>
                        <div class="space-y-2 text-sm">
                            <label class="block"><input type="checkbox" name="is_active" value="1" @checked($p->is_active)> Publikasikan</label>
                            <label class="block"><input type="checkbox" name="show_homepage" value="1" @checked($p->show_homepage)> Homepage</label>
                            <button class="w-full rounded-xl bg-blue-700 text-white px-3 py-2.5">Simpan Jabatan</button>
                        </div>
                    </form>
                    <form method="POST" action="{{ route('admin.struktur.positions.destroy', $p) }}" class="mt-3" onsubmit="return confirm('Hapus jabatan ini? Hanya bisa jika tidak punya anak jabatan/personel.')">
                        @csrf @method('DELETE')
                        <button class="text-sm text-red-700 font-medium">Hapus Jabatan</button>
                    </form>
                </details>
            @empty
                <p class="text-slate-500">Belum ada jabatan. Tambahkan jabatan atau jalankan seeder contoh pada database development.</p>
            @endforelse
        </div>
    </section>

    <section class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
        <h2 class="text-lg font-semibold mb-1">Tambah Personel</h2>
        <p class="text-sm text-slate-500 mb-5">Satu orang boleh ditambahkan pada beberapa jabatan. Foto opsional.</p>
        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.struktur.members.store') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @csrf
            <label class="text-sm">Jabatan
                <select name="school_position_id" required class="mt-2 block w-full border rounded-xl px-4 py-3">
                    <option value="">Pilih jabatan</option>
                    @foreach($positions as $p)<option value="{{ $p->id }}" @selected(old('school_position_id') == $p->id)>{{ $p->title }}</option>@endforeach
                </select>
            </label>
            <label class="text-sm">Nama lengkap
                <input name="name" required maxlength="150" value="{{ old('name') }}" placeholder="Nama petugas / guru" class="mt-2 block w-full border rounded-xl px-4 py-3">
            </label>
            <label class="text-sm">Gelar / keterangan singkat (opsional)
                <input name="subtitle" maxlength="180" value="{{ old('subtitle') }}" placeholder="S.Pd., Gr." class="mt-2 block w-full border rounded-xl px-4 py-3">
            </label>
            <label class="text-sm">Foto (jpg/png/webp maks. 2 MB)
                <input type="file" accept="image/png,image/jpeg,image/webp" name="photo" class="mt-2 block w-full border rounded-xl px-4 py-3">
            </label>
            <label class="text-sm">Urutan personel
                <input type="number" name="sort_order" min="0" max="99999" value="{{ old('sort_order', 0) }}" required class="mt-2 block w-full border rounded-xl px-4 py-3">
            </label>
            <div class="flex flex-col justify-end gap-3">
                <label class="text-sm"><input name="is_active" type="checkbox" value="1" checked> Publikasikan personel</label>
                <button class="rounded-xl bg-blue-700 hover:bg-blue-800 text-white px-5 py-3 font-semibold">Tambah Personel</button>
            </div>
        </form>
    </section>

    <section class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
        <h2 class="text-lg font-semibold mb-4">Daftar Personel</h2>
        <div class="space-y-3">
            @forelse($members as $person)
                <details class="rounded-xl border border-slate-200 p-4">
                    <summary class="cursor-pointer flex items-center justify-between gap-3 list-none">
                        <div class="flex items-center gap-3">
                            @if($person->photo_path)
                                <img src="{{ asset('storage/'.$person->photo_path) }}" alt="" class="w-12 h-12 rounded-full object-cover">
                            @else
                                <span class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-semibold">{{ mb_substr($person->name, 0, 1) }}</span>
                            @endif
                            <div>
                                <p class="font-semibold text-slate-800">{{ $person->name }}</p>
                                <p class="text-xs text-slate-500">{{ $person->position?->title }} · {{ $person->is_active ? 'Terbit' : 'Draft' }}</p>
                            </div>
                        </div>
                        <span class="text-blue-700 text-sm">Edit</span>
                    </summary>
                    <form method="POST" enctype="multipart/form-data" action="{{ route('admin.struktur.members.update', $person) }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 mt-5 items-end">
                        @csrf @method('PUT')
                        <label class="text-sm">Jabatan
                            <select name="school_position_id" required class="mt-1 w-full border rounded-xl px-4 py-3">
                                @foreach($positions as $p)<option value="{{ $p->id }}" @selected($p->id === $person->school_position_id)>{{ $p->title }}</option>@endforeach
                            </select>
                        </label>
                        <label class="text-sm">Nama
                            <input name="name" required maxlength="150" value="{{ $person->name }}" class="mt-1 w-full border rounded-xl px-4 py-3">
                        </label>
                        <label class="text-sm">Gelar / keterangan
                            <input name="subtitle" maxlength="180" value="{{ $person->subtitle }}" class="mt-1 w-full border rounded-xl px-4 py-3">
                        </label>
                        <label class="text-sm">Foto baru
                            <input type="file" name="photo" accept="image/png,image/jpeg,image/webp" class="mt-1 w-full border rounded-xl px-4 py-3">
                        </label>
                        <label class="text-sm">Urutan
                            <input type="number" name="sort_order" min="0" max="99999" value="{{ $person->sort_order }}" required class="mt-1 w-full border rounded-xl px-4 py-3">
                        </label>
                        <div class="space-y-2 text-sm">
                            <label class="block"><input type="checkbox" name="is_active" value="1" @checked($person->is_active)> Publikasikan</label>
                            <label class="block"><input type="checkbox" name="remove_photo" value="1"> Hapus foto lama</label>
                            <button class="w-full rounded-xl bg-blue-700 text-white py-2.5">Simpan Personel</button>
                        </div>
                    </form>
                    <form method="POST" action="{{ route('admin.struktur.members.destroy', $person) }}" onsubmit="return confirm('Hapus personel dari struktur?')" class="mt-3">
                        @csrf @method('DELETE')
                        <button class="text-red-700 text-sm font-medium">Hapus Personel</button>
                    </form>
                </details>
            @empty
                <p class="text-slate-500">Belum ada personel.</p>
            @endforelse
        </div>
        <div class="mt-5">{{ $members->links() }}</div>
    </section>
</div>
@endsection
