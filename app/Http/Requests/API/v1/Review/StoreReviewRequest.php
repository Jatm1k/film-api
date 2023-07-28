<?php

namespace App\Http\Requests\API\v1\Review;

use App\Enums\API\v1\ReviewType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreReviewRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'film_id' => ['required', 'int', 'exists:films,id'],
            'title' => ['nullable', 'string', 'max:255'],
            'text' => ['required', 'string', 'max:3000'],
            'type' => ['required', 'string', new Enum(ReviewType::class)],
        ];
    }
}
