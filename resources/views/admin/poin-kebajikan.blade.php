@extends('components.admin')

@section('title', 'Beri Kebajikan')

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
            padding: 11px 14px !important;
            font-size: 0.875rem;
        }

        .ts-dropdown .option.active {
            background: #ecfdf5 !important;
            color: #047857 !important;
        }

        .ts-dropdown .no-results {
            padding: 14px !important;
            color: #64748b;
            text-align: center;
            font-size: 0.875rem;
        }
    </style>


    <div class="py-8 space-y-6">

        {{-- ========================================================= --}}
        {{-- HEADER --}}
        {{-- ========================================================= --}}

        <div
            class="
            flex
            flex-col
            sm:flex-row
            sm:items-start
            sm:justify-between
            gap-4
        ">

            <div>

                <h1 class="text-3xl font-bold text-slate-900">
                    Beri Kebajikan
                </h1>

                <p class="text-slate-500 mt-1">
                    Berikan poin kebajikan dari daftar atau catat kebajikan secara manual untuk dinilai kemudian.
                </p>

            </div>


            @if (Route::has('admin.penilaian-kebajikan'))
                <a href="{{ route('admin.penilaian-kebajikan') }}"
                    class="
                    inline-flex
                    items-center
                    justify-center
                    px-4
                    py-2.5
                    rounded-xl
                    border
                    border-amber-200
                    bg-amber-50
                    text-amber-700
                    text-sm
                    font-semibold
                    hover:bg-amber-100
                    transition
                    whitespace-nowrap
                ">

                    Penilaian Kebajikan

                </a>
            @endif

        </div>



        {{-- ========================================================= --}}
        {{-- SUCCESS --}}
        {{-- ========================================================= --}}

        @if (session('success'))
            <div
                class="
                bg-emerald-50
                border
                border-emerald-200
                text-emerald-700
                rounded-xl
                p-4
            ">

                {{ session('success') }}

            </div>
        @endif



        {{-- ========================================================= --}}
        {{-- ERROR --}}
        {{-- ========================================================= --}}

        @if ($errors->any())

            <div
                class="
                bg-red-50
                border
                border-red-200
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



        {{-- ========================================================= --}}
        {{-- FORM --}}
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

            <div class="p-5 border-b border-slate-100">

                <h2 class="font-semibold text-lg text-slate-800">
                    Form Pemberian Kebajikan
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Pilih kebajikan dari daftar atau gunakan catatan manual.
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


                    {{-- ================================================= --}}
                    {{-- SISWA --}}
                    {{-- ================================================= --}}

                    <div>

                        <label for="siswa_id"
                            class="
                            block
                            text-sm
                            font-semibold
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
                                    -
                                    {{ $siswa->kelas?->nama_kelas ?? 'Belum ada kelas' }}

                                </option>
                            @endforeach

                        </select>

                    </div>



                    {{-- ================================================= --}}
                    {{-- JENIS PENCATATAN --}}
                    {{-- ================================================= --}}

                    <div>

                        <label
                            class="
                            block
                            text-sm
                            font-semibold
                            text-slate-700
                            mb-2
                        ">

                            Jenis Pencatatan

                        </label>


                        <div
                            class="
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
                                border-emerald-200
                                bg-emerald-50
                                rounded-xl
                                p-3
                                transition
                            ">

                                <div class="flex items-start gap-3">

                                    <input type="radio" name="jenis_pencatatan" value="master" class="mt-1"
                                        @checked(old('jenis_pencatatan', 'master') === 'master')>


                                    <div>

                                        <div class="text-sm font-semibold text-slate-800">
                                            Dari Daftar
                                        </div>

                                        <div class="text-xs text-slate-500 mt-1">
                                            Poin langsung mengikuti jenis kebajikan.
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

                                        <div class="text-sm font-semibold text-slate-800">
                                            Catatan Manual
                                        </div>

                                        <div class="text-xs text-slate-500 mt-1">
                                            Poin ditentukan kemudian.
                                        </div>

                                    </div>

                                </div>

                            </label>

                        </div>

                    </div>



                    {{-- ================================================= --}}
                    {{-- KEBAJIKAN MASTER --}}
                    {{-- ================================================= --}}

                    <div id="kebajikan-master-wrapper">

                        <label for="kebajikan_id"
                            class="
                            block
                            text-sm
                            font-semibold
                            text-slate-700
                            mb-2
                        ">

                            Jenis Kebajikan

                        </label>


                        <select id="kebajikan_id" name="kebajikan_id"
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


                            @foreach ($kebajikans as $kebajikan)
                                <option value="{{ $kebajikan->id }}" @selected(old('kebajikan_id') == $kebajikan->id)>

                                    {{ $kebajikan->deskripsi }}
                                    (+{{ $kebajikan->skor }} poin)
                                </option>
                            @endforeach

                        </select>


                        <p class="text-xs text-slate-400 mt-1">
                            Poin langsung mengikuti jenis kebajikan yang dipilih.
                        </p>

                    </div>



                    {{-- ================================================= --}}
                    {{-- INFO MANUAL --}}
                    {{-- ================================================= --}}

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
                                text-amber-700
                                flex
                                items-center
                                justify-center
                                font-bold
                            ">

                                !

                            </div>


                            <div>

                                <div class="text-sm font-semibold text-amber-800">
                                    Poin Belum Ditentukan
                                </div>

                                <p
                                    class="
                                    text-xs
                                    text-amber-700
                                    mt-1
                                    leading-relaxed
                                ">

                                    Tuliskan kebajikan yang dilakukan siswa pada kolom keterangan.
                                    Poin dapat ditentukan setelah catatan diperiksa.

                                </p>

                            </div>

                        </div>

                    </div>



                    {{-- ================================================= --}}
                    {{-- TANGGAL --}}
                    {{-- ================================================= --}}

                    <div>

                        <label for="tanggal"
                            class="
                            block
                            text-sm
                            font-semibold
                            text-slate-700
                            mb-2
                        ">

                            Tanggal

                        </label>


                        <input id="tanggal" type="date" name="tanggal"
                            value="{{ old('tanggal', now()->format('Y-m-d')) }}" required
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



                    {{-- ================================================= --}}
                    {{-- KETERANGAN --}}
                    {{-- ================================================= --}}

                    <div>

                        <label for="keterangan"
                            class="
                            block
                            text-sm
                            font-semibold
                            text-slate-700
                            mb-2
                        ">

                            Keterangan

                            <span id="keterangan-opsional" class="font-normal text-slate-400">

                                (Opsional)

                            </span>

                        </label>


                        <textarea id="keterangan" name="keterangan" rows="3" placeholder="Tambahkan keterangan..."
                            class="
                            w-full
                            border
                            border-slate-300
                            rounded-xl
                            px-4
                            py-3
                            resize-none
                            focus:ring-2
                            focus:ring-emerald-500
                            focus:border-emerald-500
                        ">{{ old('keterangan') }}</textarea>


                        <p id="manual-help"
                            class="
                            hidden
                            text-xs
                            text-slate-500
                            mt-1
                        ">

                            Jelaskan kebajikan yang dilakukan siswa secara jelas.

                        </p>

                    </div>

                </div>



                {{-- ================================================= --}}
                {{-- SUBMIT --}}
                {{-- ================================================= --}}

                <div
                    class="
                    mt-6
                    flex
                    justify-end
                ">

                    <button type="submit" id="submit-button"
                        class="
                        inline-flex
                        items-center
                        justify-center
                        gap-2
                        bg-emerald-600
                        hover:bg-emerald-700
                        text-white
                        px-6
                        py-3
                        rounded-xl
                        font-semibold
                        transition
                    ">

                        Berikan Kebajikan

                    </button>

                </div>

            </form>

        </section>



        {{-- ========================================================= --}}
        {{-- RIWAYAT --}}
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

            <div class="p-5 border-b border-slate-100">

                <h2 class="font-semibold text-lg text-slate-800">
                    Riwayat Kebajikan
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Seluruh kebajikan yang dicatat oleh Admin dan Guru.
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
                                <td class="p-4 font-medium text-slate-800">

                                    {{ $item->siswa?->nama ?? 'Siswa dihapus' }}

                                </td>



                                {{-- KELAS --}}
                                <td class="p-4 whitespace-nowrap">

                                    {{ $item->siswa?->kelas?->nama_kelas ?? 'Belum ada kelas' }}

                                </td>



                                {{-- KEBAJIKAN --}}
                                <td class="p-4 min-w-[250px]">

                                    @if ($item->kebajikan)
                                        <div class="text-slate-800">

                                            {{ $item->kebajikan->deskripsi }}

                                        </div>


                                        <span
                                            class="
                                            inline-flex
                                            mt-1
                                            px-2
                                            py-1
                                            rounded-full
                                            bg-emerald-50
                                            text-emerald-700
                                            text-xs
                                            font-medium
                                        ">

                                            Dari Daftar

                                        </span>
                                    @else
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
                                    @endif

                                </td>



                                {{-- POIN --}}
                                <td class="p-4">

                                    @if (is_null($item->skor))
                                        <div>

                                            <span
                                                class="
                                                inline-flex
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

                                        </div>


                                        <div
                                            class="
                                            text-xs
                                            text-amber-600
                                            mt-1
                                            whitespace-nowrap
                                        ">

                                            Menunggu penilaian

                                        </div>
                                    @else
                                        <span
                                            class="
                                            inline-flex
                                            px-3
                                            py-1
                                            rounded-full
                                            bg-emerald-50
                                            text-emerald-700
                                            font-bold
                                            whitespace-nowrap
                                        ">

                                            +{{ $item->skor }}

                                        </span>


                                        @if (is_null($item->kebajikan_id))
                                            <div
                                                class="
                                                text-xs
                                                text-emerald-600
                                                mt-1
                                                whitespace-nowrap
                                            ">

                                                Sudah dinilai

                                            </div>
                                        @endif
                                    @endif

                                </td>



                                {{-- CREATOR --}}
                                <td class="p-4 whitespace-nowrap">

                                    {{ $item->creator?->name ?? 'User dihapus' }}

                                </td>



                                {{-- KETERANGAN --}}
                                <td class="p-4 min-w-[220px]">

                                    @if ($item->keterangan)
                                        <div class="text-slate-700 leading-relaxed">

                                            {{ $item->keterangan }}

                                        </div>
                                    @else
                                        <span class="text-slate-400">
                                            -
                                        </span>
                                    @endif

                                </td>



                                {{-- AKSI --}}
                                <td class="p-4 text-center">

                                    <form method="POST" action="{{ route('admin.poin-kebajikan.delete', $item->id) }}"
                                        onsubmit="return confirm('Hapus riwayat kebajikan ini?')">

                                        @csrf
                                        @method('DELETE')


                                        <button type="submit"
                                            class="
                                            px-3
                                            py-2
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



            {{-- PAGINATION --}}
            @if ($riwayat->hasPages())
                <div
                    class="
                    p-4
                    border-t
                    border-slate-100
                ">

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


            const kebajikanWrapper =
                document.getElementById(
                    'kebajikan-master-wrapper'
                );


            const kebajikanSelect =
                document.getElementById(
                    'kebajikan_id'
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



            /*
            |--------------------------------------------------------------------------
            | UPDATE MODE
            |--------------------------------------------------------------------------
            */

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
                | MANUAL
                |--------------------------------------------------------------------------
                */

                if (selected.value === 'manual') {

                    kebajikanWrapper.classList.add(
                        'hidden'
                    );


                    manualInfo.classList.remove(
                        'hidden'
                    );


                    /*
                     * Tidak mengirim kebajikan_id.
                     */
                    kebajikanSelect.required = false;

                    kebajikanSelect.disabled = true;


                    /*
                     * Keterangan wajib.
                     */
                    keterangan.required = true;

                    keterangan.placeholder =
                        'Tuliskan kebajikan yang dilakukan siswa...';


                    keteranganOpsional.classList.add(
                        'hidden'
                    );


                    manualHelp.classList.remove(
                        'hidden'
                    );


                    submitButton.textContent =
                        'Simpan Catatan Kebajikan';


                    /*
                     * Style manual aktif.
                     */
                    labelManual.classList.remove(
                        'border-slate-200',
                        'bg-white'
                    );


                    labelManual.classList.add(
                        'border-amber-300',
                        'bg-amber-50'
                    );


                    /*
                     * Master nonaktif.
                     */
                    labelMaster.classList.remove(
                        'border-emerald-200',
                        'bg-emerald-50'
                    );


                    labelMaster.classList.add(
                        'border-slate-200',
                        'bg-white'
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | MASTER
                |--------------------------------------------------------------------------
                */
                else {

                    kebajikanWrapper.classList.remove(
                        'hidden'
                    );


                    manualInfo.classList.add(
                        'hidden'
                    );


                    kebajikanSelect.disabled = false;

                    kebajikanSelect.required = true;


                    keterangan.required = false;

                    keterangan.placeholder =
                        'Tambahkan keterangan...';


                    keteranganOpsional.classList.remove(
                        'hidden'
                    );


                    manualHelp.classList.add(
                        'hidden'
                    );


                    submitButton.textContent =
                        'Berikan Kebajikan';


                    /*
                     * Master aktif.
                     */
                    labelMaster.classList.remove(
                        'border-slate-200',
                        'bg-white'
                    );


                    labelMaster.classList.add(
                        'border-emerald-200',
                        'bg-emerald-50'
                    );


                    /*
                     * Manual nonaktif.
                     */
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



            /*
            |--------------------------------------------------------------------------
            | EVENT
            |--------------------------------------------------------------------------
            */

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
            */

            updateJenisPencatatan();

        });
    </script>

@endsection
