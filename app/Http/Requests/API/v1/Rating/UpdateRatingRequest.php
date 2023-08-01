<?php

namespace App\Http\Requests\API\v1\Rating;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRatingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'rating' => ['required', 'int', 'between:1,10'],
        ];
    }
}
