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
    public const USER_WATCHING_STATUS = 'watching';
    public const USER_WATCHED_STATUS = 'watched';

    protected $withCount = ['episodes as total_episodes'];

    protected $appends = ['total_seasons', 'watch_status', 'watched_episodes', 'user_vote', 'rating'];

    protected $fillable = [
        'title',
        'title_original',
        'description',
        'year',
        'status',
        'imdb_id',
        'updated_at',
    ];

    protected $hidden = [
        'pivot'
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

    public function getWatchedEpisodesAttribute(): int
    {
        if (Auth::guest()) {
            return 0;
        }

        return Auth::user()->episodes()->where('show_id', $this->id)->count();
    }

    public function getWatchStatusAttribute(): ?string
    {
        if (Auth::guest() || !$this->users()->where('user_id', Auth::id())->exists()) {
            return null;
        }

        if ($this->watched_episodes < $this->total_episodes) {
            return self::USER_WATCHING_STATUS;
        }

        return self::USER_WATCHED_STATUS;
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('vote');
    }

    public function getUserVoteAttribute()
    {
        if (Auth::guest()) {
            return null;
        }

        $userVote = $this->users()->firstWhere('user_id', Auth::id());

        if (!$userVote) {
            return null;
        }

        return $userVote->pivot->vote;
    }

    public function getRatingAttribute(): int
    {
        return (int) round($this->users()->avg('vote'));
    }
}
