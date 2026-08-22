<?php

namespace App\Http\Controllers;

use App\Models\OrangTua;
use App\Models\Pelanggaran;
use App\Models\RiwayatKebajikan;
use App\Models\RiwayatPelanggaran;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;

class OrangTuaController extends Controller
{
    public function dashboard()
    {
        /*
    |--------------------------------------------------------------------------
    | Cari data orang tua berdasarkan user yang login
    |--------------------------------------------------------------------------
    */

        $orangTua = OrangTua::where(
            'user_id',
            auth()->id()
        )->firstOrFail();


        /*
    |--------------------------------------------------------------------------
    | Ambil anak berdasarkan ID tabel orang_tua
    |--------------------------------------------------------------------------
    */

        $anak = Siswa::with('kelas')
            ->withSum(
                'riwayatPelanggaran as total_pelanggaran',
                'skor'
            )
            ->withSum(
                'riwayatKebajikan as total_kebajikan',
                'skor'
            )
            ->where(
                'orang_tua_id',
                $orangTua->id
            )
            ->orderBy('nama')
            ->get();


        $anakIds = $anak->pluck('id');


        /*
    |--------------------------------------------------------------------------
    | Total Pelanggaran
    |--------------------------------------------------------------------------
    */

        $totalSkorPelanggaran = RiwayatPelanggaran::whereIn(
            'siswa_id',
            $anakIds
        )
            ->sum('skor');


        $totalSkorsing = RiwayatPelanggaran::whereIn(
            'siswa_id',
            $anakIds
        )
            ->count();


        /*
    |--------------------------------------------------------------------------
    | Total Kebajikan
    |--------------------------------------------------------------------------
    */

        $totalPoinKebajikan = RiwayatKebajikan::whereIn(
            'siswa_id',
            $anakIds
        )
            ->sum('skor');


        $totalKebajikan = RiwayatKebajikan::whereIn(
            'siswa_id',
            $anakIds
        )
            ->count();


        /*
    |--------------------------------------------------------------------------
    | Riwayat Pelanggaran
    |--------------------------------------------------------------------------
    */

        $riwayatSkorsing = RiwayatPelanggaran::with([
            'siswa.kelas',
            'pelanggaran',
        ])
            ->whereIn(
                'siswa_id',
                $anakIds
            )
            ->latest('tanggal')
            ->latest('id')
            ->take(10)
            ->get();


        /*
    |--------------------------------------------------------------------------
    | Riwayat Kebajikan
    |--------------------------------------------------------------------------
    */

        $riwayatKebajikan = RiwayatKebajikan::with([
            'siswa.kelas',
            'kebajikan',
        ])
            ->whereIn(
                'siswa_id',
                $anakIds
            )
            ->latest('tanggal')
            ->latest('id')
            ->take(10)
            ->get();


        return view(
            'orangtua.dashboard',
            compact(
                'anak',
                'totalSkorPelanggaran',
                'totalSkorsing',
                'totalPoinKebajikan',
                'totalKebajikan',
                'riwayatSkorsing',
                'riwayatKebajikan'
            )
        );
    }


    public function pelanggaran()
    {
        $user = Auth::user();

        $anakIds = Siswa::where(
            'orang_tua_id',
            $user->id
        )
            ->pluck('id');

        $riwayat = RiwayatPelanggaran::with([
            'siswa.kelas',
            'pelanggaran',
        ])
            ->whereIn('siswa_id', $anakIds)
            ->latest('tanggal')
            ->paginate(10);

        $pelanggarans = Pelanggaran::orderBy('kategori')
            ->orderBy('skor')
            ->get();

        return view(
            'orangtua.pelanggaran',
            compact(
                'riwayat',
                'pelanggarans'
            )
        );
    }
    public function kebajikan()
    {
        $orangTua = auth()->user()->orangTua;


        $siswa = $orangTua
            ->siswa()
            ->with([
                'kelas',
                'riwayatKebajikan.kebajikan',
                'riwayatKebajikan.creator'
            ])
            ->get();


        return view('orangtua.kebajikan', compact('siswa'));
    }
}
