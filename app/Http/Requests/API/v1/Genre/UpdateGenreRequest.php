<?php

namespace App\Http\Requests\API\v1\Genre;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateGenreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', Rule::unique('genres')->ignore($this->id), 'max:100'],
        ];
    }
}
