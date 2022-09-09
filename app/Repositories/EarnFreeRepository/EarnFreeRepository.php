<?php

namespace App\Repositories\EarnFreeRepository;

use App\Models\AppSetting;
use App\Models\CrowdfundingVoucher;
use App\Models\OtherApp;
use App\Models\Shop;
use App\Models\User;
use App\Repositories\EarnFreeRepository\iEarnFreeRepository;
use Illuminate\Http\Request;
use App\Traits\UpdateUserAssetsTrait;
use App\Traits\checkSubscriptionTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\Subscription;
use App\Traits\TimeZoneToUTC;

class EarnFreeRepository implements iEarnFreeRepository
{

    use UpdateUserAssetsTrait, checkSubscriptionTrait, TimeZoneToUTC;

    public function getOtherApp(Request $request)
    {
        $request->validate([
            'country_id'    =>  'required|integer|exists:countries,id'
        ]);

        $countryApps =  OtherApp::with(['user' => function ($query) {
            $query->select('users.id')->where('users.id', auth()->user()->id);
        }])
        ->where('is_active', 1)
        ->whereHas('country', function ($query) use ($request) {
            $query->where('country_id', $request->country_id);
        })

        ->get();

        $countryApps = $countryApps->toArray();


        $worldWideApps =  OtherApp::with(['user' => function ($query) {
            $query->select('users.id')->where('users.id', auth()->user()->id);
        }])->where('all_over_world', 1)
        ->where('is_active', 1)
        ->get();

        $worldWideApps = $worldWideApps->toArray();

        $apps = array_merge($countryApps, $worldWideApps);

        return $apps;
    }

    public function getReward(Request $request)
    {
        $request->validate([
            'bundle_id_android' => 'required_without:bundle_id_ios|exists:other_apps,bundle_id_android',
            'bundle_id_ios'     =>  'required_without:bundle_id_android|exists:other_apps,bundle_id_ios'
        ]);


        if ($request->has('bundle_id_android')) {
            $app = OtherApp::with(['user' => function ($query) {
                $query->where('users.id', auth()->user()->id);
            }])->where('bundle_id_android', $request->bundle_id_android)->first();
        } else {
            $app = OtherApp::with(['user' => function ($query) {
                $query->where('users.id', auth()->user()->id);
            }])->where('bundle_id_ios', $request->bundle_id_ios)->first();
        }

        if ($app->user->isEmpty()) {
            $appDownloadReward = AppSetting::where('shortcode', 'EGC')->where('value1', 'download_other_app')->first()->value2;
            $app->user()->attach(auth()->id());
            $this->updateUserAssets('Gold', $appDownloadReward, 'Add', auth()->user()->id);
            return $appDownloadReward;
        } else {
            return 0;
        }
    }

    public function giveReward($voucherCode){
         $shopItem = Shop::where('type', $voucherCode->subscription_type)->where('quantity', $voucherCode->subscription_month)->first();
         $quantity = $shopItem->quantity * 5;
         if ($shopItem->type != 'VIP' && $shopItem->type != 'BS') {
             responseNow(0, 'Invalid Package', 'Invalid Package id');
         }

         DB::beginTransaction();
         try {
             $package = Subscription::where('shortcode', $shopItem->type)->first();

             $subscription = auth()->user()->subscription()->where('shortcode', '!=', 'GAM')
                 ->latest()->first();

             if ($subscription) {
                 $packageDate = Carbon::parse($subscription->pivot->valid_till);
                 $is_expired =  Carbon::now()->gt($packageDate);

                 if (!$is_expired) {
                     $newPackageDate = $packageDate->addDays($quantity);
                     $newStartDate =  Carbon::now();
                     auth()->user()->subscription()->updateExistingPivot($subscription->id, ['valid_till' => $newPackageDate, 'package_id' => $shopItem->package_id, 'start_date' => $newStartDate, 'subscription_id' => $package->id]);
                 } else {
                     $valid_till = Carbon::now()->addDays( $quantity);
                     $newStartDate = Carbon::now();
                     auth()->user()->subscription()->updateExistingPivot($subscription->id, ['valid_till' => $valid_till, 'package_id' => $shopItem->package_id, 'start_date' => $newStartDate, 'subscription_id' => $package->id]);
                 }
             } else {
                 $valid_till = Carbon::now()->addMinutes($quantity);
                 $startDate = Carbon::now();
                 $valid_till_appstore = $this->TimeZoneToLocal($valid_till, auth()->user()->time_zone);
                 auth()->user()->subscription()->attach($package->id, ['valid_till' => $valid_till, 'package_id' => $shopItem->package_id, 'valid_till_appstore' => $valid_till_appstore, 'start_date' => $startDate]);
             }

             auth()->user()->crowdfunding_ref_used = $voucherCode->voucher_code;

             $benifits = $this->getBenifits($shopItem->package_id, auth()->user());

             DB::commit();
             return $benifits;
         } catch (\Exception $e) {
             DB::rollBack();
             responseNow(0, 'Server error', 'Something went wrong. Please try again later');
         }

    }

    public function getBenifits($package,$user){
        $packageItems  =   AppSetting::where('shortcode' , $package)->get();
          $assetsArray = [];

          foreach($packageItems as $item){
              if($item->value1 == 'gold_coin'){
                  $user->gold_coin = $sum =  $user->gold_coin + $item->value2;
                  $assetsArray['gold_coin'] = $sum;
              }elseif($item->value1 == 'daily_like'){
                  $user->available_likes = $sum =  $user->available_likes + $item->value2;
                  $assetsArray['daily_like'] = $sum;
              }elseif($item->value1 == 'super_like'){
                  $user->available_super_likes = $sum = $user->available_super_likes + $item->value2;
                  $assetsArray['super_like'] = $sum;
              }elseif($item->value1 == 'favorite'){
                  $user->available_favorite = $sum = $user->available_favorite + $item->value2;
                  $assetsArray['favorite'] = $sum;
              }
          }

          $user->save();

          return $assetsArray;
      }

}
