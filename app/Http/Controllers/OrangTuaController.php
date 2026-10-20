<?php

namespace App\Http\Controllers;

use App\Models\Kebajikan;
use App\Models\OrangTua;
use App\Models\Pelanggaran;
use App\Models\RiwayatKebajikan;
use App\Models\RiwayatPelanggaran;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class OrangTuaController extends Controller
{
    /**
     * Mengambil profil orang tua berdasarkan user yang sedang login.
     */
    private function getOrangTua()
    {
        return OrangTua::where('user_id', auth()->id())
            ->firstOrFail();
    }


    /**
     * Dashboard Orang Tua
     */
    public function dashboard()
    {
        $orangTua = $this->getOrangTua();

        $anak = Siswa::with('kelas')
            ->withSum(
                'riwayatPelanggaran as total_pelanggaran',
                'skor'
            )
            ->withSum(
                'riwayatKebajikan as total_kebajikan',
                'skor'
            )
            ->where('orang_tua_id', $orangTua->id)
            ->orderBy('nama')
            ->get();


        $anakIds = $anak->pluck('id');


        /*
        |--------------------------------------------------------------------------
        | Total Pelanggaran
        |--------------------------------------------------------------------------
        */

        $totalSkorPelanggaran = RiwayatPelanggaran::whereIn(
            'siswa_id',
            $anakIds
        )->sum('skor');


        $totalSkorsing = RiwayatPelanggaran::whereIn(
            'siswa_id',
            $anakIds
        )->count();


        /*
        |--------------------------------------------------------------------------
        | Total Kebajikan
        |--------------------------------------------------------------------------
        */

        $totalPoinKebajikan = RiwayatKebajikan::whereIn(
            'siswa_id',
            $anakIds
        )->sum('skor');


        $totalKebajikan = RiwayatKebajikan::whereIn(
            'siswa_id',
            $anakIds
        )->count();


        /*
        |--------------------------------------------------------------------------
        | Riwayat Pelanggaran Terbaru
        |--------------------------------------------------------------------------
        */

        $riwayatSkorsing = RiwayatPelanggaran::with([
            'siswa.kelas',
            'pelanggaran',
        ])
            ->whereIn('siswa_id', $anakIds)
            ->latest('tanggal')
            ->latest('id')
            ->limit(10)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Riwayat Kebajikan Terbaru
        |--------------------------------------------------------------------------
        */

        $riwayatKebajikan = RiwayatKebajikan::with([
            'siswa.kelas',
            'kebajikan',
        ])
            ->whereIn('siswa_id', $anakIds)
            ->latest('tanggal')
            ->latest('id')
            ->limit(10)
            ->get();


        return view(
            'orangtua.dashboard',
            compact(
                'anak',
                'totalSkorPelanggaran',
                'totalSkorsing',
                'totalPoinKebajikan',
                'totalKebajikan',
                'riwayatSkorsing',
                'riwayatKebajikan'
            )
        );
    }


    /**
     * Daftar Jenis Pelanggaran + Riwayat Anak
     */
    public function pelanggaran()
    {
        /*
        |--------------------------------------------------------------------------
        | Ambil profil orang tua
        |--------------------------------------------------------------------------
        */

        $orangTua = $this->getOrangTua();


        /*
        |--------------------------------------------------------------------------
        | Ambil ID anak milik orang tua
        |--------------------------------------------------------------------------
        |
        | PENTING:
        | orang_tua_id di tabel siswa menunjuk ke orang_tua.id,
        | BUKAN users.id.
        |
        */

        $anakIds = Siswa::where(
            'orang_tua_id',
            $orangTua->id
        )
            ->pluck('id');


        /*
        |--------------------------------------------------------------------------
        | Riwayat Pelanggaran Anak
        |--------------------------------------------------------------------------
        */

        $riwayat = RiwayatPelanggaran::with([
            'siswa.kelas',
            'pelanggaran',
        ])
            ->whereIn('siswa_id', $anakIds)
            ->latest('tanggal')
            ->latest('id')
            ->paginate(10, ['*'], 'riwayat_page');


        /*
        |--------------------------------------------------------------------------
        | Daftar Jenis Pelanggaran
        |--------------------------------------------------------------------------
        |
        | HARUS paginate(), bukan get(),
        | karena Blade menggunakan:
        |
        | {{ $pelanggarans->links() }}
        |
        */

        $pelanggarans = Pelanggaran::orderByRaw("
                CASE
                    WHEN kategori = 'Ringan' THEN 1
                    WHEN kategori = 'Sedang' THEN 2
                    WHEN kategori = 'Sangat Berat' THEN 3
                    ELSE 4
                END
            ")
            ->orderBy('skor')
            ->paginate(10, ['*'], 'pelanggaran_page');


        return view(
            'orangtua.pelanggaran',
            compact(
                'riwayat',
                'pelanggarans'
            )
        );
    }


    /**
     * Riwayat Kebajikan Anak
     */
    public function kebajikan()
    {
        $kebajikans = Kebajikan::orderBy('deskripsi')
            ->paginate(10);

        return view(
            'orangtua.kebajikan',
            compact('kebajikans')
        );
    }
    public function profil()
    {
        $user = auth()->user();

        return view(
            'orangtua.profil',
            compact('user')
        );
    }

    public function updateProfil(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'no_hp' => ['required', 'string', 'max:20'],
            'jenis_kelamin' => [
                'nullable',
                Rule::in(['Laki-Laki', 'Perempuan']),
            ],
        ]);

        $phone = $this->normalizePhone($data['no_hp']);

        if (! $phone) {
            return back()
                ->withInput()
                ->withErrors([
                    'no_hp' => 'Nomor WhatsApp tidak valid. Gunakan nomor Indonesia, contoh 08123456789.',
                ]);
        }

        $phoneExists = OrangTua::with('user')
            ->get()
            ->contains(function ($orangTua) use ($phone, $user) {
                if (! $orangTua->user || $orangTua->user->id === $user->id) {
                    return false;
                }

                return $this->normalizePhone($orangTua->user->no_hp) === $phone;
            });

        if ($phoneExists) {
            return back()
                ->withInput()
                ->withErrors([
                    'no_hp' => 'Nomor WhatsApp tersebut sudah digunakan oleh akun orang tua lain.',
                ]);
        }

        $data['no_hp'] = $phone;

        $user->update($data);

        return back()->with(
            'success',
            'Profil berhasil diperbarui.'
        );
    }

    public function updatePassword(Request $request)
    {
        $data = $request->validate([
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);

        auth()->user()->update([
            'password' => Hash::make($data['password']),
        ]);

        return back()->with(
            'success',
            'Password berhasil diperbarui.'
        );
    }

    private function normalizePhone(?string $value): ?string
    {
        $phone = preg_replace('/\D+/', '', (string) $value) ?? '';

        if ($phone === '') {
            return null;
        }

        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        } elseif (str_starts_with($phone, '8')) {
            $phone = '62' . $phone;
        }

        if (! preg_match('/^628\d{8,12}$/', $phone)) {
            return null;
        }

        return $phone;
    }
}
