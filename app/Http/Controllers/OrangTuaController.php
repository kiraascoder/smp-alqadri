<?php

namespace App\Http\Controllers;

use App\Models\Pelanggaran;
use App\Models\RiwayatPelanggaran;
use Illuminate\Support\Facades\Auth;

class OrangTuaController extends Controller
{
    private function profile()
    {
        return Auth::user()->orangTuaProfile()->firstOrFail();
    }

    public function dashboard()
    {
        $ortu = $this->profile();
        $anak = $ortu->siswa()->with('kelas')->orderBy('nama')->get();
        $anakIds = $anak->pluck('id');
        $totalSkor = $anak->sum('score_bk');
        $totalSkorsing = RiwayatPelanggaran::whereIn('siswa_id', $anakIds)->count();
        $riwayat = RiwayatPelanggaran::with(['siswa.kelas', 'pelanggaran', 'creator'])
            ->whereIn('siswa_id', $anakIds)
            ->latest('tanggal')
            ->take(8)
            ->get();

        return view('orangtua.dashboard', compact('anak', 'totalSkor', 'totalSkorsing', 'riwayat'));
    }

    public function anak()
    {
        $anak = $this->profile()->siswa()->with('kelas')->orderBy('nama')->get();
        return view('orangtua.anak', compact('anak'));
    }

    public function pelanggaran()
    {
        $pelanggarans = Pelanggaran::orderBy('kategori')->paginate(15);
        return view('orangtua.pelanggaran', compact('pelanggarans'));
    }

    public function skorsing()
    {
        $anakIds = $this->profile()->siswa()->pluck('id');
        $riwayat = RiwayatPelanggaran::with(['siswa.kelas', 'pelanggaran', 'creator'])
            ->whereIn('siswa_id', $anakIds)
            ->latest('tanggal')
            ->paginate(15);

        return view('orangtua.skorsing', compact('riwayat'));
    }
}
