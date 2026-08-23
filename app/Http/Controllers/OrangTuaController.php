<?php

namespace App\Http\Controllers;

use App\Models\OrangTua;
use App\Models\Pelanggaran;
use App\Models\RiwayatKebajikan;
use App\Models\RiwayatPelanggaran;
use App\Models\Siswa;

class OrangTuaController extends Controller
{
    /**
     * Mengambil profil orang tua berdasarkan user yang sedang login.
     */
    private function getOrangTua()
    {
        return OrangTua::where('user_id', auth()->id())
            ->firstOrFail();
    }


    /**
     * Dashboard Orang Tua
     */
    public function dashboard()
    {
        $orangTua = $this->getOrangTua();

        $anak = Siswa::with('kelas')
            ->withSum(
                'riwayatPelanggaran as total_pelanggaran',
                'skor'
            )
            ->withSum(
                'riwayatKebajikan as total_kebajikan',
                'skor'
            )
            ->where('orang_tua_id', $orangTua->id)
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
        )->sum('skor');


        $totalSkorsing = RiwayatPelanggaran::whereIn(
            'siswa_id',
            $anakIds
        )->count();


        /*
        |--------------------------------------------------------------------------
        | Total Kebajikan
        |--------------------------------------------------------------------------
        */

        $totalPoinKebajikan = RiwayatKebajikan::whereIn(
            'siswa_id',
            $anakIds
        )->sum('skor');


        $totalKebajikan = RiwayatKebajikan::whereIn(
            'siswa_id',
            $anakIds
        )->count();


        /*
        |--------------------------------------------------------------------------
        | Riwayat Pelanggaran Terbaru
        |--------------------------------------------------------------------------
        */

        $riwayatSkorsing = RiwayatPelanggaran::with([
            'siswa.kelas',
            'pelanggaran',
        ])
            ->whereIn('siswa_id', $anakIds)
            ->latest('tanggal')
            ->latest('id')
            ->limit(10)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Riwayat Kebajikan Terbaru
        |--------------------------------------------------------------------------
        */

        $riwayatKebajikan = RiwayatKebajikan::with([
            'siswa.kelas',
            'kebajikan',
        ])
            ->whereIn('siswa_id', $anakIds)
            ->latest('tanggal')
            ->latest('id')
            ->limit(10)
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


    /**
     * Daftar Jenis Pelanggaran + Riwayat Anak
     */
    public function pelanggaran()
    {
        /*
        |--------------------------------------------------------------------------
        | Ambil profil orang tua
        |--------------------------------------------------------------------------
        */

        $orangTua = $this->getOrangTua();


        /*
        |--------------------------------------------------------------------------
        | Ambil ID anak milik orang tua
        |--------------------------------------------------------------------------
        |
        | PENTING:
        | orang_tua_id di tabel siswa menunjuk ke orang_tua.id,
        | BUKAN users.id.
        |
        */

        $anakIds = Siswa::where(
            'orang_tua_id',
            $orangTua->id
        )
            ->pluck('id');


        /*
        |--------------------------------------------------------------------------
        | Riwayat Pelanggaran Anak
        |--------------------------------------------------------------------------
        */

        $riwayat = RiwayatPelanggaran::with([
            'siswa.kelas',
            'pelanggaran',
        ])
            ->whereIn('siswa_id', $anakIds)
            ->latest('tanggal')
            ->latest('id')
            ->paginate(10, ['*'], 'riwayat_page');


        /*
        |--------------------------------------------------------------------------
        | Daftar Jenis Pelanggaran
        |--------------------------------------------------------------------------
        |
        | HARUS paginate(), bukan get(),
        | karena Blade menggunakan:
        |
        | {{ $pelanggarans->links() }}
        |
        */

        $pelanggarans = Pelanggaran::orderByRaw("
                CASE
                    WHEN kategori = 'Ringan' THEN 1
                    WHEN kategori = 'Sedang' THEN 2
                    WHEN kategori = 'Sangat Berat' THEN 3
                    ELSE 4
                END
            ")
            ->orderBy('skor')
            ->paginate(10, ['*'], 'pelanggaran_page');


        return view(
            'orangtua.pelanggaran',
            compact(
                'riwayat',
                'pelanggarans'
            )
        );
    }


    /**
     * Riwayat Kebajikan Anak
     */
    public function kebajikan()
    {
        $orangTua = $this->getOrangTua();


        $siswa = Siswa::where(
            'orang_tua_id',
            $orangTua->id
        )
            ->with([
                'kelas',
                'riwayatKebajikan.kebajikan',
                'riwayatKebajikan.creator',
            ])
            ->orderBy('nama')
            ->get();


        return view(
            'orangtua.kebajikan',
            compact('siswa')
        );
    }
}