<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatPelanggaran extends Model
{
    protected $fillable = ['siswa_id', 'pelanggaran_id', 'tanggal', 'keterangan'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function pelanggaran()
    {
        return $this->belongsTo(Pelanggaran::class);
    }
}
