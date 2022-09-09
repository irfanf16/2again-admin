<?php

namespace App\Http\Resources;

use App\Models\GiftInvitations;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use App\Traits\checkSubscriptionTrait;

class NearbyUserResource extends JsonResource
{
    use checkSubscriptionTrait;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $lang = $request->lang;

        return [
            'id'                 => $this->id,
            'name'               => $this->name,
            'lastname'           => $this->lastname,
            'age'                => $this->setting_hide_age == 1 ? null : \Carbon\Carbon::parse($this->dob)->diff(\Carbon\Carbon::now())->format('%y'),
            'country'            => isset($this->translatedCountry) ? $this->translatedCountry : $this->countryName ?? $this->country()->select('name')->get()->pluck('name')[0],
            'gender'             => $this->gender_id,
            'media'              => explode(',', $this->medias),
            'connection_id'      => $this->connection_id,
            'profile_pic'        =>  $this->profile_pic,
            'totalPrivatePhotos' => $this->totalPhotos,
            'totalPrivateVideos' => $this->totalVideos,
            'wishlist_gifts'     => $this->getGiftWishlist($this->id, $lang),
            'wishlist_invitations' =>$this->getInvitationWishlist($this->id, $lang),
            'appearFirst'           =>  $this->appearFirst,
            'is_boosted'           =>  isset($this->boost_distance) ? 1 : 0,
            'is_online'             =>  $this->is_online,
            'badge'                 =>  $this->getUserSubscription($this),
            'second_badge'          =>  $this->getSecondBadge($this)
        ];
    }


    public function getGiftWishlist($user_id, $lang){
        $giftWishlist = GiftInvitations::orderBy('name', 'ASC')
        ->when($lang != null, function($query) use($lang){
            $query->with(['giftInvitationTranslation' => function($query) use ($lang){
                $query->select('id', 'table_name', 'column_name', 'language_id', 'translation as trr', 'record_id')
                ->where(['table_name' => 'gift', 'column_name' => 'name', 'language_id' => $lang->language_id])
                ->orWhere(['table_name' => 'invitation', 'column_name' => 'name', 'language_id' => $lang->language_id]);
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
            ->where(['table_name' => 'gift', 'column_name' => 'name', 'language_id' => $lang->language_id])
            ->orWhere(['table_name' => 'invitation', 'column_name' => 'name', 'language_id' => $lang->language_id]);
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

}
