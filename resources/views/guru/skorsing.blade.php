@extends('components.admin')

@section('title', 'Skorsing Guru')

@section('content')

    <div class="py-8 space-y-6">

        {{-- Header --}}
        <div>
            <h1 class="text-3xl font-bold text-slate-900">
                Skorsing
            </h1>

            <p class="text-slate-500 mt-1">
                Kelola riwayat pelanggaran siswa yang Anda buat.
            </p>
        </div>


        {{-- Alert --}}
        @if (session('success'))
            <div class="p-4 bg-emerald-50 text-emerald-700 rounded-xl border border-emerald-100">
                {{ session('success') }}
            </div>
        @endif


        @if ($errors->any())
            <div class="p-4 bg-red-50 text-red-700 rounded-xl border border-red-100">
                {{ $errors->first() }}
            </div>
        @endif



        {{-- Form Tambah --}}
        <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">


            <div class="mb-5">

                <h2 class="text-lg font-semibold text-slate-900">
                    Tambah Skorsing
                </h2>

                <p class="text-sm text-slate-500">
                    Pilih siswa dan jenis pelanggaran yang dilakukan.
                </p>

            </div>



            <form method="POST" action="{{ route('guru.skorsing.store') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">

                @csrf


                {{-- Siswa --}}
                <div>

                    <label class="text-sm font-medium text-slate-700">
                        Siswa
                    </label>

                    <select name="siswa_id" required
                        class="mt-1 w-full border border-slate-300 rounded-xl px-4 py-3
                    focus:ring-2 focus:ring-blue-500">

                        <option value="">
                            Pilih siswa
                        </option>


                        @foreach ($siswas as $s)
                            <option value="{{ $s->id }}">

                                {{ $s->nama }}
                                -
                                {{ $s->kelas?->nama_kelas }}

                            </option>
                        @endforeach


                    </select>

                </div>



                {{-- Pelanggaran --}}
                <div>

                    <label class="text-sm font-medium text-slate-700">
                        Jenis Pelanggaran
                    </label>


                    <select name="pelanggaran_id" required
                        class="mt-1 w-full border border-slate-300 rounded-xl px-4 py-3
                    focus:ring-2 focus:ring-blue-500">


                        <option value="">
                            Pilih pelanggaran
                        </option>


                        @foreach ($pelanggarans as $p)
                            <option value="{{ $p->id }}">

                                {{ Str::limit($p->deskripsi, 70) }}
                                (+{{ $p->skor }})
                            </option>
                        @endforeach


                    </select>


                </div>




                {{-- Tanggal --}}
                <div>

                    <label class="text-sm font-medium text-slate-700">
                        Tanggal
                    </label>


                    <input type="date" name="tanggal" value="{{ now()->toDateString() }}" required
                        class="mt-1 w-full border border-slate-300 rounded-xl px-4 py-3">


                </div>



                {{-- Keterangan --}}
                <div>


                    <label class="text-sm font-medium text-slate-700">
                        Keterangan
                    </label>


                    <input name="keterangan" placeholder="Tambahkan keterangan"
                        class="mt-1 w-full border border-slate-300 rounded-xl px-4 py-3">


                </div>




                <button
                    class="md:col-span-2
                bg-red-600 hover:bg-red-700
                text-white rounded-xl py-3
                font-semibold transition">

                    Tambah Skorsing

                </button>



            </form>


        </section>




        {{-- Riwayat --}}
        <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">


            <div class="p-6 border-b">

                <h2 class="font-semibold text-lg">
                    Riwayat Skorsing
                </h2>

                <p class="text-sm text-slate-500">
                    Data skorsing yang pernah Anda tambahkan.
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
                                Siswa
                            </th>


                            <th class="p-4 text-left">
                                Pelanggaran
                            </th>


                            <th class="p-4 text-left">
                                Skor
                            </th>


                            <th class="p-4 text-center">
                                Aksi
                            </th>


                        </tr>


                    </thead>




                    <tbody>


                        @forelse($riwayat as $item)
                            <tr class="border-t hover:bg-slate-50">


                                <td class="p-4 whitespace-nowrap">

                                    {{ $item->tanggal?->format('d/m/Y') }}

                                </td>



                                <td class="p-4">

                                    <div class="font-semibold text-slate-800">

                                        {{ $item->siswa?->nama }}

                                    </div>


                                    <div class="text-xs text-slate-500">

                                        {{ $item->siswa?->kelas?->nama_kelas }}

                                    </div>


                                </td>




                                <td class="p-4 min-w-[250px]">

                                    {{ $item->pelanggaran?->deskripsi }}

                                </td>



                                <td class="p-4">

                                    <span
                                        class="px-3 py-1 rounded-full
                            bg-red-50 text-red-700
                            font-semibold">

                                        +{{ $item->skor }}

                                    </span>

                                </td>




                                <td class="p-4 text-center">


                                    <form method="POST" action="{{ route('guru.skorsing.delete', $item->id) }}"
                                        onsubmit="return confirm('Hapus skorsing ini?')">


                                        @csrf

                                        @method('DELETE')


                                        <button class="text-red-600 hover:text-red-800 font-medium">

                                            Hapus

                                        </button>


                                    </form>


                                </td>



                            </tr>



                        @empty


                            <tr>

                                <td colspan="5" class="p-8 text-center text-slate-500">

                                    Belum ada riwayat skorsing.

                                </td>


                            </tr>
                        @endforelse



                    </tbody>



                </table>


            </div>



            <div class="p-4">

                {{ $riwayat->links() }}

            </div>



        </section>


    </div>

@endsection
