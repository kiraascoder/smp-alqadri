@extends('components.admin')

@section('title', 'Dashboard Admin')

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
                Dashboard Admin
            </h1>

            <p class="text-slate-500 mt-1">
                Ringkasan data SMP AL QADRI ISLAMIC SCHOOL.
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


            {{-- TOTAL GURU --}}
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
                            Guru
                        </p>

                        <p
                            class="
                            text-3xl
                            font-bold
                            text-slate-900
                            mt-2
                        ">

                            {{ $guruCount }}

                        </p>

                    </div>


                    <div
                        class="
                        w-12
                        h-12
                        rounded-xl
                        bg-blue-50
                        flex
                        items-center
                        justify-center
                        text-xl
                    ">

                        👨‍🏫

                    </div>

                </div>

            </div>



            {{-- TOTAL SISWA --}}
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
                            Siswa
                        </p>

                        <p
                            class="
                            text-3xl
                            font-bold
                            text-slate-900
                            mt-2
                        ">

                            {{ $siswaCount }}

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

                        🎓

                    </div>

                </div>

            </div>



            {{-- TOTAL ORANG TUA --}}
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
                            Orang Tua
                        </p>

                        <p
                            class="
                            text-3xl
                            font-bold
                            text-slate-900
                            mt-2
                        ">

                            {{ $orangTuaCount }}

                        </p>

                    </div>


                    <div
                        class="
                        w-12
                        h-12
                        rounded-xl
                        bg-purple-50
                        flex
                        items-center
                        justify-center
                        text-xl
                    ">

                        👨‍👩‍👧

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

                            {{ $skorsingBulanIniCount }}

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

                        🚨

                    </div>

                </div>

            </div>

        </div>



        {{-- ========================================================= --}}
        {{-- SKORSING TERBARU --}}
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


            {{-- HEADER TABLE --}}
            <div
                class="
                p-6
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
                        text-xl
                        font-semibold
                        text-slate-900
                    ">

                        Skorsing Terbaru

                    </h2>


                    <p class="text-sm text-slate-500 mt-1">

                        Pelanggaran terbaru yang dicatat oleh Admin maupun Guru.

                    </p>

                </div>


                @if (Route::has('admin.skorsing'))
                    <a href="{{ route('admin.skorsing') }}"
                        class="
                        text-sm
                        font-semibold
                        text-blue-600
                        hover:text-blue-700
                        whitespace-nowrap
                    ">

                        Lihat Semua

                    </a>
                @endif

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


                            <th
                                class="
                                p-4
                                text-left
                                font-semibold
                                text-slate-700
                            ">

                                Oleh

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
                                <td class="p-4">

                                    <div
                                        class="
                                        font-semibold
                                        text-slate-800
                                    ">

                                        {{ $item->siswa?->nama ?? 'Siswa dihapus' }}

                                    </div>

                                </td>



                                {{-- KELAS --}}
                                <td class="p-4 whitespace-nowrap">

                                    {{ $item->siswa?->kelas?->nama_kelas ?? 'Belum ada kelas' }}

                                </td>



                                {{-- PELANGGARAN --}}
                                <td class="p-4 min-w-[280px]">

                                    @if ($item->pelanggaran)
                                        {{-- PELANGGARAN MASTER --}}
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



                                {{-- DIBUAT OLEH --}}
                                <td class="p-4">

                                    <div
                                        class="
                                        font-medium
                                        text-slate-700
                                    ">

                                        {{ $item->creator?->name ?? 'User dihapus' }}

                                    </div>


                                    @if (is_null($item->pelanggaran_id) && is_null($item->skor))
                                        <div
                                            class="
                                            text-xs
                                            text-amber-600
                                            mt-1
                                        ">

                                            Menunggu penilaian

                                        </div>
                                    @elseif (is_null($item->pelanggaran_id) && !is_null($item->skor))
                                        <div
                                            class="
                                            text-xs
                                            text-emerald-600
                                            mt-1
                                        ">

                                            Sudah dinilai

                                        </div>
                                    @endif

                                </td>

                            </tr>


                        @empty

                            <tr>

                                <td colspan="6"
                                    class="
                                    p-8
                                    text-center
                                    text-slate-500
                                ">

                                    Belum ada skorsing.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </section>

    </div>

@endsection
