<?php

namespace App\Traits;

use App\Models\AppSetting;
use App\Models\InAppTransaction;
use App\Models\User;
use App\Traits\CoinSettingTrait;
use App\Traits\TransactionTrait;
use App\Traits\checkSubscriptionTrait;
use Carbon\Carbon;

trait UpdateUserAssetsTrait
{
    use CoinSettingTrait, TransactionTrait, checkSubscriptionTrait;

    public function updateUserAssets($type, $count = null, $action=null, $user_id = null)
    {

        if ($type == 'SuperLike') {

            $this->updateSuperLikes($user_id);
            return;

        } elseif ($type == 'Favorite') {

            $this->updateFavorites();
            return;

        } elseif ($type == 'Photo') {

            $this->updatePhotoCount();
            return;

        } elseif ($type == 'Video') {

            $this->updateVideoCount();
            return;

        } elseif ($type == 'Call') {
            $this->updateMinutesCount($count);
            return;
        } elseif($type == 'Gold'){
            $this->updateGoldCoins($count, $action);
            return;
        }elseif($type == 'Silver'){
            $this->updateSilverCoins($count, $action, $user_id);
            return;
        }
    }

    public function updateSuperLikes($user_id){
        auth()->user()->available_super_likes = auth()->user()->available_super_likes - 1;
        auth()->user()->save();

        return;
    }

    public function updateFavorites(){
        auth()->user()->available_favorite = auth()->user()->available_favorite - 1;
        auth()->user()->save();
        return;
    }

    public function updatePhotoCount(){
        auth()->user()->available_photo_count = auth()->user()->available_photo_count - 1;
        auth()->user()->save();
        return;
    }

    public function updateVideoCount(){
        auth()->user()->available_video_count = auth()->user()->available_video_count - 1;
        auth()->user()->save();
        return;
    }

    public function updateMinutesCount($count){
        auth()->user()->available_call_min = auth()->user()->available_call_min - $count;
        auth()->user()->save();
        return;
    }

    public function updateGoldCoins($quantity, $action){
        if($action == 'Add'){
            auth()->user()->gold_coin = auth()->user()->gold_coin + $quantity;
        }else{
            auth()->user()->gold_coin = auth()->user()->gold_coin - $quantity;
        }
        auth()->user()->save();
        return;
    }

    public function updateSilverCoins($quantity, $action, $user_id){

        $user = User::find($user_id);

        if($action == 'Add'){
            $user->silver_coin = $user->silver_coin + $quantity;
        }elseif($action == 'Sub'){
            $user->silver_coin = $user->silver_coin - $quantity;
        }
        $user->save();
        return;
    }

    public function checkEarningLimitPerUser($earned_From, $earned_by ,$coins){

        $perUserEarningLimit = AppSetting::where('shortcode', 'PUEL')->first()->value2;

        if($coins > $perUserEarningLimit){
            $coins = $perUserEarningLimit;
            $past30DaysEarned = $this->getPast30DaysEarning($coins, $earned_From, $earned_by);
            $remaining = $perUserEarningLimit - $past30DaysEarned;
            $earnable = $remaining;

        }else{
            $past30DaysEarned = $this->getPast30DaysEarning($coins, $earned_From, $earned_by);
            $remaining = (int)$perUserEarningLimit - (int)$past30DaysEarned;
            $earnable = $remaining;
        }
        return $earnable;
    }

    public function getPast30DaysEarning($coins, $earned_From, $earned_by){
        $date = Carbon::now()->subDays(30);

        $past30DaysEarned = InAppTransaction::where('created_at', '>=',  $date)
        ->where('coin', 'Silver')
        ->where('type', 'CREDIT')
        ->where('earned_from', $earned_From)
        ->where('user_id', $earned_by)
        ->sum('amount');

        return $past30DaysEarned;
    }
}
