<?php
namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'nisn_nip'    => 'required',
            'password' => 'required',
        ];
    }
    public function messages()
    {
        return[
    'nisn_nip.required'=>'NISN_NIP Harus Diisi',
    'password.required'=>'Password Harus Diisi'
    ];
    }
    

}
