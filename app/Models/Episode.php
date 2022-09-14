<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Episode extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'season',
        'episode_number',
        'air_at',
        'show_id',
    ];

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
