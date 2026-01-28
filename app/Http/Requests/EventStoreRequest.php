<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'name' => 'required|string|',
            'description' => 'required|string',
            'price' => 'required',
            'date' => 'required|date',
            'time' => 'required',
            'is_active' => 'required|boolean',
        ];
    }

    public function attributes()
    {
        return [
            'thumbnail' => 'Thumbnail',
            'name' => 'Nama',
            'description' => 'Deskripsi',
            'price' => 'Harga',
            'date' => 'Tanggal',
            'time' => 'Waktu',
            'is_active' => 'Aktif'
        ];
    }
}
