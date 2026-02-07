<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'thumbnail' => $this->thumbnail,
            'name' => $this->name,
            'about' => $this->about,
            'headman' => $this->headman,
            'people' => $this->people,
            'agricultural_area' => (float)(string)$this->agricultural_area,
            'total_area' => (float)(string)$this->total_area,
            'profile_images' => ProfileImageResource::collection($this->profileImages)
        ];
    }
}
