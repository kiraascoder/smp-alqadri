<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';
    protected $fillable = ['user_id', 'kelas_id', 'nisn', 'score_bk'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }


    public function riwayatPelanggaran()
    {
        return $this->hasMany(RiwayatPelanggaran::class);
    }
}
