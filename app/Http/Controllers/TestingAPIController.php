<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestingAPIController extends Controller
{

    public function checkDatabaseStructure()
    {
        try {
            // Cek struktur tabel siswa
            $siswaColumns = collect(\DB::select("DESCRIBE siswa"))
                ->pluck('Field')
                ->toArray();

            // Cek struktur tabel riwayat_pelanggaran  
            $riwayatColumns = collect(\DB::select("DESCRIBE riwayat_pelanggaran"))
                ->pluck('Field')
                ->toArray();

            // Cek data sample siswa
            $sampleSiswa = \DB::table('siswa')
                ->select('id', 'nisn', 'score_bk', 'user_id', 'kelas_id')
                ->limit(3)
                ->get();

            // Cek data sample riwayat pelanggaran
            $sampleRiwayat = \DB::table('riwayat_pelanggaran')
                ->select('id', 'siswa_id', 'pelanggaran_id', 'tanggal')
                ->limit(3)
                ->get();

            return response()->json([
                'status' => 'success',
                'tables' => [
                    'siswa' => [
                        'columns' => $siswaColumns,
                        'has_score_bk' => in_array('score_bk', $siswaColumns),
                        'sample_data' => $sampleSiswa
                    ],
                    'riwayat_pelanggaran' => [
                        'columns' => $riwayatColumns,
                        'has_pelanggaran_id' => in_array('pelanggaran_id', $riwayatColumns),
                        'has_pelanggaran_id' => in_array('pelanggaran_id', $riwayatColumns),
                        'sample_data' => $sampleRiwayat
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
        }
    }

    public function debugSkorsing($id)
    {
        try {
            // Test dengan Eloquent
            $eloquentResult = RiwayatPelanggaran::with(['siswa.user', 'siswa.kelas', 'pelanggaran'])
                ->where('id', $id)
                ->first();

            // Test dengan Raw Query
            $rawResult = \DB::select("
            SELECT 
                rp.id,
                rp.siswa_id,
                rp.pelanggaran_id,
                rp.tanggal,
                s.nisn,
                s.score_bk,
                s.user_id,
                s.kelas_id,
                u.name as user_name,
                k.nama_kelas,
                p.deskripsi,
                p.skor
            FROM riwayat_pelanggaran rp
            LEFT JOIN siswa s ON rp.siswa_id = s.id
            LEFT JOIN users u ON s.user_id = u.id
            LEFT JOIN kelas k ON s.kelas_id = k.id
            LEFT JOIN pelanggaran p ON rp.pelanggaran_id = p.id
            WHERE rp.id = ?
        ", [$id]);

            return response()->json([
                'status' => 'success',
                'eloquent_found' => $eloquentResult ? true : false,
                'eloquent_data' => $eloquentResult ? [
                    'id' => $eloquentResult->id,
                    'siswa_exists' => $eloquentResult->siswa ? true : false,
                    'siswa_data' => $eloquentResult->siswa ? $eloquentResult->siswa->toArray() : null,
                    'score_bk' => $eloquentResult->siswa ? $eloquentResult->siswa->score_bk : 'SISWA_NULL'
                ] : null,
                'raw_query_found' => !empty($rawResult),
                'raw_data' => $rawResult ? $rawResult[0] : null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
        }
    }

    public function debugRawQuery($id)
    {
        try {
            $result = \DB::select("
            SELECT 
                rp.*,
                s.*,
                u.name as user_name,
                k.nama_kelas,
                p.deskripsi as pelanggaran_desc,
                p.skor as pelanggaran_skor
            FROM riwayat_pelanggaran rp
            LEFT JOIN siswa s ON rp.siswa_id = s.id
            LEFT JOIN users u ON s.user_id = u.id
            LEFT JOIN kelas k ON s.kelas_id = k.id
            LEFT JOIN pelanggaran p ON rp.pelanggaran_id = p.id
            WHERE rp.id = ?
        ", [$id]);

            if (empty($result)) {
                return response()->json([
                    'status' => 'not_found',
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $data = $result[0];

            return response()->json([
                'id' => $data->id,
                'siswa' => [
                    'user' => [
                        'name' => $data->user_name ?? '-'
                    ],
                    'nisn' => $data->nisn ?? '-',
                    'score_bk' => $data->score_bk ?? 0,
                    'kelas' => [
                        'nama_kelas' => $data->nama_kelas ?? '-'
                    ]
                ],
                'pelanggaran' => [
                    'deskripsi' => $data->pelanggaran_desc ?? '-',
                    'skor' => $data->pelanggaran_skor ?? 0
                ],
                'tanggal' => $data->tanggal,
                'keterangan' => $data->keterangan,
                'created_at' => $data->created_at,
                'debug_raw_data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
