@extends('components.admin')

@section('title', 'Beri Kebajikan')

@section('content')

    <div class="py-8 space-y-6">

        {{-- HEADER --}}
        <div>

            <h1 class="text-3xl font-bold text-slate-900">
                Beri Kebajikan
            </h1>

            <p class="text-slate-500 mt-1">
                Berikan poin kebajikan kepada siswa berdasarkan perilaku positif yang dilakukan.
            </p>

        </div>



        {{-- SUCCESS --}}
        @if (session('success'))
            <div
                class="
                bg-emerald-50
                border border-emerald-200
                text-emerald-700
                rounded-xl
                p-4
            ">

                {{ session('success') }}

            </div>
        @endif



        {{-- ERROR --}}
        @if ($errors->any())

            <div
                class="
                bg-red-50
                border border-red-200
                text-red-700
                rounded-xl
                p-4
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



        {{-- FORM --}}
        <section
            class="
            bg-white
            border border-slate-200
            rounded-2xl
            shadow-sm
            overflow-hidden
        ">

            <div class="p-5 border-b border-slate-100">

                <h2 class="font-semibold text-lg text-slate-800">
                    Form Pemberian Kebajikan
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Pilih siswa dan jenis kebajikan yang akan diberikan.
                </p>

            </div>


            <form method="POST" action="{{ route('admin.poin-kebajikan.store') }}" class="p-6">

                @csrf


                <div
                    class="
                    grid
                    grid-cols-1
                    md:grid-cols-2
                    gap-5
                ">


                    {{-- SISWA --}}
                    <div>

                        <label
                            class="
                            block
                            text-sm
                            font-semibold
                            text-slate-700
                            mb-2
                        ">

                            Siswa

                        </label>


                        <select name="siswa_id" required
                            class="
                            w-full
                            border border-slate-300
                            rounded-xl
                            px-4 py-3
                            bg-white
                            focus:ring-2
                            focus:ring-emerald-500
                            focus:border-emerald-500
                        ">

                            <option value="">
                                Pilih siswa
                            </option>


                            @foreach ($siswas as $siswa)
                                <option value="{{ $siswa->id }}" @selected(old('siswa_id') == $siswa->id)>

                                    {{ $siswa->nama }}
                                    —
                                    {{ $siswa->kelas?->nama_kelas ?? 'Belum ada kelas' }}

                                </option>
                            @endforeach

                        </select>

                    </div>



                    {{-- KEBAJIKAN --}}
                    <div>

                        <label
                            class="
                            block
                            text-sm
                            font-semibold
                            text-slate-700
                            mb-2
                        ">

                            Jenis Kebajikan

                        </label>


                        <select name="kebajikan_id" required
                            class="
                            w-full
                            border border-slate-300
                            rounded-xl
                            px-4 py-3
                            bg-white
                            focus:ring-2
                            focus:ring-emerald-500
                            focus:border-emerald-500
                        ">

                            <option value="">
                                Pilih kebajikan
                            </option>


                            @foreach ($kebajikans as $kebajikan)
                                <option value="{{ $kebajikan->id }}" @selected(old('kebajikan_id') == $kebajikan->id)>

                                    {{ $kebajikan->deskripsi }}
                                    (+{{ $kebajikan->skor }} poin)
                                </option>
                            @endforeach

                        </select>

                    </div>



                    {{-- TANGGAL --}}
                    <div>

                        <label
                            class="
                            block
                            text-sm
                            font-semibold
                            text-slate-700
                            mb-2
                        ">

                            Tanggal

                        </label>


                        <input type="date" name="tanggal" value="{{ old('tanggal', now()->format('Y-m-d')) }}" required
                            class="
                            w-full
                            border border-slate-300
                            rounded-xl
                            px-4 py-3
                            focus:ring-2
                            focus:ring-emerald-500
                        ">

                    </div>



                    {{-- KETERANGAN --}}
                    <div>

                        <label
                            class="
                            block
                            text-sm
                            font-semibold
                            text-slate-700
                            mb-2
                        ">

                            Keterangan

                            <span class="font-normal text-slate-400">
                                (Opsional)
                            </span>

                        </label>


                        <textarea name="keterangan" rows="3" placeholder="Tambahkan keterangan..."
                            class="
                            w-full
                            border border-slate-300
                            rounded-xl
                            px-4 py-3
                            resize-none
                            focus:ring-2
                            focus:ring-emerald-500
                        ">{{ old('keterangan') }}</textarea>

                    </div>

                </div>



                <div
                    class="
                    mt-6
                    flex
                    justify-end
                ">

                    <button type="submit"
                        class="
                        inline-flex
                        items-center
                        justify-center
                        gap-2
                        bg-emerald-600
                        hover:bg-emerald-700
                        text-white
                        px-6 py-3
                        rounded-xl
                        font-semibold
                        transition
                    ">

                        ⭐ Berikan Kebajikan

                    </button>

                </div>

            </form>

        </section>



        {{-- RIWAYAT --}}
        <section
            class="
            bg-white
            border border-slate-200
            rounded-2xl
            shadow-sm
            overflow-hidden
        ">

            <div class="p-5 border-b border-slate-100">

                <h2 class="font-semibold text-lg text-slate-800">
                    Riwayat Kebajikan
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Seluruh poin kebajikan yang telah diberikan oleh Admin dan Guru.
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
                                Kelas
                            </th>

                            <th class="p-4 text-left">
                                Kebajikan
                            </th>

                            <th class="p-4 text-left">
                                Poin
                            </th>

                            <th class="p-4 text-left">
                                Diberikan Oleh
                            </th>

                            <th class="p-4 text-left">
                                Keterangan
                            </th>

                            <th class="p-4 text-center">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($riwayat as $item)
                            <tr
                                class="
                                border-t
                                border-slate-100
                                hover:bg-slate-50
                            ">

                                <td class="p-4 whitespace-nowrap">

                                    {{ $item->tanggal?->format('d/m/Y') ?? '-' }}

                                </td>


                                <td class="p-4 font-medium text-slate-800">

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
                                        rounded-full
                                        bg-emerald-50
                                        text-emerald-700
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


                                <td class="p-4 text-center">

                                    <form method="POST"
                                        action="{{ route('admin.poin-kebajikan.delete', $item->id) }}"
                                        onsubmit="
                                        return confirm(
                                            'Hapus riwayat kebajikan ini?'
                                        )
                                    ">

                                        @csrf
                                        @method('DELETE')


                                        <button type="submit"
                                            class="
                                            px-3 py-2
                                            bg-red-50
                                            hover:bg-red-100
                                            text-red-600
                                            rounded-lg
                                            text-xs
                                            font-semibold
                                            transition
                                        ">

                                            Hapus

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="8"
                                    class="
                                    p-10
                                    text-center
                                    text-slate-500
                                ">

                                    Belum ada kebajikan yang diberikan.

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>


            @if ($riwayat->hasPages())
                <div class="
                    p-4
                    border-t border-slate-100
                ">

                    {{ $riwayat->links() }}

                </div>
            @endif

        </section>

    </div>

@endsection
