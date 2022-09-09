<?php

namespace App\Http\Resources;

use App\Models\AppSetting;
use App\Models\CoinSetting;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use App\Traits\PrivateMediaTrait;
use App\Models\GiftInvitations;
use App\Traits\checkSubscriptionTrait;

class UserDetailResource extends JsonResource
{
    use PrivateMediaTrait, checkSubscriptionTrait;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       $badge = $this->getUserSubscription($this);
       $second_badge = $this->getSecondBadge($this);

        $result  =  [
            'id'                    =>  $this->id,
            'profile_pic'           =>  $this->profile_pic,
            'name'                  =>  $this->name,
            'lastname'              =>  $this->lastname,
            'age'                   =>  $this->setting_hide_age == 1 ? null : \Carbon\Carbon::parse($this->dob)->diff(\Carbon\Carbon::now())->format('%y'),
            'country'               =>  isset($this->country->countryTranslation->trr) ? $this->country->countryTranslation->trr : $this->country->name,
            'gender'                =>  $this->gender_id,
            'bio'                   =>  $this->bio,
            'status'                =>  $this->status == null ? null : (array('id' => $this->status->id, 'name' => isset($this->status->statusTranslation->trr) ? $this->status->statusTranslation->trr : $this->status->name)),
            'have_children'         =>  $this->have_children,
            'have_animals'          =>  $this->have_animals,
            'is_smoker'             =>  $this->is_smoker,
            'is_online'             =>  $this->is_online,
            'mood'                  =>  $this->getMood(),
            'religion'              =>  $this->religion == null ? null : (isset($this->religion->religionTranslation->trr) ? $this->religion->religionTranslation->trr : $this->religion->name),
            'language'              =>  isset($this->language->languageTranslation->trr) ? $this->language->languageTranslation->trr : $this->language->name,
            'looking'               =>  $this->getLookings($this, $request->lang),
            'hobbies'               =>  $this->hobbies,
            'private_photos'        =>  $this->privatePhotos($this->id, 3),
            'private_photo_plus'    =>  $this->privatePhotoCount($this->id, 3),
            'private_photo_cost'    =>  CoinSetting::where('item', 'Photo')->first()->deduct_gold_coins,
            'private_videos'        =>  $this->privateVideos($this->id, 3),
            'private_video_plus'    =>  $this->privateVideoCount($this->id, 3),
            'private_video_cost'    =>  CoinSetting::where('item', 'Video')->first()->deduct_gold_coins,
            'photo_gallery_likes'   =>  $this->photo_gallery_likes,
            'photo_gallery_dislikes'=>  $this->photo_gallery_dislikes,
            'video_gallery_dislikes'=>  $this->video_gallery_dislikes,
            'video_gallery_likes'   =>  $this->video_gallery_likes,
            'badge'                 =>  $badge,
            'second_badge'          =>  $second_badge,
            'wishlist_gifts'        =>  $this->getGiftWishlist($this->id, $request->lang),
            'wishlist_invitations'  =>    $this->getInvitationWishlist($this->id, $request->lang),
            'search_distance'       =>(int)AppSetting::where('shortcode', 'SD')->first()->value2,
        ];

        if($request->id == auth()->user()->id){
            if($this->boost()->get()->last()){
                // $boostValidTill = Carbon::parse($this->boost()->get()->last()->valid_till);
                // $boostExpiresIn =  $boostValidTill->diffInMinutes();

                $result['boost'] = Carbon::parse($this->boost()->latest()->first()->valid_till);
            }else{
               $result['boost'] = null;
            }

        }

        return $result;
    }

    public function getMood(){
        $emoji = $this->mood()->latest()->first();
        if($emoji){
            $expiry_date = Carbon::parse($emoji->pivot->valid_till);
            $is_expired =  Carbon::now()->gt($expiry_date);
            if(!$is_expired){
                return new EmojiResource($this->mood()->latest()->first());
            }else{
                return null;
            }
        }

        return null;

    }

    public function getGiftWishlist($user_id, $lang){
        $giftWishlist = GiftInvitations::orderBy('name', 'ASC')
        ->when($lang != null, function($query) use($lang){
            $query->with(['giftInvitationTranslation' => function($query) use ($lang){
                $query->select('id', 'table_name', 'column_name', 'language_id', 'translation as trr', 'record_id')
                ->where(['table_name' => 'gift', 'column_name' => 'name', 'language_id' => $lang->language_id]);
            }]);
        })
        ->whereHas('user', function($query) use ($user_id){
                        $query->where('users.id', $user_id);
                        })->where('type', 'Gift')->get()->toArray();

        return $this->changeName($giftWishlist);
    }

    public function getInvitationWishlist($user_id, $lang){
       $invitationWishlist =  GiftInvitations::orderBy('name', 'ASC')
       ->when($lang != null, function($query) use($lang){
        $query->with(['giftInvitationTranslation' => function($query) use ($lang){
            $query->select('id', 'table_name', 'column_name', 'language_id', 'translation as trr', 'record_id')
            ->where(['table_name' => 'invitation', 'column_name' => 'name', 'language_id' => $lang->language_id]);
        }]);
    })
       ->whereHas('user', function($query) use($user_id){
            $query->where('users.id',$user_id);
                })->where('type', 'Invitation')->get()->toArray();

        return $this->changeName($invitationWishlist);
    }

    public function changeName($invitationWishlist){

        $invitationWishlistArray = array();

        foreach($invitationWishlist as $gi){
            if(isset($gi['gift_invitation_translation']['trr'])){
                $gi['name'] = $gi['gift_invitation_translation']['trr'];
                $invitationWishlistArray[] = $gi;
            }else{
                $invitationWishlistArray[] = $gi;
            }
        }

        return  $invitationWishlistArray;
    }

    public function getLookings($user, $lang){

       $lookings =  $user->looking()->select('lookings.id', 'name')
       ->when($lang != null, function($query) use($lang){
        $query->with(['lookingTranslation' => function($query) use ($lang){
            $query->select('id', 'table_name', 'column_name', 'language_id', 'translation as trr', 'record_id')
            ->where('table_name', 'country')
            ->where('column_name', 'name')
            ->where('language_id', $lang->language_id);
        }]);
    })->get()->toArray();
       return LookingListResource::collection($lookings);
    }


}
