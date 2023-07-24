<?php

namespace App\Models\API\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
