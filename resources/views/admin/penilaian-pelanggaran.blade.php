@extends('components.admin')

@section('title', 'Penilaian Pelanggaran Manual')

@section('content')

    <div class="py-8 space-y-6">

        {{-- ========================================================= --}}
        {{-- HEADER --}}
        {{-- ========================================================= --}}

        <div
            class="
            flex
            flex-col
            md:flex-row
            md:items-center
            md:justify-between
            gap-4
        ">

            <div>

                <h1 class="text-3xl font-bold text-slate-900">
                    Penilaian Pelanggaran Manual
                </h1>

                <p class="text-slate-500 mt-1">
                    Tentukan poin untuk pelanggaran manual yang dicatat oleh Admin atau Guru.
                </p>

            </div>


            <a href="{{ route('admin.skorsing') }}"
                class="
                inline-flex
                items-center
                justify-center
                px-4
                py-2.5
                rounded-xl
                border
                border-slate-300
                text-slate-700
                text-sm
                font-semibold
                hover:bg-slate-50
                transition
                whitespace-nowrap
            ">

                Kembali ke Skorsing

            </a>

        </div>



        {{-- ========================================================= --}}
        {{-- SUCCESS --}}
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
        {{-- ERROR --}}
        {{-- ========================================================= --}}

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

                <ul class="list-disc list-inside space-y-1">

                    @foreach ($errors->all() as $error)
                        <li>
                            {{ $error }}
                        </li>
                    @endforeach

                </ul>

            </div>

        @endif



        {{-- ========================================================= --}}
        {{-- INFO --}}
        {{-- ========================================================= --}}

        <div
            class="
            border
            border-amber-200
            bg-amber-50
            rounded-2xl
            p-5
        ">

            <div class="flex items-start gap-3">

                <div
                    class="
                    shrink-0
                    w-9
                    h-9
                    rounded-xl
                    bg-amber-100
                    text-amber-700
                    flex
                    items-center
                    justify-center
                    font-bold
                ">

                    !

                </div>


                <div>

                    <h2 class="font-semibold text-amber-800">
                        Pelanggaran Menunggu Penilaian
                    </h2>

                    <p class="text-sm text-amber-700 mt-1">
                        Data di bawah merupakan catatan pelanggaran manual yang belum mempunyai poin.
                        Setelah poin ditentukan, poin akan otomatis ditambahkan ke score BK siswa.
                    </p>

                </div>

            </div>

        </div>



        {{-- ========================================================= --}}
        {{-- TABLE --}}
        {{-- ========================================================= --}}

        <section
            class="
            bg-white
            border
            border-slate-200
            rounded-2xl
            shadow-sm
            overflow-hidden
        ">

            <div
                class="
                p-5
                border-b
                border-slate-100
                flex
                items-center
                justify-between
                gap-4
            ">

                <div>

                    <h2 class="font-semibold text-lg text-slate-800">
                        Daftar Pelanggaran Manual
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        Hanya catatan yang belum memiliki poin yang ditampilkan.
                    </p>

                </div>


                <span
                    class="
                    inline-flex
                    px-3
                    py-1
                    rounded-full
                    bg-amber-50
                    text-amber-700
                    text-sm
                    font-semibold
                    whitespace-nowrap
                ">

                    {{ $riwayat->total() }} menunggu

                </span>

            </div>


            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-slate-50">

                        <tr>

                            <th class="p-4 text-left font-semibold text-slate-700">
                                Tanggal
                            </th>

                            <th class="p-4 text-left font-semibold text-slate-700">
                                Siswa
                            </th>

                            <th class="p-4 text-left font-semibold text-slate-700">
                                Pelanggaran
                            </th>

                            <th class="p-4 text-left font-semibold text-slate-700">
                                Dicatat Oleh
                            </th>

                            <th class="p-4 text-left font-semibold text-slate-700">
                                Tentukan Poin
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse ($riwayat as $item)
                            <tr
                                class="
                                border-t
                                border-slate-100
                                hover:bg-slate-50
                            ">


                                {{-- TANGGAL --}}
                                <td class="p-4 whitespace-nowrap align-top">

                                    {{ $item->tanggal?->format('d/m/Y') ?? '-' }}

                                </td>



                                {{-- SISWA --}}
                                <td class="p-4 align-top">

                                    <div class="font-semibold text-slate-800">

                                        {{ $item->siswa?->nama ?? 'Siswa dihapus' }}

                                    </div>


                                    <div class="text-xs text-slate-500 mt-1">

                                        {{ $item->siswa?->kelas?->nama_kelas ?? 'Belum ada kelas' }}

                                    </div>

                                </td>



                                {{-- PELANGGARAN --}}
                                <td class="p-4 min-w-[300px] align-top">

                                    <div class="mb-2">

                                        <span
                                            class="
                                            inline-flex
                                            px-2
                                            py-1
                                            rounded-full
                                            bg-amber-50
                                            text-amber-700
                                            text-xs
                                            font-semibold
                                        ">

                                            Catatan Manual

                                        </span>

                                    </div>


                                    <div
                                        class="
                                        text-slate-800
                                        leading-relaxed
                                        whitespace-pre-line
                                    ">

                                        {{ $item->keterangan ?? '-' }}

                                    </div>

                                </td>



                                {{-- CREATOR --}}
                                <td class="p-4 whitespace-nowrap align-top">

                                    <div class="font-medium text-slate-700">

                                        {{ $item->creator?->name ?? 'User dihapus' }}

                                    </div>

                                </td>



                                {{-- FORM POIN --}}
                                <td class="p-4 min-w-[240px] align-top">

                                    <form method="POST" action="{{ route('admin.penilaian-pelanggaran.update', $item) }}"
                                        onsubmit="return confirm('Tetapkan poin pelanggaran ini?')">

                                        @csrf
                                        @method('PATCH')


                                        <label for="skor_pelanggaran_{{ $item->id }}"
                                            class="
                                            block
                                            text-xs
                                            font-medium
                                            text-slate-600
                                            mb-2
                                        ">

                                            Poin Pelanggaran

                                        </label>


                                        <div
                                            class="
                                            flex
                                            flex-col
                                            sm:flex-row
                                            gap-2
                                        ">

                                            <input id="skor_pelanggaran_{{ $item->id }}" type="number" name="skor"
                                                min="1" step="1" required placeholder="Contoh: 10"
                                                class="
                                                w-full
                                                sm:w-28
                                                border
                                                border-slate-300
                                                rounded-xl
                                                px-3
                                                py-2.5
                                                focus:ring-2
                                                focus:ring-red-500
                                                focus:border-red-500
                                            ">


                                            <button type="submit"
                                                class="
                                                inline-flex
                                                items-center
                                                justify-center
                                                px-4
                                                py-2.5
                                                rounded-xl
                                                bg-red-600
                                                hover:bg-red-700
                                                text-white
                                                text-sm
                                                font-semibold
                                                transition
                                                whitespace-nowrap
                                            ">

                                                Tetapkan Poin

                                            </button>

                                        </div>

                                    </form>

                                </td>

                            </tr>


                        @empty

                            <tr>

                                <td colspan="5"
                                    class="
                                    p-12
                                    text-center
                                ">

                                    <div
                                        class="
                                        w-12
                                        h-12
                                        mx-auto
                                        rounded-full
                                        bg-emerald-50
                                        flex
                                        items-center
                                        justify-center
                                        text-emerald-600
                                        font-bold
                                        mb-3
                                    ">

                                        ✓

                                    </div>

                                    <div class="font-semibold text-slate-800">
                                        Tidak ada pelanggaran yang menunggu penilaian
                                    </div>

                                    <p class="text-sm text-slate-500 mt-1">
                                        Semua catatan pelanggaran manual sudah mempunyai poin.
                                    </p>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>



            @if ($riwayat->hasPages())
                <div
                    class="
                    p-4
                    border-t
                    border-slate-100
                ">

                    {{ $riwayat->links() }}

                </div>
            @endif

        </section>

    </div>

@endsection
