<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'guru';
    protected $fillable = ['user_id',];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
