<?php

namespace App\Http\Resources;

use App\Models\HeadOfFamily;
use Illuminate\Http\Resources\Json\JsonResource;

class EventParticipantResource extends JsonResource
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
            'event' => new EventResource($this->event),
            'head_of_family' => new HeadOfFamilyResource($this->headOfFamily),
            'quantity' => $this->quantity,
            'total_price' => (float)(string)$this->total_price,
            'payment_status' => $this->payment_status,
        ];
    }
}
