<?php

namespace App\Http\Requests\DetailTransaksi;

use Illuminate\Foundation\Http\FormRequest;

class DetailTransaksiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'transaksi_id' => 'required|exists:transaksi,id',
            'menu_id' => 'required|exists:menu,id',
            'qty' => 'required|integer|min:1'
        ];
    }
}