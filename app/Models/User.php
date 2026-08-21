<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const ROLE_ADMIN = 'admin';
    public const ROLE_GURU = 'guru';
    public const ROLE_ORANG_TUA = 'orang_tua';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'jenis_kelamin',
        'no_hp',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function guru()
    {
        return $this->hasOne(Guru::class);
    }

    public function orangTuaProfile()
    {
        return $this->hasOne(OrangTua::class, 'user_id');
    }

    public function skorsingDibuat()
    {
        return $this->hasMany(RiwayatPelanggaran::class, 'created_by');
    }
    public function siswa()
    {
        return $this->hasOne(Siswa::class, 'user_id');
    }

    public function anak()
    {
        return $this->hasMany(Siswa::class, 'orang_tua_id');
    }
}
