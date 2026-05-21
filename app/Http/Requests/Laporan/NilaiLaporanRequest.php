<?php

namespace App\Http\Requests\Laporan;

use Illuminate\Foundation\Http\FormRequest;

class NilaiLaporanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
        'status'=>'required|in:terkirim,diterima,ditolak',
        ];
    }
            public function messages()
    {
        return[
            'status.required'=>'status diperlukan',
            'status.in'=>'status harus salah satu dari: terkirim, diterima, ditolak',

        ];
    }
}
