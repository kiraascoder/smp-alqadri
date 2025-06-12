<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Konseling;
use App\Models\Pelanggaran;
use App\Models\RiwayatPelanggaran;
use App\Models\Siswa;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BkController extends Controller
{
    public function index()
    {
        return view('bk.dashboard');
    }
    public function profil()
    {
        $guru = Guru::with(['user'])->where('user_id', Auth::id())->first();
        return view('bk.profil', compact('guru'));
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

        return redirect()->route('bk.profil')->with('success', 'Profil berhasil diperbarui.');
    }

    public function pengaduan()
    {
        $pelanggarans = Pelanggaran::paginate(10);
        return view('bk.pengaduan', compact('pelanggarans'));
    }
    public function pelanggaran()
    {
        $pelanggarans = Pelanggaran::paginate(10);
        return view('bk.pelanggaran', compact('pelanggarans'));
    }
    public function riwayat()
    {
        $pelanggarans = Pelanggaran::paginate(10);
        return view('bk.riwayat', compact('pelanggarans'));
    }
    public function skorsing()
    {
        $siswas = Siswa::with(['user', 'kelas'])->get();
        $riwayat = RiwayatPelanggaran::with(['siswa', 'pelanggaran'])->get();
        $pelanggarans = Pelanggaran::all();
        return view('bk.skorsing', compact('siswas', 'riwayat', 'pelanggarans'));
    }
    public function konseling()
    {
        $siswas = Siswa::with(['user', 'kelas'])->get();
        $konselings = Konseling::with(['guruBk'])->latest()->get();
        $guruBkList = User::where('role', 'guru_bk')->get();
        return view('bk.konseling', compact('konselings', 'guruBkList', 'siswas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id'   => 'required|exists:siswa,id',
            'guru_bk_id' => 'required|exists:users,id',
            'tanggal'    => 'required|date',
            'waktu'      => 'required',
            'tempat'     => 'required|string|max:255',
            'topik'      => 'nullable|string',
        ]);

        try {
            $siswa = Siswa::findOrFail($request->siswa_id);

            Konseling::create([
                'user_id'       => $siswa->user_id,
                'guru_bk_id'    => auth()->id(), 
                'tanggal'       => $request->tanggal,
                'waktu'         => $request->waktu,
                'tempat'        => $request->tempat,
                'topik'         => $request->topik,
                'status'        => 'dijadwalkan',
                'alasan_batal'  => null,
                'catatan'       => null,
            ]);

            return redirect()->back()->with('success', 'Permohonan konseling berhasil dikirim.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data konseling: ' . $e->getMessage());
        }
    }
}
