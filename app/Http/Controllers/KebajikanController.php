<?php

namespace App\Http\Controllers;

use App\Models\Kebajikan;
use App\Models\RiwayatKebajikan;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KebajikanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ADMIN - MASTER KEBAJIKAN
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $kebajikans = Kebajikan::orderBy('skor')
            ->orderBy('deskripsi')
            ->paginate(10);

        return view(
            'admin.kebajikan',
            compact('kebajikans')
        );
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'deskripsi' => [
                'required',
                'string',
                'max:1000',
            ],

            'skor' => [
                'required',
                'integer',
                'min:1',
            ],
        ]);


        Kebajikan::create($data);


        return back()->with(
            'success',
            'Jenis kebajikan berhasil ditambahkan.'
        );
    }


    public function update(
        Request $request,
        Kebajikan $kebajikan
    ) {
        $data = $request->validate([
            'deskripsi' => [
                'required',
                'string',
                'max:1000',
            ],

            'skor' => [
                'required',
                'integer',
                'min:1',
            ],
        ]);


        $kebajikan->update($data);


        return back()->with(
            'success',
            'Jenis kebajikan berhasil diperbarui.'
        );
    }


    public function destroy(Kebajikan $kebajikan)
    {
        if ($kebajikan->riwayat()->exists()) {

            return back()->with(
                'error',
                'Jenis kebajikan tidak dapat dihapus karena sudah digunakan.'
            );
        }


        $kebajikan->delete();


        return back()->with(
            'success',
            'Jenis kebajikan berhasil dihapus.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | GURU - POIN KEBAJIKAN
    |--------------------------------------------------------------------------
    */

    public function guruIndex()
    {
        $siswas = Siswa::with('kelas')
            ->orderBy('nama')
            ->get();


        $kebajikans = Kebajikan::orderBy('skor')
            ->orderBy('deskripsi')
            ->get();


        $riwayat = RiwayatKebajikan::with([
            'siswa.kelas',
            'kebajikan',
        ])
            ->where(
                'created_by',
                auth()->id()
            )
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->paginate(10);


        return view(
            'guru.kebajikan',
            compact(
                'siswas',
                'kebajikans',
                'riwayat'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SIMPAN KEBAJIKAN
    |--------------------------------------------------------------------------
    |
    | jenis_pencatatan:
    |
    | master
    | - memilih jenis kebajikan
    | - skor langsung dari master
    |
    | manual
    | - guru hanya menulis keterangan
    | - kebajikan_id = NULL
    | - skor = NULL
    | - poin ditentukan Admin kemudian
    |
    */

    public function beriPoin(Request $request)
    {
        $data = $request->validate([
            'jenis_pencatatan' => [
                'required',
                'in:master,manual',
            ],

            'siswa_id' => [
                'required',
                'exists:siswa,id',
            ],

            'kebajikan_id' => [
                'nullable',
                'required_if:jenis_pencatatan,master',
                'exists:kebajikans,id',
            ],

            'tanggal' => [
                'required',
                'date',
            ],

            'keterangan' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | CATATAN MANUAL WAJIB MEMILIKI KETERANGAN
        |--------------------------------------------------------------------------
        */

        if (
            $data['jenis_pencatatan'] === 'manual' &&
            empty(trim($data['keterangan'] ?? ''))
        ) {

            return back()
                ->withErrors([
                    'keterangan' =>
                    'Keterangan kebajikan wajib diisi untuk pencatatan manual.',
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | MODE MANUAL
        |--------------------------------------------------------------------------
        */

        if ($data['jenis_pencatatan'] === 'manual') {

            DB::transaction(function () use ($data) {

                RiwayatKebajikan::create([
                    'siswa_id' =>
                    $data['siswa_id'],

                    'kebajikan_id' =>
                    null,

                    'skor' =>
                    null,

                    'tanggal' =>
                    $data['tanggal'],

                    'keterangan' =>
                    $data['keterangan'],

                    'created_by' =>
                    auth()->id(),

                    'dinilai_oleh' =>
                    null,

                    'dinilai_pada' =>
                    null,
                ]);
            });


            return back()->with(
                'success',
                'Catatan kebajikan berhasil disimpan dan menunggu penentuan poin.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | MODE MASTER
        |--------------------------------------------------------------------------
        */

        $kebajikan = Kebajikan::findOrFail(
            $data['kebajikan_id']
        );


        DB::transaction(function () use (
            $data,
            $kebajikan
        ) {

            RiwayatKebajikan::create([
                'siswa_id' =>
                $data['siswa_id'],

                'kebajikan_id' =>
                $kebajikan->id,

                'skor' =>
                $kebajikan->skor,

                'tanggal' =>
                $data['tanggal'],

                'keterangan' =>
                $data['keterangan'] ?? null,

                'created_by' =>
                auth()->id(),
            ]);
        });


        return back()->with(
            'success',
            'Poin kebajikan +' .
                $kebajikan->skor .
                ' berhasil diberikan.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | HAPUS RIWAYAT GURU
    |--------------------------------------------------------------------------
    */

    public function hapusRiwayat(
        RiwayatKebajikan $riwayat
    ) {
        abort_unless(
            (int) $riwayat->created_by ===
                (int) auth()->id(),
            403
        );


        $riwayat->delete();


        return back()->with(
            'success',
            'Riwayat kebajikan berhasil dihapus.'
        );
    }
}
