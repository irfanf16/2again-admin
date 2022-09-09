<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\CoinSetting;
use Illuminate\Http\Request;


class AppSettingController extends Controller
{
    public function settingsView()
    {

        $appSettings = [];

        $settings = AppSetting::all();
        $appSettings['withdraw_limits'] = $settings->where('shortcode', 'MWL')->first();
        $appSettings['silver_to_usd'] = $settings->where('shortcode', 'STU')->first();
        $appSettings['download_other_app'] = $settings->where('value1', 'download_other_app')->first();
        $appSettings['watch_video_ad'] = $settings->where('value1', 'watch_video_ad')->first();
        $appSettings['invite_friend_gold'] = $settings->where('shortcode', 'EGC')->where('value1', 'invite_friend')->first();
        $appSettings['invite_friend_business_affiliate'] = $settings->where('shortcode', 'EGC')->where('value1', 'invite_friend_business_affiliate')->first();
        $appSettings['invite_friend_silver'] = $settings->where('shortcode', 'ESC')->first();
        $appSettings['public_photo_limit'] = $settings->where('shortcode', 'PPL')->first();
        $appSettings['MWLIMIT'] = $settings->where('shortcode', 'MWLIMIT')->first();
        $appSettings['PUEL'] = $settings->where('shortcode', 'PUEL')->first();
        $appSettings['search_distance'] = $settings->where('shortcode', 'SD')->first();
        $appSettings['silver_coins_expiry_days'] = $settings->where('shortcode', 'SCED')->first();

        $coinSettings = [];

        $settings = CoinSetting::all();

        $coinSettings['DM'] = $settings->where('item', 'DM')->first();
        $coinSettings['Call'] = $settings->where('item', 'Call')->first();
        $coinSettings['SuperLike'] = $settings->where('item', 'SuperLike')->first();
        $coinSettings['Photo'] = $settings->where('item', 'Photo')->first();
        $coinSettings['Video'] = $settings->where('item', 'Video')->first();
        $coinSettings['Emoji'] = $settings->where('item', 'Emoji')->first();
        $coinSettings['AF'] = $settings->where('item', 'AF')->first();
        return view('admin.pages.setting.appSettings')->with(compact('appSettings','coinSettings'));
    }

    public function subscriptionsView()
    {


        $subscriptionSettings = [];

        $settings = AppSetting::all();

        /// greet and meet
        $subscriptionSettings['gam_gold_coins'] = $settings->where('shortcode', 'GAM')->where('value1', 'gold_coins')->first()->value2;
        $subscriptionSettings['gam_daily_like'] = $settings->where('shortcode', 'GAM')->where('value1', 'daily_like')->first()->value2;
        $subscriptionSettings['gam_super_like'] = $settings->where('shortcode', 'GAM')->where('value1', 'super_like')->first()->value2;
        $subscriptionSettings['gam_favorite'] = $settings->where('shortcode', 'GAM')->where('value1', 'favorite')->first()->value2;

        /// vip 1 month
        $subscriptionSettings['vip_1m_gold_coins'] =   $settings->where('shortcode', 'com.twoagainaps.vip1month')->where('value1', 'gold_coin')->first()->value2;
        $subscriptionSettings['vip_1m_daily_like'] =   $settings->where('shortcode', 'com.twoagainaps.vip1month')->where('value1', 'daily_like')->first()->value2;
        $subscriptionSettings['vip_1m_super_like'] = $settings->where('shortcode', 'com.twoagainaps.vip1month')->where('value1', 'super_like')->first()->value2;
        $subscriptionSettings['vip_1m_favorite'] = $settings->where('shortcode', 'com.twoagainaps.vip1month')->where('value1', 'favorite')->first()->value2;


        $subscriptionSettings['vip_3m_gold_coins'] =   $settings->where('shortcode', 'com.twoagainaps.vip3month')->where('value1', 'gold_coin')->first()->value2;
        $subscriptionSettings['vip_3m_daily_like'] =   $settings->where('shortcode', 'com.twoagainaps.vip3month')->where('value1', 'daily_like')->first()->value2;
        $subscriptionSettings['vip_3m_super_like'] = $settings->where('shortcode', 'com.twoagainaps.vip3month')->where('value1', 'super_like')->first()->value2;
        $subscriptionSettings['vip_3m_favorite'] = $settings->where('shortcode', 'com.twoagainaps.vip3month')->where('value1', 'favorite')->first()->value2;

        $subscriptionSettings['vip_6m_gold_coins'] =   $settings->where('shortcode', 'com.twoagainaps.vip6month')->where('value1', 'gold_coin')->first()->value2;
        $subscriptionSettings['vip_6m_daily_like'] =   $settings->where('shortcode', 'com.twoagainaps.vip6month')->where('value1', 'daily_like')->first()->value2;
        $subscriptionSettings['vip_6m_super_like'] = $settings->where('shortcode', 'com.twoagainaps.vip6month')->where('value1', 'super_like')->first()->value2;
        $subscriptionSettings['vip_6m_favorite'] = $settings->where('shortcode', 'com.twoagainaps.vip6month')->where('value1', 'favorite')->first()->value2;

        $subscriptionSettings['vip_12m_gold_coins'] =   $settings->where('shortcode', 'com.twoagainaps.vip12month')->where('value1', 'gold_coin')->first()->value2;
        $subscriptionSettings['vip_12m_daily_like'] =   $settings->where('shortcode', 'com.twoagainaps.vip12month')->where('value1', 'daily_like')->first()->value2;
        $subscriptionSettings['vip_12m_super_like'] = $settings->where('shortcode', 'com.twoagainaps.vip12month')->where('value1', 'super_like')->first()->value2;
        $subscriptionSettings['vip_12m_favorite'] = $settings->where('shortcode', 'com.twoagainaps.vip12month')->where('value1', 'favorite')->first()->value2;


        $subscriptionSettings['big_1m_gold_coins'] =   $settings->where('shortcode', 'com.twoagainaps.bigspender1month')->where('value1', 'gold_coin')->first()->value2;
        $subscriptionSettings['big_1m_daily_like'] =   $settings->where('shortcode', 'com.twoagainaps.bigspender1month')->where('value1', 'daily_like')->first()->value2;
        $subscriptionSettings['big_1m_super_like'] = $settings->where('shortcode', 'com.twoagainaps.bigspender1month')->where('value1', 'super_like')->first()->value2;
        $subscriptionSettings['big_1m_favorite'] = $settings->where('shortcode', 'com.twoagainaps.bigspender1month')->where('value1', 'favorite')->first()->value2;

//
//        $subscriptionSettings['big_3m_gold_coins'] =   $settings->where('shortcode', 'com.twoagainaps.bigspender3month')->where('value1', 'gold_coin')->first()->value2;
//        $subscriptionSettings['big_3m_daily_like'] =   $settings->where('shortcode', 'com.twoagainaps.bigspender3month')->where('value1', 'daily_like')->first()->value2;
//        $subscriptionSettings['big_3m_super_like'] = $settings->where('shortcode', 'com.twoagainaps.bigspender3month')->where('value1', 'super_like')->first()->value2;
//        $subscriptionSettings['big_3m_favorite'] = $settings->where('shortcode', 'com.twoagainaps.bigspender3month')->where('value1', 'favorite')->first()->value2;

        $subscriptionSettings['big_3m_gold_coins'] =   $settings->where('shortcode', 'com.twoagainaps.bigspender3month')->where('value1', 'gold_coin')->first()->value2;
        $subscriptionSettings['big_3m_daily_like'] =   $settings->where('shortcode', 'com.twoagainaps.bigspender3month')->where('value1', 'daily_like')->first()->value2;
        $subscriptionSettings['big_3m_super_like'] = $settings->where('shortcode', 'com.twoagainaps.bigspender3month')->where('value1', 'super_like')->first()->value2;
        $subscriptionSettings['big_3m_favorite'] = $settings->where('shortcode', 'com.twoagainaps.bigspender3month')->where('value1', 'favorite')->first()->value2;

        $subscriptionSettings['big_6m_gold_coins'] =   $settings->where('shortcode', 'com.twoagainaps.bigspender6month')->where('value1', 'gold_coin')->first()->value2;
        $subscriptionSettings['big_6m_daily_like'] =   $settings->where('shortcode', 'com.twoagainaps.bigspender6month')->where('value1', 'daily_like')->first()->value2;
        $subscriptionSettings['big_6m_super_like'] = $settings->where('shortcode', 'com.twoagainaps.bigspender6month')->where('value1', 'super_like')->first()->value2;
        $subscriptionSettings['big_6m_favorite'] = $settings->where('shortcode', 'com.twoagainaps.bigspender6month')->where('value1', 'favorite')->first()->value2;

        $subscriptionSettings['big_12m_gold_coins'] =   $settings->where('shortcode', 'com.twoagainaps.bigspender12month')->where('value1', 'gold_coin')->first()->value2;
        $subscriptionSettings['big_12m_daily_like'] =   $settings->where('shortcode', 'com.twoagainaps.bigspender12month')->where('value1', 'daily_like')->first()->value2;
        $subscriptionSettings['big_12m_super_like'] = $settings->where('shortcode', 'com.twoagainaps.bigspender12month')->where('value1', 'super_like')->first()->value2;
        $subscriptionSettings['big_12m_favorite'] = $settings->where('shortcode', 'com.twoagainaps.bigspender12month')->where('value1', 'favorite')->first()->value2;


        return view('admin.pages.setting.subscriptions')->with(compact('subscriptionSettings'));
    }

    public function coinsView()
    {
        $coinSettings = [];

        $settings = CoinSetting::all();

        $coinSettings['DM'] = $settings->where('item', 'DM')->first();
        $coinSettings['Call'] = $settings->where('item', 'Call')->first();
        $coinSettings['SuperLike'] = $settings->where('item', 'SuperLike')->first();
        $coinSettings['Photo'] = $settings->where('item', 'Photo')->first();
        $coinSettings['Video'] = $settings->where('item', 'Video')->first();
        $coinSettings['Emoji'] = $settings->where('item', 'Emoji')->first();
        $coinSettings['AF'] = $settings->where('item', 'AF')->first();

        return view('admin.pages.setting.coins')->with(compact('coinSettings'));
    }

    public function updateSubscriptionsSettings(Request $request)
    {

        $collection =  collect($request->all());

        if (strpos($collection['items'][0]['name'], '-') !== false) {

            foreach ($collection['items'] as $item) {
                $itemArray = explode('-', $item['name']);
                $settings = AppSetting::where(['shortcode' => $itemArray[0], 'value1' => $itemArray[1]])->first();

                $settings->update([
                    'value2' => $item['value']
                ]);
            }
            return 1;
        } else {


            $settings = AppSetting::where(['shortcode' => $collection['items'][0]['name']])->first();
            $settings->update([
                'value1' => $collection['items'][0]['value'],
                'value2' => $collection['items'][1]['value']
            ]);

            $settings = AppSetting::where(['shortcode' => $collection['items'][2]['name']])->first();
            $settings->update([
                'value1' => 1,
                'value2' => $collection['items'][2]['value']
            ]);

            $settings = AppSetting::where(['shortcode' => $collection['items'][3]['name']])->first();
            $settings->update([
                'value1' => null,
                'value2' => $collection['items'][3]['value']
            ]);

            $settings = AppSetting::where(['shortcode' => $collection['items'][4]['name']])->first();
            $settings->update([
                'value1' => null,
                'value2' => $collection['items'][4]['value']
            ]);
            $settings = AppSetting::where(['shortcode' => $collection['items'][5]['name']])->first();
            $settings->update([
                'value2' => $collection['items'][5]['value']
            ]);

            return 1;
        }
    }

    public function updateCoinSettings(Request $request)
    {
        $collection =  collect($request->all());

        $settings = CoinSetting::where('item', $collection['items'][0]['name'])->first();

        if (isset($collection['items'][1])) {
            $settings->update([
                'deduct_gold_coins' =>  $collection['items'][0]['value'],
                'earn_silver_coins' =>  $collection['items'][1]['value']
            ]);
        } else {
            $settings->update([
                'deduct_gold_coins' =>  $collection['items'][0]['value'],
            ]);
        }

        return 1;
    }

    public function versionControl(){
        $appSettings = [];

        $settings = AppSetting::all();
        $appSettings['AVA_IOS']=$settings->where('shortcode', 'AVA_IOS')->first();
        $appSettings['AVA_ANDROID']=$settings->where('shortcode', 'AVA_ANDROID')->first();

        return view('admin.pages.versionControl',compact('appSettings'));
    }
    public function versionControlSave(Request $request){

        AppSetting::where('shortcode',$request->shortcode)->update(['value1'=>$request->value1,'value2'=>$request->value2]);
        return 1;

    }
}
