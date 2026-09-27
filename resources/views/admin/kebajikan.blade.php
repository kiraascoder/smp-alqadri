@extends('components.admin')

@section('title', 'Jenis Kebajikan')

@section('content')

    <div class="py-8 space-y-6">

        {{-- ========================================================= --}}
        {{-- HEADER --}}
        {{-- ========================================================= --}}

        <div>

            <h1 class="text-3xl font-bold text-slate-900">
                Jenis Kebajikan
            </h1>

            <p class="mt-1 text-slate-500">
                Kelola jenis kebajikan dan bobot poin peserta didik.
            </p>

        </div>



        {{-- ========================================================= --}}
        {{-- ALERT SUCCESS --}}
        {{-- ========================================================= --}}

        @if (session('success'))
            <div
                class="
                p-4
                rounded-xl
                border
                border-emerald-200
                bg-emerald-50
                text-emerald-700
            ">

                {{ session('success') }}

            </div>
        @endif



        {{-- ========================================================= --}}
        {{-- ALERT ERROR --}}
        {{-- ========================================================= --}}

        @if (session('error'))
            <div
                class="
                p-4
                rounded-xl
                border
                border-red-200
                bg-red-50
                text-red-700
            ">

                {{ session('error') }}

            </div>
        @endif



        @if ($errors->any())
            <div
                class="
                p-4
                rounded-xl
                border
                border-red-200
                bg-red-50
                text-red-700
            ">

                {{ $errors->first() }}

            </div>
        @endif



        {{-- ========================================================= --}}
        {{-- TAMBAH JENIS KEBAJIKAN --}}
        {{-- ========================================================= --}}

        <section
            class="
            bg-white
            rounded-2xl
            border
            border-slate-200
            shadow-sm
            p-6
        ">

            <div class="mb-5">

                <h2 class="text-lg font-semibold text-slate-900">
                    Tambah Jenis Kebajikan
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Tambahkan jenis kebajikan yang sudah memiliki bobot poin tetap.
                </p>

            </div>


            <form method="POST" action="{{ route('admin.kebajikan.store') }}"
                class="
                grid
                grid-cols-1
                md:grid-cols-4
                gap-4
            ">

                @csrf


                {{-- DESKRIPSI --}}
                <div class="md:col-span-3">

                    <label for="deskripsi"
                        class="
                        block
                        mb-2
                        text-sm
                        font-medium
                        text-slate-700
                    ">

                        Deskripsi Kebajikan

                    </label>


                    <input id="deskripsi" type="text" name="deskripsi" value="{{ old('deskripsi') }}" required
                        maxlength="1000" placeholder="Contoh: Membantu guru tanpa diminta"
                        class="
                        w-full
                        border
                        border-slate-300
                        rounded-xl
                        px-4
                        py-3
                        text-sm
                        focus:ring-2
                        focus:ring-emerald-500
                        focus:border-emerald-500
                    ">

                </div>



                {{-- POIN --}}
                <div>

                    <label for="skor"
                        class="
                        block
                        mb-2
                        text-sm
                        font-medium
                        text-slate-700
                    ">

                        Poin

                    </label>


                    <input id="skor" type="number" name="skor" min="1" step="1"
                        value="{{ old('skor') }}" required placeholder="5"
                        class="
                        w-full
                        border
                        border-slate-300
                        rounded-xl
                        px-4
                        py-3
                        text-sm
                        focus:ring-2
                        focus:ring-emerald-500
                        focus:border-emerald-500
                    ">

                </div>



                {{-- SUBMIT --}}
                <div class="md:col-span-4 flex justify-end">

                    <button type="submit"
                        class="
                        w-full
                        sm:w-auto
                        bg-emerald-600
                        hover:bg-emerald-700
                        text-white
                        font-semibold
                        px-6
                        py-3
                        rounded-xl
                        transition
                    ">

                        Tambah Kebajikan

                    </button>

                </div>

            </form>

        </section>



        {{-- ========================================================= --}}
        {{-- DAFTAR JENIS KEBAJIKAN --}}
        {{-- ========================================================= --}}

        <section
            class="
            bg-white
            rounded-2xl
            border
            border-slate-200
            shadow-sm
            overflow-hidden
        ">


            {{-- HEADER --}}
            <div class="
                p-6
                border-b
                border-slate-200
            ">

                <h2 class="text-lg font-semibold text-slate-900">
                    Daftar Jenis Kebajikan
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Kebajikan pada daftar ini mempunyai poin tetap dan dapat dipilih saat pemberian kebajikan kepada siswa.
                </p>

            </div>



            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-slate-50">

                        <tr>

                            <th
                                class="
                                p-4
                                text-left
                                font-semibold
                                text-slate-700
                            ">

                                Deskripsi

                            </th>


                            <th
                                class="
                                p-4
                                text-center
                                font-semibold
                                text-slate-700
                                w-32
                            ">

                                Poin

                            </th>


                            <th
                                class="
                                p-4
                                text-center
                                font-semibold
                                text-slate-700
                                w-40
                            ">

                                Aksi

                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse ($kebajikans as $item)
                            <tr class="
                                border-t
                                border-slate-100
                                hover:bg-slate-50
                            "
                                x-data="{ edit: false }">


                                {{-- DESKRIPSI --}}
                                <td class="p-4">

                                    <div
                                        class="
                                        font-medium
                                        text-slate-800
                                    ">

                                        {{ $item->deskripsi }}

                                    </div>

                                </td>



                                {{-- POIN --}}
                                <td class="p-4 text-center">

                                    <span
                                        class="
                                        inline-flex
                                        items-center
                                        rounded-full
                                        bg-emerald-100
                                        px-3
                                        py-1
                                        font-semibold
                                        text-emerald-700
                                        whitespace-nowrap
                                    ">

                                        +{{ $item->skor }}

                                    </span>

                                </td>



                                {{-- AKSI --}}
                                <td class="p-4">

                                    <div
                                        class="
                                        flex
                                        items-center
                                        justify-center
                                        gap-4
                                    ">


                                        {{-- EDIT --}}
                                        <button type="button" @click="edit = true"
                                            class="
                                            text-blue-600
                                            hover:text-blue-800
                                            font-medium
                                            transition
                                        ">

                                            Edit

                                        </button>



                                        {{-- DELETE --}}
                                        <form method="POST" action="{{ route('admin.kebajikan.delete', $item) }}"
                                            onsubmit="return confirm('Hapus jenis kebajikan ini?')">

                                            @csrf
                                            @method('DELETE')


                                            <button type="submit"
                                                class="
                                                text-red-600
                                                hover:text-red-800
                                                font-medium
                                                transition
                                            ">

                                                Hapus

                                            </button>

                                        </form>

                                    </div>



                                    {{-- ========================================= --}}
                                    {{-- MODAL EDIT --}}
                                    {{-- ========================================= --}}

                                    <div x-show="edit" x-cloak x-transition.opacity @keydown.escape.window="edit = false"
                                        class="
                                        fixed
                                        inset-0
                                        z-[70]
                                        flex
                                        items-center
                                        justify-center
                                        bg-black/40
                                        p-4
                                    ">


                                        <form method="POST" action="{{ route('admin.kebajikan.update', $item) }}"
                                            @click.outside="edit = false"
                                            class="
                                            w-full
                                            max-w-lg
                                            rounded-2xl
                                            bg-white
                                            p-6
                                            shadow-xl
                                            text-left
                                        ">

                                            @csrf
                                            @method('PUT')


                                            {{-- MODAL HEADER --}}
                                            <div
                                                class="
                                                flex
                                                items-start
                                                justify-between
                                                gap-4
                                                mb-5
                                            ">

                                                <div>

                                                    <h3
                                                        class="
                                                        text-lg
                                                        font-semibold
                                                        text-slate-900
                                                    ">

                                                        Edit Jenis Kebajikan

                                                    </h3>

                                                    <p
                                                        class="
                                                        text-sm
                                                        text-slate-500
                                                        mt-1
                                                    ">

                                                        Perbarui deskripsi dan bobot poin kebajikan.

                                                    </p>

                                                </div>


                                                <button type="button" @click="edit = false"
                                                    class="
                                                    text-slate-400
                                                    hover:text-slate-700
                                                    text-xl
                                                    leading-none
                                                "
                                                    aria-label="Tutup">

                                                    &times;

                                                </button>

                                            </div>



                                            <div class="space-y-4">


                                                {{-- DESKRIPSI EDIT --}}
                                                <div>

                                                    <label for="deskripsi_{{ $item->id }}"
                                                        class="
                                                        block
                                                        mb-2
                                                        text-sm
                                                        font-medium
                                                        text-slate-700
                                                    ">

                                                        Deskripsi

                                                    </label>


                                                    <textarea id="deskripsi_{{ $item->id }}" name="deskripsi" rows="4" maxlength="1000" required
                                                        class="
                                                        w-full
                                                        border
                                                        border-slate-300
                                                        rounded-xl
                                                        px-4
                                                        py-3
                                                        resize-none
                                                        text-sm
                                                        focus:ring-2
                                                        focus:ring-emerald-500
                                                        focus:border-emerald-500
                                                    ">{{ $item->deskripsi }}</textarea>

                                                </div>



                                                {{-- POIN EDIT --}}
                                                <div>

                                                    <label for="skor_{{ $item->id }}"
                                                        class="
                                                        block
                                                        mb-2
                                                        text-sm
                                                        font-medium
                                                        text-slate-700
                                                    ">

                                                        Poin

                                                    </label>


                                                    <input id="skor_{{ $item->id }}" type="number" name="skor"
                                                        min="1" step="1" value="{{ $item->skor }}" required
                                                        class="
                                                        w-full
                                                        border
                                                        border-slate-300
                                                        rounded-xl
                                                        px-4
                                                        py-3
                                                        text-sm
                                                        focus:ring-2
                                                        focus:ring-emerald-500
                                                        focus:border-emerald-500
                                                    ">

                                                </div>



                                                {{-- CATATAN --}}
                                                <div
                                                    class="
                                                    p-3
                                                    rounded-xl
                                                    bg-amber-50
                                                    border
                                                    border-amber-100
                                                    text-xs
                                                    text-amber-700
                                                    leading-relaxed
                                                ">

                                                    Perubahan poin pada master tidak mengubah poin pada riwayat kebajikan
                                                    yang sudah tercatat sebelumnya.

                                                </div>



                                                {{-- BUTTON --}}
                                                <div
                                                    class="
                                                    flex
                                                    flex-col-reverse
                                                    sm:flex-row
                                                    gap-3
                                                    pt-2
                                                ">


                                                    <button type="button" @click="edit = false"
                                                        class="
                                                        flex-1
                                                        border
                                                        border-slate-300
                                                        hover:bg-slate-50
                                                        text-slate-700
                                                        rounded-xl
                                                        py-3
                                                        font-medium
                                                        transition
                                                    ">

                                                        Batal

                                                    </button>


                                                    <button type="submit"
                                                        class="
                                                        flex-1
                                                        bg-emerald-600
                                                        hover:bg-emerald-700
                                                        text-white
                                                        rounded-xl
                                                        py-3
                                                        font-semibold
                                                        transition
                                                    ">

                                                        Simpan Perubahan

                                                    </button>

                                                </div>

                                            </div>

                                        </form>

                                    </div>

                                </td>

                            </tr>


                        @empty

                            <tr>

                                <td colspan="3"
                                    class="
                                    p-10
                                    text-center
                                    text-slate-500
                                ">

                                    Belum ada jenis kebajikan.

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>



            {{-- PAGINATION --}}
            @if ($kebajikans->hasPages())
                <div
                    class="
                    p-4
                    border-t
                    border-slate-100
                ">

                    {{ $kebajikans->links() }}

                </div>
            @endif

        </section>

    </div>

@endsection
