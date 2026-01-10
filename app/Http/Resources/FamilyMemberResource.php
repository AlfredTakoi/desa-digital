<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FamilyMemberResource extends JsonResource
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
            'id'=> $this->id,
            'user' => new UserResource($this->user),
            'head_of_family' => new HeadOfFamilyResource($this->whenLoaded('headOfFamily')),
            'profile_picture' => $this->profile_picture,
            'gender' => $this->gender,
            'date_of_birth' => $this->date_of_birth,
            'identity_number' => $this->identity_number,
            'phone_number' => $this->phone_number,
            'occupation' => $this->occupation,
            'relation' => $this->relation,
        ];
    }
}
