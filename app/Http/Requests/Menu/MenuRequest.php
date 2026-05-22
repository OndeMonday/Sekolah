<?php

namespace App\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules():Array
    {
        return [
            'name'=>'required|string',
            'harga'=>'required|integer',
            'stok'=>'nullable|integer',
            'gambar'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }
            public function messages()
    {
        return[
            'name.required'=>'Nama menu diperlukan',
            'name.string'=>'Nama menu harus berupa string',
            'harga.required'=>'Harga menu diperlukan',
            'harga.integer'=>'Harga menu harus berupa angka',
            'stok.integer'=>'Stok menu harus berupa angka',
            'gambar.image'=>'Gambar harus berupa file gambar',
            'gambar.mimes'=>'Gambar harus berformat jpeg, png, jpg, gif, atau svg',
            'gambar.max'=>'Gambar tidak boleh lebih dari 2048 kilobytes'
        ];
    }
}
