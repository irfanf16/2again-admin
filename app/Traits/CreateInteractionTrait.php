<?php

namespace App\Traits;

use App\Models\LikeType;
use Illuminate\Http\Request;
use App\Traits\SpendEarnTrait;
use App\Traits\NotificationTrait;
use App\Traits\CheckMatchTrait;


trait CreateInteractionTrait
{
    use SpendEarnTrait, NotificationTrait, CheckMatchTrait;

    public function createLike(Request $request)
    {
        $request->validate([
            'like_to'       => 'required|exists:users,id',
            'like'          => 'required|string|exists:like_types,name',
        ]);

        $like_type = LikeType::select('id')->where('name', $request->like)->first();

        $action =  $request->like;

        if ($action != 'Nope') {
            $this->checkAvailability($action);
        }

        $request['like_type'] = $like_type->id;
        unset($request['like']);

        $like = auth()->user()->sentLikePivot()->where([
            'like_to'       => $request->input('like_to'),
            'like_type'     =>  $request->like_type
        ])->firstOr(function () use ($request) {
            return auth()->user()->sentLikePivot()->updateOrCreate(['like_to' => $request->input('like_to')], $request->all());
        });

        if ($action != 'Like') {
            $this->updateUserAssets($action, null, null, $request->like_to);
        }

        if ($like->wasRecentlyCreated || $like->wasChanged()) {

            //send super like notification
            $this->sendNotification($request->input('like_to'), $action);

            if ($action == 'SuperLike') {
                if ($this->checkOtherUserSubscription(['VIP', 'BS'], $request->like_to)) {

                    $item = $this->getCoinSetting('SuperLike');

                    $earnable = $this->checkEarningLimitPerUser(auth()->id(), $request->like_to, $item->earn_silver_coins);

                    if ($earnable > 0) {
                        if ($earnable >= $item->earn_silver_coins) {
                            $earnable = $item->earn_silver_coins;
                        }

                        $this->updateUserAssets('Silver', $earnable, 'Add', $request->like_to);
                        $this->createTransaction($request->like_to, 'received_super_like', 'CREDIT', 'Silver', $earnable, auth()->id());
                        $this->sendNotification($request->like_to, 'EARN_COUNTER');
                    }
                } else {
                    $this->sendNotification($request->like_to, 'SUB_AND_EARN');
                }
            }

            if ($like->wasRecentlyCreated) {
                if ($this->checkMatch($request->input('like_to'))) {
                    $this->sendNotification($request->input('like_to'), 'NewMatch');
                }
            }

            $message = $request->lang != null ? 'Profile_' . $action . '_successfully' : 'Profile ' . $action . ' successfully';
        } else {

            $message = $request->lang != null ? 'you_already_' . $action . '_this_profile' : 'You Already ' . $action . ' this profile';

            return [
                'code'  => 0,
                'message'   => $message,
            ];
        }

        return [
            'code' => 1,
            'message' => $message
        ];
    }

    public function createAppearFirst(Request $request)
    {
        $request->validate([
            'user_target'       =>  'required|exists:users,id'
        ]);

        $item = $this->getCoinSetting('AF');

        $this->checkAvailability('Gold', $item->deduct_gold_coins);

        $checkIfAlready = auth()->user()->appearFirst()->where('user_target', $request->user_target)->first();

        if ($checkIfAlready) {

            $message = $request->lang != null ? 'you_are_already_set_to_appear_first_to_this_person' : 'You are already set to appear first to this person';

            return [
                'code' => 0,
                'message' => $message
            ];
        }

        auth()->user()->appearFirst()->attach($request->user_target);

        $this->updateUserAssets('Gold', $item->deduct_gold_coins, 'Sub');
        $this->createTransaction(auth()->user()->id, 'set_appear_first', 'DEBIT', 'Gold', $item->deduct_gold_coins);

        $message = $request->lang != null ? 'you_will_appear_first_to_this_person' : 'You will appear first to this person';


        return [
            'code' => 1,
            'message' =>  $message
        ];
    }
}
