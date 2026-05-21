<?php

namespace App\Http\Requests\Kelas;

use Illuminate\Foundation\Http\FormRequest;

class AssignStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
        public function rules(): array
        {
            return [
                'siswa' => 'required',
                'siswa.*' => 'exists:users,nisn_nip',
            ];
        }
        public function messages()
        {
            return[
            'siswa.required'=>'Diperlukan NISN Siswa',
            'siswa.*.exists'=>'Siswa Tidak Terdaftar'
            ];
        }
}
