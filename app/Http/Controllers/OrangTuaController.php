<?php

namespace App\Http\Controllers;

use App\Models\Pelanggaran;
use App\Models\RiwayatPelanggaran;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrangTuaController extends Controller
{
    public function anak()
    {
        $user = Auth::user();

        if ($user->role !== 'orang_tua') {
            abort(403);
        }
        $anak = $user->anakSiswa()->with('user')->get();


        return view('orangtua.anak', compact('anak'));
    }

    public function pelanggaran()
    {
        $user = Auth::user();
        $anakIds = $user->anak->pluck('id'); 
        $riwayat = RiwayatPelanggaran::with(['siswa', 'pelanggaran'])
            ->whereIn('siswa_id', $anakIds)
            ->orderBy('tanggal', 'desc')
            ->paginate(10);


        $siswas = $user->anak()->with('kelas')->get();

        $pelanggarans = Pelanggaran::all();

        return view('orangtua.pelanggaran', compact('siswas', 'riwayat', 'pelanggarans'));
    }
}
