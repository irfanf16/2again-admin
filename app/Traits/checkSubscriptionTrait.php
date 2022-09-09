<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

trait checkSubscriptionTrait
{
    public function checkSubscription(array $subscriptions){
        $userSubscription = auth()->user()->subscription()->latest()->first();
        if(in_array($userSubscription->shortcode, $subscriptions)){
            if($userSubscription->shortcode != 'GAM'){

                $packageDate = Carbon::parse($userSubscription->pivot->valid_till);
                $is_expired =  Carbon::now()->gt($packageDate);

                if($is_expired){
                    return false;
                }
            }
            return true;
        }else{
            return false;
        }
    }

    public function checkOtherUserSubscription(array $subscriptions, $user_id){
        $user = User::find($user_id);

        $userSubscription = $user->subscription()->latest()->first();
        if(in_array($userSubscription->shortcode, $subscriptions)){
            if($userSubscription->shortcode != 'GAM'){

                $packageDate = Carbon::parse($userSubscription->pivot->valid_till);
                $is_expired =  Carbon::now()->gt($packageDate);

                if($is_expired){
                    return false;
                }
            }
            return true;
        }else{
            return false;
        }
    }

    public function getUserSubscription($user){
        $user = User::with(['subscription' => function($query){
            $query->where('shortcode', '!=', 'Custom');
        }])->find($user->id);

        $subsctiptions = $user->subscription;
        $badge = '';

        if(count($subsctiptions) > 1){

            foreach($subsctiptions as $sub){
                if($sub->shortcode == 'BS'){
                    $packageDate = Carbon::parse($sub->pivot->valid_till);
                    $is_expired =  Carbon::now()->gt($packageDate);
                    if(!$is_expired){
                        $badge = $sub->badge;
                        break;
                    }
                }elseif($sub->shortcode == 'VIP'){
                    $packageDate = Carbon::parse($sub->pivot->valid_till);
                    $is_expired =  Carbon::now()->gt($packageDate);

                    if(!$is_expired){
                        $badge = $sub->badge;
                        break;
                    }
                }else{
                    $badge = $sub->badge;
                }
            }
        }else{
            if(!isset($subsctiptions[0])){
                dd($user->id);
            }
            $badge = $subsctiptions[0]->badge;
        }

        return $badge;
    }

    public function getCompleteSubscription($user){
        $user = User::with(['subscription' => function($query){
            $query->where('shortcode', '!=', 'Custom');
        }])->find($user->id);

        $subsctiptions = $user->subscription;
        $badge = '';

        if(count($subsctiptions) > 1){

            foreach($subsctiptions as $sub){
                if($sub->shortcode == 'BS'){
                    $packageDate = Carbon::parse($sub->pivot->valid_till);
                    $is_expired =  Carbon::now()->gt($packageDate);
                    if(!$is_expired){
                        $badge = $sub;
                        break;
                    }
                }elseif($sub->shortcode == 'VIP'){
                    $packageDate = Carbon::parse($sub->pivot->valid_till);
                    $is_expired =  Carbon::now()->gt($packageDate);

                    if(!$is_expired){
                        $badge = $sub;
                        break;
                    }
                }else{
                    $badge = $sub;
                }
            }
        }else{
            if(!isset($subsctiptions[0])){
                dd($user->id);
            }
            $badge = $subsctiptions[0];
        }

        return $badge;
    }

    public function getSecondBadge($user){
        $user = User::with(['subscription' => function($query){
            $query->where('shortcode', '=', 'CUSTOM');
        }])->find($user->id);

        $subsctiptions = $user->subscription;
        $badge = '';

        if(isset($subsctiptions[0])){
            $subscription = $subsctiptions[0];
                $packageDate = Carbon::parse($subscription->pivot->valid_till);
                $startDate = Carbon::parse($subscription->pivot->start_date);

                $is_started = Carbon::now()->gt($startDate);
                if(!$is_started){
                    $badge = null;
                    return;
                }

                $is_expired =  Carbon::now()->gt($packageDate);

                if(!$is_expired){
                    $badge = $subscription->badge;
                }else{
                    $badge = null;
                }
        }else{
            $badge = null;
        }
        return $badge;

    }
}
