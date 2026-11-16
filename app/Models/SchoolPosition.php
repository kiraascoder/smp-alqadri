<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolPosition extends Model
{
    protected $fillable = ['parent_id', 'title', 'sort_order', 'is_active', 'show_homepage'];

    protected $casts = [
        'is_active' => 'boolean',
        'show_homepage' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('sort_order')->orderBy('id');
    }

    public function members(): HasMany
    {
        return $this->hasMany(SchoolPositionMember::class, 'school_position_id')
            ->orderBy('sort_order')->orderBy('id');
    }
}
