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
            'deskripsi' => 'required|string|max:1000',
            'skor' => 'required|integer|min:1',
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
            'deskripsi' => 'required|string|max:1000',
            'skor' => 'required|integer|min:1',
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
        /*
        |--------------------------------------------------------------------------
        | Siswa sekarang TIDAK memakai relasi user
        |--------------------------------------------------------------------------
        */

        $siswas = Siswa::with('kelas')
            ->orderBy('nama')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Master kebajikan
        |--------------------------------------------------------------------------
        */

        $kebajikans = Kebajikan::orderBy('skor')
            ->orderBy('deskripsi')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Riwayat kebajikan guru yang login
        |--------------------------------------------------------------------------
        */

        $riwayat = RiwayatKebajikan::with([
            'siswa.kelas',
            'kebajikan',
        ])
            ->where('created_by', auth()->id())
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


    public function beriPoin(Request $request)
    {
        $data = $request->validate([
            'siswa_id' => [
                'required',
                'exists:siswa,id',
            ],

            'kebajikan_id' => [
                'required',
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


        $kebajikan = Kebajikan::findOrFail(
            $data['kebajikan_id']
        );


        DB::transaction(function () use (
            $data,
            $kebajikan
        ) {

            RiwayatKebajikan::create([
                'siswa_id' => $data['siswa_id'],

                'kebajikan_id' => $kebajikan->id,

                'skor' => $kebajikan->skor,

                'tanggal' => $data['tanggal'],

                'keterangan' =>
                $data['keterangan'] ?? null,

                'created_by' => auth()->id(),
            ]);
        });


        return back()->with(
            'success',
            'Poin kebajikan +' .
                $kebajikan->skor .
                ' berhasil diberikan.'
        );
    }


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
            'Riwayat poin kebajikan berhasil dihapus.'
        );
    }
}
