<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatKebajikan extends Model
{
    use HasFactory;

    protected $table = 'riwayat_kebajikan';

    protected $fillable = [
        'siswa_id',
        'kebajikan_id',
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


    public function kebajikan()
    {
        return $this->belongsTo(
            Kebajikan::class,
            'kebajikan_id'
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