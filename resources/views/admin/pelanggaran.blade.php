@extends('components.admin')

@section('title', 'Jenis Pelanggaran')

@section('content')
    <div class="py-8 space-y-6">

        {{-- Header --}}
        <div>
            <h1 class="text-3xl font-bold text-slate-900">
                Jenis Pelanggaran
            </h1>

            <p class="mt-1 text-slate-500">
                Kelola kategori dan bobot skor pelanggaran peserta didik.
            </p>
        </div>

        {{-- Alert Success --}}
        @if (session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        {{-- Alert Error --}}
        @if (session('error'))
            <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl">
                {{ session('error') }}
            </div>
        @endif

        {{-- Validation --}}
        @if ($errors->any())
            <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        {{-- Form Tambah --}}
        <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">

            <div class="mb-5">
                <h2 class="text-lg font-semibold text-slate-900">
                    Tambah Jenis Pelanggaran
                </h2>

                <p class="text-sm text-slate-500">
                    Tambahkan jenis pelanggaran beserta kategori dan skor pengurangannya.
                </p>
            </div>

            <form method="POST" action="{{ route('admin.pelanggaran.store') }}"
                class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @csrf

                {{-- Kategori --}}
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700">
                        Kategori
                    </label>

                    <select name="kategori" required
                        class="w-full border border-slate-300 rounded-xl px-4 py-3
                           focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Kategori</option>

                        <option value="Ringan" @selected(old('kategori') === 'Ringan')>
                            Ringan
                        </option>

                        <option value="Sedang" @selected(old('kategori') === 'Sedang')>
                            Sedang
                        </option>

                        <option value="Sangat Berat" @selected(old('kategori') === 'Sangat Berat')>
                            Sangat Berat
                        </option>
                    </select>
                </div>


                {{-- Deskripsi --}}
                <div class="md:col-span-2">
                    <label class="block mb-2 text-sm font-medium text-slate-700">
                        Jenis Pelanggaran
                    </label>

                    <input type="text" name="deskripsi" value="{{ old('deskripsi') }}" required
                        class="w-full border border-slate-300 rounded-xl px-4 py-3
                           focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Masukkan deskripsi pelanggaran">
                </div>


                {{-- Skor --}}
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700">
                        Skor
                    </label>

                    <input type="number" min="1" name="skor" value="{{ old('skor') }}" required
                        class="w-full border border-slate-300 rounded-xl px-4 py-3
                           focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Skor">
                </div>


                {{-- Tombol --}}
                <div class="md:col-span-4 flex justify-end">
                    <button type="submit"
                        class="px-6 py-3 bg-blue-700 hover:bg-blue-800
                           text-white font-medium rounded-xl transition">
                        Tambah Jenis Pelanggaran
                    </button>
                </div>

            </form>
        </section>


        {{-- Tabel --}}
        <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="p-4 text-left font-semibold text-slate-700 w-40">
                                Kategori
                            </th>

                            <th class="p-4 text-left font-semibold text-slate-700">
                                Jenis Pelanggaran
                            </th>

                            <th class="p-4 text-center font-semibold text-slate-700 w-24">
                                Skor
                            </th>

                            <th class="p-4 text-center font-semibold text-slate-700 w-32">
                                Aksi
                            </th>
                        </tr>
                    </thead>


                    <tbody>

                        @forelse ($pelanggarans as $item)
                            <tr class="border-b border-slate-100 hover:bg-slate-50">

                                {{-- Kategori --}}
                                <td class="p-4">

                                    @if ($item->kategori === 'Ringan')
                                        <span
                                            class="inline-flex px-3 py-1 rounded-full text-xs font-medium
                                                 bg-emerald-100 text-emerald-700">
                                            Ringan
                                        </span>
                                    @elseif ($item->kategori === 'Sedang')
                                        <span
                                            class="inline-flex px-3 py-1 rounded-full text-xs font-medium
                                                 bg-amber-100 text-amber-700">
                                            Sedang
                                        </span>
                                    @elseif ($item->kategori === 'Sangat Berat')
                                        <span
                                            class="inline-flex px-3 py-1 rounded-full text-xs font-medium
                                                 bg-red-100 text-red-700">
                                            Sangat Berat
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex px-3 py-1 rounded-full text-xs font-medium
                                                 bg-slate-100 text-slate-700">
                                            {{ $item->kategori }}
                                        </span>
                                    @endif

                                </td>


                                {{-- Deskripsi --}}
                                <td class="p-4 text-slate-700">
                                    {{ $item->deskripsi }}
                                </td>


                                {{-- Skor --}}
                                <td class="p-4 text-center">
                                    <span class="font-bold text-red-600">
                                        {{ $item->skor }}
                                    </span>
                                </td>


                                {{-- Aksi --}}
                                <td class="p-4">

                                    <div class="flex items-center justify-center gap-3" x-data="{ edit: false }">

                                        {{-- Edit --}}
                                        <button type="button" @click="edit = true"
                                            class="font-medium text-blue-700 hover:text-blue-900">
                                            Edit
                                        </button>


                                        {{-- Delete --}}
                                        <form method="POST" action="{{ route('admin.pelanggaran.delete', $item) }}"
                                            onsubmit="return confirm('Yakin ingin menghapus jenis pelanggaran ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="font-medium text-red-600 hover:text-red-800">
                                                Hapus
                                            </button>
                                        </form>


                                        {{-- Modal Edit --}}
                                        <div x-show="edit" x-cloak x-transition
                                            class="fixed inset-0 z-[70] flex items-center justify-center
                                               bg-black/50 p-4">

                                            <div @click.outside="edit = false"
                                                class="w-full max-w-lg rounded-2xl bg-white shadow-xl">

                                                <form method="POST"
                                                    action="{{ route('admin.pelanggaran.update', $item) }}"
                                                    class="p-6 text-left">
                                                    @csrf
                                                    @method('PUT')


                                                    {{-- Modal Header --}}
                                                    <div class="flex items-center justify-between mb-6">

                                                        <div>
                                                            <h3 class="text-lg font-semibold text-slate-900">
                                                                Edit Jenis Pelanggaran
                                                            </h3>

                                                            <p class="text-sm text-slate-500">
                                                                Perbarui kategori, deskripsi, atau skor.
                                                            </p>
                                                        </div>


                                                        <button type="button" @click="edit = false"
                                                            class="text-slate-400 hover:text-slate-700 text-2xl">
                                                            &times;
                                                        </button>

                                                    </div>


                                                    <div class="space-y-4">

                                                        {{-- Kategori --}}
                                                        <div>
                                                            <label class="block mb-2 text-sm font-medium text-slate-700">
                                                                Kategori
                                                            </label>

                                                            <select name="kategori" required
                                                                class="w-full border border-slate-300 rounded-xl px-4 py-3
                                                                   focus:ring-2 focus:ring-blue-500">

                                                                <option value="Ringan" @selected($item->kategori === 'Ringan')>
                                                                    Ringan
                                                                </option>

                                                                <option value="Sedang" @selected($item->kategori === 'Sedang')>
                                                                    Sedang
                                                                </option>

                                                                <option value="Sangat Berat" @selected($item->kategori === 'Sangat Berat')>
                                                                    Sangat Berat
                                                                </option>

                                                            </select>
                                                        </div>


                                                        {{-- Deskripsi --}}
                                                        <div>
                                                            <label class="block mb-2 text-sm font-medium text-slate-700">
                                                                Jenis Pelanggaran
                                                            </label>

                                                            <textarea name="deskripsi" required rows="4"
                                                                class="w-full border border-slate-300 rounded-xl px-4 py-3
                                                                   focus:ring-2 focus:ring-blue-500 resize-none">{{ $item->deskripsi }}</textarea>
                                                        </div>


                                                        {{-- Skor --}}
                                                        <div>
                                                            <label class="block mb-2 text-sm font-medium text-slate-700">
                                                                Skor
                                                            </label>

                                                            <input type="number" min="1" name="skor"
                                                                value="{{ $item->skor }}" required
                                                                class="w-full border border-slate-300 rounded-xl px-4 py-3
                                                                   focus:ring-2 focus:ring-blue-500">
                                                        </div>


                                                        <p class="text-xs text-slate-500">
                                                            Perubahan skor master tidak mengubah skor pada riwayat
                                                            pelanggaran yang sudah tercatat sebelumnya.
                                                        </p>


                                                        <div class="flex gap-3 pt-2">

                                                            <button type="button" @click="edit = false"
                                                                class="flex-1 border border-slate-300 text-slate-700
                                                                   rounded-xl py-3 hover:bg-slate-50">
                                                                Batal
                                                            </button>

                                                            <button type="submit"
                                                                class="flex-1 bg-blue-700 hover:bg-blue-800
                                                                   text-white rounded-xl py-3">
                                                                Simpan Perubahan
                                                            </button>

                                                        </div>

                                                    </div>

                                                </form>

                                            </div>

                                        </div>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="4" class="p-10 text-center text-slate-500">
                                    Belum ada data jenis pelanggaran.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Pagination --}}
            @if ($pelanggarans->hasPages())
                <div class="p-4 border-t border-slate-200">
                    {{ $pelanggarans->links() }}
                </div>
            @endif

        </section>

    </div>
@endsection
