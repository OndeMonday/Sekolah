<?php

namespace App\Http\Requests\Tugas;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

public function rules(): array
{
    return [
        'title' => 'nullable',
        'description' => 'nullable',
        'deadline' => 'date',
        'image_path'=> 'nullable'
    ];
}

}