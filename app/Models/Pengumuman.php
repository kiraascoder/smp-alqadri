<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengumuman extends Model
{
    protected $table = 'pengumuman_sekolah';

    protected $fillable = [
        'judul', 'slug', 'kategori', 'ringkasan', 'isi',
        'gambar', 'lampiran', 'nama_lampiran', 'status',
        'is_pinned', 'published_at', 'expires_on', 'created_by',
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'published_at' => 'datetime',
        'expires_on' => 'date',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Draft, belum terbit, atau sudah kedaluwarsa tidak terlihat oleh publik.
    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->where(function (Builder $q) {
                $q->whereNull('expires_on')
                  ->orWhereDate('expires_on', '>=', now('Asia/Makassar')->toDateString());
            });
    }

    public function isVisible(): bool
    {
        return $this->status === 'published'
            && $this->published_at !== null
            && $this->published_at->lte(now())
            && ($this->expires_on === null
                || $this->expires_on->toDateString() >= now('Asia/Makassar')->toDateString());
    }
}
