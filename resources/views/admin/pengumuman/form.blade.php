@extends('components.admin')
@section('title', $pengumuman->exists ? 'Edit Pengumuman' : 'Tambah Pengumuman')
@section('content')
@php
    $editing = $pengumuman->exists;
    $formAction = $editing
        ? route('admin.pengumuman.update', $pengumuman)
        : route('admin.pengumuman.store');
@endphp
<div class="mx-auto max-w-5xl space-y-6 py-8">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <a href="{{ route('admin.pengumuman.index') }}" class="text-sm font-semibold text-blue-700 hover:underline">← Daftar Pengumuman</a>
            <h1 class="mt-3 text-3xl font-bold text-slate-900">{{ $editing ? 'Edit Pengumuman' : 'Buat Pengumuman Baru' }}</h1>
            <p class="mt-1 text-sm text-slate-500">Pengumuman resmi sekolah. Draft tidak akan terlihat oleh pengunjung.</p>
        </div>
    </div>

    @if($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 p-5 text-sm text-red-700">
            <p class="font-semibold">Mohon perbaiki:</p>
            <ul class="mt-2 list-disc space-y-1 pl-5">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ $formAction }}" enctype="multipart/form-data"
          class="space-y-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        @csrf
        @if($editing) @method('PUT') @endif
        <div class="grid gap-5 sm:grid-cols-2">
            <label class="block text-sm font-semibold text-slate-700 sm:col-span-2">
                Judul Pengumuman <span class="text-red-600">*</span>
                <input name="judul" required maxlength="180" value="{{ old('judul', $pengumuman->judul) }}"
                       placeholder="Contoh: Jadwal Penilaian Akhir Semester"
                       class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 font-normal focus:ring-2 focus:ring-blue-500">
            </label>

            <label class="block text-sm font-semibold text-slate-700">
                Kategori
                <input name="kategori" maxlength="100" list="kategori-pengumuman"
                       value="{{ old('kategori', $pengumuman->kategori) }}" placeholder="Akademik, Kegiatan, Umum..."
                       class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 font-normal">
                <datalist id="kategori-pengumuman">
                    <option value="Akademik"><option value="Kesiswaan"><option value="Kegiatan">
                    <option value="Administrasi"><option value="Umum">
                </datalist>
            </label>
            <label class="block text-sm font-semibold text-slate-700">
                Status Publikasi <span class="text-red-600">*</span>
                <select name="status" required class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 font-normal">
                    <option value="draft" @selected(old('status', $pengumuman->status ?: 'draft') === 'draft')>Draft — belum terlihat publik</option>
                    <option value="published" @selected(old('status', $pengumuman->status) === 'published')>Terbit — tampil publik</option>
                </select>
            </label>
            <label class="block text-sm font-semibold text-slate-700 sm:col-span-2">
                Ringkasan (opsional)
                <textarea name="ringkasan" rows="2" maxlength="500" placeholder="Ringkasan yang terlihat pada kartu pengumuman..."
                          class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 font-normal">{{ old('ringkasan', $pengumuman->ringkasan) }}</textarea>
                <span class="mt-1 block text-xs font-normal text-slate-500">Jika dikosongkan, sistem mengambil ringkasan otomatis dari isi.</span>
            </label>
            <label class="block text-sm font-semibold text-slate-700 sm:col-span-2">
                Isi Pengumuman <span class="text-red-600">*</span>
                <textarea name="isi" rows="12" required minlength="10"
                          placeholder="Tulis pengumuman resmi sekolah di sini..."
                          class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 font-normal leading-7">{{ old('isi', $pengumuman->isi) }}</textarea>
                <span class="mt-1 block text-xs font-normal text-slate-500">Mendukung paragraf/baris baru; isi ditampilkan aman sebagai teks, bukan HTML.</span>
            </label>
            <label class="block text-sm font-semibold text-slate-700">
                Tanggal Berakhir (opsional)
                <input type="date" name="expires_on"
                       value="{{ old('expires_on', $pengumuman->expires_on?->format('Y-m-d')) }}"
                       class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 font-normal">
                <span class="mt-1 block text-xs font-normal text-slate-500">Pengumuman tetap tampil sampai akhir tanggal ini menurut WITA. Kosongkan jika tanpa batas.</span>
            </label>
            <div class="rounded-xl bg-amber-50 p-4 text-sm text-amber-900">
                <label class="flex items-center gap-3 font-semibold">
                    <input type="checkbox" name="is_pinned" value="1" @checked(old('is_pinned', $pengumuman->is_pinned)) class="rounded text-amber-600">
                    Jadikan Pengumuman Penting
                </label>
                <p class="mt-2 text-xs leading-5">Pengumuman penting berada di urutan teratas selama masih aktif dan diterbitkan.</p>
            </div>
            <label class="block text-sm font-semibold text-slate-700">
                Foto Sampul (JPG/PNG/WEBP, maks. 3 MB)
                <input type="file" name="gambar" accept="image/jpeg,image/png,image/webp"
                       class="mt-2 block w-full rounded-xl border border-slate-300 px-3 py-3 font-normal">
                @if($editing && $pengumuman->gambar)
                    <img src="{{ Storage::disk('public')->url($pengumuman->gambar) }}" alt="Foto sampul saat ini"
                         class="mt-3 h-32 w-full rounded-xl object-cover">
                    <label class="mt-3 flex items-center gap-2 text-xs font-normal">
                        <input type="checkbox" name="hapus_gambar" value="1"> Hapus foto lama
                    </label>
                @endif
            </label>
            <label class="block text-sm font-semibold text-slate-700">
                Lampiran PDF (opsional, maks. 5 MB)
                <input type="file" name="lampiran" accept="application/pdf"
                       class="mt-2 block w-full rounded-xl border border-slate-300 px-3 py-3 font-normal">
                @if($editing && $pengumuman->lampiran)
                    <a href="{{ Storage::disk('public')->url($pengumuman->lampiran) }}"
                       target="_blank" rel="noopener" class="mt-2 block break-all text-xs font-normal text-blue-700 underline">
                        {{ $pengumuman->nama_lampiran ?: 'Lihat lampiran lama' }}
                    </a>
                    <label class="mt-2 flex items-center gap-2 text-xs font-normal">
                        <input type="checkbox" name="hapus_lampiran" value="1"> Hapus lampiran lama
                    </label>
                @endif
            </label>
        </div>
        <div class="flex flex-wrap items-center justify-end gap-3 border-t border-slate-100 pt-6">
            <a href="{{ route('admin.pengumuman.index') }}" class="rounded-xl bg-slate-100 px-6 py-3 font-semibold text-slate-700">Batal</a>
            <button type="submit" class="rounded-xl bg-blue-700 px-6 py-3 font-semibold text-white hover:bg-blue-800">
                {{ $editing ? 'Simpan Perubahan' : 'Simpan Pengumuman' }}
            </button>
        </div>
    </form>
</div>
@endsection
