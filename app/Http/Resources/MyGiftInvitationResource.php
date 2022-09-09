<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MyGiftInvitationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if($this->is_accepted == 1){
            $silver = auth()->user()->silver_coin + $this->giftInvitation->silver_coin;
        }else{
            $silver = auth()->user()->silver_coin;
        }

        return [
            'id'                =>  $this->id,
            'user'              =>  new UserLessInfoResource($this->fromUser),
            'silver_coin'       =>  $silver,
            'sent_at'           =>  $this->created_at->diffForHumans(),
            'is_accepted'       =>  (int)$this->is_accepted,
            'giftInvitation'    =>  $this->giftInvitationNameChange($this->giftInvitation)
        ];
    }

    public function giftInvitationNameChange($giftInvitation){
        $giftInvitationArray = $giftInvitation->toArray();
        if(isset($giftInvitationArray['gift_invitation_translation']['trr'])){
            $giftInvitationArray['name'] = $giftInvitationArray['gift_invitation_translation']['trr'];
            return $giftInvitationArray;
        }else{
            return  $giftInvitation;
        }
    }
}
