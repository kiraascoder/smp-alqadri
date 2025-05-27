<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $fillable = ['user_id', 'nip'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

 
}
