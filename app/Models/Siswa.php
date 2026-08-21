<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $fillable = [
        'orang_tua_id',
        'kelas_id',
        'nama',
        'tanggal_lahir',
        'score_bk',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'score_bk' => 'integer',
    ];

    public function kelas()
    {
        return $this->belongsTo(
            Kelas::class,
            'kelas_id'
        );
    }

    public function orangTua()
    {
        return $this->belongsTo(
            OrangTua::class,
            'orang_tua_id'
        );
    }

    public function riwayatPelanggaran()
    {
        return $this->hasMany(
            RiwayatPelanggaran::class,
            'siswa_id'
        );
    }

    public function riwayatKebajikan()
    {
        return $this->hasMany(
            RiwayatKebajikan::class,
            'siswa_id'
        );
    }
}
