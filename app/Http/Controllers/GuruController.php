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
        $skorsingCount = RiwayatPelanggaran::where('created_by', Auth::id())->count();
        $skorsingBulanIni = RiwayatPelanggaran::where('created_by', Auth::id())
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->count();
        $riwayat = RiwayatPelanggaran::with(['siswa.kelas', 'pelanggaran'])
            ->where('created_by', Auth::id())
            ->latest('tanggal')
            ->take(8)
            ->get();

        return view('guru.dashboard', compact('skorsingCount', 'skorsingBulanIni', 'riwayat'));
    }

    public function profil()
    {
        $guru = Guru::with('user')->where('user_id', Auth::id())->firstOrFail();
        return view('guru.profil', compact('guru'));
    }

    public function edit(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function pelanggaran()
    {
        $pelanggarans = Pelanggaran::orderBy('kategori')->paginate(10);
        return view('guru.pelanggaran', compact('pelanggarans'));
    }

    public function skorsing()
    {
        $siswas = Siswa::with('kelas')->orderBy('nama')->get();
        $pelanggarans = Pelanggaran::orderBy('kategori')->orderBy('deskripsi')->get();
        $riwayat = RiwayatPelanggaran::with(['siswa.kelas', 'pelanggaran'])
            ->where('created_by', Auth::id())
            ->latest('tanggal')
            ->paginate(15);

        return view('guru.skorsing', compact('siswas', 'riwayat', 'pelanggarans'));
    }

    public function tambahSkorsing(Request $request)
    {
        $data = $request->validate([
            'siswa_id' => ['required', 'exists:siswa,id'],
            'pelanggaran_id' => ['required', 'exists:pelanggarans,id'],
            'tanggal' => ['required', 'date'],
            'keterangan' => ['nullable', 'string', 'max:2000'],
        ]);

        $siswa = DB::transaction(function () use ($data) {
            $siswa = Siswa::lockForUpdate()->findOrFail($data['siswa_id']);
            $pelanggaran = Pelanggaran::findOrFail($data['pelanggaran_id']);

            RiwayatPelanggaran::create($data + [
                'created_by' => Auth::id(),
                'skor' => $pelanggaran->skor,
            ]);
            $siswa->increment('score_bk', $pelanggaran->skor);

            return $siswa->fresh();
        });

        return back()->with('success', "Skorsing {$siswa->nama} berhasil ditambahkan.");
    }

    public function detailSkorsing(int $id)
    {
        $skorsing = RiwayatPelanggaran::with(['siswa.kelas', 'pelanggaran'])
            ->where('created_by', Auth::id())
            ->findOrFail($id);

        return response()->json([
            'id' => $skorsing->id,
            'siswa' => [
                'nama' => $skorsing->siswa?->nama,
                'kelas' => $skorsing->siswa?->kelas?->nama_kelas,
                'score_bk' => $skorsing->siswa?->score_bk,
            ],
            'pelanggaran' => [
                'deskripsi' => $skorsing->pelanggaran?->deskripsi,
                'skor' => $skorsing->skor,
            ],
            'tanggal' => optional($skorsing->tanggal)->format('Y-m-d'),
            'keterangan' => $skorsing->keterangan,
        ]);
    }

    public function destroySkorsing(int $id)
    {
        DB::transaction(function () use ($id) {
            $riwayat = RiwayatPelanggaran::with('pelanggaran')
                ->where('created_by', Auth::id())
                ->lockForUpdate()
                ->findOrFail($id);

            $siswa = Siswa::lockForUpdate()->findOrFail($riwayat->siswa_id);
            $siswa->score_bk = max(0, $siswa->score_bk - $riwayat->skor);
            $siswa->save();
            $riwayat->delete();
        });

        return back()->with('success', 'Skorsing berhasil dihapus.');
    }
}
