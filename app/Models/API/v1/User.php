<?php

namespace App\Models\API\v1;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'login',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function watchedFilms(): BelongsToMany
    {
        return $this->belongsToMany(Film::class, 'film_user_watched');
    }

    public function favoriteFilms(): BelongsToMany
    {
        return $this->belongsToMany(Film::class, 'film_user_favorite');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function subscriptions(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_subscriptions', 'subscriber_id', 'user_id');
    }

    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_subscriptions', 'user_id', 'subscriber_id');
    }

}
