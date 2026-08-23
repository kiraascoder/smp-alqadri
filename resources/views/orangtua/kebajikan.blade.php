@extends('components.admin')

@section('title', 'Jenis Kebajikan')

@section('content')

    <div class="py-8 space-y-6">

        {{-- HEADER --}}
        <div>

            <h1 class="text-3xl font-bold text-slate-900">
                Jenis Kebajikan
            </h1>

            <p class="text-slate-500 mt-1">
                Referensi jenis kebajikan dan poin yang berlaku di sekolah.
            </p>

        </div>


        {{-- INFORMASI --}}
        <div
            class="
            bg-emerald-50
            border border-emerald-200
            rounded-2xl
            p-5
        ">

            <div class="flex gap-4">

                <div
                    class="
                    w-11 h-11
                    shrink-0
                    rounded-xl
                    bg-emerald-100
                    flex
                    items-center
                    justify-center
                    text-xl
                ">

                    ⭐

                </div>


                <div>

                    <h2 class="font-semibold text-emerald-900">
                        Tentang Poin Kebajikan
                    </h2>

                    <p
                        class="
                        text-sm
                        text-emerald-700
                        mt-1
                        leading-relaxed
                    ">

                        Poin kebajikan diberikan kepada siswa sebagai
                        apresiasi atas perilaku positif dan tindakan baik
                        yang dilakukan di lingkungan sekolah.

                    </p>

                </div>

            </div>

        </div>


        {{-- TABLE --}}
        <section
            class="
            bg-white
            border border-slate-200
            rounded-2xl
            shadow-sm
            overflow-hidden
        ">


            {{-- TABLE HEADER --}}
            <div class="
                p-5
                border-b border-slate-100
            ">

                <h2
                    class="
                    font-semibold
                    text-lg
                    text-slate-800
                ">

                    Daftar Jenis Kebajikan

                </h2>

                <p
                    class="
                    text-sm
                    text-slate-500
                    mt-1
                ">

                    Daftar perilaku positif yang mendapatkan poin kebajikan.

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
                                w-16
                            ">

                                No

                            </th>


                            <th
                                class="
                                p-4
                                text-left
                                font-semibold
                                text-slate-700
                            ">

                                Jenis Kebajikan

                            </th>


                            <th
                                class="
                                p-4
                                text-left
                                font-semibold
                                text-slate-700
                                whitespace-nowrap
                            ">

                                Poin

                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($kebajikans as $item)
                            <tr
                                class="
                                border-t
                                border-slate-100
                                hover:bg-slate-50
                                transition
                            ">


                                {{-- NOMOR --}}
                                <td
                                    class="
                                    p-4
                                    text-slate-500
                                ">

                                    {{ $kebajikans->firstItem() + $loop->index }}

                                </td>


                                {{-- KEBAJIKAN --}}
                                <td
                                    class="
                                    p-4
                                    text-slate-700
                                    min-w-[250px]
                                ">

                                    <div class="flex items-start gap-3">

                                        <div
                                            class="
                                            w-8 h-8
                                            shrink-0
                                            rounded-lg
                                            bg-emerald-50
                                            flex
                                            items-center
                                            justify-center
                                        ">

                                            ⭐

                                        </div>


                                        <span class="pt-1 font-medium">

                                            {{ $item->deskripsi }}

                                        </span>

                                    </div>

                                </td>


                                {{-- POIN --}}
                                <td class="p-4">

                                    <span
                                        class="
                                        inline-flex
                                        items-center
                                        px-3 py-1
                                        rounded-full
                                        bg-emerald-50
                                        text-emerald-700
                                        font-bold
                                        whitespace-nowrap
                                    ">

                                        +{{ $item->skor }}

                                        <span
                                            class="
                                            ml-1
                                            text-xs
                                            font-semibold
                                        ">

                                            Poin

                                        </span>

                                    </span>

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

                                    <div
                                        class="
                                        text-3xl
                                        mb-3
                                    ">

                                        ⭐

                                    </div>

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
