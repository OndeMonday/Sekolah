<?php

namespace App\Http\Requests\Tugas;

use Illuminate\Foundation\Http\FormRequest;

class SubmissionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

public function rules()
{
    return [
        'image' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        'description' => 'nullable|string',
    ];
}
}
