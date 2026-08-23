@extends('components.admin')

@section('title', 'Rekap Kebajikan')

@section('content')

    <div class="py-8 space-y-6">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>

                <h1 class="text-3xl font-bold text-slate-900">
                    Rekap Kebajikan
                </h1>

                <p class="text-slate-500 mt-1">
                    Seluruh riwayat poin kebajikan siswa yang diberikan oleh Admin dan Guru.
                </p>

            </div>


            <a href="{{ route('admin.rekap-kebajikan.pdf', request()->query()) }}"
                class="
                inline-flex
                items-center
                justify-center
                gap-2
                px-5 py-3
                bg-emerald-600
                hover:bg-emerald-700
                text-white
                font-semibold
                rounded-xl
                shadow-sm
                transition
            ">

                📄 Download PDF

            </a>

        </div>



        {{-- FILTER --}}
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">

            <div class="mb-5">

                <h2 class="font-semibold text-lg text-slate-800">
                    Filter Data
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Filter berdasarkan tanggal, pembuat, kelas, siswa, atau jenis kebajikan.
                </p>

            </div>


            <form method="GET" action="{{ route('admin.rekap-kebajikan') }}"
                class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">


                <div>

                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Tanggal Mulai
                    </label>

                    <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}"
                        class="w-full border border-slate-300 rounded-xl px-3 py-2.5">

                </div>


                <div>

                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Tanggal Selesai
                    </label>

                    <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}"
                        class="w-full border border-slate-300 rounded-xl px-3 py-2.5">

                </div>


                <div>

                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Dibuat Oleh
                    </label>

                    <select name="pembuat_id" class="w-full border border-slate-300 rounded-xl px-3 py-2.5">

                        <option value="">
                            Semua pembuat
                        </option>

                        @foreach ($pembuatList as $u)
                            <option value="{{ $u->id }}" @selected(request('pembuat_id') == $u->id)>

                                {{ $u->name }}

                            </option>
                        @endforeach

                    </select>

                </div>


                <div>

                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Kelas
                    </label>

                    <select name="kelas_id" class="w-full border border-slate-300 rounded-xl px-3 py-2.5">

                        <option value="">
                            Semua kelas
                        </option>

                        @foreach ($kelasList as $k)
                            <option value="{{ $k->id }}" @selected(request('kelas_id') == $k->id)>

                                {{ $k->nama_kelas }}

                            </option>
                        @endforeach

                    </select>

                </div>


                <div>

                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Siswa
                    </label>

                    <select name="siswa_id" class="w-full border border-slate-300 rounded-xl px-3 py-2.5">

                        <option value="">
                            Semua siswa
                        </option>

                        @foreach ($siswaList as $s)
                            <option value="{{ $s->id }}" @selected(request('siswa_id') == $s->id)>

                                {{ $s->nama }}

                            </option>
                        @endforeach

                    </select>

                </div>


                <div>

                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Jenis Kebajikan
                    </label>

                    <select name="kebajikan_id" class="w-full border border-slate-300 rounded-xl px-3 py-2.5">

                        <option value="">
                            Semua kebajikan
                        </option>

                        @foreach ($kebajikanList as $kebajikan)
                            <option value="{{ $kebajikan->id }}" @selected(request('kebajikan_id') == $kebajikan->id)>

                                {{ $kebajikan->deskripsi }}

                            </option>
                        @endforeach

                    </select>

                </div>


                <div class="md:col-span-2 xl:col-span-3 flex flex-col sm:flex-row gap-3 pt-2">

                    <button type="submit"
                        class="
                        flex-1
                        bg-blue-700
                        hover:bg-blue-800
                        text-white
                        rounded-xl
                        px-5 py-3
                        font-semibold
                        transition
                    ">

                        Terapkan Filter

                    </button>


                    <a href="{{ route('admin.rekap-kebajikan') }}"
                        class="
                        px-6 py-3
                        border border-slate-300
                        rounded-xl
                        text-center
                        font-semibold
                        text-slate-700
                        hover:bg-slate-50
                    ">

                        Reset

                    </a>

                </div>

            </form>

        </div>



        {{-- TABLE --}}
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">

            <div class="p-5 border-b border-slate-100">

                <h2 class="font-semibold text-lg text-slate-800">
                    Data Rekap Kebajikan
                </h2>

            </div>


            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-slate-50">

                        <tr>

                            <th class="p-4 text-left">
                                Tanggal
                            </th>

                            <th class="p-4 text-left">
                                Siswa
                            </th>

                            <th class="p-4 text-left">
                                Kelas
                            </th>

                            <th class="p-4 text-left">
                                Kebajikan
                            </th>

                            <th class="p-4 text-left">
                                Poin
                            </th>

                            <th class="p-4 text-left">
                                Dibuat Oleh
                            </th>

                            <th class="p-4 text-left">
                                Keterangan
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($rekap as $item)
                            <tr class="border-t border-slate-100 hover:bg-slate-50">

                                <td class="p-4 whitespace-nowrap">
                                    {{ $item->tanggal?->format('d/m/Y') }}
                                </td>


                                <td class="p-4 font-medium">
                                    {{ $item->siswa?->nama ?? '-' }}
                                </td>


                                <td class="p-4 whitespace-nowrap">
                                    {{ $item->siswa?->kelas?->nama_kelas ?? '-' }}
                                </td>


                                <td class="p-4 min-w-[250px]">
                                    {{ $item->kebajikan?->deskripsi ?? '-' }}
                                </td>


                                <td class="p-4">

                                    <span
                                        class="
                                        inline-flex
                                        px-3 py-1
                                        bg-emerald-50
                                        text-emerald-700
                                        rounded-full
                                        font-bold
                                    ">

                                        +{{ $item->skor }}

                                    </span>

                                </td>


                                <td class="p-4 whitespace-nowrap">
                                    {{ $item->creator?->name ?? 'User dihapus' }}
                                </td>


                                <td class="p-4 min-w-[200px]">
                                    {{ $item->keterangan ?? '-' }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7" class="p-10 text-center text-slate-500">

                                    Belum ada data kebajikan.

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>


            @if ($rekap->hasPages())
                <div class="p-4 border-t border-slate-100">

                    {{ $rekap->links() }}

                </div>
            @endif

        </div>

    </div>

@endsection
