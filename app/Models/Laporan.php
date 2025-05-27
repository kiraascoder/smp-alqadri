<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pelanggaran_id',
        'guru_id',
        'deskripsi',
    ];

    
    public function siswa()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    
    public function pelanggaran()
    {
        return $this->belongsTo(Pelanggaran::class, 'pelanggaran_id');
    }

    
    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    
    public function konseling()
    {
        return $this->hasOne(Konseling::class);
    }
}
