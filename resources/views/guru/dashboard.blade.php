@extends('components.admin')

@section('title', 'Dashboard Guru')

@section('content')

    <div class="py-8 space-y-6">

        {{-- ========================================================= --}}
        {{-- HEADER --}}
        {{-- ========================================================= --}}

        <div
            class="
            bg-white
            border
            border-slate-200
            rounded-2xl
            shadow-sm
            p-6
        ">

            <h1 class="text-3xl font-bold text-slate-900">
                Dashboard Guru
            </h1>

            <p class="text-slate-500 mt-1">
                Ringkasan pelanggaran dan kebajikan yang Anda catat kepada siswa.
            </p>

        </div>



        {{-- ========================================================= --}}
        {{-- SUMMARY --}}
        {{-- ========================================================= --}}

        <div
            class="
            grid
            grid-cols-1
            sm:grid-cols-2
            xl:grid-cols-4
            gap-4
        ">


            {{-- TOTAL SKORSING --}}
            <div
                class="
                bg-white
                border
                border-slate-200
                rounded-2xl
                shadow-sm
                p-6
            ">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm text-slate-500">
                            Total Skorsing Saya
                        </p>

                        <p
                            class="
                            text-3xl
                            font-bold
                            text-slate-900
                            mt-2
                        ">

                            {{ $skorsingCount }}

                        </p>

                    </div>


                    <div
                        class="
                        w-12
                        h-12
                        rounded-xl
                        bg-red-100
                        flex
                        items-center
                        justify-center
                        text-xl
                    ">

                        🚨

                    </div>

                </div>

            </div>



            {{-- SKORSING BULAN INI --}}
            <div
                class="
                bg-white
                border
                border-slate-200
                rounded-2xl
                shadow-sm
                p-6
            ">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm text-slate-500">
                            Skorsing Bulan Ini
                        </p>

                        <p
                            class="
                            text-3xl
                            font-bold
                            text-red-600
                            mt-2
                        ">

                            {{ $skorsingBulanIni }}

                        </p>

                    </div>


                    <div
                        class="
                        w-12
                        h-12
                        rounded-xl
                        bg-red-50
                        flex
                        items-center
                        justify-center
                        text-xl
                    ">

                        📅

                    </div>

                </div>

            </div>



            {{-- TOTAL KEBAJIKAN --}}
            <div
                class="
                bg-white
                border
                border-slate-200
                rounded-2xl
                shadow-sm
                p-6
            ">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm text-slate-500">
                            Total Kebajikan Saya
                        </p>

                        <p
                            class="
                            text-3xl
                            font-bold
                            text-emerald-600
                            mt-2
                        ">

                            {{ $kebajikanCount }}

                        </p>

                    </div>


                    <div
                        class="
                        w-12
                        h-12
                        rounded-xl
                        bg-emerald-100
                        flex
                        items-center
                        justify-center
                        text-xl
                    ">

                        ⭐

                    </div>

                </div>

            </div>



            {{-- TOTAL POIN KEBAJIKAN --}}
            <div
                class="
                bg-white
                border
                border-slate-200
                rounded-2xl
                shadow-sm
                p-6
            ">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm text-slate-500">
                            Poin Kebajikan Diberikan
                        </p>

                        <p
                            class="
                            text-3xl
                            font-bold
                            text-emerald-600
                            mt-2
                        ">

                            +{{ $totalPoinKebajikan }}

                        </p>


                        <p class="text-xs text-slate-400 mt-1">

                            {{ $kebajikanBulanIni }}
                            kebajikan bulan ini

                        </p>

                    </div>


                    <div
                        class="
                        w-12
                        h-12
                        rounded-xl
                        bg-emerald-50
                        flex
                        items-center
                        justify-center
                        text-xl
                    ">

                        🏆

                    </div>

                </div>

            </div>

        </div>



        {{-- ========================================================= --}}
        {{-- RIWAYAT SKORSING --}}
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

            {{-- HEADER --}}
            <div
                class="
                p-5
                border-b
                border-slate-100
                flex
                flex-col
                sm:flex-row
                sm:items-center
                sm:justify-between
                gap-3
            ">

                <div>

                    <h2
                        class="
                        font-semibold
                        text-lg
                        text-slate-800
                    ">

                        Riwayat Skorsing Terbaru

                    </h2>


                    <p class="text-sm text-slate-500 mt-1">

                        Pelanggaran terakhir yang Anda catat.

                    </p>

                </div>


                <a href="{{ route('guru.skorsing') }}"
                    class="
                    text-sm
                    font-semibold
                    text-blue-600
                    hover:text-blue-700
                    whitespace-nowrap
                ">

                    Lihat Semua

                </a>

            </div>



            {{-- TABLE --}}
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

                                Tanggal

                            </th>


                            <th
                                class="
                                p-4
                                text-left
                                font-semibold
                                text-slate-700
                            ">

                                Siswa

                            </th>


                            <th
                                class="
                                p-4
                                text-left
                                font-semibold
                                text-slate-700
                            ">

                                Kelas

                            </th>


                            <th
                                class="
                                p-4
                                text-left
                                font-semibold
                                text-slate-700
                            ">

                                Pelanggaran

                            </th>


                            <th
                                class="
                                p-4
                                text-left
                                font-semibold
                                text-slate-700
                            ">

                                Skor

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
                                <td class="p-4 whitespace-nowrap">

                                    {{ $item->tanggal?->format('d/m/Y') ?? '-' }}

                                </td>



                                {{-- SISWA --}}
                                <td
                                    class="
                                    p-4
                                    font-medium
                                    text-slate-800
                                ">

                                    {{ $item->siswa?->nama ?? 'Siswa dihapus' }}

                                </td>



                                {{-- KELAS --}}
                                <td class="p-4 whitespace-nowrap">

                                    {{ $item->siswa?->kelas?->nama_kelas ?? 'Belum ada kelas' }}

                                </td>



                                {{-- PELANGGARAN --}}
                                <td class="p-4 min-w-[280px]">

                                    @if ($item->pelanggaran)
                                        <div class="text-slate-800">

                                            {{ $item->pelanggaran->deskripsi }}

                                        </div>


                                        @if ($item->keterangan)
                                            <div
                                                class="
                                                text-xs
                                                text-slate-500
                                                mt-1
                                            ">

                                                {{ $item->keterangan }}

                                            </div>
                                        @endif
                                    @else
                                        {{-- CATATAN MANUAL --}}
                                        <div class="mb-1">

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


                                        <div class="text-slate-700">

                                            {{ $item->keterangan ?? '-' }}

                                        </div>
                                    @endif

                                </td>



                                {{-- SKOR --}}
                                <td class="p-4">

                                    @if (is_null($item->skor))
                                        <span
                                            class="
                                            inline-flex
                                            items-center
                                            px-3
                                            py-1
                                            rounded-full
                                            bg-amber-50
                                            text-amber-700
                                            font-semibold
                                            whitespace-nowrap
                                        ">

                                            Belum Ditentukan

                                        </span>
                                    @else
                                        <span
                                            class="
                                            inline-flex
                                            px-3
                                            py-1
                                            rounded-full
                                            bg-red-50
                                            text-red-700
                                            font-bold
                                            whitespace-nowrap
                                        ">

                                            +{{ $item->skor }}

                                        </span>
                                    @endif

                                </td>

                            </tr>


                        @empty

                            <tr>

                                <td colspan="5"
                                    class="
                                    p-8
                                    text-center
                                    text-slate-500
                                ">

                                    Belum ada skorsing yang Anda berikan.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </section>



        {{-- ========================================================= --}}
        {{-- RIWAYAT KEBAJIKAN --}}
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

            {{-- HEADER --}}
            <div
                class="
                p-5
                border-b
                border-slate-100
                flex
                flex-col
                sm:flex-row
                sm:items-center
                sm:justify-between
                gap-3
            ">

                <div>

                    <h2
                        class="
                        font-semibold
                        text-lg
                        text-slate-800
                    ">

                        Kebajikan Terbaru

                    </h2>


                    <p class="text-sm text-slate-500 mt-1">

                        Kebajikan terakhir yang Anda catat kepada siswa.

                    </p>

                </div>


                <a href="{{ route('guru.kebajikan') }}"
                    class="
                    text-sm
                    font-semibold
                    text-emerald-600
                    hover:text-emerald-700
                    whitespace-nowrap
                ">

                    Lihat Semua

                </a>

            </div>



            {{-- TABLE --}}
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

                                Tanggal

                            </th>


                            <th
                                class="
                                p-4
                                text-left
                                font-semibold
                                text-slate-700
                            ">

                                Siswa

                            </th>


                            <th
                                class="
                                p-4
                                text-left
                                font-semibold
                                text-slate-700
                            ">

                                Kelas

                            </th>


                            <th
                                class="
                                p-4
                                text-left
                                font-semibold
                                text-slate-700
                            ">

                                Kebajikan

                            </th>


                            <th
                                class="
                                p-4
                                text-left
                                font-semibold
                                text-slate-700
                            ">

                                Poin

                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse ($riwayatKebajikan as $item)

                            <tr
                                class="
                                border-t
                                border-slate-100
                                hover:bg-slate-50
                            ">


                                {{-- TANGGAL --}}
                                <td class="p-4 whitespace-nowrap">

                                    {{ $item->tanggal?->format('d/m/Y') ?? '-' }}

                                </td>



                                {{-- SISWA --}}
                                <td
                                    class="
                                    p-4
                                    font-medium
                                    text-slate-800
                                ">

                                    {{ $item->siswa?->nama ?? 'Siswa dihapus' }}

                                </td>



                                {{-- KELAS --}}
                                <td class="p-4 whitespace-nowrap">

                                    {{ $item->siswa?->kelas?->nama_kelas ?? 'Belum ada kelas' }}

                                </td>



                                {{-- KEBAJIKAN --}}
                                <td class="p-4 min-w-[280px]">

                                    @if ($item->kebajikan)
                                        <div class="text-slate-800">

                                            {{ $item->kebajikan->deskripsi }}

                                        </div>


                                        @if ($item->keterangan)
                                            <div
                                                class="
                                                text-xs
                                                text-slate-500
                                                mt-1
                                            ">

                                                {{ $item->keterangan }}

                                            </div>
                                        @endif
                                    @else
                                        {{-- CATATAN MANUAL --}}
                                        <div class="mb-1">

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


                                        <div class="text-slate-700">

                                            {{ $item->keterangan ?? '-' }}

                                        </div>
                                    @endif

                                </td>



                                {{-- POIN --}}
                                <td class="p-4">

                                    @if (is_null($item->skor))
                                        <span
                                            class="
                                            inline-flex
                                            items-center
                                            px-3
                                            py-1
                                            rounded-full
                                            bg-amber-50
                                            text-amber-700
                                            font-semibold
                                            whitespace-nowrap
                                        ">

                                            Belum Ditentukan

                                        </span>
                                    @else
                                        <span
                                            class="
                                            inline-flex
                                            px-3
                                            py-1
                                            rounded-full
                                            bg-emerald-50
                                            text-emerald-700
                                            font-bold
                                            whitespace-nowrap
                                        ">

                                            +{{ $item->skor }}

                                        </span>
                                    @endif

                                </td>

                            </tr>


                        @empty

                            <tr>

                                <td colspan="5"
                                    class="
                                    p-8
                                    text-center
                                    text-slate-500
                                ">

                                    Belum ada kebajikan yang Anda berikan.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </section>

    </div>

@endsection
