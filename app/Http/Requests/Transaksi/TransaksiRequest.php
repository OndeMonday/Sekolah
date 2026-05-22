<?php

namespace App\Http\Requests\Transaksi;

use Illuminate\Foundation\Http\FormRequest;

class TransaksiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'items' => 'required|array|min:1',

            'items.*.menu_id' =>
            'required|exists:menu,id',

            'items.*.qty' =>
            'required|integer|min:1'
        ];
    }
}