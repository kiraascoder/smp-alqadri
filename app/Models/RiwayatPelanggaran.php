<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatPelanggaran extends Model
{
    protected $table = 'riwayat_pelanggaran';

    protected $fillable = [
        'siswa_id',
        'pelanggaran_id',
        'created_by',
        'skor',
        'tanggal',
        'keterangan',
    ];

    protected function casts(): array
    {
        return ['tanggal' => 'date'];
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function pelanggaran()
    {
        return $this->belongsTo(Pelanggaran::class, 'pelanggaran_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
