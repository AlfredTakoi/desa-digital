<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SocialAssistanceUpdateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'provider' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_available' => 'required|boolean'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nama',
            'thumbnail' => 'Thumbnail',
            'category' => 'Kategori',
            'amount' => 'Jumlah',
            'provider' => 'Penyedia',
            'description' => 'Deskripsi',
            'is_available' => 'Ketersediaan',
        ];
    }
}
