<?php

namespace App\Traits;

use App\Models\AppSetting;
use App\Models\Lang;
use App\Models\ResponseMessages;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Traits\checkSubscriptionTrait;

trait checkAvailabilityTrait
{

    use checkSubscriptionTrait;

    public function checkAvailability($type, $amount = null)
    {
        if ($type == 'Like') {
            $this->likeCheck();
        } elseif ($type == 'SuperLike') {
            $this->SuperLikeCheck();
        } elseif ($type == 'Favorite') {
            $this->FavoriteCheck();
        } elseif ($type == 'Photo') {
            $this->PhotoGalleryCountCheck();
        } elseif ($type == 'Video') {
            $this->videoGalleryCountCheck();
        } elseif ($type == 'Call') {
            $this->callMinCountCheck();
        }elseif($type == 'Gold'){
            $this->checkGoldCoins($amount);
        }elseif($type == 'Sliver'){
            $this->checkSilverCoins($amount);
        }else{

            responseNow(0, null, 'Invalid item type');
        }
    }

    public function likeCheck(){

        $lang = $this->getLanguageFromVailabilityTrait();
        $responseMessage = $this->getResponseMessageAvailabilityTrait('please_buy_more_likes', $lang);


            $todayLike = auth()->user()->sentLikePivot()->whereDate(
            'created_at' , Carbon::today())
            ->where('like_from', auth()->user()->id)
            ->where('like_type', '!=', 2)
            ->count();


            $userSubscription = $this->getCompleteSubscription(auth()->user());

            if($userSubscription->shortcode == 'GAM'){
                $likeLimit = AppSetting::where(['shortcode' => 'GAM', 'value1' => 'daily_like'])->first()->value2;
            }else {
                $likeLimit = AppSetting::where(['shortcode' => $userSubscription->pivot->package_id, 'value1' => 'daily_like'])->first()->value2;
            }

            if($todayLike >= $likeLimit){
                if (auth()->user()->available_likes  < 1) {
                    responseNow(2, 'Show Buy Like popup', $responseMessage[0]['key_translation']);
                }else{
                    auth()->user()->available_likes = auth()->user()->available_likes - 1;
                    auth()->user()->save();
                }
            }
            return;
    }

    public function SuperLikeCheck()
    {
        $lang = $this->getLanguageFromVailabilityTrait();
        $responseMessage = $this->getResponseMessageAvailabilityTrait('please_buy_more_superLikes', $lang);

        if (auth()->user()->available_super_likes == 0) {
            response()->json(['ResponseCode' => 2, 'ResponseMessage' => 'Show Buy SuperLike popup', 'error' => [$responseMessage[0]['key_translation']]], 400)->send();
            die;
        }
    }

    public function FavoriteCheck()
    {
        $lang = $this->getLanguageFromVailabilityTrait();
        $responseMessage = $this->getResponseMessageAvailabilityTrait('please_buy_more_favorites', $lang);

        if (auth()->user()->available_favorite == 0) {
            response()->json(['ResponseCode' => 2, 'ResponseMessage' => 'Show Buy Favorite popup', 'error' => [$responseMessage[0]['key_translation']]], 400)->send();
            die;
        }
    }

    public function PhotoGalleryCountCheck()
    {
        $lang = $this->getLanguageFromVailabilityTrait();
        $responseMessage = $this->getResponseMessageAvailabilityTrait('please_buy_more_photo_slots', $lang);

        if (auth()->user()->available_photo_count == 0) {
            response()->json(['ResponseCode' => 2, 'ResponseMessage' => 'Show Buy Photo popup', 'error' => [$responseMessage[0]['key_translation']]], 400)->send();
            die;
        }
    }

    public function videoGalleryCountCheck()
    {

        $lang = $this->getLanguageFromVailabilityTrait();
        $responseMessage = $this->getResponseMessageAvailabilityTrait('please_buy_more_video_slots', $lang);

        if (auth()->user()->available_video_count == 0) {
            response()->json(['ResponseCode' => 2, 'ResponseMessage' => 'Show Buy Video popup', 'error' => [$responseMessage[0]['key_translation']]], 400)->send();
            die;
        }
    }

    public function callMinCountCheck()
    {
        $lang = $this->getLanguageFromVailabilityTrait();
        $responseMessage = $this->getResponseMessageAvailabilityTrait('please_buy_more_call_minutes', $lang);

        if (auth()->user()->available_call_min == 0) {
            response()->json(['ResponseCode' => 2, 'ResponseMessage' => 'Show Buy Call Minutes popup', 'error' => [$responseMessage[0]['key_translation']]], 400)->send();
            die;
        }
    }

    public function checkGoldCoins($amount){

        $lang = $this->getLanguageFromVailabilityTrait();
        $responseMessage = $this->getResponseMessageAvailabilityTrait('you_do_not_have_enough_gold_coins', $lang);

        if (auth()->user()->gold_coin < $amount) {
            response()->json(['ResponseCode' => 2, 'ResponseMessage' => 'Insuficient gold coins..', 'error' => [$responseMessage[0]['key_translation']]], 400)->send();
            die;
        }
    }

    public function checkSilverCoins($amount){

        $lang = $this->getLanguageFromVailabilityTrait();
        $responseMessage = $this->getResponseMessageAvailabilityTrait('you_do_not_have_enough_silver_coins', $lang);

        if (auth()->user()->silver_coin < $amount) {
            response()->json(['ResponseCode' => 2, 'ResponseMessage' => 'Insuficient silver coins.', 'error' => [$responseMessage[0]['key_translation']]], 400)->send();
            die;
        }
    }



    public function getLanguageFromVailabilityTrait(){

        $lang =   request()->header('X-localization');

        if($lang == 'fil' || $lang == 'fi'){
            $lang = 'tl';
        }
        if($lang == 'en'){
            return null;
        }

        return Lang::where('lang', $lang)->where('is_active', 1)->first();

      }


    public function getResponseMessageAvailabilityTrait($key, $lang){
        $responseMessage = ResponseMessages::where('key_string', $key)
        ->when($lang != null, function($query) use($lang){
            $query->with(['responseMessageTranslation' => function($query) use ($lang){
                $query->select('id', 'table_name', 'column_name', 'language_id', 'translation as trr', 'record_id')
                ->where('table_name', 'response_messages')
                ->where('column_name', 'key_translation')
                ->where('language_id', $lang->language_id);
            }]);
        })->get()->toArray();

        $responseMessage = $this->setTranslationAvailabilityTrait($responseMessage, 'response_message_translation', 'trr', 'key_translation');
        return $responseMessage;
    }

    public function setTranslationAvailabilityTrait(array $listOfObjects, $translatedObjectKey, $translationKey, $keyToBeTranslated){
        $translatedObject = array();
        foreach($listOfObjects as $object){
            if(isset($object[$translatedObjectKey][$translationKey])){
                $object[$keyToBeTranslated] = $object[$translatedObjectKey][$translationKey];
                unset($object[$translatedObjectKey]);
                $translatedObject[] = $object;
            }else{
                $translatedObject[] = $object;
            }
        }

        return $translatedObject;
    }
}
