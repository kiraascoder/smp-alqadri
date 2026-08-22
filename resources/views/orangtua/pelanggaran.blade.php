@extends('components.admin')

@section('title', 'Jenis Pelanggaran')

@section('content')

    <div class="py-8 space-y-6">


        {{-- HEADER --}}
        <div>

            <h1 class="text-3xl font-bold text-slate-900">
                Jenis Pelanggaran
            </h1>

            <p class="text-slate-500 mt-1">
                Referensi pelanggaran dan skor yang berlaku.
            </p>

        </div>




        {{-- TABLE CARD --}}
        <section class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">


            <div class="p-5 border-b border-slate-100">

                <h2 class="font-semibold text-lg text-slate-800">
                    Daftar Pelanggaran
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Informasi kategori, jenis pelanggaran, dan bobot skor.
                </p>

            </div>



            <div class="overflow-x-auto">


                <table class="w-full text-sm">


                    <thead class="bg-slate-50">


                        <tr>

                            <th class="p-4 text-left font-semibold text-slate-700">
                                Kategori
                            </th>


                            <th class="p-4 text-left font-semibold text-slate-700">
                                Pelanggaran
                            </th>


                            <th class="p-4 text-left font-semibold text-slate-700">
                                Skor
                            </th>


                        </tr>


                    </thead>



                    <tbody>


                        @forelse($pelanggarans as $item)
                            <tr class="border-t hover:bg-slate-50 transition">


                                {{-- KATEGORI --}}
                                <td class="p-4 whitespace-nowrap">


                                    @php

                                        $warna = match (strtolower($item->kategori)) {
                                            'ringan' => 'bg-green-100 text-green-700',

                                            'sedang' => 'bg-yellow-100 text-yellow-700',

                                            'berat' => 'bg-orange-100 text-orange-700',

                                            'sangat berat' => 'bg-red-100 text-red-700',

                                            default => 'bg-slate-100 text-slate-700',
                                        };

                                    @endphp



                                    <span
                                        class="
                                inline-flex
                                px-3
                                py-1
                                rounded-full
                                text-xs
                                font-semibold
                                {{ $warna }}">

                                        {{ ucfirst($item->kategori) }}

                                    </span>


                                </td>





                                {{-- DESKRIPSI --}}
                                <td class="p-4 text-slate-700 min-w-[250px]">


                                    {{ $item->deskripsi }}


                                </td>





                                {{-- SKOR --}}
                                <td class="p-4">


                                    <span
                                        class="
                                inline-flex
                                items-center
                                px-3
                                py-1
                                rounded-full
                                bg-red-50
                                text-red-700
                                font-bold">


                                        {{ $item->skor }}


                                        <span class="ml-1 text-xs">
                                            Poin
                                        </span>


                                    </span>


                                </td>


                            </tr>



                        @empty


                            <tr>


                                <td colspan="3"
                                    class="
                            p-8
                            text-center
                            text-slate-500">


                                    Belum ada jenis pelanggaran.


                                </td>


                            </tr>
                        @endforelse


                    </tbody>


                </table>


            </div>



            {{-- PAGINATION --}}
            <div class="p-4 border-t border-slate-100">

                {{ $pelanggarans->links() }}

            </div>



        </section>


    </div>

@endsection
