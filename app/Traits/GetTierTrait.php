<?php

namespace App\Traits;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

trait GetTierTrait
{
    public function getTiers($item){

        if ($item == 'Like') {

            return $this->tierLike();

        } elseif ($item == 'SuperLike') {

            return $this->tierSuperLike();

        } elseif ($item == 'Favorite') {

            return $this->tierFavorite();

        } elseif ($item == 'Photo') {

            return $this->tierPhoto();

        } elseif ($item == 'Video') {

            return $this->tierVideo();

        } elseif ($item == 'Call') {

            return $this->tierCall();
        }elseif ($item == 'Boost') {

            return $this->tierBoost();

        }elseif($item == 'Gold'){
            return $this->tierGold();
        }

        else{
            responseNow(0, null, 'Invalid item type');
        }

    }

    public function tierLike(){
        $existing = auth()->user()->available_likes;
        $tiers = Shop::where(['type' => 'Like', 'is_active' => 1])->get();

        return [
            'existing'  => $existing,
            'tiers'     => $tiers
        ];
    }

    public function tierSuperLike(){
        $existing = auth()->user()->available_super_likes;
        $tiers = Shop::where(['type' => 'SuperLike', 'is_active' => 1])->get();

        return [
            'existing'  => $existing,
            'tiers'     => $tiers
        ];
    }

    public function tierFavorite(){

        $existing = auth()->user()->available_favorite;

        $tiers = Shop::where(['type' => 'Favorite', 'is_active' => 1])->get();

        return [
            'existing'  => $existing,
            'tiers'     => $tiers
        ];
    }

    public function tierPhoto(){
        $existing = auth()->user()->available_photo_count;
        $tiers = Shop::where(['type' => 'Photo', 'is_active' => 1])->get();

        return [
            'existing'  => $existing,
            'tiers'     => $tiers
        ];
    }

    public function tierVideo(){
        $existing = auth()->user()->available_video_count;
        $tiers = Shop::where(['type' => 'Video', 'is_active' => 1])->get();

        return [
            'existing'  => $existing,
            'tiers'     => $tiers
        ];
    }

    public function tierCall(){
        $existing = (int) (auth()->user()->available_call_min / 60);

        // $minutes = Carbon::createFromFormat('H:i:s',   $existing)->format('i');
        // $hours = Carbon::createFromFormat('H:i:s',   $existing)->format('H');

        // $hoursToMinutes = $hours * 60;

        // $existing = $hoursToMinutes + $minutes;


        $tiers = Shop::where(['type' => 'Call', 'is_active' => 1])->get();

        return [
            'existing'  => $existing,
            'tiers'     => $tiers
        ];
    }

    public function tierBoost(){
        $tiers = Shop::where(['type' => 'Boost', 'is_active' => 1])->get();

        $boost = auth()->user()->boost()->latest()->first()->valid_till ?? null;
        if($boost){
            $boost = Carbon::parse($boost);
        }
        return [
            'existing' => $boost,
            'tiers' =>  $tiers
        ];
    }
    public function tierGold(){
        $tiers = Shop::where(['type' => 'Gold', 'is_active' => 1])->get();

        return [
            'tiers' =>  $tiers
        ];
    }

}
