<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubmissionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

public function rules()
{
return [
    'image' => 'nullable|max:2048',
    'description' => 'nullable'
];
}
public function messages()
{
    return[
    'image.max'=>'Tidak Lebih Dari 2MB',
    'image.image'=>'Tidak Menggunakan Format File[PDF,DOC,ZIP]'
    ];
}
}
