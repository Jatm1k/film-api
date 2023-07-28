<?php

namespace App\Models\API\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'text',
        'type',
        'film_id',
        'user_id',
    ];

//    protected $with = ['film', 'author'];

    public function film(): BelongsTo
    {
        return $this->belongsTo(Film::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
