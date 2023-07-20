<?php

namespace App\Http\Requests\API\v1\Film;

use App\Rules\ImageOrUrl;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFilmRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'production_year' => ['nullable', 'date_format:Y'],
            'duration' => ['required', 'date_format:H:i'],
            'poster' => ['required', new ImageOrUrl()],
            'images' => ['nullable', 'array'],
            'images.*' => [new ImageOrUrl()],
            'trailer' => ['nullable', 'file'],
        ];
    }
}
