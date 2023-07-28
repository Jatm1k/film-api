<?php

namespace App\Http\Requests\API\v1\Review;

use App\Enums\API\v1\ReviewType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateReviewRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['nullable', 'string', 'max:255'],
            'text' => ['required', 'string', 'max:3000'],
            'type' => ['required', 'string', new Enum(ReviewType::class)],
        ];
    }
}
