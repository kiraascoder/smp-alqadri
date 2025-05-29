<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Pelanggaran;
use Illuminate\Http\Request;
use App\Models\User;

class LaporanController extends Controller
{
    public function laporan()
    {
        $laporans = Laporan::with(['siswa', 'guru', 'pelanggaran', 'konseling'])->latest()->get();
        $siswaList = User::where('role', 'siswa')->get();
        $guruList = User::where('role', 'guru_bk')->get();
        $pelanggaranList = Pelanggaran::all();
        return view('siswa.laporan', compact('laporans', 'siswaList', 'guruList', 'pelanggaranList'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'pelanggaran_id' => 'required|exists:pelanggarans,id',
            'guru_id' => 'required|exists:users,id',
            'deskripsi' => 'nullable|string',
        ]);

        Laporan::create([
            'user_id' => $request->user_id,
            'pelanggaran_id' => $request->pelanggaran_id,
            'guru_id' => $request->guru_id,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil ditambahkan.');
    }
    public function destroy($id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->delete();

        return redirect()->back()->with('success', 'Laporan berhasil dihapus.');
    }
}
