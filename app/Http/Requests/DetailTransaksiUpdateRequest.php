<?php

namespace App\Http\Requests\DetailTransaksi;

use Illuminate\Foundation\Http\FormRequest;

class DetailTransaksiUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'qty' => 'sometimes|integer|min:1'
        ];
    }
}