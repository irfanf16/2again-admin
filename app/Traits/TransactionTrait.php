<?php

namespace App\Traits;

use App\Models\InAppTransaction;
use Illuminate\Http\Request;

trait TransactionTrait
{
    public function createTransaction($user_id, $source, $type, $coin, $amount, $earned_from = null){

        InAppTransaction::create([
            'user_id'       =>  $user_id,
            'earned_from'   =>  $earned_from,
            'source'        => $source,
            'type'          =>  $type,
            'coin'          =>  $coin,
            'amount'        =>  $amount
        ]);
    }

}
