<?php

namespace App\Http\Requests;

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
        'name'=>'required',
        'deskripsi'=>'required',
        ];
    }
            public function messages()
    {
        return[
            'name.required'=>'nama dibutuhkan',
            'deskripsi.required'=>'deskripsi diperlukan',

        ];
    }
}
