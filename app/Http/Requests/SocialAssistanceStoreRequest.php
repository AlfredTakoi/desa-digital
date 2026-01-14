<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SocialAssistanceStoreRequest extends FormRequest
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
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category' => 'required|in:staple,cash,subsidized fuel,health',
            'amount' => 'required',
            'provider' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_available' => 'boolean',
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
