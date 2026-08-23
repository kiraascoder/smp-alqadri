@extends('components.admin')

@section('title', 'Dashboard Orang Tua')

@section('content')

    <div class="py-8 space-y-6">

        {{-- Header --}}
        <div>
            <h1 class="text-3xl font-bold text-slate-900">
                Dashboard Orang Tua
            </h1>

            <p class="mt-1 text-slate-500">
                Pantau poin pelanggaran, skorsing, dan kebajikan anak Anda.
            </p>
        </div>


        {{-- Statistik --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">

            {{-- Jumlah Anak --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">

                <p class="text-sm text-slate-500">
                    Jumlah Anak
                </p>

                <p class="mt-2 text-3xl font-bold text-slate-900">
                    {{ $anak->count() }}
                </p>

            </div>


            {{-- Pelanggaran --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">

                <p class="text-sm text-slate-500">
                    Total Poin Pelanggaran
                </p>

                <p class="mt-2 text-3xl font-bold text-red-600">
                    {{ $totalSkorPelanggaran }}
                </p>

            </div>


            {{-- Kebajikan --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">

                <p class="text-sm text-slate-500">
                    Total Poin Kebajikan
                </p>

                <p class="mt-2 text-3xl font-bold text-emerald-600">
                    +{{ $totalPoinKebajikan }}
                </p>

            </div>


            {{-- Skorsing --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">

                <p class="text-sm text-slate-500">
                    Total Skorsing
                </p>

                <p class="mt-2 text-3xl font-bold text-slate-900">
                    {{ $totalSkorsing }}
                </p>

            </div>

        </div>


        {{-- Daftar Anak --}}
        <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">

            <div class="mb-5">
                <h2 class="text-lg font-semibold text-slate-900">
                    Data Anak
                </h2>

                <p class="text-sm text-slate-500">
                    Ringkasan peserta didik yang terhubung dengan akun Anda.
                </p>
            </div>


            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                @forelse ($anak as $siswa)
                    @php
                        $totalPelanggaranAnak = $siswa->riwayatPelanggaran()->sum('skor');

                        $totalKebajikanAnak = $siswa->riwayatKebajikan()->sum('skor');
                    @endphp


                    <div class="rounded-xl border border-slate-200 p-5">

                        <h3 class="font-semibold text-slate-900">
                            {{ $siswa->nama }}
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            {{ $siswa->kelas?->nama_kelas ?? '-' }}
                        </p>


                        <div class="mt-4 grid grid-cols-2 gap-3">

                            <div class="rounded-lg bg-red-50 p-3">
                                <p class="text-xs text-red-600">
                                    Pelanggaran
                                </p>

                                <p class="mt-1 font-bold text-red-700">
                                    {{ $totalPelanggaranAnak }}
                                </p>
                            </div>


                            <div class="rounded-lg bg-emerald-50 p-3">
                                <p class="text-xs text-emerald-600">
                                    Kebajikan
                                </p>

                                <p class="mt-1 font-bold text-emerald-700">
                                    +{{ $totalKebajikanAnak }}
                                </p>
                            </div>

                        </div>

                    </div>

                @empty

                    <div class="col-span-full py-6 text-center text-slate-500">
                        Belum ada data anak yang terhubung.
                    </div>
                @endforelse

            </div>

        </section>


        {{-- RIWAYAT SKORSING --}}
        <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

            <div class="px-6 py-5 border-b border-slate-200">

                <h2 class="text-lg font-semibold text-slate-900">
                    Skorsing / Pelanggaran Anak
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Pelanggaran terbaru yang tercatat pada anak Anda.
                </p>

            </div>


            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-slate-50">

                        <tr>

                            <th class="p-4 text-left">
                                Tanggal
                            </th>

                            <th class="p-4 text-left">
                                Anak
                            </th>

                            <th class="p-4 text-left">
                                Pelanggaran
                            </th>

                            <th class="p-4 text-center">
                                Skor
                            </th>

                            <th class="p-4 text-left">
                                Keterangan
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse ($riwayatSkorsing as $item)
                            <tr class="border-t border-slate-100">

                                <td class="p-4 whitespace-nowrap">
                                    {{ $item->tanggal?->format('d/m/Y') }}
                                </td>


                                <td class="p-4">

                                    <div class="font-medium text-slate-900">
                                        {{ $item->siswa?->nama }}
                                    </div>

                                    <div class="text-xs text-slate-500">
                                        {{ $item->siswa?->kelas?->nama_kelas }}
                                    </div>

                                </td>


                                <td class="p-4">
                                    {{ $item->pelanggaran?->deskripsi ?? '-' }}
                                </td>


                                <td class="p-4 text-center">

                                    <span
                                        class="inline-flex rounded-full
                                             bg-red-100 px-3 py-1
                                             font-semibold text-red-700">

                                        -{{ $item->skor }}

                                    </span>

                                </td>


                                <td class="p-4 text-slate-600">
                                    {{ $item->keterangan ?: '-' }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="p-10 text-center text-slate-500">
                                    Belum ada riwayat skorsing anak.
                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </section>


        {{-- RIWAYAT KEBAJIKAN --}}
        <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

            <div class="px-6 py-5 border-b border-slate-200">

                <h2 class="text-lg font-semibold text-slate-900">
                    Kebajikan Anak
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Prestasi dan kebajikan terbaru yang diperoleh anak Anda.
                </p>

            </div>


            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-slate-50">

                        <tr>

                            <th class="p-4 text-left">
                                Tanggal
                            </th>

                            <th class="p-4 text-left">
                                Anak
                            </th>

                            <th class="p-4 text-left">
                                Kebajikan / Prestasi
                            </th>

                            <th class="p-4 text-center">
                                Poin
                            </th>

                            <th class="p-4 text-left">
                                Keterangan
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse ($riwayatKebajikan as $item)
                            <tr class="border-t border-slate-100">

                                <td class="p-4 whitespace-nowrap">
                                    {{ $item->tanggal?->format('d/m/Y') }}
                                </td>


                                <td class="p-4">

                                    <div class="font-medium text-slate-900">
                                        {{ $item->siswa?->nama }}
                                    </div>

                                    <div class="text-xs text-slate-500">
                                        {{ $item->siswa?->kelas?->nama_kelas }}
                                    </div>

                                </td>


                                <td class="p-4">
                                    {{ $item->kebajikan?->deskripsi ?? '-' }}
                                </td>


                                <td class="p-4 text-center">

                                    <span
                                        class="inline-flex rounded-full
                                             bg-emerald-100 px-3 py-1
                                             font-semibold text-emerald-700">

                                        +{{ $item->skor }}

                                    </span>

                                </td>


                                <td class="p-4 text-slate-600">
                                    {{ $item->keterangan ?: '-' }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="p-10 text-center text-slate-500">
                                    Belum ada riwayat kebajikan anak.
                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </section>

    </div>

@endsection
