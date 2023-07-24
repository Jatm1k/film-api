<?php

namespace App\Http\Requests\API\v1\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'login' => ['required', 'string', 'regex:/[A-z]/', 'max:30', 'unique:users'],
            'email' => ['required', 'string', 'email', 'unique:users'],
            'password' => ['required', 'string', 'confirmed', Password::default()],
        ];
    }
}
