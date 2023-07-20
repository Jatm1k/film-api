<?php

namespace App\Http\Requests\API\v1\Film;

use Illuminate\Foundation\Http\FormRequest;

class StoreFilmRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'production_year' => ['nullable', 'date_format:Y'],
            'duration' => ['required', 'date_format:H:i'],
            'poster' => ['required', 'image'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image'],
            'trailer' => ['nullable', 'file'],
        ];
    }
}
