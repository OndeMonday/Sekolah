<?php

namespace App\Http\Requests\Kelas;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNamaKelasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // atau cek role admin di sini
    }

    public function rules(): array
    {
        return [
            'name' => 'required|max:15',
            'kelas'=> 'required|max:3'
        ];
    }
        public function messages()
    {
        return[
    'name.required'=>'Nama Diperlukan',
    'name.max'=>'Tidak Lebih Dari 15 Karakter',
    'kelas.required'=>'Tingkat Kelas Diperlukan',
    'kelas.max'=>'Hanya Bisa X,XI Dan XII',
    'kelas.in'=>'Hanya Bisa X,XI,XII'
        ];
    }
}