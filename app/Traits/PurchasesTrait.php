<?php

namespace App\Traits;

use App\Models\Purchase;
use Illuminate\Http\Request;

trait PurchasesTrait
{
    public function createPurchase($user_id, $purchase_type, $item_purchased, $quantity, $amount, $currency){

        Purchase::create([
            'user_id'           =>  $user_id,
            'purchase_type'     => $purchase_type,
            'item_purchased'    =>  $item_purchased,
            'quantity'          =>  $quantity,
            'spend_amount'      =>  $amount,
            'currency'          =>  $currency
        ]);
    }

    public function getPurchase(){
        return Purchase::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->paginate(15);
    }

}
