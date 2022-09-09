<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Traits\checkAvailabilityTrait;
use App\Traits\UpdateUserAssetsTrait;
use App\Traits\CoinSettingTrait;
use App\Traits\TransactionTrait;

trait SpendEarnTrait
{
    use checkAvailabilityTrait, UpdateUserAssetsTrait, CoinSettingTrait, TransactionTrait;

}
