<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kebajikan extends Model
{
    protected $fillable = [
        'deskripsi',
        'skor',
    ];

    protected $casts = [
        'skor' => 'integer',
    ];

    public function riwayat()
    {
        return $this->hasMany(
            RiwayatKebajikan::class,
            'kebajikan_id'
        );
    }
}
