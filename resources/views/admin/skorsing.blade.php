@extends('components.admin')

@section('title', 'Skorsing')

@section('content')

    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">

    <style>
        .ts-wrapper {
            margin-top: 0.25rem;
        }

        .ts-control {
            min-height: 50px !important;
            border: 1px solid #cbd5e1 !important;
            border-radius: 0.75rem !important;
            padding: 0.75rem 1rem !important;
            box-shadow: none !important;
            font-size: 0.875rem;
            background: #ffffff !important;
        }

        .ts-wrapper.focus .ts-control {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.15) !important;
        }

        .ts-dropdown {
            border: 1px solid #e2e8f0 !important;
            border-radius: 0.75rem !important;
            overflow: hidden;
            margin-top: 5px !important;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.10) !important;
        }

        .ts-dropdown .option {
            padding: 10px 14px !important;
            font-size: 0.875rem;
        }

        .ts-dropdown .option.active {
            background: #eff6ff !important;
            color: #1d4ed8 !important;
        }

        .ts-dropdown .no-results {
            padding: 14px !important;
            color: #64748b;
            font-size: 0.875rem;
            text-align: center;
        }

        .ts-control input {
            font-size: 0.875rem !important;
        }
    </style>


    <div class="py-8 space-y-6">

        {{-- Header --}}
        <div>

            <h1 class="text-3xl font-bold text-slate-900">
                Skorsing
            </h1>

            <p class="text-slate-500 mt-1">
                Admin dapat menambahkan dan melihat seluruh riwayat skorsing siswa.
            </p>

        </div>


        {{-- Alert --}}
        @if (session('success'))
            <div
                class="
                p-4
                bg-emerald-50
                text-emerald-700
                rounded-xl
                border
                border-emerald-100
            ">

                {{ session('success') }}

            </div>
        @endif


        @if ($errors->any())
            <div
                class="
                p-4
                bg-red-50
                text-red-700
                rounded-xl
                border
                border-red-100
            ">

                {{ $errors->first() }}

            </div>
        @endif



        {{-- Form Tambah --}}
        <section
            class="
            bg-white
            rounded-2xl
            border
            border-slate-200
            shadow-sm
            p-6
        ">

            <div class="mb-5">

                <h2 class="text-lg font-semibold text-slate-900">
                    Tambah Skorsing
                </h2>

                <p class="text-sm text-slate-500">
                    Tambahkan catatan pelanggaran siswa.
                </p>

            </div>


            <form method="POST" action="{{ route('admin.skorsing.store') }}"
                class="
                grid
                grid-cols-1
                md:grid-cols-2
                gap-4
            ">

                @csrf


                {{-- Siswa --}}
                <div>

                    <label for="siswa_id" class="text-sm font-medium text-slate-700">

                        Siswa

                    </label>


                    <select id="siswa_id" name="siswa_id" required placeholder="Ketik nama siswa atau kelas...">

                        <option value="">
                            Pilih siswa
                        </option>


                        @foreach ($siswas as $siswa)
                            <option value="{{ $siswa->id }}" @selected(old('siswa_id') == $siswa->id)>

                                {{ $siswa->nama }}
                                -
                                {{ $siswa->kelas?->nama_kelas ?? 'Belum ada kelas' }}

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
                        class="
                        mt-1
                        w-full
                        border
                        border-slate-300
                        rounded-xl
                        px-4
                        py-3
                        focus:ring-2
                        focus:ring-blue-500
                    ">

                        <option value="">
                            Pilih pelanggaran
                        </option>


                        @foreach ($pelanggarans as $p)
                            <option value="{{ $p->id }}" @selected(old('pelanggaran_id') == $p->id)>

                                [{{ ucfirst($p->kategori) }}]
                                {{ \Illuminate\Support\Str::limit($p->deskripsi, 60) }}
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


                    <input type="date" name="tanggal" value="{{ old('tanggal', now()->toDateString()) }}" required
                        class="
                        mt-1
                        w-full
                        border
                        border-slate-300
                        rounded-xl
                        px-4
                        py-3
                        focus:ring-2
                        focus:ring-blue-500
                    ">

                </div>



                {{-- Keterangan --}}
                <div>

                    <label class="text-sm font-medium text-slate-700">

                        Keterangan

                    </label>


                    <input name="keterangan" value="{{ old('keterangan') }}" placeholder="Keterangan (opsional)"
                        class="
                        mt-1
                        w-full
                        border
                        border-slate-300
                        rounded-xl
                        px-4
                        py-3
                        focus:ring-2
                        focus:ring-blue-500
                    ">

                </div>



                {{-- Submit --}}
                <button type="submit"
                    class="
                    md:col-span-2
                    bg-red-600
                    hover:bg-red-700
                    text-white
                    rounded-xl
                    py-3
                    font-semibold
                    transition
                ">

                    Simpan Skorsing

                </button>

            </form>

        </section>



        {{-- Riwayat --}}
        <section
            class="
            bg-white
            rounded-2xl
            border
            border-slate-200
            shadow-sm
            overflow-hidden
        ">

            <div class="
                p-6
                border-b
                border-slate-200
            ">

                <h2 class="text-lg font-semibold text-slate-900">
                    Riwayat Skorsing
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Seluruh data skorsing yang tercatat dalam sistem.
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

                            <th class="p-4 text-left">
                                Oleh
                            </th>

                            <th class="p-4 text-center">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($riwayat as $item)
                            <tr class="border-t hover:bg-slate-50">


                                {{-- tanggal --}}
                                <td class="p-4 whitespace-nowrap">

                                    {{ $item->tanggal?->format('d/m/Y') }}

                                </td>



                                {{-- siswa --}}
                                <td class="p-4">

                                    <div class="font-semibold text-slate-900">

                                        {{ $item->siswa?->nama }}

                                    </div>


                                    <div class="text-xs text-slate-500">

                                        {{ $item->siswa?->kelas?->nama_kelas }}

                                    </div>

                                </td>



                                {{-- pelanggaran --}}
                                <td class="p-4 min-w-[280px]">

                                    {{ $item->pelanggaran?->deskripsi }}

                                </td>



                                {{-- skor --}}
                                <td class="p-4">

                                    <span
                                        class="
                                        inline-flex
                                        px-3
                                        py-1
                                        rounded-full
                                        bg-red-50
                                        text-red-700
                                        font-semibold
                                    ">

                                        +{{ $item->skor }}

                                    </span>

                                </td>



                                {{-- creator --}}
                                <td class="p-4">

                                    {{ $item->creator?->name ?? 'User dihapus' }}

                                </td>



                                {{-- aksi --}}
                                <td class="p-4 text-center">

                                    <form method="POST" action="{{ route('admin.skorsing.delete', $item->id) }}"
                                        onsubmit="return confirm('Hapus skorsing ini? Skor siswa akan disesuaikan.')">

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

                                <td colspan="6"
                                    class="
                                    p-10
                                    text-center
                                    text-slate-500
                                ">

                                    Belum ada data skorsing.

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>


            @if ($riwayat->hasPages())
                <div class="p-4">

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
