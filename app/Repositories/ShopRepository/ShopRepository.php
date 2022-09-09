<?php

namespace App\Repositories\ShopRepository;

use App\Models\AppSetting;
use App\Models\Purchase;
use App\Models\User;
use App\Repositories\ShopRepository\iShopRepository;
use App\Models\Shop;
use App\Models\Subscription;
use App\Traits\BuyItemTrait;
use App\Traits\GetTierTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Traits\PurchasesTrait;
use Illuminate\Support\Facades\DB;
use App\Traits\SpendEarnTrait;
use App\Traits\TimeZoneToUTC;
use App\Traits\GetUserSubscriptionTrait;
use Illuminate\Support\Facades\Storage;


class   ShopRepository implements iShopRepository
{

    use SpendEarnTrait, BuyItemTrait, GetTierTrait, PurchasesTrait, TimeZoneToUTC, GetUserSubscriptionTrait;

    public function buy($tier_id)
    {

        $shopItem = Shop::find($tier_id);

        $this->checkAvailability('Gold', $shopItem->price);

        $valid_till = $this->buyItem($shopItem);

        $this->createTransaction(auth()->user()->id, 'buy_' .  strtolower($shopItem->type) . '-' . $shopItem->quantity, 'DEBIT', 'Gold', $shopItem->price);

        if ($shopItem->type == 'Boost') {
            return [
                'quantity' => null,
                'boost' => $valid_till
            ];
        } else if ($shopItem->type == 'Call') {
            return [
                'quantity' => (int) ($valid_till / 60),
                'boost' => null
            ];
        }
        return [
            'quantity' => $shopItem->quantity,
            'boost' => null
        ];
    }

    public function getTierList($item)
    {
        return $this->getTiers($item);
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'package_id'                => 'exists:shops,package_id|required',
            'package_name'              =>  'required_without:original_transaction_id',
            'purchase_token'            =>  'required_without:original_transaction_id',
            'original_transaction_id'   =>  'required_without:purchase_token',
            'expiry'                    =>  'required_without:purchase_token',
            'currency'                  =>  'required_without:purchase_token',
            'price'                     =>  'required_without:purchase_token',
            'device'                    =>  'required'
        ]);

        if ($request->device != 'ANDROID' && $request->device != 'IOS' && $request->device != 'Web') {
            return 0;
        }

        // DB::beginTransaction();
        // try {

            if ($request->device == 'ANDROID') {
                $benifits =  $this->addAndroidSubscription($request->all());
            }elseif($request->device == 'IOS'){
                $benifits =  $this->addIosSubscription($request->all());
            }

            auth()->user()->subscription_availed()->updateOrCreate([
                'id'            =>  auth()->id(),
                'package_id'    =>  $request->package_id,
            ],[
                'id'            =>  auth()->id(),
                'package_id'    =>  $request->package_id,
                'is_availed'    =>  1
            ]);
            //DB::commit();
            return $benifits;
        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     responseNow(0, 'Server error', 'Something went wrong. Please try again later');
        // }
    }

    public function addAndroidSubscription(array $attributes)
    {


        $item = Shop::where('package_id', $attributes['package_id'])->first();

        $package = Subscription::where('shortcode', $item->type)->first();


        $subscription = auth()->user()->subscription()->where('shortcode', '!=', 'GAM')
            ->latest()->first();
        if($subscription){
            auth()->user()->subscription()->detach($subscription->id);
        }

        $oauth_credentials = Storage::path('google_service_account.json');
        $client = new \Google\Client();
        $client->setAuthConfig($oauth_credentials);
        $client->addScope("https://www.googleapis.com/auth/androidpublisher");

        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithAssertion();
        }

        if ($client->getAccessToken()) {
            $service = new \Google\Service\AndroidPublisher($client);
            $results = $service->purchases_subscriptions->get($attributes['package_name'], $attributes['package_id'], $attributes['purchase_token'], []);

            // $countryCode = $results->countryCode;
            $expiryTimeMili = $results->expiryTimeMillis;
            $orderId = $results->orderId;
            $priceAmountMicros = $results->priceAmountMicros;
            $priceCurrencyCode = $results->priceCurrencyCode;
            $startTimeMillis = $results->startTimeMillis;
            $ActualPrice =  $priceAmountMicros * 0.000010;
            // $startTimeUTC =  date("d-m-Y H:i:s", ($startTimeMillis / 1000) );
            $expiryTimeUTC = date("d-m-Y H:i:s", ($expiryTimeMili / 1000));

            $expiryTimeLocal = $this->TimeZoneToLocal($expiryTimeUTC, auth()->user()->time_zone);

            auth()->user()->subscription()->attach($package->id, ['valid_till' => $expiryTimeUTC, 'android_order_id' => $orderId, 'is_downgraded' => null, 'valid_till_appstore' => $expiryTimeLocal, 'package_id' => $attributes['package_id']]);


            $subscriptionGAM = auth()->user()->subscription()->where('shortcode', 'GAM')
            ->latest()->first();

            auth()->user()->subscription()->updateExistingPivot($subscriptionGAM->id, ['valid_till' => $expiryTimeUTC]);


            $benifits = $this->getBenifits($attributes['package_id']);
            // $this->createPurchase(auth()->user()->id, 'In-App', $package->name, $item->quantity, $ActualPrice, $priceCurrencyCode);

            return $benifits;
        }

    }

    public function addIosSubscription(array $attributes){

        $item = Shop::where('package_id', $attributes['package_id'])->first();

        $package = Subscription::where('shortcode', $item->type)->first();

        $subscription = auth()->user()->subscription()->where('shortcode', '!=', 'GAM')
            ->latest()->first();
        if($subscription){
            auth()->user()->subscription()->detach($subscription->id);
        }


        $expiryTimeUTC = $this->TimeZoneToUTC($attributes['expiry'], auth()->user()->time_zone);

        auth()->user()->subscription()->attach($package->id, ['valid_till' => $expiryTimeUTC, 'ios_original_transaction_id' => $attributes['original_transaction_id'], 'is_downgraded' => null, 'valid_till_appstore' => $attributes['expiry'], 'package_id' => $attributes['package_id']]);

        $subscriptionGAM = auth()->user()->subscription()->where('shortcode', 'GAM')
        ->latest()->first();

        auth()->user()->subscription()->updateExistingPivot($subscriptionGAM->id, ['valid_till' => $expiryTimeUTC]);

        $benifits = $this->getBenifits($attributes['package_id']);

        // $this->createPurchase(auth()->user()->id, 'In-App', $package->name, $item->quantity, $attributes['price'], $attributes['currency']);

        return $benifits;

    }

    public function assignBadge(Request $request)
    {

        if ($request->type != 'VIP' && $request->type != 'BS' && $request->type != 'CUSTOM') {
            return false;
        }
        DB::beginTransaction();
        try {
            $user = User::withTrashed()->find($request->userId);
            if ($request->type == 'VIP' || $request->type == 'BS') {
                $item = Shop::where(['type' => $request->type, 'quantity' => $request->quantity])->first();
                $quantity = $item->quantity * 7;
                $package = Subscription::where('shortcode', $request->type)->first();
                $subscription = $user->subscription()->where('shortcode', '!=', 'GAM')->where('shortcode', '!=', 'CUSTOM')
                    ->latest()->first();

                if ($subscription) {
                    $packageDate = Carbon::parse($subscription->pivot->valid_till);
                    $is_expired = Carbon::now()->gt($packageDate);

                    if (!$is_expired) {
                        $newPackageDate = $packageDate->addDays($quantity);
                        $user->subscription()->updateExistingPivot($subscription->id, ['valid_till' => $newPackageDate, 'subscription_id' => $package->id, 'start_date' => $request->start_date]);
                    } else {
                        $valid_till = Carbon::parse($request->start_date);
                        $valid_till = $valid_till->addDays($quantity);
                        $user->subscription()->updateExistingPivot($subscription->id, ['valid_till' => $valid_till, 'subscription_id' => $package->id, 'start_date' => $request->start_date]);
                    }
                } else {
                    $valid_till = Carbon::parse($request->start_date);
                    $valid_till = $valid_till->addDays($quantity);
                    $user->subscription()->attach($package->id, ['valid_till' => $valid_till, 'start_date' => $request->start_date]);
                }
                if ($request->type == 'VIP' || $request->type == 'BS') {
                    $packageItems = AppSetting::where('shortcode', $item->package_id)->get();
                    foreach ($packageItems as $item) {
                        if ($item->value1 == 'gold_coin') {
                            $user->gold_coin = $sum = $user->gold_coin + $item->value2;
                        } elseif ($item->value1 == 'daily_like') {
                            $user->available_likes = $sum = $user->available_likes + $item->value2;
                        } elseif ($item->value1 == 'super_like') {
                            $user->available_super_likes = $sum = $user->available_super_likes + $item->value2;
                        } elseif ($item->value1 == 'favorite') {
                            $user->available_favorite = $sum = $user->available_favorite + $item->value2;
                        }
                    }
                    $user->save();
                }
            } else {
                $package = Subscription::where('shortcode', $request->type)->first();
                $subscription = $user->subscription()->where('shortcode', '=', 'CUSTOM')
                    ->latest()->first();

                if ($subscription) {
                    $user->subscription()->updateExistingPivot($subscription->id, ['valid_till' => $request->valid_till, 'subscription_id' => $package->id, 'start_date' => $request->start_date]);
                } else {
                    $user->subscription()->attach($package->id, ['valid_till' => $request->valid_till, 'start_date' => $request->start_date]);
                }
            }
            DB::commit();
            return 1;
        } catch (\Exception $e) {
            DB::rollBack();
            responseNow(0, 'Server error', 'Something went wrong. Please try again later');
        }
    }

    public function buyGold(Request $request)
    {
        $request->validate([
            'package_id' => 'exists:shops,package_id',
            'price' => 'required',
            'currency' => 'required'
        ]);

        DB::beginTransaction();
        try {

            $item = Shop::where('package_id', $request->package_id)->first();

            if ($item->type != 'Gold') {
                responseNow(0, 'Invalid Package', 'Invalid Package id');
            }

            $this->updateGoldCoins($item->quantity, 'Add');

            $this->createPurchase(auth()->user()->id, 'In-App', 'Gold Coins', $item->quantity, $request->price, $request->currency);

            $this->createTransaction(auth()->user()->id, 'purchased', 'CREDIT', 'Gold', $item->quantity);

            DB::commit();

            return 1;
        } catch (\Exception $e) {
            DB::rollBack();
            responseNow(0, 'Server error', 'Something went wrong. Please try again later');
        }
    }

    public function purchaseHistory()
    {
        return $this->getPurchase();
    }

    public function getBenifits($package)
    {
        $packageItems = AppSetting::where('shortcode', $package)->get();
        $assetsArray = [];

        foreach ($packageItems as $item) {
            if ($item->value1 == 'gold_coin') {
                auth()->user()->gold_coin = $sum = auth()->user()->gold_coin + $item->value2;
                $this->createTransaction(auth()->id(), 'subscription_purchase', 'CREDIT', 'Gold', $item->value2);
                $assetsArray['gold_coin'] = $sum;
            } elseif ($item->value1 == 'daily_like') {
                // auth()->user()->available_likes = $sum = auth()->user()->available_likes + $item->value2;
                $assetsArray['daily_like'] = auth()->user()->available_likes + $item->value2;
            } elseif ($item->value1 == 'super_like') {
                auth()->user()->available_super_likes = $sum = auth()->user()->available_super_likes + $item->value2;
                $assetsArray['super_like'] = $sum;
            } elseif ($item->value1 == 'favorite') {
                auth()->user()->available_favorite = $sum = auth()->user()->available_favorite + $item->value2;
                $assetsArray['favorite'] = $sum;
            }
        }

        auth()->user()->save();

        return $assetsArray;
    }

    public function goldCoinsQuantity()
    {
        $item['quantity'] = Shop::where('type', 'Gold')->select('quantity', 'package_id')->orderBy('quantity', 'asc')->get();
        return $item;
    }

    public function downgradeSubscription($package_id, $price)
    {

        $subscription = $this->getSubscription(auth()->id());

        if ($subscription->shortcode == 'GAM') {
            return 0;
        } else {

            auth()->user()->subscription()->updateExistingPivot($subscription->id, ['is_downgraded' => $package_id, 'downgraded_price' => $price]);

            return 1;
        }
    }
}
