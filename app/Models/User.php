<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'jenis_kelamin',
        'no_hp',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Dipertahankan untuk kompatibilitas kode lama.
    public function anakSiswa()
    {
        return $this->hasMany(Siswa::class, 'orang_tua_id');
    }

    public function anak()
    {
        return $this->hasMany(Siswa::class, 'orang_tua_id');
    }

    public function siswa()
    {
        return $this->hasOne(Siswa::class, 'user_id');
    }

    public function siswaProfile()
    {
        return $this->hasOne(Siswa::class, 'user_id');
    }

    public function guru()
    {
        return $this->hasOne(Guru::class);
    }

    // Relasi audit baru.
    public function skorsingDibuat()
    {
        return $this->hasMany(RiwayatPelanggaran::class, 'created_by');
    }

    public function kebajikanDibuat()
    {
        return $this->hasMany(RiwayatKebajikan::class, 'created_by');
    }
}
