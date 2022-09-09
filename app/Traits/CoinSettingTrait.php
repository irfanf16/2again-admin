<?php

namespace App\Traits;

use App\Models\CoinSetting;
use Illuminate\Http\Request;

trait CoinSettingTrait
{
    public function getCoinSetting($item){
        return CoinSetting::where('item', $item)->first();
    }

    public function allSettings(){
        return CoinSetting::all();
    }
}
