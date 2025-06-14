<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Pelanggaran;
use App\Models\RiwayatPelanggaran;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class GuruController extends Controller
{
    public function index()
    {
        return view('guru.dashboard');
    }

    public function siswa()
    {
        $siswas = Siswa::with(['user', 'kelas'])->get();
        return view('guru.siswa', compact('siswas'));
    }
    public function profil()
    {
        $guru = Guru::with(['user'])->where('user_id', Auth::id())->first();
        return view('guru.profil', compact('guru'));
    }

    public function edit(Request $request)
    {
        $user = auth()->user();
        $guru = $user->guru;

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'no_hp' => 'nullable|string|max:20',
            'nip' => ['required', 'string', 'max:20', Rule::unique('guru')->ignore($guru->id)],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,

        ]);

        $guru->update([
            'nip' => $request->nip,
        ]);

        return redirect()->route('guru.profil')->with('success', 'Profil berhasil diperbarui.');
    }

    public function skorsing()
    {
        $siswas = Siswa::with(['user', 'kelas'])->get();
        $riwayat = RiwayatPelanggaran::with(['siswa', 'pelanggaran'])->get();
        $pelanggarans = Pelanggaran::all();
        return view('guru.skorsing', compact('siswas', 'riwayat', 'pelanggarans'));
    }
    public function pelanggaran()
    {
        $pelanggarans = Pelanggaran::paginate(10);
        return view('guru.pelanggaran', compact('pelanggarans'));
    }

    public function tambahSkorsing(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'pelanggarans_id' => 'required|exists:pelanggarans,id',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);
        $siswa = Siswa::find($request->siswa_id);
        $pelanggarans = Pelanggaran::find($request->pelanggarans_id);

        RiwayatPelanggaran::create([
            'siswa_id' => $siswa->id,
            'pelanggarans_id' => $request->pelanggarans_id,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);


        $siswa->score_bk -= $pelanggarans->skor;
        $siswa->save();

        return redirect()->route('guru.skorsing')->with('success', 'Skorsing berhasil ditambahkan.');
    }
}
