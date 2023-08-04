<?php

namespace App\Models\API\v1;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Film extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'production_year',
        'duration',
        'poster',
        'images',
        'trailer',
    ];

    protected $casts = [
        'images' => 'array'
    ];

    public function watchedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'film_user_watched');
    }

    public function favouriteByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'film_user_favorite');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }

    public function rating(): Attribute
    {
        return Attribute::make(
            get: fn() => [
                'value' => round($this->ratings()->avg('rating'), 1),
                'count' => $this->ratings()->count('rating'),
            ]
        );
    }

    public function watchWithIt(): Attribute
    {
        $userIds = $this->watchedByUsers->pluck('id');

        return Attribute::make(
            get: fn() => self::whereHas('watchedByUsers', function ($query) use ($userIds) {
                $query->whereIn('user_id', $userIds);
            })->withCount('watchedByUsers')
                ->orderBy('watched_by_users_count', 'desc')
                ->limit(10)
                ->get()
        );
    }

    public function scopePopular(Builder $query): Builder
    {
        return $query
            ->withCount('watchedByUsers')
            ->orderByDesc('watched_by_users_count');
    }

    public function scopeBigRating(Builder $query): Builder
    {
        return $query
            ->withAvg('ratings', 'rating')
            ->orderByDesc('ratings_avg_rating');
    }

    public function scopeNew(Builder $query): Builder
    {
        return $query
            ->orderByDesc('created_at');
    }
}
