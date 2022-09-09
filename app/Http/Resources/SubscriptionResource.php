<?php

namespace App\Http\Resources;

use App\Models\Purchase;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Traits\GetUserSubscriptionTrait;

class SubscriptionResource extends JsonResource
{
    use GetUserSubscriptionTrait;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $purchase = Purchase::where(['user_id' => auth()->id(), 'item_purchased' => 'VIP'])
        ->orwhere(function ($query){
            $query->where(['user_id' => auth()->id(), 'item_purchased' => 'Big Spender']);
        })
        ->latest()->first();

        return [
            'name'              =>  $this->name,
            'badge'             =>  $this->badge,
            'validity'          =>  $this->pivot->valid_till_appstore,
            'package_id'        =>  $this->pivot->package_id,
            'shortcode'         =>  $this->shortcode,
            'price'             =>  $purchase->spend_amount ?? null,
            'is_downgraded'     =>  $this->pivot->is_downgraded,
            'currency'          =>  $purchase->currency ?? null,
            'downgraded_price'  =>  $this->pivot->downgraded_price
        ];
    }
}
