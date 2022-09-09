<?php

namespace App\Repositories\OfferRepository;

use App\Models\Offer;
use App\Repositories\OfferRepository\iOfferRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\SpendEarnTrait;

class OfferRepository implements iOfferRepository{

    use SpendEarnTrait;

    public function getOffers()
    {

        $purchasedOffer = auth()->user()->offers()->pluck('offer_id')->toArray();


        return Offer::where('start_date', '<=', Carbon::now())
        ->where('valid_till', '>=', Carbon::now())
        ->whereNotIn('id', $purchasedOffer)
        ->get();
    }

    public function offerDetail(Request $request)
    {
        $request->validate([
            'offer_id'  =>  'exists:offers,id'
        ]);

        return Offer::with('consumables')->find($request->offer_id);
    }

    public function buy(Request $request){
        $request->validate([
            'offer_id'      =>  'required|exists:offers,id'
        ]);

        $is_already_purchased =   auth()->user()->offers()->where('offer_id', $request->offer_id)->exists();
        if($is_already_purchased){
            return 2;
        }

        $offer = Offer::with('consumables')->find($request->offer_id);

        $packageDate = Carbon::parse($offer->valid_till);
        $is_expired =  Carbon::now()->gt($packageDate);

        if($is_expired){
            return 0;
        }

        $this->checkAvailability('Gold', $offer->cost);

        $consumableArray = [];

        foreach($offer->consumables as $consumable){
            if($consumable->name == 'Like'){
                auth()->user()->available_likes = $consumableArray[$consumable->name] =   auth()->user()->available_likes + $consumable->pivot->quantity;
            }elseif($consumable->name == 'SuperLike'){
                auth()->user()->available_super_likes = $consumableArray[$consumable->name] =  auth()->user()->available_super_likes + $consumable->pivot->quantity;
            }elseif($consumable->name == 'Favorite'){
                auth()->user()->available_favorite = $consumableArray[$consumable->name] =  auth()->user()->available_favorite + $consumable->pivot->quantity;
            }elseif($consumable->name == 'Photo'){
                auth()->user()->available_photo_count = $consumableArray[$consumable->name] =  auth()->user()->available_photo_count + $consumable->pivot->quantity;
            }elseif($consumable->name == 'Video'){
                auth()->user()->available_video_count = $consumableArray[$consumable->name] =  auth()->user()->available_video_count + $consumable->pivot->quantity;
            }elseif($consumable->name == 'Call'){
                auth()->user()->available_call_min =  auth()->user()->available_call_min + ($consumable->pivot->quantity * 60);
                $consumableArray[$consumable->name] = $consumable->pivot->quantity;
            }
        }

        $this->updateUserAssets('Gold', $offer->cost , 'Sub', auth()->user()->id);
        if($offer->cost > 0){
            $this->createTransaction(auth()->user()->id, 'buy_offer', 'DEBIT', 'Gold', $offer->cost);
        }

        auth()->user()->offers()->create([
            'offer_id'  =>  $request->offer_id
        ]);

        $consumableArray['gold_coin'] = auth()->user()->gold_coin;
        return $consumableArray;

    }
}
