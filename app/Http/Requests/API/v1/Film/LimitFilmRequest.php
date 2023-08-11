<?php

namespace App\Http\Requests\API\v1\Film;

use Illuminate\Foundation\Http\FormRequest;

class LimitFilmRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'limit' => ['nullable', 'int', 'min:1']
        ];
    }
}
