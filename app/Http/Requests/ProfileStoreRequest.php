<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'thumbnail' => 'required|image',
            'name' => 'required|string',
            'about' => 'required|string',
            'headman' => 'required|string',
            'people' => 'required|integer',
            'agricultural_area' => 'required',
            'total_area' => 'required',
            'images' => 'nullable|array',
            'images.*' => 'nullable|mimes:png,jpg,jpeg|max:2048'
        ];
    }

    public function attributes()
    {
        return [
            'thumbnail' => 'Thumbnail',
            'name' => 'Nama',
            'about' => 'Deskripsi',
            'headman' => 'Kepala Desa',
            'people' => 'Jumlah Penduduk',
            'agricultural_area' => 'Luas Pertanian',
            'total_area' => 'Luas Pertanian',
            'images' => 'Gambar'
        ];
    }
}
