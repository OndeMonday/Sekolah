<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ChangeRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->role === 'admin';
    }

    public function rules(): array
    {
        return [
        'role' => 'required|in:murid,guru,admin',
        ];
    }
    public function messages()
    {
        return[
        'role.required'=>'role harus diisi'
        ];
    }
}
