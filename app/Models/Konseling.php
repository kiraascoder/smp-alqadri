<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konseling extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'guru_bk_id',
        'tanggal',
        'waktu',
        'tempat',
        'topik',
        'status',
        'alasan_batal',
        'catatan',
    ];


    public function siswa()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function guruBk()
    {
        return $this->belongsTo(User::class, 'guru_bk_id');
    }


    public function laporan()
    {
        return $this->belongsTo(Laporan::class, 'laporan_id');
    }
}
