<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Pelanggaran;
use App\Models\RiwayatPelanggaran;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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

        // Validation rules
        $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'no_hp' => 'nullable|string|max:20',
        ]);
        $avatarPath = $user->avatar;
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {

            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }


        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'avatar' => $avatarPath
        ]);

        return redirect()->route('guru.profil')->with('success', 'Profil berhasil diperbarui.');
    }

    public function detailSkorsing($id)
    {
        try {

            $skorsing = RiwayatPelanggaran::with([
                'siswa.user',
                'siswa.kelas',
                'pelanggaran'
            ])
                ->where('id', $id)
                ->first();

            if (!$skorsing) {
                return response()->json([
                    'error' => 'Data skorsing tidak ditemukan'
                ], 404);
            }

            if (!$skorsing->siswa) {
                return response()->json([
                    'error' => 'Data siswa tidak ditemukan'
                ], 404);
            }

            \Log::info('=== DEBUG SKORSING ===');
            \Log::info('Skorsing ID: ' . $id);
            \Log::info('Siswa Data: ', $skorsing->siswa->toArray());
            \Log::info('Score BK: ' . ($skorsing->siswa->score_bk ?? 'NULL'));

            $response = [
                'id' => $skorsing->id,
                'siswa' => [
                    'user' => [
                        'name' => $skorsing->siswa->user->name ?? '-'
                    ],
                    'nisn' => $skorsing->siswa->nisn ?? '-',
                    'score_bk' => $skorsing->siswa->score_bk ?? 0,
                    'kelas' => [
                        'nama_kelas' => $skorsing->siswa->kelas->nama_kelas ?? '-'
                    ]
                ],
                'pelanggaran' => [
                    'deskripsi' => $skorsing->pelanggaran->deskripsi ?? '-',
                    'skor' => $skorsing->pelanggaran->skor ?? 0
                ],
                'tanggal' => $skorsing->tanggal,
                'keterangan' => $skorsing->keterangan,
                'created_at' => $skorsing->created_at
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            \Log::error('Error in detailSkorsing: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'error' => 'Terjadi kesalahan server',
                'message' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }
    public function skorsing()
    {
        $siswas = Siswa::with(['user', 'kelas'])->get();
        $riwayat = RiwayatPelanggaran::with(['siswa', 'pelanggaran'])
            ->orderBy('tanggal', 'desc')
            ->paginate(10);
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
            'pelanggaran_id' => 'required|exists:pelanggarans,id',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $siswa = Siswa::find($request->siswa_id);
            $pelanggaran = Pelanggaran::find($request->pelanggaran_id);


            RiwayatPelanggaran::create([
                'siswa_id' => $siswa->id,
                'pelanggaran_id' => $request->pelanggaran_id,
                'tanggal' => $request->tanggal,
                'keterangan' => $request->keterangan,
            ]);


            $siswa->score_bk = ($siswa->score_bk ?? 0) + $pelanggaran->skor;
            $siswa->save();

            DB::commit();

            return redirect()->route('guru.skorsing')->with(
                'success',
                "Skorsing berhasil ditambahkan. Skor {$siswa->user->name} sekarang: {$siswa->score_bk} poin"
            );
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error tambah skorsing: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambah skorsing.');
        }
    }
}
