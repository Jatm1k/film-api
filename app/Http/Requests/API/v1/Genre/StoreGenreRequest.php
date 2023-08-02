<?php

namespace App\Http\Requests\API\v1\Genre;

use Illuminate\Foundation\Http\FormRequest;

class StoreGenreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'unique:genres', 'max:100'],
        ];
    }
}
