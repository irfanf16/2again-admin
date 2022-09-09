<?php

namespace App\Observers;

use App\Jobs\UserNotificationJob;
use App\Models\AppSetting;
use App\Models\ReferralLink;
use App\Models\user;
use Twilio\Rest\Client;
use GuzzleHttp\Client as GuzzleClient;
use App\Traits\UpdateUserAssetsTrait;
use App\Traits\checkSubscriptionTrait;
use App\Traits\NotificationTrait;
class UserObserver
{
    use UpdateUserAssetsTrait, checkSubscriptionTrait, NotificationTrait;
    /**
     * Handle the user "created" event.
     *
     * @param  \App\Models\user  $user
     * @return void
     */
   public function created(user $user)
   {
      if ($user->email != null) {
          dispatch(new UserNotificationJob($user));
      } elseif ($user->phone != null) {
          try {
              $message = 'You 2Again OTP code is ' . $user->otp;
              $account_sid = getenv("TWILIO_ACCOUNT_SID");
              $auth_token = getenv("TWILIO_AUTH_TOKEN");
              $twilio_number = getenv("TWILIO_PHONE_NUMBER");
              $client = new Client($account_sid, $auth_token);

              $client->messages->create(
                  $user->phone,
                  [
                      'from' => $twilio_number,
                      'body' => $message
                  ]
              );
          } catch (\Exception $e) {
              responseNow(0, 'null', 'Invalid Phone number');
          }
      }

      $user->update([
          'gold_ref_code'     => mt_rand(100000, 999999),
          'silver_ref_code'   =>  mt_rand(100000, 999999)
      ]);


      $gold_link = $this->getDynamicLink('g_'.$user->gold_ref_code);
      $silver_link = $this->getDynamicLink('s_'.$user->silver_ref_code);

      $user->referral_link()->saveMany([
          new ReferralLink(['user_id' => auth()->id(), 'link_type' => 'Gold', 'link' => $gold_link]),
          new ReferralLink(['user_id' => auth()->id(), 'link_type' => 'Silver', 'link' => $silver_link]),
      ]);
   }

    /**
     * Handle the user "updated" event.
     *
     * @param  \App\Models\user  $user
     * @return void
     */
    public function updated(user $user)
    {
        if($user->ref_used != null){

        }
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\Models\user  $user
     * @return void
     */
    public function deleted(user $user)
    {
        //
    }

    /**
     * Handle the user "restored" event.
     *
     * @param  \App\Models\user  $user
     * @return void
     */
    public function restored(user $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param  \App\Models\user  $user
     * @return void
     */
    public function forceDeleted(user $user)
    {
        //
    }

    /**
     * Listen to the User updating event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function updating(User $user)
    {
      if($user->isDirty('ref_used') && $user->ref_used != null){
        // ref_used has changed
        if($user->social_id != null){
            $condition = ['social_id' => $user->social_id];
        }elseif($user->email != null){
            $condition = ['email' => $user->email];
        }elseif($user->phone != null){
            $condition = ['phone' => $user->phone];
        }

        $isAlreadyUsed = User::withTrashed()->where($condition)->where('ref_used', '!=', null)->first();

        if(!$isAlreadyUsed){
            $this->giveReward($user);
        }else{
            $user->ref_used = null;
        }

      }

    }


    public function getDynamicLink($code){
        $gold_link = 'https://www.2again.com/data?'.$code;

        $api_key = env('FIREBASE_API_KEY');

        $domain = env('FIREBASE_DYNAMIC_LINKS_DOMAIN');
        $json = '{
            "dynamicLinkInfo": {
                "domainUriPrefix": "'.$domain.'",
                "link": "'.$gold_link.'",
                "androidInfo": {
                    "androidPackageName": "com.two.again.android",
                    "androidFallbackLink": "https://play.google.com/store/apps/details?id=com.two.again.android"
                },
                "iosInfo": {
                    "iosBundleId": "com.2againAps",
                    "iosFallbackLink": "https://apps.apple.com/us/app/2again/id1609571166",
                    "iosIpadFallbackLink": "https://apps.apple.com/us/app/2again/id1609571166",
                    "iosIpadBundleId": "com.2againAps",
                    "iosAppStoreId": "1609571166"
                },
                "navigationInfo": {
                    "enableForcedRedirect": "1"
                }
            },
            "suffix": {
                "option": "UNGUESSABLE"
            }
        }';

        $client = new GuzzleClient([
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $response = $client->post("https://firebasedynamiclinks.googleapis.com/v1/shortLinks?key=$api_key",
            ['body' => $json]
        );


         $response = $response->getBody();
        $response = json_decode($response);

        return $response->shortLink;
    }



    public function giveReward($user)
    {
        $otherUser =  $this->getReferralUser($user);
        if ($otherUser) {
            $earnGoldCoinLimit = AppSetting::where(['shortcode' => 'EGC', 'value1' => 'invite_friend'])->first()->value2;
            auth()->user()->gold_coin = auth()->user()->gold_coin + $earnGoldCoinLimit;

            $this->createTransaction(auth()->id(), 'referral_link', 'CREDIT', 'Gold', $earnGoldCoinLimit);

            return 1;
        } else {
            return null;
        }
    }

    public function getReferralUser($userBeingRegistered)
    {
        $code = $userBeingRegistered->ref_used;
        $codeArray = explode('_', $code);
        if ($codeArray[0] == 'g') {
            $earnGoldCoinLimit = AppSetting::where(['shortcode' => 'EGC', 'value1' => 'invite_friend'])->first()->value2;
            if (auth()->user()->gold_ref_code != $codeArray[1]) {

                $user = User::where('gold_ref_code', $codeArray[1])->first();

                if ($user) {
                    $user->gold_coin = $user->gold_coin + $earnGoldCoinLimit;
                    $user->save();
                    $this->createTransaction($user->id, 'By: '.$userBeingRegistered->name . $userBeingRegistered->lastname, 'CREDIT', 'Gold', $earnGoldCoinLimit);
                    return 1;
                }
            }
            return null;
        } elseif ($codeArray[0] == 's') {
                if(auth()->user()->silver_ref_code != $codeArray[1]){
                $user = User::where('silver_ref_code', $codeArray[1])->first();
                if ($user) {
                    if($this->checkOtherUserSubscription(['VIP', 'BS'], $user->id)){
                        $earnGoldCoinLimit = AppSetting::where(['shortcode' => 'ESC', 'value1' => 'invite_friend'])->first()->value2;
                        $earnable = $this->checkEarningLimitPerUser(auth()->id(),$user->id, $earnGoldCoinLimit);
                        if($earnable > 0){
                            if($earnable >= $earnGoldCoinLimit){
                                $earnable = $earnGoldCoinLimit;
                            }
                            $user->silver_coin = $user->silver_coin + $earnable;
                            $this->createTransaction($user->id, 'By: '.$userBeingRegistered->name . $userBeingRegistered->lastname, 'CREDIT', 'Silver', $earnable, auth()->id());
                            $this->sendNotification($user->id, 'EARN_COUNTER');
                        }
                    }else{
                        $earnGoldCoinLimit = AppSetting::where(['shortcode' => 'EGC', 'value1' => 'invite_friend_business_affiliate'])->first()->value2;
                        $user->gold_coin = $user->gold_coin + $earnGoldCoinLimit;
                        $this->createTransaction($user->id, 'By: '.$userBeingRegistered->name . $userBeingRegistered->lastname, 'CREDIT', 'Gold', $earnGoldCoinLimit);
                    }

                    $user->save();
                    return 1;
                }
            }
            return null;
        } else {
            return null;
        }
    }

}
