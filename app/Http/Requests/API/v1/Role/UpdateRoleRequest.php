<?php

namespace App\Http\Requests\API\v1\Role;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', Rule::unique('roles')->ignore($this->id), 'max:100'],
        ];
    }
}
