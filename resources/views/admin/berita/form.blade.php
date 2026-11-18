@extends('components.admin')
@section('title', $berita->exists ? 'Edit Berita' : 'Tambah Berita')
@section('content')
<div class="py-8 space-y-6">
    <div>
        <a href="{{ route('admin.berita.index') }}" class="text-sm font-medium text-blue-700 hover:underline">← Kembali ke daftar berita</a>
        <h1 class="mt-3 text-3xl font-bold text-slate-900">{{ $berita->exists ? 'Edit Berita' : 'Tambah Berita' }}</h1>
        <p class="mt-1 text-slate-500">Berita yang masih Draft tidak akan terlihat oleh pengunjung.</p>
    </div>
    @if($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-red-800">
            <p class="font-semibold">Periksa kembali isian berikut:</p>
            <ul class="mt-2 list-inside list-disc text-sm">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form method="POST" enctype="multipart/form-data"
          action="{{ $berita->exists ? route('admin.berita.update', $berita) : route('admin.berita.store') }}"
          class="space-y-5 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        @csrf
        @if($berita->exists) @method('PUT') @endif

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
            <label class="md:col-span-2 block text-sm font-semibold text-slate-700">Judul Berita
                <input name="judul" value="{{ old('judul', $berita->judul) }}" maxlength="180" required
                       placeholder="Contoh: Siswa SMP Al-Qadri Meraih Prestasi..."
                       class="mt-2 block w-full rounded-xl border border-slate-300 px-4 py-3 font-normal">
            </label>
            <label class="block text-sm font-semibold text-slate-700">Kategori
                <input name="kategori" list="kategori-berita" maxlength="100" value="{{ old('kategori', $berita->kategori) }}"
                       placeholder="Pilih atau ketik kategori"
                       class="mt-2 block w-full rounded-xl border border-slate-300 px-4 py-3 font-normal">
                <datalist id="kategori-berita">
                    <option value="Kegiatan Sekolah"><option value="Prestasi"><option value="Akademik">
                    <option value="Ekstrakurikuler"><option value="Informasi Sekolah">
                </datalist>
            </label>
            <label class="block text-sm font-semibold text-slate-700">Status Publikasi
                <select name="status" required class="mt-2 block w-full rounded-xl border border-slate-300 px-4 py-3 font-normal">
                    <option value="draft" @selected(old('status', $berita->status ?: 'draft') === 'draft')>Simpan sebagai Draft</option>
                    <option value="published" @selected(old('status', $berita->status) === 'published')>Terbitkan sekarang</option>
                </select>
            </label>
            <label class="md:col-span-2 block text-sm font-semibold text-slate-700">Ringkasan (maksimum 500 karakter)
                <textarea name="ringkasan" maxlength="500" rows="3" placeholder="Ringkasan pendek untuk halaman daftar berita..."
                          class="mt-2 block w-full rounded-xl border border-slate-300 px-4 py-3 font-normal">{{ old('ringkasan', $berita->ringkasan) }}</textarea>
                <span class="mt-1 block text-xs font-normal text-slate-500">Jika kosong, ringkasan dibuat otomatis dari isi berita.</span>
            </label>
            <label class="md:col-span-2 block text-sm font-semibold text-slate-700">Isi Berita
                <textarea name="isi" required rows="14" placeholder="Tulis isi lengkap berita di sini. Pisahkan paragraf dengan baris kosong."
                          class="mt-2 block w-full rounded-xl border border-slate-300 px-4 py-3 font-normal leading-7">{{ old('isi', $berita->isi) }}</textarea>
                <span class="mt-1 block text-xs font-normal text-slate-500">Isi berita disimpan sebagai teks biasa untuk keamanan. Paragraf akan dipertahankan pada halaman publik.</span>
            </label>
            <label class="md:col-span-2 block text-sm font-semibold text-slate-700">Foto Sampul (JPG/PNG/WEBP, maks. 3 MB)
                <input name="gambar" type="file" accept="image/jpeg,image/png,image/webp"
                       class="mt-2 block w-full rounded-xl border border-slate-300 px-4 py-3 font-normal">
            </label>
            @if($berita->exists && $berita->gambar)
                <div class="md:col-span-2">
                    <img src="{{ Storage::disk('public')->url($berita->gambar) }}" alt="Foto saat ini"
                         class="h-44 w-auto rounded-xl border object-cover">
                    <label class="mt-2 flex items-center gap-2 text-sm text-slate-600">
                        <input type="checkbox" name="hapus_gambar" value="1"> Hapus foto lama
                    </label>
                </div>
            @endif
        </div>
        <div class="flex flex-wrap items-center justify-end gap-3 border-t border-slate-100 pt-5">
            <a href="{{ route('admin.berita.index') }}" class="rounded-xl bg-slate-100 px-5 py-3 font-semibold text-slate-700">Batal</a>
            <button class="rounded-xl bg-blue-700 px-7 py-3 font-semibold text-white hover:bg-blue-800">
                {{ $berita->exists ? 'Simpan Perubahan' : 'Simpan Berita' }}
            </button>
        </div>
    </form>
</div>
@endsection
