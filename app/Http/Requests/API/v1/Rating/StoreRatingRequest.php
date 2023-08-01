<?php

namespace App\Http\Requests\API\v1\Rating;

use Illuminate\Foundation\Http\FormRequest;

class StoreRatingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'film_id' => ['required', 'int', 'exists:films,id'],
            'rating' => ['required', 'int', 'between:1,10'],
        ];
    }
}
