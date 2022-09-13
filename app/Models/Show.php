<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Show extends Model
{
    use HasFactory;

    protected $withCount = ['episodes as total_episodes'];

    protected $appends = ['total_seasons'];

    protected $fillable = [
        'title',
        'title_original',
        'description',
        'year',
        'status',
        'imdb_id',
        'updated_at',
    ];

    public function episodes(): HasMany
    {
        return $this->hasMany(Episode::class);
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }

    public function getTotalSeasonsAttribute(): int
    {
        return $this->episodes()->distinct()->count('season');
    }
}
