@extends('components.admin')

@section('title', 'Poin Kebajikan')

@section('content')

    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">

    <style>
        .ts-wrapper {
            margin-top: 0;
        }

        .ts-control {
            min-height: 50px !important;
            border: 1px solid #cbd5e1 !important;
            border-radius: 0.75rem !important;
            padding: 0.75rem 1rem !important;
            background: #ffffff !important;
            box-shadow: none !important;
            font-size: 0.875rem;
        }

        .ts-wrapper.focus .ts-control {
            border-color: #10b981 !important;
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.15) !important;
        }

        .ts-control input {
            font-size: 0.875rem !important;
        }

        .ts-dropdown {
            margin-top: 5px !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 0.75rem !important;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.10) !important;
        }

        .ts-dropdown .option {
            padding: 10px 14px !important;
            font-size: 0.875rem;
        }

        .ts-dropdown .option.active {
            background: #ecfdf5 !important;
            color: #047857 !important;
        }

        .ts-dropdown .no-results {
            padding: 14px !important;
            text-align: center;
            color: #64748b;
            font-size: 0.875rem;
        }
    </style>


    <div class="py-8 space-y-6">

        <div>

            <h1 class="text-3xl font-bold text-slate-900">
                Poin Kebajikan
            </h1>

            <p class="text-slate-500">
                Berikan poin kebajikan kepada peserta didik.
            </p>

        </div>


        @if (session('success'))
            <div
                class="
                p-4
                bg-emerald-50
                border
                border-emerald-200
                text-emerald-700
                rounded-xl
            ">

                {{ session('success') }}

            </div>
        @endif


        @if ($errors->any())
            <div
                class="
                p-4
                bg-red-50
                border
                border-red-200
                text-red-700
                rounded-xl
            ">

                {{ $errors->first() }}

            </div>
        @endif


        {{-- FORM --}}
        <section
            class="
            bg-white
            rounded-2xl
            border
            border-slate-200
            shadow-sm
            p-6
        ">

            <form method="POST" action="{{ route('guru.kebajikan.store') }}"
                class="
                grid
                grid-cols-1
                md:grid-cols-2
                gap-4
            ">

                @csrf


                {{-- SISWA --}}
                <div>

                    <label for="siswa_id"
                        class="
                        block
                        text-sm
                        font-medium
                        text-slate-700
                        mb-2
                    ">

                        Siswa

                    </label>


                    <select id="siswa_id" name="siswa_id" required placeholder="Ketik nama siswa atau kelas...">

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
                        font-medium
                        text-slate-700
                        mb-2
                    ">

                        Jenis Kebajikan

                    </label>


                    <select name="kebajikan_id" required
                        class="
                        w-full
                        border
                        border-slate-300
                        rounded-xl
                        px-4
                        py-3
                        bg-white
                        focus:ring-2
                        focus:ring-emerald-500
                        focus:border-emerald-500
                    ">

                        <option value="">
                            Pilih kebajikan
                        </option>


                        @foreach ($kebajikans as $item)
                            <option value="{{ $item->id }}" @selected(old('kebajikan_id') == $item->id)>

                                {{ $item->deskripsi }}
                                (+{{ $item->skor }})
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
                        font-medium
                        text-slate-700
                        mb-2
                    ">

                        Tanggal

                    </label>


                    <input type="date" name="tanggal" value="{{ old('tanggal', now()->toDateString()) }}" required
                        class="
                        w-full
                        border
                        border-slate-300
                        rounded-xl
                        px-4
                        py-3
                        focus:ring-2
                        focus:ring-emerald-500
                        focus:border-emerald-500
                    ">

                </div>


                {{-- KETERANGAN --}}
                <div>

                    <label
                        class="
                        block
                        text-sm
                        font-medium
                        text-slate-700
                        mb-2
                    ">

                        Keterangan

                    </label>


                    <input type="text" name="keterangan" value="{{ old('keterangan') }}"
                        placeholder="Keterangan (opsional)"
                        class="
                        w-full
                        border
                        border-slate-300
                        rounded-xl
                        px-4
                        py-3
                        focus:ring-2
                        focus:ring-emerald-500
                        focus:border-emerald-500
                    ">

                </div>


                {{-- SUBMIT --}}
                <button type="submit"
                    class="
                    md:col-span-2
                    bg-emerald-600
                    hover:bg-emerald-700
                    text-white
                    rounded-xl
                    py-3
                    font-semibold
                    transition
                ">

                    Berikan Poin Kebajikan

                </button>

            </form>

        </section>


        {{-- RIWAYAT --}}
        <section
            class="
            bg-white
            rounded-2xl
            border
            border-slate-200
            shadow-sm
            overflow-hidden
        ">

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
                                Kebajikan
                            </th>

                            <th class="p-4 text-center">
                                Poin
                            </th>

                            <th class="p-4 text-center">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse ($riwayat as $item)
                            <tr class="border-t hover:bg-slate-50">

                                <td class="p-4">

                                    {{ $item->tanggal?->format('d/m/Y') }}

                                </td>


                                <td class="p-4">

                                    <div class="font-medium">

                                        {{ $item->siswa?->nama ?? 'Siswa dihapus' }}

                                    </div>

                                    <div class="text-xs text-slate-500">

                                        {{ $item->siswa?->kelas?->nama_kelas ?? 'Belum ada kelas' }}

                                    </div>

                                </td>


                                <td class="p-4">

                                    {{ $item->kebajikan?->deskripsi ?? 'Kebajikan dihapus' }}

                                </td>


                                <td class="p-4 text-center">

                                    <span
                                        class="
                                        rounded-full
                                        bg-emerald-100
                                        px-3
                                        py-1
                                        font-bold
                                        text-emerald-700
                                    ">

                                        +{{ $item->skor }}

                                    </span>

                                </td>


                                <td class="p-4 text-center">

                                    <form method="POST" action="{{ route('guru.kebajikan.delete', $item) }}"
                                        onsubmit="return confirm('Hapus poin kebajikan ini?')">

                                        @csrf
                                        @method('DELETE')


                                        <button type="submit"
                                            class="
                                            text-red-600
                                            hover:text-red-800
                                            font-medium
                                        ">

                                            Hapus

                                        </button>

                                    </form>

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

                                    Belum ada poin kebajikan.

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>


            @if ($riwayat->hasPages())
                <div class="p-4 border-t">

                    {{ $riwayat->links() }}

                </div>
            @endif

        </section>

    </div>


    {{-- TOM SELECT --}}
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const siswaSelect =
                document.getElementById('siswa_id');


            if (siswaSelect) {

                new TomSelect(
                    siswaSelect, {
                        create: false,

                        allowEmptyOption: true,

                        placeholder: 'Ketik nama siswa atau kelas...',

                        searchField: [
                            'text'
                        ],

                        sortField: {
                            field: 'text',
                            direction: 'asc'
                        },

                        maxOptions: 100,

                        closeAfterSelect: true,

                        render: {

                            no_results: function() {

                                return `
                            <div class="no-results">
                                Siswa tidak ditemukan.
                            </div>
                        `;

                            }

                        }
                    }
                );

            }

        });
    </script>

@endsection
