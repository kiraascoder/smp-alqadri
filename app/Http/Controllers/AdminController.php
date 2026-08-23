<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kebajikan;
use App\Models\Kelas;
use App\Models\OrangTua;
use App\Models\Pelanggaran;
use App\Models\RiwayatKebajikan;
use App\Models\RiwayatPelanggaran;
use App\Models\Siswa;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $guruCount = Guru::count();

        $siswaCount = Siswa::count();

        $orangTuaCount = OrangTua::count();

        $skorsingBulanIniCount = RiwayatPelanggaran::whereDate(
            'tanggal',
            '>=',
            Carbon::now()->startOfMonth()
        )
            ->count();

        $riwayat = RiwayatPelanggaran::with([
            'siswa.kelas',
            'pelanggaran',
            'creator',
        ])
            ->latest('tanggal')
            ->latest('id')
            ->take(8)
            ->get();

        return view(
            'admin.dashboard',
            compact(
                'guruCount',
                'siswaCount',
                'orangTuaCount',
                'skorsingBulanIniCount',
                'riwayat'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | GURU
    |--------------------------------------------------------------------------
    */

    public function guru()
    {
        $gurus = Guru::with('user')
            ->latest()
            ->paginate(10);

        return view(
            'admin.guru',
            compact('gurus')
        );
    }


    public function storeGuru(Request $request)
    {
        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'unique:users,email',
            ],

            'no_hp' => [
                'nullable',
                'string',
                'max:20',
            ],

            'jenis_kelamin' => [
                'nullable',
                Rule::in([
                    'Laki-Laki',
                    'Perempuan',
                ]),
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);


        DB::transaction(function () use ($data) {

            $user = User::create([
                'name' => $data['name'],

                'email' => $data['email'],

                'no_hp' => $data['no_hp'] ?? null,

                'jenis_kelamin' =>
                $data['jenis_kelamin'] ?? null,

                'password' =>
                Hash::make($data['password']),

                'role' => User::ROLE_GURU,
            ]);


            Guru::create([
                'user_id' => $user->id,
            ]);
        });


        return back()->with(
            'success',
            'Guru berhasil ditambahkan.'
        );
    }


    public function editGuru(
        Request $request,
        int $id
    ) {
        $guru = Guru::with('user')
            ->findOrFail($id);


        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',

                Rule::unique(
                    'users',
                    'email'
                )->ignore(
                    $guru->user_id
                ),
            ],

            'no_hp' => [
                'nullable',
                'string',
                'max:20',
            ],

            'jenis_kelamin' => [
                'nullable',
                Rule::in([
                    'Laki-Laki',
                    'Perempuan',
                ]),
            ],
        ]);


        $guru->user->update($data);


        return back()->with(
            'success',
            'Data guru berhasil diperbarui.'
        );
    }


    public function destroyGuru(int $id)
    {
        DB::transaction(function () use ($id) {

            $guru = Guru::with('user')
                ->findOrFail($id);


            $user = $guru->user;


            /*
             * Hapus profil guru terlebih dahulu.
             */
            $guru->delete();


            /*
             * Kemudian hapus akun user.
             */
            if ($user) {
                $user->delete();
            }
        });


        return back()->with(
            'success',
            'Guru berhasil dihapus.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | KELAS
    |--------------------------------------------------------------------------
    */

    public function kelas()
    {
        $kelasList = Kelas::withCount('siswa')
            ->orderBy('nama_kelas')
            ->paginate(15);


        return view(
            'admin.kelas',
            compact('kelasList')
        );
    }


    public function storeKelas(Request $request)
    {
        $data = $request->validate([
            'nama_kelas' => [
                'required',
                'string',
                'max:100',
                'unique:kelas,nama_kelas',
            ],
        ]);


        Kelas::create($data);


        return back()->with(
            'success',
            'Kelas berhasil ditambahkan.'
        );
    }


    public function updateKelas(
        Request $request,
        Kelas $kelas
    ) {
        $data = $request->validate([
            'nama_kelas' => [
                'required',
                'string',
                'max:100',

                Rule::unique(
                    'kelas',
                    'nama_kelas'
                )->ignore(
                    $kelas->id
                ),
            ],
        ]);


        $kelas->update($data);


        return back()->with(
            'success',
            'Kelas berhasil diperbarui.'
        );
    }


    public function destroyKelas(Kelas $kelas)
    {
        if ($kelas->siswa()->exists()) {

            return back()->with(
                'error',
                'Kelas masih digunakan oleh siswa dan tidak dapat dihapus.'
            );
        }


        $kelas->delete();


        return back()->with(
            'success',
            'Kelas berhasil dihapus.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SISWA
    |--------------------------------------------------------------------------
    */

    public function siswa()
    {
        $siswas = Siswa::with([
            'kelas',
            'orangTua.user',
        ])
            ->latest()
            ->paginate(10);


        $kelasList = Kelas::orderBy(
            'nama_kelas'
        )->get();


        $orangTuaList = OrangTua::with('user')
            ->get()
            ->sortBy(
                fn($ortu) =>
                $ortu->user?->name
            );


        return view(
            'admin.siswa',
            compact(
                'siswas',
                'kelasList',
                'orangTuaList'
            )
        );
    }


    public function storeSiswa(Request $request)
    {
        $data = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
            ],

            'kelas_id' => [
                'required',
                'exists:kelas,id',
            ],

            'tanggal_lahir' => [
                'required',
                'date',
                'before:today',
            ],

            'orang_tua_id' => [
                'nullable',
                'exists:orang_tua,id',
            ],
        ]);


        Siswa::create(
            $data + [
                'score_bk' => 0,
            ]
        );


        return back()->with(
            'success',
            'Siswa berhasil ditambahkan.'
        );
    }


    public function updateSiswa(
        Request $request,
        int $id
    ) {
        $siswa = Siswa::findOrFail($id);


        $data = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
            ],

            'kelas_id' => [
                'required',
                'exists:kelas,id',
            ],

            'tanggal_lahir' => [
                'required',
                'date',
                'before:today',
            ],

            'orang_tua_id' => [
                'nullable',
                'exists:orang_tua,id',
            ],
        ]);


        $siswa->update($data);


        return back()->with(
            'success',
            'Data siswa berhasil diperbarui.'
        );
    }


    public function destroySiswa(int $id)
    {
        $siswa = Siswa::findOrFail($id);

        $siswa->delete();


        return back()->with(
            'success',
            'Siswa berhasil dihapus.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ORANG TUA
    |--------------------------------------------------------------------------
    */

    public function orangTua()
    {
        $ortu = OrangTua::with([
            'user',
            'siswa.kelas',
        ])
            ->latest()
            ->paginate(10);


        /*
         * Hanya siswa yang belum mempunyai orang tua
         * yang ditampilkan pada pilihan tautkan anak.
         */
        $siswaList = Siswa::with('kelas')
            ->whereNull('orang_tua_id')
            ->orderBy('nama')
            ->get();


        return view(
            'admin.orang-tua',
            compact(
                'ortu',
                'siswaList'
            )
        );
    }


    public function registerOrtu(Request $request)
    {
        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'unique:users,email',
            ],

            'no_hp' => [
                'nullable',
                'string',
                'max:20',
            ],

            'jenis_kelamin' => [
                'nullable',

                Rule::in([
                    'Laki-Laki',
                    'Perempuan',
                ]),
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

            'anak' => [
                'nullable',
                'array',
            ],

            'anak.*' => [
                'integer',

                Rule::exists(
                    'siswa',
                    'id'
                )->whereNull(
                    'orang_tua_id'
                ),
            ],
        ]);


        DB::transaction(function () use ($data) {

            /*
             * Buat akun user.
             */
            $user = User::create([
                'name' => $data['name'],

                'email' => $data['email'],

                'no_hp' =>
                $data['no_hp'] ?? null,

                'jenis_kelamin' =>
                $data['jenis_kelamin'] ?? null,

                'password' =>
                Hash::make(
                    $data['password']
                ),

                'role' =>
                User::ROLE_ORANG_TUA,
            ]);


            /*
             * Buat profil orang tua.
             */
            $ortu = OrangTua::create([
                'user_id' => $user->id,
            ]);


            /*
             * Tautkan siswa ke orang tua.
             */
            if (! empty($data['anak'])) {

                Siswa::whereIn(
                    'id',
                    $data['anak']
                )->update([
                    'orang_tua_id' =>
                    $ortu->id,
                ]);
            }
        });


        return back()->with(
            'success',
            'Akun orang tua berhasil dibuat.'
        );
    }


    public function destroyOrangTua(int $id)
    {
        DB::transaction(function () use ($id) {

            $ortu = OrangTua::with('user')
                ->findOrFail($id);


            $user = $ortu->user;


            /*
             * Lepaskan relasi seluruh anak.
             */
            Siswa::where(
                'orang_tua_id',
                $ortu->id
            )->update([
                'orang_tua_id' => null,
            ]);


            /*
             * Hapus profil orang tua.
             */
            $ortu->delete();


            /*
             * Hapus akun user.
             */
            if ($user) {
                $user->delete();
            }
        });


        return back()->with(
            'success',
            'Orang tua berhasil dihapus dan relasi anak berhasil dilepas.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | MASTER PELANGGARAN
    |--------------------------------------------------------------------------
    */

    public function pelanggaran()
    {
        $pelanggarans = Pelanggaran::latest()
            ->paginate(10);


        return view(
            'admin.pelanggaran',
            compact('pelanggarans')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SKORSING / RIWAYAT PELANGGARAN
    |--------------------------------------------------------------------------
    */

    public function skorsing()
    {
        $siswas = Siswa::with('kelas')
            ->orderBy('nama')
            ->get();


        $pelanggarans = Pelanggaran::orderBy(
            'kategori'
        )
            ->orderBy(
                'deskripsi'
            )
            ->get();


        $riwayat = RiwayatPelanggaran::with([
            'siswa.kelas',
            'pelanggaran',
            'creator',
        ])
            ->latest('tanggal')
            ->latest('id')
            ->paginate(15);


        return view(
            'admin.skorsing',
            compact(
                'siswas',
                'pelanggarans',
                'riwayat'
            )
        );
    }


    public function tambahSkorsing(Request $request)
    {
        $data = $request->validate([
            'siswa_id' => [
                'required',
                'exists:siswa,id',
            ],

            'pelanggaran_id' => [
                'required',
                'exists:pelanggarans,id',
            ],

            'tanggal' => [
                'required',
                'date',
            ],

            'keterangan' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);


        DB::transaction(function () use ($data) {

            /*
             * Lock data siswa agar perubahan score_bk
             * aman dari request bersamaan.
             */
            $siswa = Siswa::lockForUpdate()
                ->findOrFail(
                    $data['siswa_id']
                );


            $pelanggaran =
                Pelanggaran::findOrFail(
                    $data['pelanggaran_id']
                );


            /*
             * Simpan snapshot skor.
             */
            RiwayatPelanggaran::create(
                $data + [
                    'created_by' =>
                    auth()->id(),

                    'skor' =>
                    $pelanggaran->skor,
                ]
            );


            /*
             * Tambahkan score BK siswa.
             */
            $siswa->increment(
                'score_bk',
                $pelanggaran->skor
            );
        });


        return back()->with(
            'success',
            'Skorsing berhasil ditambahkan.'
        );
    }


    public function destroySkorsing(int $id)
    {
        DB::transaction(function () use ($id) {

            $riwayat =
                RiwayatPelanggaran::lockForUpdate()
                ->findOrFail($id);


            $siswa =
                Siswa::lockForUpdate()
                ->findOrFail(
                    $riwayat->siswa_id
                );


            /*
             * Kurangi score_bk berdasarkan snapshot skor
             * yang tersimpan di riwayat.
             */
            $siswa->score_bk = max(
                0,
                $siswa->score_bk -
                    $riwayat->skor
            );


            $siswa->save();


            $riwayat->delete();
        });


        return back()->with(
            'success',
            'Skorsing berhasil dihapus dan skor siswa disesuaikan.'
        );
    }


    public function detailSkorsing(int $id)
    {
        $skorsing =
            RiwayatPelanggaran::with([
                'siswa.kelas',
                'pelanggaran',
                'creator',
            ])
            ->findOrFail($id);


        return response()->json([
            'id' =>
            $skorsing->id,

            'siswa' => [
                'nama' =>
                $skorsing->siswa?->nama,

                'kelas' =>
                $skorsing
                    ->siswa
                    ?->kelas
                    ?->nama_kelas,

                'score_bk' =>
                $skorsing
                    ->siswa
                    ?->score_bk,
            ],

            'pelanggaran' => [
                'kategori' =>
                $skorsing
                    ->pelanggaran
                    ?->kategori,

                'deskripsi' =>
                $skorsing
                    ->pelanggaran
                    ?->deskripsi,

                'skor' =>
                $skorsing->skor,
            ],

            'tanggal' =>
            optional(
                $skorsing->tanggal
            )->format('Y-m-d'),

            'keterangan' =>
            $skorsing->keterangan,

            'dibuat_oleh' =>
            $skorsing
                ->creator
                ?->name
                ?? 'User dihapus',
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | QUERY REKAP SKORSING
    |--------------------------------------------------------------------------
    */

    private function queryRekapSkorsing(
        Request $request
    ) {
        return RiwayatPelanggaran::query()

            ->with([
                'siswa.kelas',
                'pelanggaran',
                'creator',
            ])


            /*
             * Filter tanggal mulai.
             */
            ->when(
                $request->filled(
                    'tanggal_mulai'
                ),

                fn($query) =>
                $query->whereDate(
                    'tanggal',
                    '>=',
                    $request->tanggal_mulai
                )
            )


            /*
             * Filter tanggal selesai.
             */
            ->when(
                $request->filled(
                    'tanggal_selesai'
                ),

                fn($query) =>
                $query->whereDate(
                    'tanggal',
                    '<=',
                    $request->tanggal_selesai
                )
            )


            /*
             * Filter pembuat.
             */
            ->when(
                $request->filled(
                    'pembuat_id'
                ),

                fn($query) =>
                $query->where(
                    'created_by',
                    $request->pembuat_id
                )
            )


            /*
             * Filter kelas.
             */
            ->when(
                $request->filled(
                    'kelas_id'
                ),

                function ($query) use ($request) {

                    $query->whereHas(
                        'siswa',

                        fn($siswa) =>
                        $siswa->where(
                            'kelas_id',
                            $request->kelas_id
                        )
                    );
                }
            )


            /*
             * Filter siswa.
             */
            ->when(
                $request->filled(
                    'siswa_id'
                ),

                fn($query) =>
                $query->where(
                    'siswa_id',
                    $request->siswa_id
                )
            )


            /*
             * Filter pelanggaran.
             */
            ->when(
                $request->filled(
                    'pelanggaran_id'
                ),

                fn($query) =>
                $query->where(
                    'pelanggaran_id',
                    $request->pelanggaran_id
                )
            )


            ->latest('tanggal')
            ->latest('id');
    }


    /*
    |--------------------------------------------------------------------------
    | REKAP SKORSING
    |--------------------------------------------------------------------------
    */

    public function rekapSkorsing(
        Request $request
    ) {
        $rekap =
            $this->queryRekapSkorsing(
                $request
            )
            ->paginate(15)
            ->withQueryString();


        $pembuatList =
            User::whereIn(
                'role',
                [
                    User::ROLE_ADMIN,
                    User::ROLE_GURU,
                ]
            )
            ->orderBy('name')
            ->get();


        $kelasList =
            Kelas::orderBy(
                'nama_kelas'
            )->get();


        $siswaList =
            Siswa::orderBy(
                'nama'
            )->get();


        $pelanggaranList =
            Pelanggaran::orderBy(
                'kategori'
            )
            ->orderBy('skor')
            ->get();


        return view(
            'admin.rekap-skorsing',
            compact(
                'rekap',
                'pembuatList',
                'kelasList',
                'siswaList',
                'pelanggaranList'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD PDF REKAP SKORSING
    |--------------------------------------------------------------------------
    */

    public function rekapSkorsingPdf(
        Request $request
    ) {
        /*
         * Menggunakan query yang sama dengan
         * halaman rekap sehingga filter PDF sama.
         */
        $rekap =
            $this->queryRekapSkorsing(
                $request
            )->get();


        $pdf = Pdf::loadView(
            'admin.pdf.rekap-skorsing',
            [
                'rekap' => $rekap,

                'filter' => [
                    'tanggal_mulai' =>
                    $request->tanggal_mulai,

                    'tanggal_selesai' =>
                    $request->tanggal_selesai,
                ],
            ]
        )
            ->setPaper(
                'a4',
                'landscape'
            );


        return $pdf->download(
            'rekap-skorsing-' .
                now()->format(
                    'Y-m-d-His'
                ) .
                '.pdf'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | QUERY REKAP KEBAJIKAN
    |--------------------------------------------------------------------------
    */

    private function queryRekapKebajikan(
        Request $request
    ) {
        return RiwayatKebajikan::query()

            ->with([
                'siswa.kelas',
                'kebajikan',
                'creator',
            ])


            /*
             * Filter tanggal mulai.
             */
            ->when(
                $request->filled(
                    'tanggal_mulai'
                ),

                fn($query) =>
                $query->whereDate(
                    'tanggal',
                    '>=',
                    $request->tanggal_mulai
                )
            )


            /*
             * Filter tanggal selesai.
             */
            ->when(
                $request->filled(
                    'tanggal_selesai'
                ),

                fn($query) =>
                $query->whereDate(
                    'tanggal',
                    '<=',
                    $request->tanggal_selesai
                )
            )


            /*
             * Filter pembuat.
             */
            ->when(
                $request->filled(
                    'pembuat_id'
                ),

                fn($query) =>
                $query->where(
                    'created_by',
                    $request->pembuat_id
                )
            )


            /*
             * Filter kelas.
             */
            ->when(
                $request->filled(
                    'kelas_id'
                ),

                function ($query) use ($request) {

                    $query->whereHas(
                        'siswa',

                        fn($siswa) =>
                        $siswa->where(
                            'kelas_id',
                            $request->kelas_id
                        )
                    );
                }
            )


            /*
             * Filter siswa.
             */
            ->when(
                $request->filled(
                    'siswa_id'
                ),

                fn($query) =>
                $query->where(
                    'siswa_id',
                    $request->siswa_id
                )
            )


            /*
             * Filter jenis kebajikan.
             */
            ->when(
                $request->filled(
                    'kebajikan_id'
                ),

                fn($query) =>
                $query->where(
                    'kebajikan_id',
                    $request->kebajikan_id
                )
            )


            ->latest('tanggal')
            ->latest('id');
    }


    /*
    |--------------------------------------------------------------------------
    | REKAP KEBAJIKAN
    |--------------------------------------------------------------------------
    */

    public function rekapKebajikan(
        Request $request
    ) {
        $rekap =
            $this->queryRekapKebajikan(
                $request
            )
            ->paginate(15)
            ->withQueryString();


        $pembuatList =
            User::whereIn(
                'role',
                [
                    User::ROLE_ADMIN,
                    User::ROLE_GURU,
                ]
            )
            ->orderBy('name')
            ->get();


        $kelasList =
            Kelas::orderBy(
                'nama_kelas'
            )->get();


        $siswaList =
            Siswa::orderBy(
                'nama'
            )->get();


        $kebajikanList =
            Kebajikan::orderBy(
                'deskripsi'
            )->get();


        return view(
            'admin.rekap-kebajikan',
            compact(
                'rekap',
                'pembuatList',
                'kelasList',
                'siswaList',
                'kebajikanList'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD PDF REKAP KEBAJIKAN
    |--------------------------------------------------------------------------
    */

    public function rekapKebajikanPdf(
        Request $request
    ) {
        /*
         * Menggunakan query yang sama dengan
         * halaman rekap kebajikan.
         */
        $rekap =
            $this->queryRekapKebajikan(
                $request
            )->get();


        $pdf = Pdf::loadView(
            'admin.pdf.rekap-kebajikan',
            [
                'rekap' => $rekap,

                'filter' => [
                    'tanggal_mulai' =>
                    $request->tanggal_mulai,

                    'tanggal_selesai' =>
                    $request->tanggal_selesai,
                ],
            ]
        )
            ->setPaper(
                'a4',
                'landscape'
            );


        return $pdf->download(
            'rekap-kebajikan-' .
                now()->format(
                    'Y-m-d-His'
                ) .
                '.pdf'
        );
    }
    /*
|--------------------------------------------------------------------------
| POIN KEBAJIKAN
|--------------------------------------------------------------------------
*/

    public function poinKebajikan()
    {
        /*
     * Daftar siswa untuk pilihan penerima kebajikan.
     */
        $siswas = Siswa::with('kelas')
            ->orderBy('nama')
            ->get();


        /*
     * Master jenis kebajikan.
     */
        $kebajikans = Kebajikan::orderBy('deskripsi')
            ->get();


        /*
     * Semua riwayat kebajikan.
     * Admin boleh melihat pemberian dari admin maupun guru.
     */
        $riwayat = RiwayatKebajikan::with([
            'siswa.kelas',
            'kebajikan',
            'creator',
        ])
            ->latest('tanggal')
            ->latest('id')
            ->paginate(15);


        return view(
            'admin.poin-kebajikan',
            compact(
                'siswas',
                'kebajikans',
                'riwayat'
            )
        );
    }


    /*
|--------------------------------------------------------------------------
| BERI KEBAJIKAN
|--------------------------------------------------------------------------
*/

    public function beriKebajikan(Request $request)
    {
        $data = $request->validate([
            'siswa_id' => [
                'required',
                'exists:siswa,id',
            ],

            'kebajikan_id' => [
                'required',
                'exists:kebajikans,id',
            ],

            'tanggal' => [
                'required',
                'date',
            ],

            'keterangan' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);


        DB::transaction(function () use ($data) {

            /*
         * Pastikan siswa benar-benar ada.
         */
            Siswa::findOrFail(
                $data['siswa_id']
            );


            /*
         * Ambil master kebajikan.
         */
            $kebajikan = Kebajikan::findOrFail(
                $data['kebajikan_id']
            );


            /*
         * Simpan snapshot skor.
         *
         * Jadi apabila skor master kebajikan berubah
         * di kemudian hari, riwayat lama tidak ikut berubah.
         */
            RiwayatKebajikan::create([
                'siswa_id' =>
                $data['siswa_id'],

                'kebajikan_id' =>
                $data['kebajikan_id'],

                'skor' =>
                $kebajikan->skor,

                'tanggal' =>
                $data['tanggal'],

                'keterangan' =>
                $data['keterangan'] ?? null,

                'created_by' =>
                auth()->id(),
            ]);
        });


        return back()->with(
            'success',
            'Poin kebajikan berhasil diberikan kepada siswa.'
        );
    }


    /*
|--------------------------------------------------------------------------
| HAPUS RIWAYAT KEBAJIKAN
|--------------------------------------------------------------------------
*/

    public function hapusKebajikan(
        RiwayatKebajikan $riwayat
    ) {
        $riwayat->delete();


        return back()->with(
            'success',
            'Riwayat kebajikan berhasil dihapus.'
        );
    }
}