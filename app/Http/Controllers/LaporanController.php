<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Pelanggaran;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function laporan()
    {
        $laporans = Laporan::with(['siswa', 'pelanggaran', 'pelapor'])
            ->where('pelapor_id', Auth::id())
            ->latest()
            ->get();
        $siswas = User::where('role', 'siswa')->get();
        $currentUserId = auth()->id();
        $gurus = User::where('role', 'guru_bk')->get();
        $pelanggarans = Pelanggaran::all();
        return view('siswa.laporan', compact('laporans', 'siswas', 'gurus', 'pelanggarans', 'currentUserId'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'pelanggaran_id' => 'required|exists:pelanggarans,id',
            'deskripsi' => 'nullable|string',
        ]);

        Laporan::create([
            'user_id' => $request->user_id,
            'pelanggaran_id' => $request->pelanggaran_id,
            'pelapor_id' => auth()->id(),
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->back()->with('success',  'Laporan berhasil ditambahkan.');
    }
    public function destroy($id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->delete();

        return redirect()->back()->with('success', 'Laporan berhasil dihapus.');
    }
}
