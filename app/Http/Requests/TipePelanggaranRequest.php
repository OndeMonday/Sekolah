<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipePelanggaranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

public function rules(): array
{
    return [
        "nama"=>"required",
        "poin"=>"required|integer",
        "deskripsi"=>"nullable",    
        "is_active"=>"required|boolean"

    ];
}

}