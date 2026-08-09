<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $fillable = [
        'user_id',
        'orang_tua_id',
        'kelas_id',
        'nisn',
        'nama',
        'tanggal_lahir',
        'score_bk',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'score_bk' => 'integer',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Dipertahankan sesuai model repo saat ini: orang_tua_id menunjuk users.id.
    public function orangTua()
    {
        return $this->belongsTo(User::class, 'orang_tua_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }

    public function riwayatPelanggaran()
    {
        return $this->hasMany(RiwayatPelanggaran::class, 'siswa_id', 'id');
    }

    public function riwayatKebajikan()
    {
        return $this->hasMany(RiwayatKebajikan::class, 'siswa_id', 'id');
    }

    public function getNamaTampilAttribute(): string
    {
        return $this->nama ?: ($this->user?->name ?: 'Siswa');
    }
}
