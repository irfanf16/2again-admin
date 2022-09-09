<?php

namespace App\Repositories\GiftInvitationRepository;

use App\Repositories\GiftInvitationRepository\iGiftInvitationRepository;
use Illuminate\Http\Request;
use App\Models\GiftInvitations;
use App\Traits\checkAvailabilityTrait;
use App\Traits\UpdateUserAssetsTrait;
use App\Traits\CreateInteractionTrait;
use App\Http\Resources\MyGiftInvitationResource;
use App\Http\Resources\SentGiftInvitationResource;
use App\Traits\NotificationTrait;
use App\Traits\checkSubscriptionTrait;

class GiftInvitationRepository implements iGiftInvitationRepository{

    use checkAvailabilityTrait, UpdateUserAssetsTrait, CreateInteractionTrait, NotificationTrait, checkSubscriptionTrait;


    public function sendGiftOrInvitation(Request $request)
    {
        $request->validate([
            'to_user'               => 'required|exists:users,id',
            'gifts_invitations_id'  => 'required|exists:gifts_invitations,id'
        ]);

        $giftInvitation = GiftInvitations::find($request->gifts_invitations_id);

        $this->checkAvailability('Gold', $giftInvitation->price);

        $request['price'] = $giftInvitation->price;

        auth()->user()->mySentGiftInvitations()->create($request->all());

        $this->updateUserAssets('Gold', $giftInvitation->price, 'Sub');
        $this->createTransaction(auth()->user()->id, 'sent_' . strtolower($giftInvitation->type), 'DEBIT', 'Gold', $giftInvitation->price);

        if ($giftInvitation->type == 'Invitation') {

            $myRequest = new Request();
            $myRequest['like_to'] = $request->to_user;
            $myRequest['like'] = 'Like';

            $this->createLike($myRequest);

            $this->sendNotification($request->to_user, 'NewInvitation');

        }else{

            $this->sendNotification($request->to_user, 'NewGift');
        }

       return  [
                'gift_invitation' => $giftInvitation,
                'gold_coins'       =>   auth()->user()->gold_coin
            ];
    }

    public function acceptRejectGiftInvitation(Request $request)
    {
        $request->validate([
            'gift_invitation_id'        =>  'exists:users_gifts_invitations,id|required',
            'action'                    =>  'required|integer'
        ]);

        if ($request->action == 1) {
            $action = 'accepted';
        } elseif ($request->action == -1) {
            $action = 'rejected';
        } else {
            responseNow(0, null, 'Invalid Action', 400);
        }

        $giftOrInvitation =  auth()->user()->myGiftsInvitations()->with('giftInvitation')->where('id', $request->gift_invitation_id)->first();

        if (!$giftOrInvitation) {
            responseNow(0, null, 'This gift does not belong to this user', 400);
        }

        if ($giftOrInvitation->is_accepted != 0) {
            responseNow(0, null, 'Action already performed on this item', 400);
        }

        $giftOrInvitation->update([
            'is_accepted' => $request->action
        ]);

        if ($request->action == 1) {

            if($this->checkSubscription(['VIP', 'BS'])){
                $earnable = $this->checkEarningLimitPerUser($giftOrInvitation->from_user, auth()->user()->id, $giftOrInvitation->giftInvitation->silver_coin);
                if($earnable > 0){
                    if($earnable >=  $giftOrInvitation->giftInvitation->silver_coin){
                        $earnable = $giftOrInvitation->giftInvitation->silver_coin;
                    }
                    $this->updateUserAssets('Silver', $earnable, 'Add', auth()->user()->id);
                    $this->createTransaction(auth()->user()->id, 'received' . $giftOrInvitation->giftInvitation->type, 'CREDIT', 'Silver', $earnable, $giftOrInvitation->from_user);
                    $this->sendNotification($giftOrInvitation->to_user, 'EARN_COUNTER');
                }
                $is_silver_earned = 1;
            }else{
                $this->sendNotification($giftOrInvitation->to_user, 'SUB_AND_EARN');
                $is_silver_earned = 0;
            }
        }else{
            $is_silver_earned = 1;
        }

        $giftOrInvitation = new MyGiftInvitationResource($giftOrInvitation);

        return [
            'giftOrInvitation'          => $giftOrInvitation,
            'action'                    =>  $action,
            'is_silver_earned'          =>  $is_silver_earned
        ];
    }

    public function myGiftInvitations(Request $request)
    {
        $lang = $request->lang;

        $newGiftsAndInvitations = auth()->user()->myGiftsInvitations()->with(['fromUser' => function ($query) {
            $query->select('id', 'name', 'profile_pic', 'gender_id', 'dob');
        },
        'giftInvitation' => function($query) use($lang){
//            $query->withTrashed();
            $query->when($lang != null, function($query) use($lang){
                    $query->with(['giftInvitationTranslation' => function($query) use ($lang){
                        $query->select('id', 'table_name', 'column_name', 'language_id', 'translation as trr', 'record_id')
                        ->where(function($query){
                            $query->where('table_name', 'gift')
                            ->orWhere('table_name', 'invitation');
                        })->where('language_id', $lang->language_id);
                    }]);
                });
        }])
        ->whereHas('giftInvitation', function ($query) use ($request) {
            $query->where('type', $request->type);
        })->where('is_accepted', 0)
        ->orderBy('id', 'DESC')
        ->get();

        $historyGiftInvitations = auth()->user()->myGiftsInvitations()->with(['fromUser' => function ($query) use($lang) {
            $query->select('id', 'name', 'profile_pic', 'gender_id', 'dob');
        },
        'giftInvitation' => function($query) use($lang){
//            $query->withTrashed();
            $query->when($lang != null, function($query) use($lang){
                $query->with(['giftInvitationTranslation' => function($query) use ($lang){
                    $query->select('id', 'table_name', 'column_name', 'language_id', 'translation as trr', 'record_id')
                    ->where(function($query){
                        $query->where('table_name', 'gift')
                        ->orWhere('table_name', 'invitation');
                    })->where('language_id', $lang->language_id);
                }]);
            });
        }])
            ->whereHas('giftInvitation', function ($query) use ($request) {
                $query->where('type', $request->type);
            })->where('is_accepted', '!=', 0)
            ->orderBy('id', 'DESC')
            ->get();

        $historyGiftInvitations = MyGiftInvitationResource::collection($historyGiftInvitations);
        $newGiftsAndInvitations = MyGiftInvitationResource::collection($newGiftsAndInvitations);

        return [
            'pending' => $newGiftsAndInvitations,
            'history'   => $historyGiftInvitations
        ];
    }

    public function mySentGiftInvitations(Request $request)
    {
             $lang = $request->lang;

            $history = auth()->user()->mySentGiftInvitations()
            ->with(['toUser' => function ($query) use($lang){
                    $query->select('id', 'name', 'profile_pic', 'gender_id', 'dob');
                }, 'giftInvitation' => function($query) use($lang){
//                    $query->withTrashed();
                    $query->when($lang != null, function($query) use($lang){
                        $query->with(['giftInvitationTranslation' => function($query) use ($lang){
                            $query->select('id', 'table_name', 'column_name', 'language_id', 'translation as trr', 'record_id')
                            ->where(function($query){
                                $query->where('table_name', 'gift')
                                ->orWhere('table_name', 'invitation');
                            })->where('language_id', $lang->language_id);
                        }]);
                    });

                }])
            ->whereHas('giftInvitation', function ($query) use ($request) {
                $query->where('type', $request->type);
            })
            ->where('is_accepted', '!=', 0)
            ->orderBy('id', 'DESC')
            ->get();

        $pending = auth()->user()->mySentGiftInvitations()->with(['toUser' => function ($query) use($lang) {
            $query->select('id', 'name', 'profile_pic', 'gender_id', 'dob');
        }, 'giftInvitation' => function($query) use($lang){
//            $query->withTrashed();
                $query->when($lang != null, function($query) use($lang){
                    $query->with(['giftInvitationTranslation' => function($query) use ($lang){
                        $query->select('id', 'table_name', 'column_name', 'language_id', 'translation as trr', 'record_id')
                        ->where(function($query){
                            $query->where('table_name', 'gift')
                            ->orWhere('table_name', 'invitation');
                        })->where('language_id', $lang->language_id);
                    }]);
                });
        }])
            ->whereHas('giftInvitation', function ($query) use ($request) {
                $query->where('type', $request->type);
            })->where('is_accepted', 0)
            ->orderBy('id', 'DESC')
            ->get();

        $history = SentGiftInvitationResource::collection($history);
        $pending = SentGiftInvitationResource::collection($pending);

        return [
            'pending' => $pending,
            'history'   =>  $history
        ];
    }

    public function wishlist(Request $request)
    {
        $request->validate([
            'id'       => 'required|exists:gifts_invitations,id',
        ]);

        $ifExists = auth()->user()->wishlist()->where('gifts_invitations.id', $request->id)->first();

        if ($ifExists) {
            auth()->user()->wishlist()->detach($request->id);
            return 0;
        }

        auth()->user()->wishlist()->attach($request->id);

        return 1;
    }
}
