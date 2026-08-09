@extends('components.admin')

@section('title', 'Jenis Kebajikan')

@section('content')
<div class="py-8 space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-slate-900">Jenis Kebajikan</h1>
        <p class="mt-1 text-slate-500">Kelola bentuk kebajikan/prestasi dan bobot poin positif peserta didik.</p>
    </div>

    @if (session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-5">
            <h2 class="text-lg font-semibold text-slate-900">Tambah Jenis Kebajikan</h2>
            <p class="text-sm text-slate-500">Master ini akan menjadi pilihan guru saat memberikan poin kebajikan.</p>
        </div>

        <form method="POST" action="{{ route('admin.kebajikan.store') }}" class="grid grid-cols-1 gap-4 md:grid-cols-4">
            @csrf

            <div class="md:col-span-3">
                <label class="mb-2 block text-sm font-medium text-slate-700">Bentuk Kebajikan / Prestasi</label>
                <input type="text" name="deskripsi" value="{{ old('deskripsi') }}" required
                    placeholder="Contoh: Membantu guru tanpa diminta"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">Poin</label>
                <input type="number" min="1" name="skor" value="{{ old('skor') }}" required
                    placeholder="5"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="md:col-span-4 flex justify-end">
                <button type="submit" class="rounded-xl bg-blue-700 px-6 py-3 font-medium text-white hover:bg-blue-800">
                    Tambah Jenis Kebajikan
                </button>
            </div>
        </form>
    </section>

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-6 py-5">
            <h2 class="text-lg font-semibold text-slate-900">Daftar Kebajikan</h2>
            <p class="text-sm text-slate-500">Poin master dapat diubah tanpa mengubah snapshot poin pada riwayat lama.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="p-4 text-left font-semibold text-slate-700">Bentuk Kebajikan / Prestasi</th>
                        <th class="w-28 p-4 text-center font-semibold text-slate-700">Poin</th>
                        <th class="w-32 p-4 text-center font-semibold text-slate-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kebajikans as $item)
                        <tr class="border-t border-slate-100 hover:bg-slate-50">
                            <td class="p-4 text-slate-700">{{ $item->deskripsi }}</td>
                            <td class="p-4 text-center">
                                <span class="inline-flex min-w-[54px] justify-center rounded-full bg-emerald-100 px-3 py-1 font-bold text-emerald-700">
                                    +{{ $item->skor }}
                                </span>
                            </td>
                            <td class="p-4">
                                <div class="flex justify-center gap-3" x-data="{ edit: false }">
                                    <button type="button" @click="edit = true" class="font-medium text-blue-700 hover:text-blue-900">Edit</button>

                                    <form method="POST" action="{{ route('admin.kebajikan.delete', $item) }}"
                                        onsubmit="return confirm('Hapus jenis kebajikan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-medium text-red-600 hover:text-red-800">Hapus</button>
                                    </form>

                                    <div x-show="edit" x-cloak x-transition
                                        class="fixed inset-0 z-[70] flex items-center justify-center bg-black/50 p-4">
                                        <div @click.outside="edit = false" class="w-full max-w-lg rounded-2xl bg-white p-6 text-left shadow-xl">
                                            <form method="POST" action="{{ route('admin.kebajikan.update', $item) }}" class="space-y-4">
                                                @csrf
                                                @method('PUT')

                                                <div class="flex items-start justify-between gap-4">
                                                    <div>
                                                        <h3 class="text-lg font-semibold text-slate-900">Edit Jenis Kebajikan</h3>
                                                        <p class="text-sm text-slate-500">Perbarui deskripsi atau poin master.</p>
                                                    </div>
                                                    <button type="button" @click="edit = false" class="text-2xl leading-none text-slate-400 hover:text-slate-700">&times;</button>
                                                </div>

                                                <div>
                                                    <label class="mb-2 block text-sm font-medium text-slate-700">Bentuk Kebajikan / Prestasi</label>
                                                    <textarea name="deskripsi" rows="4" required
                                                        class="w-full resize-none rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-500">{{ $item->deskripsi }}</textarea>
                                                </div>

                                                <div>
                                                    <label class="mb-2 block text-sm font-medium text-slate-700">Poin</label>
                                                    <input type="number" min="1" name="skor" value="{{ $item->skor }}" required
                                                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                                                </div>

                                                <p class="text-xs text-slate-500">Perubahan poin master tidak mengubah poin pada riwayat kebajikan yang sudah tercatat.</p>

                                                <div class="flex gap-3 pt-2">
                                                    <button type="button" @click="edit = false" class="flex-1 rounded-xl border border-slate-300 py-3 text-slate-700 hover:bg-slate-50">Batal</button>
                                                    <button type="submit" class="flex-1 rounded-xl bg-blue-700 py-3 text-white hover:bg-blue-800">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-10 text-center text-slate-500">Belum ada master kebajikan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($kebajikans->hasPages())
            <div class="border-t border-slate-200 p-4">{{ $kebajikans->links() }}</div>
        @endif
    </section>
</div>
@endsection
