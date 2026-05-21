<?php

namespace App\Http\Requests\Laporan;

use Illuminate\Foundation\Http\FormRequest;

class EditLaporanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
        'terlapor'=>'required|string',
        'pelanggaran_id'=>'required|integer',
        'bukti'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'keterangan'=>'nullable|string'
        ];
    }
            public function messages()
    {
        return[
            'terlapor.required'=>'terlapor diperlukan',
            'pelanggaran_id.required'=>'pelanggaran_id dibutuhkan',
            'pelanggaran_id.integer'=>'pelanggaran_id harus berupa angka',
            'bukti.string'=>'bukti harus berupa string',
            'keterangan.string'=>'keterangan harus berupa string'
        ];
    }
}
