<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatKebajikan extends Model
{
    protected $table = 'riwayat_kebajikan';

    protected $fillable = [
        'siswa_id',
        'kebajikan_id',
        'created_by',
        'tanggal',
        'skor',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'skor' => 'integer',
        ];
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function kebajikan()
    {
        return $this->belongsTo(Kebajikan::class, 'kebajikan_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
