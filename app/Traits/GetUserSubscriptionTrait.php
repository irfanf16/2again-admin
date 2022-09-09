<?php

namespace App\Traits;

use App\Models\Purchase;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

trait GetUserSubscriptionTrait
{

    public function getSubscription($user_id){

        $user = User::withTrashed()->with('subscription')->findOrFail($user_id);
        $subsctiptions = $user->subscription;
        $subscription = '';

        if(count($subsctiptions) > 1){
            foreach($subsctiptions as $sub){
                if($sub->shortcode == 'BS'){
                    // $packageDate = Carbon::createFromFormat('Y-m-d H:i:s', $sub->pivot->valid_till, 'UTC')
                    // ->setTimezone('UTC');
                    $packageDate = Carbon::parse($sub->pivot->valid_till);
                    $is_expired =  Carbon::now()->gt($packageDate);

                    if(!$is_expired){
                        $subscription = $sub;
                        break;
                    }
                }elseif($sub->shortcode == 'VIP'){

                    // $packageDate = Carbon::createFromFormat('Y-m-d H:i:s', $sub->pivot->valid_till, 'UTC')
                    // ->setTimezone('UTC');
                    $packageDate = Carbon::parse($sub->pivot->valid_till);
                    $is_expired =  Carbon::now()->gt($packageDate);

                    if(!$is_expired){
                        $subscription = $sub;
                        break;
                    }
                }else{
                    if($sub->shortcode != 'CUSTOM'){
                        $subscription = $sub;
                    }
                }
            }
        }else{
            if(isset($subsctiptions[0])){
                $subscription = $subsctiptions[0];
            }else{
               return null;
            }

        }

        return $subscription;

    }
    public function getUserSecondBadge($user){
        $user = User::with(['subscription' => function($query){
            $query->where('shortcode', '=', 'CUSTOM');
        }])->find($user->id);

        $subsctiptions = $user->subscription ?? null;
        $badge = '';

        if(isset($subsctiptions[0])){
            $subscription = $subsctiptions[0];

            $packageDate = Carbon::parse($subscription->pivot->valid_till);
            $startDate = Carbon::parse($subscription->pivot->start_date);

            $is_started = Carbon::now()->gt($subscription->pivot->start_date);
//            dd($is_started);
            if(!$is_started){
                $badge = null;
                return;
            }

            $is_expired =  Carbon::now()->gt($packageDate);

            if(!$is_expired){
                $badge = $subscription;
            }else{
                $badge = null;
            }
        }else{
            $badge = null;
        }
        return $badge;

    }

}
