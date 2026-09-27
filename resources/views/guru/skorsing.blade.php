@extends('components.admin')

@section('title', 'Skorsing Guru')

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
            background: #ffffff !important;
            box-shadow: none !important;
            font-size: 0.875rem;
        }

        .ts-wrapper.focus .ts-control {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.15) !important;
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
            background: #eff6ff !important;
            color: #1d4ed8 !important;
        }

        .ts-dropdown .no-results {
            padding: 14px !important;
            text-align: center;
            color: #64748b;
            font-size: 0.875rem;
        }
    </style>


    <div class="py-8 space-y-6">

        {{-- HEADER --}}
        <div>

            <h1 class="text-3xl font-bold text-slate-900">
                Skorsing
            </h1>

            <p class="text-slate-500 mt-1">
                Kelola riwayat pelanggaran siswa yang Anda buat.
            </p>

        </div>


        {{-- ALERT SUCCESS --}}
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


        {{-- ALERT ERROR --}}
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



        {{-- FORM TAMBAH --}}
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
                    Pilih pelanggaran dari daftar atau buat catatan manual untuk dinilai kemudian.
                </p>

            </div>


            <form method="POST" action="{{ route('guru.skorsing.store') }}"
                class="
                grid
                grid-cols-1
                md:grid-cols-2
                gap-4
            ">

                @csrf


                {{-- ===================================================== --}}
                {{-- SISWA --}}
                {{-- ===================================================== --}}
                <div>

                    <label for="siswa_id" class="text-sm font-medium text-slate-700">

                        Siswa

                    </label>


                    <select id="siswa_id" name="siswa_id" required placeholder="Ketik nama siswa atau kelas...">

                        <option value="">
                            Pilih siswa
                        </option>


                        @foreach ($siswas as $s)
                            <option value="{{ $s->id }}" @selected(old('siswa_id') == $s->id)>

                                {{ $s->nama }}
                                -
                                {{ $s->kelas?->nama_kelas ?? 'Belum ada kelas' }}

                            </option>
                        @endforeach

                    </select>

                </div>



                {{-- ===================================================== --}}
                {{-- JENIS PENCATATAN --}}
                {{-- ===================================================== --}}
                <div>

                    <label class="text-sm font-medium text-slate-700">
                        Jenis Pencatatan
                    </label>


                    <div
                        class="
                        mt-1
                        grid
                        grid-cols-1
                        sm:grid-cols-2
                        gap-3
                    ">

                        {{-- MASTER --}}
                        <label id="label-master"
                            class="
                            cursor-pointer
                            border
                            border-blue-200
                            bg-blue-50
                            rounded-xl
                            p-3
                            transition
                        ">

                            <div class="flex items-start gap-3">

                                <input type="radio" name="jenis_pencatatan" value="master" class="mt-1"
                                    @checked(old('jenis_pencatatan', 'master') === 'master')>


                                <div>

                                    <div class="font-semibold text-sm text-slate-800">
                                        Dari Daftar
                                    </div>

                                    <div class="text-xs text-slate-500 mt-1">
                                        Poin langsung mengikuti jenis pelanggaran.
                                    </div>

                                </div>

                            </div>

                        </label>


                        {{-- MANUAL --}}
                        <label id="label-manual"
                            class="
                            cursor-pointer
                            border
                            border-slate-200
                            bg-white
                            rounded-xl
                            p-3
                            transition
                        ">

                            <div class="flex items-start gap-3">

                                <input type="radio" name="jenis_pencatatan" value="manual" class="mt-1"
                                    @checked(old('jenis_pencatatan') === 'manual')>


                                <div>

                                    <div class="font-semibold text-sm text-slate-800">
                                        Catatan Manual
                                    </div>

                                    <div class="text-xs text-slate-500 mt-1">
                                        Poin ditentukan Admin kemudian.
                                    </div>

                                </div>

                            </div>

                        </label>

                    </div>

                </div>



                {{-- ===================================================== --}}
                {{-- PELANGGARAN MASTER --}}
                {{-- ===================================================== --}}
                <div id="pelanggaran-master-wrapper">

                    <label for="pelanggaran_id" class="text-sm font-medium text-slate-700">

                        Jenis Pelanggaran

                    </label>


                    <select id="pelanggaran_id" name="pelanggaran_id"
                        class="
                        mt-1
                        w-full
                        border
                        border-slate-300
                        rounded-xl
                        px-4
                        py-3
                        bg-white
                        focus:ring-2
                        focus:ring-blue-500
                        focus:border-blue-500
                    ">

                        <option value="">
                            Pilih pelanggaran
                        </option>


                        @foreach ($pelanggarans as $p)
                            <option value="{{ $p->id }}" @selected(old('pelanggaran_id') == $p->id)>

                                {{ \Illuminate\Support\Str::limit($p->deskripsi, 70) }}
                                (+{{ $p->skor }})
                            </option>
                        @endforeach

                    </select>


                    <p class="text-xs text-slate-400 mt-1">
                        Poin akan langsung mengikuti jenis pelanggaran yang dipilih.
                    </p>

                </div>



                {{-- ===================================================== --}}
                {{-- INFO MANUAL --}}
                {{-- ===================================================== --}}
                <div id="manual-info"
                    class="
                    hidden
                    rounded-xl
                    border
                    border-amber-200
                    bg-amber-50
                    p-4
                ">

                    <div class="flex gap-3">

                        <div
                            class="
                            shrink-0
                            w-8
                            h-8
                            rounded-lg
                            bg-amber-100
                            flex
                            items-center
                            justify-center
                        ">

                            !

                        </div>


                        <div>

                            <div class="text-sm font-semibold text-amber-800">
                                Poin Belum Ditentukan
                            </div>

                            <p class="text-xs text-amber-700 mt-1 leading-relaxed">
                                Tuliskan kejadian pelanggaran pada kolom keterangan.
                                Poin akan ditentukan oleh Admin setelah catatan diperiksa.
                            </p>

                        </div>

                    </div>

                </div>



                {{-- ===================================================== --}}
                {{-- TANGGAL --}}
                {{-- ===================================================== --}}
                <div>

                    <label for="tanggal" class="text-sm font-medium text-slate-700">

                        Tanggal

                    </label>


                    <input id="tanggal" type="date" name="tanggal" value="{{ old('tanggal', now()->toDateString()) }}"
                        required
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
                        focus:border-blue-500
                    ">

                </div>



                {{-- ===================================================== --}}
                {{-- KETERANGAN --}}
                {{-- ===================================================== --}}
                <div>

                    <label for="keterangan" id="keterangan-label" class="text-sm font-medium text-slate-700">

                        Keterangan

                        <span id="keterangan-opsional" class="text-slate-400 font-normal">

                            (Opsional)

                        </span>

                    </label>


                    <textarea id="keterangan" name="keterangan" rows="3" placeholder="Tambahkan keterangan"
                        class="
                        mt-1
                        w-full
                        border
                        border-slate-300
                        rounded-xl
                        px-4
                        py-3
                        resize-none
                        focus:ring-2
                        focus:ring-blue-500
                        focus:border-blue-500
                    ">{{ old('keterangan') }}</textarea>


                    <p id="manual-help" class="hidden text-xs text-slate-500 mt-1">

                        Jelaskan pelanggaran yang dilakukan siswa secara jelas.

                    </p>

                </div>



                {{-- ===================================================== --}}
                {{-- SUBMIT --}}
                {{-- ===================================================== --}}
                <button type="submit" id="submit-button"
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

                    Tambah Skorsing

                </button>

            </form>

        </section>



        {{-- ========================================================= --}}
        {{-- RIWAYAT --}}
        {{-- ========================================================= --}}
        <section
            class="
            bg-white
            rounded-2xl
            border
            border-slate-200
            shadow-sm
            overflow-hidden
        ">

            <div class="p-6 border-b">

                <h2 class="font-semibold text-lg">
                    Riwayat Skorsing
                </h2>

                <p class="text-sm text-slate-500">
                    Data pelanggaran yang pernah Anda tambahkan.
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


                                {{-- TANGGAL --}}
                                <td class="p-4 whitespace-nowrap">

                                    {{ $item->tanggal?->format('d/m/Y') ?? '-' }}

                                </td>



                                {{-- SISWA --}}
                                <td class="p-4">

                                    <div class="font-semibold text-slate-800">

                                        {{ $item->siswa?->nama ?? 'Siswa dihapus' }}

                                    </div>


                                    <div class="text-xs text-slate-500">

                                        {{ $item->siswa?->kelas?->nama_kelas ?? 'Belum ada kelas' }}

                                    </div>

                                </td>



                                {{-- PELANGGARAN --}}
                                <td class="p-4 min-w-[280px]">

                                    @if ($item->pelanggaran)
                                        <div class="text-slate-800">

                                            {{ $item->pelanggaran->deskripsi }}

                                        </div>


                                        @if ($item->keterangan)
                                            <div class="text-xs text-slate-500 mt-1">

                                                {{ $item->keterangan }}

                                            </div>
                                        @endif
                                    @else
                                        <div class="flex items-center gap-2 mb-1">

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
                                            font-semibold
                                        ">

                                            +{{ $item->skor }}

                                        </span>
                                    @endif

                                </td>



                                {{-- AKSI --}}
                                <td class="p-4 text-center">

                                    <form method="POST" action="{{ route('guru.skorsing.delete', $item->id) }}"
                                        onsubmit="return confirm('Hapus skorsing ini?')">

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

                                    Belum ada riwayat skorsing.

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



    {{-- ============================================================= --}}
    {{-- TOM SELECT --}}
    {{-- ============================================================= --}}
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {

            /*
            |--------------------------------------------------------------------------
            | SEARCH SISWA
            |--------------------------------------------------------------------------
            */

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


            /*
            |--------------------------------------------------------------------------
            | JENIS PENCATATAN
            |--------------------------------------------------------------------------
            */

            const jenisInputs =
                document.querySelectorAll(
                    'input[name="jenis_pencatatan"]'
                );

            const pelanggaranWrapper =
                document.getElementById(
                    'pelanggaran-master-wrapper'
                );

            const pelanggaranSelect =
                document.getElementById(
                    'pelanggaran_id'
                );

            const manualInfo =
                document.getElementById(
                    'manual-info'
                );

            const keterangan =
                document.getElementById(
                    'keterangan'
                );

            const keteranganOpsional =
                document.getElementById(
                    'keterangan-opsional'
                );

            const manualHelp =
                document.getElementById(
                    'manual-help'
                );

            const submitButton =
                document.getElementById(
                    'submit-button'
                );

            const labelMaster =
                document.getElementById(
                    'label-master'
                );

            const labelManual =
                document.getElementById(
                    'label-manual'
                );


            function updateJenisPencatatan() {
                const selected =
                    document.querySelector(
                        'input[name="jenis_pencatatan"]:checked'
                    );


                if (!selected) {
                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | MODE MANUAL
                |--------------------------------------------------------------------------
                */

                if (selected.value === 'manual') {

                    pelanggaranWrapper.classList.add(
                        'hidden'
                    );

                    manualInfo.classList.remove(
                        'hidden'
                    );


                    /*
                     * Jangan kirim pelanggaran_id.
                     */
                    pelanggaranSelect.required = false;

                    pelanggaranSelect.disabled = true;


                    /*
                     * Keterangan wajib.
                     */
                    keterangan.required = true;

                    keterangan.placeholder =
                        'Tuliskan pelanggaran yang dilakukan siswa...';


                    keteranganOpsional.classList.add(
                        'hidden'
                    );

                    manualHelp.classList.remove(
                        'hidden'
                    );


                    /*
                     * Tombol.
                     */
                    submitButton.textContent =
                        'Simpan Catatan Pelanggaran';


                    /*
                     * Style pilihan.
                     */
                    labelManual.classList.remove(
                        'border-slate-200',
                        'bg-white'
                    );

                    labelManual.classList.add(
                        'border-amber-300',
                        'bg-amber-50'
                    );


                    labelMaster.classList.remove(
                        'border-blue-200',
                        'bg-blue-50'
                    );

                    labelMaster.classList.add(
                        'border-slate-200',
                        'bg-white'
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | MODE MASTER
                |--------------------------------------------------------------------------
                */
                else {

                    pelanggaranWrapper.classList.remove(
                        'hidden'
                    );

                    manualInfo.classList.add(
                        'hidden'
                    );


                    pelanggaranSelect.disabled = false;

                    pelanggaranSelect.required = true;


                    /*
                     * Keterangan opsional.
                     */
                    keterangan.required = false;

                    keterangan.placeholder =
                        'Tambahkan keterangan';


                    keteranganOpsional.classList.remove(
                        'hidden'
                    );

                    manualHelp.classList.add(
                        'hidden'
                    );


                    submitButton.textContent =
                        'Tambah Skorsing';


                    /*
                     * Style pilihan.
                     */
                    labelMaster.classList.remove(
                        'border-slate-200',
                        'bg-white'
                    );

                    labelMaster.classList.add(
                        'border-blue-200',
                        'bg-blue-50'
                    );


                    labelManual.classList.remove(
                        'border-amber-300',
                        'bg-amber-50'
                    );

                    labelManual.classList.add(
                        'border-slate-200',
                        'bg-white'
                    );

                }
            }


            jenisInputs.forEach(function(input) {

                input.addEventListener(
                    'change',
                    updateJenisPencatatan
                );

            });


            /*
            |--------------------------------------------------------------------------
            | INITIAL STATE
            |--------------------------------------------------------------------------
            |
            | Penting agar old('jenis_pencatatan') setelah validation error
            | tetap menampilkan mode yang sebelumnya dipilih.
            |
            */

            updateJenisPencatatan();

        });
    </script>

@endsection
