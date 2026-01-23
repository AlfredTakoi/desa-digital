<?php

namespace App\Http\Resources;

use App\Models\HeadOfFamily;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\SocialAssistance;

class SocialAssistanceRecipientResource extends JsonResource
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
            'id' => $this->id,
            'social_assistance' => new SocialAssistanceResource($this->socialAssistance),
            'head_of_family' => new HeadOfFamilyResource($this->headOfFamily),
            'amount' => $this->amount,
            'reason' => $this->reason,
            'bank' => $this->bank,
            'proof' => $this->proof,
            'status' => $this->status,
        ];
    }
}
