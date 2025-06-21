<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatPelanggaran extends Model
{
    protected $table = 'riwayat_pelanggaran';


    protected $fillable = ['siswa_id', 'pelanggaran_id', 'tanggal', 'keterangan'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'id');
    }

    public function pelanggaran()
    {

        return $this->belongsTo(Pelanggaran::class, 'pelanggaran_id', 'id');
    }

    public function kelas()
    {
        return $this->hasOneThrough(Kelas::class, Siswa::class, 'id', 'id', 'siswa_id', 'kelas_id');
    }
}
