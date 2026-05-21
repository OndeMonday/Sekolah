<?php

namespace App\Http\Requests\Tugas;

use Illuminate\Foundation\Http\FormRequest;

class ApproveSubmissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => 'required|in:approved,rejected',
            'nilai' => 'nullable|min:0|max:100',
            'teacher_note' => 'nullable|string'
        ];
    }
            public function messages():array
    {
        return[
       'status.required' => 'Status Harus Diisi',
       'nilai.min' => 'Tidak Bisa Dibawah 0', 
       'nilai.max' => 'Tidak Bisa Diatas 100'
        ];
    }
}
