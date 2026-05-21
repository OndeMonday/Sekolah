<?php
namespace App\Http\Requests\Kelas;

use Illuminate\Foundation\Http\FormRequest;

class BuatKelasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'    => 'required',
            'kelas'    => 'required',
        ];
    }
            public function messages():array
    {
    return[
    'name.required' =>'Nama Harus Diisi',
    'kelas.required' => 'X,XI,XII harus Diisi',
          ];
    }
    
}
