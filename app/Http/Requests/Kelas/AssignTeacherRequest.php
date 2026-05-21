<?php

namespace App\Http\Requests\Kelas;

use Illuminate\Foundation\Http\FormRequest;

class AssignTeacherRequest extends FormRequest
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
            'nisn_nip'=>'required',
            'nisn_nip.*'=>'exists:users,nisn_nip',
            'mapel'=>'required',
            'walikelas'=>'required'
        ];
    }
        public function messages()
        {
            return[
                'nisn_nip.required'=>'NIP Guru Diperlukan',
                'nisn_nip.*.exists'=>'Guru Tidak Terdaftar'
            ];
        }
    }

