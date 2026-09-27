<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPelanggaran extends Model
{
    use HasFactory;

    protected $table = 'riwayat_pelanggaran';

    protected $fillable = [
        'siswa_id',
        'pelanggaran_id',
        'skor',
        'tanggal',
        'keterangan',
        'created_by',
        'dinilai_oleh',
        'dinilai_pada',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'skor' => 'integer',
        'dinilai_pada' => 'datetime',
    ];


    public function siswa()
    {
        return $this->belongsTo(
            Siswa::class,
            'siswa_id'
        );
    }


    public function pelanggaran()
    {
        return $this->belongsTo(
            Pelanggaran::class,
            'pelanggaran_id'
        );
    }


    public function creator()
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }


    public function penilai()
    {
        return $this->belongsTo(
            User::class,
            'dinilai_oleh'
        );
    }
}
