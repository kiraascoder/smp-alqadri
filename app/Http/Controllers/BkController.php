<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Konseling;
use App\Models\Laporan;
use App\Models\Pelanggaran;
use App\Models\RiwayatPelanggaran;
use App\Models\Siswa;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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

        return redirect()->route('bk.profil')->with('success', 'Profil berhasil diperbarui.');
    }


    public function pengaduan()
    {
        $laporans = Laporan::with(['siswa.kelas', 'pelapor', 'pelanggaran'])->latest()->get();

        $siswas = User::where('role', 'siswa')
            ->with(['siswa.kelas'])
            ->get();

        $currentUserId = auth()->id();
        $gurus = User::where('role', 'guru_bk')->get();
        $pelanggarans = Pelanggaran::paginate(10);
        return view('bk.pengaduan', compact('pelanggarans', 'laporans', 'siswas', 'gurus', 'currentUserId'));
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
        $riwayat = RiwayatPelanggaran::with(['siswa', 'pelanggaran'])
            ->orderBy('tanggal', 'desc')
            ->paginate(10);
        $pelanggarans = Pelanggaran::all();
        return view('bk.skorsing', compact('siswas', 'riwayat', 'pelanggarans'));
    }
    public function konseling()
    {
        $currentGuruId = Auth::id();


        $konselings = Konseling::with([
            'siswa.siswaProfile.kelas',
            'siswa',
            'guruBk'
        ])
            ->where('guru_bk_id', $currentGuruId)
            ->orderBy('tanggal', 'desc')
            ->orderBy('waktu', 'desc')
            ->get();


        $siswas = User::where('role', 'siswa')
            ->with('siswaProfile.kelas')
            ->orderBy('name', 'asc')
            ->get();

        return view('bk.konseling', compact('konselings', 'siswas'));
    }
    public function siswa()
    {
        $siswas = Siswa::with(['user', 'kelas'])->get();
        return view('bk.siswa', compact('siswas'));
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

            return redirect()->route('bk.skorsing')->with(
                'success',
                "Skorsing berhasil ditambahkan. Skor {$siswa->user->name} sekarang: {$siswa->score_bk} poin"
            );
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error tambah skorsing: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambah skorsing.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'    => 'required|exists:users,id',
            'tanggal'    => 'required|date|after_or_equal:today',
            'waktu'      => 'required',
            'tempat'     => 'required|string|max:255',
            'topik'      => 'nullable|string|max:1000',
        ], [
            'user_id.required' => 'Pilih siswa yang akan dikonseling.',
            'user_id.exists' => 'Siswa yang dipilih tidak valid.',
            'tanggal.required' => 'Tanggal konseling harus diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'tanggal.after_or_equal' => 'Tanggal konseling tidak boleh sebelum hari ini.',
            'waktu.required' => 'Waktu konseling harus diisi.',
            'tempat.required' => 'Tempat konseling harus diisi.',
            'tempat.max' => 'Tempat konseling maksimal 255 karakter.',
            'topik.max' => 'Topik konseling maksimal 1000 karakter.',
        ]);

        // Check if selected user is actually a student
        $siswa = User::where('id', $request->user_id)
            ->where('role', 'siswa')
            ->first();

        if (!$siswa) {
            return redirect()->back()
                ->withErrors(['user_id' => 'User yang dipilih bukan siswa.'])
                ->withInput();
        }

        // Check for scheduling conflicts for the same guru
        $conflictCheck = Konseling::where('guru_bk_id', Auth::id())
            ->where('tanggal', $request->tanggal)
            ->where('waktu', $request->waktu)
            ->where('status', '!=', 'batal')
            ->exists();

        if ($conflictCheck) {
            return redirect()->back()
                ->withErrors(['waktu' => 'Anda sudah memiliki jadwal konseling pada tanggal dan waktu tersebut.'])
                ->withInput();
        }

        // Check if student already has konseling at the same time
        $studentConflict = Konseling::where('user_id', $request->user_id)
            ->where('tanggal', $request->tanggal)
            ->where('waktu', $request->waktu)
            ->where('status', '!=', 'batal')
            ->exists();

        if ($studentConflict) {
            return redirect()->back()
                ->withErrors(['waktu' => 'Siswa sudah memiliki jadwal konseling pada tanggal dan waktu tersebut.'])
                ->withInput();
        }

        try {
            Konseling::create([
                'user_id'     => $request->user_id,
                'guru_bk_id'  => Auth::id(),
                'tanggal'     => $request->tanggal,
                'waktu'       => $request->waktu,
                'tempat'      => $request->tempat,
                'topik'       => $request->topik,
                'status'      => 'dijadwalkan',
                'alasan_batal' => null,
                'catatan'     => null,
            ]);

            return redirect()->back()
                ->with('success', 'Konseling berhasil dijadwalkan untuk siswa ' . $siswa->name . '.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.'])
                ->withInput();
        }
    }

    /**
     * Update konseling status and add notes
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:dijadwalkan,selesai,batal',
            'catatan' => 'nullable|string|max:1000',
            'alasan_batal' => 'required_if:status,batal|nullable|string|max:500',
        ], [
            'status.required' => 'Status harus dipilih.',
            'status.in' => 'Status tidak valid.',
            'catatan.max' => 'Catatan maksimal 1000 karakter.',
            'alasan_batal.required_if' => 'Alasan pembatalan harus diisi jika status batal.',
            'alasan_batal.max' => 'Alasan pembatalan maksimal 500 karakter.',
        ]);

        $konseling = Konseling::where('id', $id)
            ->where('guru_bk_id', Auth::id())
            ->first();

        if (!$konseling) {
            return redirect()->back()
                ->withErrors(['error' => 'Konseling tidak ditemukan atau Anda tidak memiliki akses.']);
        }

        try {
            $konseling->update([
                'status' => $request->status,
                'catatan' => $request->catatan,
                'alasan_batal' => $request->status === 'batal' ? $request->alasan_batal : null,
            ]);

            $statusText = $request->status === 'selesai' ? 'diselesaikan' : ($request->status === 'batal' ? 'batal' : 'diperbarui');

            return redirect()->back()
                ->with('success', 'Status konseling berhasil ' . $statusText . '.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan saat memperbarui status. Silakan coba lagi.']);
        }
    }

    public function destroy($id)
    {
        $konseling = Konseling::where('id', $id)
            ->where('guru_bk_id', Auth::id())
            ->first();

        if (!$konseling) {
            return redirect()->back()
                ->withErrors(['error' => 'Konseling tidak ditemukan atau Anda tidak memiliki akses.']);
        }

        // Only allow deletion if status is 'dijadwalkan'
        if ($konseling->status !== 'dijadwalkan') {
            return redirect()->back()
                ->withErrors(['error' => 'Hanya konseling dengan status "dijadwalkan" yang dapat dihapus.']);
        }

        try {
            $siswaName = $konseling->siswa->name;
            $konseling->delete();

            return redirect()->back()
                ->with('success', 'Konseling dengan siswa ' . $siswaName . ' berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan saat menghapus konseling. Silakan coba lagi.']);
        }
    }

    /**
     * Get konseling statistics for dashboard
     */
    public function getStatistics()
    {
        $currentGuruId = Auth::id();

        $stats = [
            'total' => Konseling::where('guru_bk_id', $currentGuruId)->count(),
            'dijadwalkan' => Konseling::where('guru_bk_id', $currentGuruId)
                ->where('status', 'dijadwalkan')->count(),
            'selesai' => Konseling::where('guru_bk_id', $currentGuruId)
                ->where('status', 'selesai')->count(),
            'batal' => Konseling::where('guru_bk_id', $currentGuruId)
                ->where('status', 'batal')->count(),
            'bulan_ini' => Konseling::where('guru_bk_id', $currentGuruId)
                ->whereMonth('tanggal', Carbon::now()->month)
                ->whereYear('tanggal', Carbon::now()->year)
                ->count(),
            'minggu_ini' => Konseling::where('guru_bk_id', $currentGuruId)
                ->whereBetween('tanggal', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->count(),
        ];

        return $stats;
    }

    /**
     * Get upcoming konseling for today and tomorrow
     */
    public function getUpcomingKonseling()
    {
        $currentGuruId = Auth::id();

        $upcoming = Konseling::with(['siswa'])
            ->where('guru_bk_id', $currentGuruId)
            ->where('status', 'dijadwalkan')
            ->whereBetween('tanggal', [
                Carbon::today(),
                Carbon::tomorrow()
            ])
            ->orderBy('tanggal', 'asc')
            ->orderBy('waktu', 'asc')
            ->get();

        return $upcoming;
    }

    /**
     * Reschedule konseling
     */
    public function reschedule(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date|after_or_equal:today',
            'waktu' => 'required',
            'tempat' => 'required|string|max:255',
        ], [
            'tanggal.required' => 'Tanggal baru harus diisi.',
            'tanggal.after_or_equal' => 'Tanggal tidak boleh sebelum hari ini.',
            'waktu.required' => 'Waktu baru harus diisi.',
            'tempat.required' => 'Tempat harus diisi.',
        ]);

        $konseling = Konseling::where('id', $id)
            ->where('guru_bk_id', Auth::id())
            ->where('status', 'dijadwalkan')
            ->first();

        if (!$konseling) {
            return redirect()->back()
                ->withErrors(['error' => 'Konseling tidak ditemukan atau tidak dapat dijadwal ulang.']);
        }

        // Check for conflicts
        $conflictCheck = Konseling::where('guru_bk_id', Auth::id())
            ->where('id', '!=', $id)
            ->where('tanggal', $request->tanggal)
            ->where('waktu', $request->waktu)
            ->where('status', '!=', 'batal')
            ->exists();

        if ($conflictCheck) {
            return redirect()->back()
                ->withErrors(['waktu' => 'Anda sudah memiliki jadwal konseling pada tanggal dan waktu tersebut.']);
        }

        try {
            $konseling->update([
                'tanggal' => $request->tanggal,
                'waktu' => $request->waktu,
                'tempat' => $request->tempat,
            ]);

            return redirect()->back()
                ->with('success', 'Jadwal konseling berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan saat memperbarui jadwal.']);
        }
    }

    public function destroyPengaduan($id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->delete();

        return redirect()->back()->with('success', 'Laporan berhasil dihapus.');
    }

    public function detailSkorsing($id)
    {
        try {
            // Query dengan eager loading yang lebih eksplisit
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

            if (!$skorsing->siswa->user) {
                return response()->json([
                    'error' => 'Data user siswa tidak ditemukan'
                ], 404);
            }

            // Debug logging
            \Log::info('=== DEBUG SKORSING BK ===');
            \Log::info('Skorsing ID: ' . $id);
            \Log::info('Siswa ID: ' . ($skorsing->siswa->id ?? 'NULL'));
            \Log::info('Kelas ID: ' . ($skorsing->siswa->kelas_id ?? 'NULL'));
            \Log::info('Kelas Object: ' . ($skorsing->siswa->kelas ? 'EXISTS' : 'NULL'));
            \Log::info('Kelas Name: ' . ($skorsing->siswa->kelas->nama_kelas ?? 'NULL'));

            // Pastikan semua data ada sebelum membuat response
            $kelasName = 'Tidak ada kelas';
            if ($skorsing->siswa->kelas && isset($skorsing->siswa->kelas->nama_kelas)) {
                $kelasName = $skorsing->siswa->kelas->nama_kelas;
            } elseif ($skorsing->siswa->kelas_id) {
                // Jika relasi tidak ter-load, coba query manual
                $kelas = \App\Models\Kelas::find($skorsing->siswa->kelas_id);
                $kelasName = $kelas ? $kelas->nama_kelas : 'Kelas tidak ditemukan';
            }

            $response = [
                'id' => $skorsing->id,
                'siswa' => [
                    'id' => $skorsing->siswa->id,
                    'user' => [
                        'name' => $skorsing->siswa->user->name ?? 'Nama tidak tersedia'
                    ],
                    'nisn' => $skorsing->siswa->nisn ?? 'NISN tidak tersedia',
                    'score_bk' => $skorsing->siswa->score_bk ?? 0,
                    'kelas_id' => $skorsing->siswa->kelas_id ?? null,
                    'kelas' => [
                        'nama_kelas' => $kelasName
                    ]
                ],
                'pelanggaran' => [
                    'deskripsi' => $skorsing->pelanggaran->deskripsi ?? 'Pelanggaran tidak tersedia',
                    'skor' => $skorsing->pelanggaran->skor ?? 0
                ],
                'tanggal' => $skorsing->tanggal,
                'keterangan' => $skorsing->keterangan,
                'created_at' => $skorsing->created_at
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            \Log::error('Error in BK detailSkorsing: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'error' => 'Terjadi kesalahan server',
                'message' => config('app.debug') ? $e->getMessage() : 'Internal server error',
                'debug_info' => config('app.debug') ? [
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ] : null
            ], 500);
        }
    }


    public function destroySkorsing($id)
    {
        try {
            DB::beginTransaction();

            $skorsing = RiwayatPelanggaran::with(['siswa.user', 'pelanggaran'])
                ->where('id', $id)
                ->first();

            if (!$skorsing) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data pelanggaran tidak ditemukan'
                ], 404);
            }

            $siswa = $skorsing->siswa;
            $siswaName = $siswa->user->name ?? 'Siswa';
            $pelanggaranDesc = $skorsing->pelanggaran->deskripsi ?? 'Pelanggaran';
            $poin = $skorsing->pelanggaran->skor ?? 0;


            if ($siswa) {
                $currentScore = $siswa->score_bk ?? 0;
                $newScore = max(0, $currentScore - $poin);

                $siswa->score_bk = $newScore;
                $siswa->save();
            }


            $skorsing->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Data pelanggaran {$pelanggaranDesc} untuk siswa {$siswaName} berhasil dihapus. Skor berkurang {$poin} poin.",
                'data' => [
                    'deleted_id' => $id,
                    'siswa_name' => $siswaName,
                    'pelanggaran' => $pelanggaranDesc,
                    'score_reduced' => $poin,
                    'score_bk_before' => $currentScore ?? 0,
                    'score_bk_now' => $siswa->score_bk ?? 0
                ]
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error hapus skorsing: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }
}
