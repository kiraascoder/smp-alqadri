<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SchoolPositionMember extends Model
{
    protected $fillable = [
        'school_position_id', 'name', 'subtitle', 'photo_path', 'sort_order', 'is_active',
    ];

    protected $casts = ['is_active' => 'boolean', 'sort_order' => 'integer'];

    public function position(): BelongsTo
    {
        return $this->belongsTo(SchoolPosition::class, 'school_position_id');
    }
}
