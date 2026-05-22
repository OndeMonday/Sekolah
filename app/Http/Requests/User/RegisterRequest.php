<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'nisn_nip' => 'required|string',
            'password' => 'required|string',
            'role' => 'required|string|in:guru,murid,admin,kantin',
        ];
    }
        public function messages()
    {
        return[
    'name,required'=>'Nama Harus Diisi',
    'name,string'=>'Tidak Bisa Dengan Simbol',
    'nisn_nip.min'=>'Minimal Harus 8 Angka',
    'password.min'=>'Minimal Harus 6 Karakter',
    'role.required'=>'Harus Diisi'
        ];
        
    }
}

