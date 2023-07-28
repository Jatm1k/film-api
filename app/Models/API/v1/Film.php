<?php

namespace App\Models\API\v1;

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

    public function viewers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'film_user');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
