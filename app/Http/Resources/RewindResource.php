<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\GiftInvitations;

class RewindResource extends JsonResource
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
            'id'                 => $this->id,
            'name'               => $this->name,
            'age'                => \Carbon\Carbon::parse($this->dob)->diff(\Carbon\Carbon::now())->format('%y'),
            'country'            =>  $this->countryName ?? $this->country()->select('name')->get()->pluck('name')[0],
            'gender'             =>   $this->gender_id,
            'media'              => explode(',', $this->medias),
            'connection_id'      => $this->connection_id,
            'profile_pic'        =>  $this->profile_pic,
            'totalPrivatePhotos' => $this->checkCount($this->totalPhotos),
            'totalPrivateVideos' => $this->checkCount($this->totalVideos),
            'wishlist_gifts'     => GiftInvitations::whereHas('user', function($query){
                                    $query->where('users.id', $this->id);
                                    })->where('type', 'Gift')->get(),
            'wishlist_invitations' =>GiftInvitations::whereHas('user', function($query){
                                    $query->where('users.id', $this->id);
                                        })->where('type', 'Invitation')->get(),
            'appearFirst'           =>  0
        ];
    }

    public function checkCount($media){
        if($media == null){
            return 0;
        }else{
            return $media;
        }
    }
}
