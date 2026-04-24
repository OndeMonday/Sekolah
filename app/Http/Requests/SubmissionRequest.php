<?php

namespace App\Http\Requests;

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
        'task_id' => 'required|exists:tasks,id',
        'image' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        'description' => 'nullable|string',
    ];
}
}
