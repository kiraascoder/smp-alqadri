<?php

namespace App\Http\Controllers;

use App\Models\Konseling;
use App\Models\User;
use Illuminate\Http\Request;

class KonselingController extends Controller
{
    public function index()
    {
        $guruBkList = User::where('role', 'guru_bk')->get();
        $konselings = Konseling::with('guruBk')->where('user_id', auth()->id())->latest()->get();
        return view('siswa.konseling', compact('guruBkList', 'konselings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'guru_bk_id' => 'required|exists:users,id',
            'tanggal'    => 'required|date',
            'waktu'      => 'required',
            'tempat'     => 'required|string|max:255',
            'topik'      => 'nullable|string',
        ]);

        Konseling::create([
            'user_id'     => auth()->id(),
            'guru_bk_id'  => $request->guru_bk_id,
            'tanggal'     => $request->tanggal,
            'waktu'       => $request->waktu,
            'tempat'      => $request->tempat,
            'topik'       => $request->topik,
            'status'      => 'dijadwalkan',
            'alasan_batal' => null,
            'catatan'     => null,
        ]);

        return redirect()->back()->with('success', 'Permohonan konseling berhasil dikirim.');
    }

    public function destroy($id)
    {
        $konseling = Konseling::findOrFail($id);
        $konseling->delete();
        return redirect()->back()->with('success', 'Data konseling berhasil dihapus.');
    }
}
