<?php

namespace App\Traits;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

trait CheckMatchTrait
{
    public function checkMatch($user_id){

        $userLike = Like::where(['like_from' => auth()->user()->id, 'like_to' => $user_id, ['like_type', '!=', 2]])->first();
        $userLiked = Like::where(['like_to' => auth()->user()->id, 'like_from' => $user_id, ['like_type', '!=', 2]])->first();

        if($userLike && $userLiked){
            return true;
        }

        return false;
    }
}
