<?php

namespace App\Repositories\InteractionRepository;

use App\Repositories\InteractionRepository\iInteractionRepository;
use App\Traits\checkAvailabilityTrait;
use App\Traits\UpdateUserAssetsTrait;
use App\Traits\CreateInteractionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\LikeType;
use App\Http\Resources\UserLessInfoResource;
use App\Http\Resources\NearbyUserResource;
use App\Http\Resources\RewindResource;
use App\Models\AppearFirst;
use App\Traits\checkSubscriptionTrait;

class InteractionRepository implements iInteractionRepository {

    use checkAvailabilityTrait, UpdateUserAssetsTrait, CreateInteractionTrait, checkSubscriptionTrait;

    public function createNewLike(Request $request){
        return $this->createLike($request);
    }

    public function favorite(Request $request){
        $request->validate([
            'favorite_to'     => 'required|exists:users,id',
        ]);

        $check = auth()->user()->favorites()->where('favorite_to', $request->input('favorite_to'))->first();
        if ($check) {
            auth()->user()->favorites()->detach($request->input('favorite_to'));
            return 0;
        }

        $this->checkAvailability('Favorite');

        auth()->user()->favorites()->attach($request->input('favorite_to'));

        $this->updateUserAssets('Favorite');

        return 1;
    }

    public function getMyInteractions(Request $request){
        $request->validate([
            'interaction_type'          => 'required|string|exists:like_types,name',
        ]);

        $like_type = LikeType::select('id')->where('name', $request->interaction_type)->first();
        $user = auth()->user()->id;

        $myLikes = DB::select("SELECT * from likes as ul inner join users
        WHERE ul.like_from='$user'
            AND ul.like_to = users.id
            AND ul.like_to NOT IN (SELECT blocked_user from blocks where blocked_by = '$user')
            AND ul.like_to NOT IN (SELECT reported_user from reports where reported_by = '$user')
            AND '$user' NOT IN (SELECT blocked_user from blocks where blocked_by = ul.like_to)
            AND '$user' NOT IN (SELECT reported_user from reports where reported_by = ul.like_to)
            AND ul.like_type = ' $like_type->id'");

       $myLikes = UserLessInfoResource::collection($myLikes);
        return $myLikes;
    }

    public function getInteractedMe(Request $request){
        $like_type = LikeType::select('id')->where('name', $request->interaction_type)->first();
        $user = auth()->user()->id;
        $likesMe = DB::select("SELECT * from likes as ul inner join users
            WHERE ul.like_to='$user'
                AND ul.like_from = users.id
                AND ul.like_from NOT IN (SELECT blocked_user from blocks where blocked_by = '$user')
                AND ul.like_from NOT IN (SELECT reported_user from reports where reported_by = '$user')
                AND '$user' NOT IN (SELECT blocked_user from blocks where blocked_by = ul.like_from)
                AND '$user' NOT IN (SELECT reported_user from reports where reported_by = ul.like_from)
                AND ul.like_type = '$like_type->id'");


        $likesMe = UserLessInfoResource::collection($likesMe);
        return $likesMe;
    }

    public function getMyMatches(){
        $user = auth()->user()->id;
        $matches = DB::select("SELECT * FROM likes as ul inner join users
        WHERE ul.like_from='$user'
            AND ul.like_to = users.id
            AND ul.like_to IN (SELECT like_from from likes where like_to = '$user' AND like_type != 2)
            AND ul.like_to NOT IN (SELECT blocked_user from blocks where blocked_by = '$user')
            AND ul.like_to NOT IN (SELECT reported_user from reports where reported_by = '$user')
            AND '$user' NOT IN (SELECT blocked_user from blocks where blocked_by = ul.like_to)
            AND '$user' NOT IN (SELECT reported_user from reports where reported_by = ul.like_to)
            AND ul.like_type != 2 AND users.id IS NOT NULL");
        $matches = UserLessInfoResource::collection($matches);
        return $matches;
    }

    public function unmatch(Request $request){
        $request->validate([
            'user_id' => 'exists:users,id',
            'is_reported'   => 'sometimes|required|boolean',
            'reason'        => 'integer|required_with:is_reported',
            'message'       => 'string|max:255|required_with:is_reported'
        ]);

        if ($request->has('is_reported')) {
            auth()->user()->report()->create([
                'reported_user' => $request->input('user_id'),
                'reason'    => $request->input('reason'),
                'message'   => $request->input('message'),
            ]);
        }

        $detach = auth()->user()->sentLike()->detach($request->input('user_id'));
        return 1;
    }

    public function seenMe(Request $request)
    {
        $request->validate([
            'has_seen'          =>  'required|boolean'
        ]);

        // $users =  auth()->user()->appearFirst()->where('has_seen', $request->has_seen)->get();
        $user = auth()->id();
        $users = DB::select("SELECT * from appear_firsts as af
        INNER JOIN users
        Where af.user_target = users.id
        AND af.user_candidate = '$user'
                AND af.user_target NOT IN (SELECT blocked_user from blocks where blocked_by = '$user')
                AND af.user_target NOT IN (SELECT reported_user from reports where reported_by = '$user')
                AND '$user' NOT IN (SELECT blocked_user from blocks where blocked_by = af.user_target)
                AND '$user' NOT IN (SELECT reported_user from reports where reported_by = af.user_target)
                And af.has_seen = '$request->has_seen'
        ");
        $users = UserLessInfoResource::collection($users);
        return $users;
    }

    public function rewind()
    {
        if(!$this->checkSubscription(['VIP', 'BS'])){
            responseNow(2, 'show popup', 'Please Become vip or big spender to perform this action');
        }

        $like = auth()->user()->sentLike()->orderBy('created_at', 'DESC')->first();

        if($like){
            $like = new RewindResource($like);
            return $like;
        }else{
            0;
        }
    }

    public function block(Request $request)
    {
        $request->validate([
            'blocked_user'       => 'exists:users,id'
        ]);

        $is_blocked = auth()->user()->block()->where('users.id', $request->blocked_user)->first();

        if($is_blocked){
            return 2;
        }

        auth()->user()->block()->attach(['id' => $request->blocked_user]);

        return 1;
    }

    public function blockedUsers(){
        $blockedUsers = auth()->user()->block()->get();
        return UserLessInfoResource::collection($blockedUsers);
    }

    public function unblock(Request $request)
    {
        $request->validate([
            'user_id'   =>  'required|exists:users,id'
        ]);

        auth()->user()->block()->detach(['id' => $request->user_id]);

        return 1;
    }

    public function appearFirst(Request $request)
    {
        return $this->createAppearFirst($request);
    }

    public function seen(Request $request)
    {
        $request->validate([
            'seen_user_id'  =>  'required|exists:users,id'
        ]);

        $appearFirst = AppearFirst::where(
            [
                'user_candidate' => $request->seen_user_id,
                'user_target' => auth()->user()->id,
                'has_seen'      =>  0
            ])->first();

        if($appearFirst){
            $appearFirst->update([
                'has_seen'  =>  1
            ]);

            $this->sendNotification($request->seen_user_id, 'SeenMe');
        }
    }
}
