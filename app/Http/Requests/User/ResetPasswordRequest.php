<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'password' => 'required|min:6'
        ];
    }
        public function messages():array
    {
        return[
    'password.required' =>'Harus Diisi',
    'password.min' => 'Minimal 6 Karakter',
        ];
    }
}
