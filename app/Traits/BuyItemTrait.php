<?php

namespace App\Traits;

use App\Jobs\ExpireProfileBoost;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

trait BuyItemTrait
{
    public function buyItem($item){

        if ($item->type == 'Like') {

            $this->buyLike($item->quantity);

        } elseif ($item->type == 'SuperLike') {

            $this->buySuperLike($item->quantity);

        } elseif ($item->type == 'Favorite') {

            $this->buyFavorite($item->quantity);

        } elseif ($item->type == 'Photo') {

            $this->buyPhotoSlot($item->quantity);

        } elseif ($item->type == 'Video') {

            $this->buyVideoSlot($item->quantity);

        } elseif ($item->type == 'Call') {

            $this->buyMinutes($item->quantity);
            $this->chargeUser($item->price);

            $available_time = auth()->user()->available_call_min;

            return (int)$available_time;


        }elseif ($item->type == 'Boost') {

           $valid_till =  $this->buyBoost($item->quantity);
           $this->chargeUser($item->price);

           return $valid_till;
        }
        else{

            responseNow(0, null, 'Invalid item type');
        }

        $this->chargeUser($item->price);
    }

    public function buyLike($quantity){
        auth()->user()->available_likes = auth()->user()->available_likes + $quantity;
        auth()->user()->save();
        return;
    }

    public function buySuperLike($quantity){

        auth()->user()->available_super_likes = auth()->user()->available_super_likes + $quantity;
        auth()->user()->save();
        return;
    }

    public function buyFavorite($quantity){

        auth()->user()->available_favorite = auth()->user()->available_favorite + $quantity;
        auth()->user()->save();
        return;
    }

    public function buyPhotoSlot($quantity){

        auth()->user()->available_photo_count = auth()->user()->available_photo_count + $quantity;
        auth()->user()->save();
        return;
    }

    public function buyVideoSlot($quantity){

        auth()->user()->available_video_count = auth()->user()->available_video_count + $quantity;
        auth()->user()->save();
        return;
    }

    public function buyMinutes($quantity){

        // $available_time = Carbon::createFromFormat('H:i:s',   auth()->user()->available_call_min)->addMinutes($quantity)->format('H:i:s');
        $calculate_seconds = $quantity * 60;
        auth()->user()->available_call_min = auth()->user()->available_call_min +  $calculate_seconds;
        auth()->user()->save();
        return;
    }

    public function chargeUser($price){

        auth()->user()->gold_coin = auth()->user()->gold_coin - $price;
        auth()->user()->save();
        return;
    }

    public function buyBoost($hours){

        $executeAt = Carbon::now()->addMinutes($hours);

        auth()->user()->boost()->create([
            'radius'            =>  auth()->user()->discover_boost_radius,
            'is_world_wide'     =>  auth()->user()->discovery_world_wide_boost,
            'valid_till'        =>  $executeAt
        ]);

        dispatch(new ExpireProfileBoost(auth()->user()->id, $executeAt))->delay($executeAt);

        return $executeAt;
    }

}
