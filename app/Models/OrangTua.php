<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrangTua extends Model
{
    protected $table = 'orang_tua';

    protected $guarded = [];



    public function user()
    {
        return $this->belongsTo(User::class);
    }



    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'orang_tua_id');
    }
}