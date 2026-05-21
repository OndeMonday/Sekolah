<?php

namespace App\Http\Requests\Pelanggaran;

use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
        'name'=>'nullable|string',
        'deskripsi'=>'nullable|string',
        'poin'=>'nullable|integer',
        'active'=>'boolean'
        ];
    }
            public function messages()
    {
        return[
            'name.required'=>'nama dibutuhkan',
            'deskripsi.required'=>'deskripsi diperlukan',
            'poin.required'=>'poin dibutuhkan',
            'poin.integer'=>'poin harus berupa angka'

        ];
    }
}
