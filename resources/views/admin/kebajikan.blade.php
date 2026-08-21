@extends('components.admin')

@section('title', 'Jenis Kebajikan')

@section('content')
<div class="py-8 space-y-6">

    <div>
        <h1 class="text-3xl font-bold text-slate-900">
            Jenis Kebajikan
        </h1>

        <p class="mt-1 text-slate-500">
            Kelola jenis kebajikan dan bobot poin peserta didik.
        </p>
    </div>


    @if (session('success'))
        <div class="p-4 rounded-xl border border-emerald-200
                    bg-emerald-50 text-emerald-700">
            {{ session('success') }}
        </div>
    @endif


    @if (session('error'))
        <div class="p-4 rounded-xl border border-red-200
                    bg-red-50 text-red-700">
            {{ session('error') }}
        </div>
    @endif


    @if ($errors->any())
        <div class="p-4 rounded-xl border border-red-200
                    bg-red-50 text-red-700">
            {{ $errors->first() }}
        </div>
    @endif


    {{-- Tambah --}}
    <section class="bg-white rounded-2xl border
                    border-slate-200 shadow-sm p-6">

        <div class="mb-5">
            <h2 class="text-lg font-semibold text-slate-900">
                Tambah Jenis Kebajikan
            </h2>

            <p class="text-sm text-slate-500">
                Masukkan kebajikan dan jumlah poin yang diberikan.
            </p>
        </div>


        <form
            method="POST"
            action="{{ route('admin.kebajikan.store') }}"
            class="grid grid-cols-1 md:grid-cols-4 gap-4"
        >
            @csrf

            <div class="md:col-span-3">
                <label class="block mb-2 text-sm font-medium text-slate-700">
                    Deskripsi Kebajikan
                </label>

                <input
                    type="text"
                    name="deskripsi"
                    value="{{ old('deskripsi') }}"
                    required
                    placeholder="Contoh: Membantu guru tanpa diminta"
                    class="w-full border border-slate-300
                           rounded-xl px-4 py-3
                           focus:ring-2 focus:ring-blue-500
                           focus:border-blue-500"
                >
            </div>


            <div>
                <label class="block mb-2 text-sm font-medium text-slate-700">
                    Poin
                </label>

                <input
                    type="number"
                    name="skor"
                    min="1"
                    value="{{ old('skor') }}"
                    required
                    placeholder="5"
                    class="w-full border border-slate-300
                           rounded-xl px-4 py-3
                           focus:ring-2 focus:ring-blue-500
                           focus:border-blue-500"
                >
            </div>


            <div class="md:col-span-4 flex justify-end">
                <button
                    type="submit"
                    class="bg-blue-700 hover:bg-blue-800
                           text-white font-medium
                           px-6 py-3 rounded-xl"
                >
                    Tambah Kebajikan
                </button>
            </div>

        </form>
    </section>


    {{-- Daftar --}}
    <section class="bg-white rounded-2xl border
                    border-slate-200 shadow-sm overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-slate-50">
                    <tr>
                        <th class="p-4 text-left">
                            Deskripsi
                        </th>

                        <th class="p-4 text-center">
                            Poin
                        </th>

                        <th class="p-4 text-center">
                            Aksi
                        </th>
                    </tr>
                </thead>


                <tbody>

                @forelse ($kebajikans as $item)

                    <tr class="border-t border-slate-100">

                        <td class="p-4">
                            {{ $item->deskripsi }}
                        </td>


                        <td class="p-4 text-center">

                            <span class="inline-flex rounded-full
                                         bg-emerald-100
                                         px-3 py-1
                                         font-semibold
                                         text-emerald-700">

                                +{{ $item->skor }}

                            </span>

                        </td>


                        <td class="p-4">

                            <div class="flex justify-center gap-4"
                                 x-data="{ edit: false }">


                                <button
                                    type="button"
                                    @click="edit = true"
                                    class="text-blue-700 font-medium"
                                >
                                    Edit
                                </button>


                                <form
                                    method="POST"
                                    action="{{ route(
                                        'admin.kebajikan.delete',
                                        $item
                                    ) }}"
                                    onsubmit="return confirm(
                                        'Hapus jenis kebajikan ini?'
                                    )"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="text-red-600 font-medium"
                                    >
                                        Hapus
                                    </button>

                                </form>


                                {{-- Modal Edit --}}
                                <div
                                    x-show="edit"
                                    x-cloak
                                    class="fixed inset-0 z-[70]
                                           flex items-center
                                           justify-center
                                           bg-black/40 p-4"
                                >

                                    <form
                                        @click.outside="edit = false"
                                        method="POST"
                                        action="{{ route(
                                            'admin.kebajikan.update',
                                            $item
                                        ) }}"
                                        class="w-full max-w-lg
                                               rounded-2xl bg-white
                                               p-6 shadow-xl
                                               text-left"
                                    >
                                        @csrf
                                        @method('PUT')


                                        <h3 class="text-lg font-semibold mb-5">
                                            Edit Jenis Kebajikan
                                        </h3>


                                        <div class="space-y-4">

                                            <div>
                                                <label class="block mb-2
                                                              text-sm
                                                              font-medium">
                                                    Deskripsi
                                                </label>

                                                <textarea
                                                    name="deskripsi"
                                                    rows="4"
                                                    required
                                                    class="w-full border
                                                           rounded-xl
                                                           px-4 py-3"
                                                >{{ $item->deskripsi }}</textarea>
                                            </div>


                                            <div>
                                                <label class="block mb-2
                                                              text-sm
                                                              font-medium">
                                                    Poin
                                                </label>

                                                <input
                                                    type="number"
                                                    name="skor"
                                                    min="1"
                                                    value="{{ $item->skor }}"
                                                    required
                                                    class="w-full border
                                                           rounded-xl
                                                           px-4 py-3"
                                                >
                                            </div>


                                            <div class="flex gap-3">

                                                <button
                                                    type="button"
                                                    @click="edit = false"
                                                    class="flex-1 border
                                                           rounded-xl py-3"
                                                >
                                                    Batal
                                                </button>


                                                <button
                                                    type="submit"
                                                    class="flex-1
                                                           bg-blue-700
                                                           text-white
                                                           rounded-xl py-3"
                                                >
                                                    Simpan
                                                </button>

                                            </div>

                                        </div>

                                    </form>

                                </div>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td
                            colspan="3"
                            class="p-10 text-center text-slate-500"
                        >
                            Belum ada jenis kebajikan.
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>


        @if ($kebajikans->hasPages())
            <div class="p-4 border-t">
                {{ $kebajikans->links() }}
            </div>
        @endif

    </section>

</div>
@endsection
