<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GiftInvitationListResource extends JsonResource
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
            'id'            =>  $this->id,
            'name'          =>  isset($this->trr) ? $this->trr : $this->name,
            'type'          =>  $this->type,
            'price'         =>  $this->price,
            'silver_coin'   =>  $this->silver_coin,
            'icon'          =>  $this->icon,
            'wishlisted'    =>  $this->wishlisted
        ];
    }
}
