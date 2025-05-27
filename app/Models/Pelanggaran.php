<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    protected $fillable = ['kategori', 'deskripsi', 'skor'];

    public function riwayat()
    {
        return $this->hasMany(RiwayatPelanggaran::class);
    }

    public function laporan()
    {
        return $this->hasMany(Laporan::class);
    }
}
