<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Traits\GetUserSubscriptionTrait;
use App\Http\Resources\SubscriptionResource;
use App\Traits\ProfileCompletionTrait;

class UserResource extends JsonResource
{
    use GetUserSubscriptionTrait, ProfileCompletionTrait;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                            =>  $this->id,
            'name'                          =>  $this->name,
            'lastname'                      =>  $this->lastname,
            'email'                         =>  $this->email,
            'phone'                         =>  $this->phone,
            'social_id'                     =>  $this->social_id,
            'gender_id'                     =>  $this->gender_id,
            'dob'                           =>  $this->dob,
            'language'                      =>  $this->language->name,
            'bio'                           =>  $this->bio,
            'country_id'                    =>  $this->country->id,
            'religion'                      =>  $this->religion->name ?? null,
            'hobbies'                       =>  $this->hobbies,
            'filter_date_range'             =>  $this->filter_date_range,
            'time_zone'                     =>  $this->time_zone,
            'profile_completed'             =>  (int) $this->getProfileCompletion($this),
            'interested_in'                 =>  (int) $this->interested_in,
            'subscription'                  =>  new SubscriptionResource($this->getSubscription($this->id)),
            'identified'                    =>  0,
            'media_url'                     => env('MEDIA_URL'),
            'icon_url'                      => env('GIFT_URL'),
            'audio_url'                     => env('AUDIO_MESSAGE_URL'),
            'is_welcome_bonus_claimed'      =>  $this->is_welcome_bonus_claimed
        ];
    }
}
