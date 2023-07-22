<?php

namespace App\Http\Requests\API\v1\Role;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'unique:roles', 'max:100'],
        ];
    }
}
