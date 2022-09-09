<?php

namespace App\Repositories\AppSettingRepository;

use App\Models\AppSetting;
use App\Repositories\AppSettingRepository\iAppSettingRepository;
use App\Traits\WithdrawTrait;

class AppSettingRepository implements iAppSettingRepository {

    use WithdrawTrait;

    public function convertCoins(){
        $settings = AppSetting::where('shortcode', 'STU')->first();
        $coins = auth()->user()->silver_coin;
        $usd = $coins * $settings->value2;

        $minWithdrawLimit = AppSetting::where('shortcode', 'MWL')->first();

        if($usd < $minWithdrawLimit->value1){
            $withdrawable = 0;
            $reason = 'minimum_withdraw_limit_is';
        }else{
            $withdrawable = 1;
            $reason=null;
        }

        return [
            'coins' =>  $coins,
            'usd'   =>  $usd,
            'withdrawable' => $withdrawable,
            'limit'         =>  $minWithdrawLimit->value1,
            'withdrawals'   =>  $this->getWithdrawals(['user_id'    => auth()->user()->id])
        ];
    }

}
