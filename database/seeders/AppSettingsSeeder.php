<?php

namespace Database\Seeders;

use App\Models\AppSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $app_settings = array(
            array('id' => '1','shortcode' => 'MWL','description' => 'minimum withdraw limit','value1' => '5','value2' => '100'),
            array('id' => '3','shortcode' => 'STU','description' => 'silver coin to usd','value1' => NULL,'value2' => '0.001'),
            array('id' => '4','shortcode' => 'VPG','description' => 'Visit photo gallery','value1' => '50','value2' => '30'),
            array('id' => '5','shortcode' => 'VVG','description' => 'visit video gallery','value1' => '100','value2' => '50'),
            array('id' => '6','shortcode' => 'GAM','description' => 'Gold Coins','value1' => 'gold_coins','value2' => '50'),
            array('id' => '7','shortcode' => 'GAM','description' => 'Daily Likees','value1' => 'daily_like','value2' => '50'),
            array('id' => '8','shortcode' => 'GAM','description' => 'super likes','value1' => 'super_like','value2' => '5'),
            array('id' => '9','shortcode' => 'GAM','description' => 'favorites','value1' => 'favorite','value2' => '5'),
            array('id' => '10','shortcode' => 'com.twoagainaps.vip1month','description' => 'gold coins','value1' => 'gold_coin','value2' => '100'),
            array('id' => '11','shortcode' => 'com.twoagainaps.vip1month','description' => 'daily likes','value1' => 'daily_like','value2' => '100'),
            array('id' => '12','shortcode' => 'com.twoagainaps.vip1month','description' => 'super like','value1' => 'super_like','value2' => '10'),
            array('id' => '13','shortcode' => 'com.twoagainaps.vip1month','description' => 'favorites','value1' => 'favorite','value2' => '10'),
            array('id' => '14','shortcode' => 'com.twoagainaps.vip3month','description' => 'gold coins','value1' => 'gold_coin','value2' => '300'),
            array('id' => '15','shortcode' => 'com.twoagainaps.vip3month','description' => 'daily likes','value1' => 'daily_like','value2' => '300'),
            array('id' => '16','shortcode' => 'com.twoagainaps.vip3month','description' => 'super likes','value1' => 'super_like','value2' => '30'),
            array('id' => '17','shortcode' => 'com.twoagainaps.vip3month','description' => 'favorites','value1' => 'favorite','value2' => '30'),
            array('id' => '18','shortcode' => 'com.twoagainaps.vip6month','description' => 'gold coins','value1' => 'gold_coin','value2' => '600'),
            array('id' => '19','shortcode' => 'com.twoagainaps.vip6month','description' => 'daily likes','value1' => 'daily_like','value2' => '600'),
            array('id' => '20','shortcode' => 'com.twoagainaps.vip6month','description' => 'super likes','value1' => 'super_like','value2' => '60'),
            array('id' => '21','shortcode' => 'com.twoagainaps.vip6month','description' => 'favorites','value1' => 'favorite','value2' => '60'),
            array('id' => '22','shortcode' => 'com.twoagainaps.vip12month','description' => 'gold coins','value1' => 'gold_coin','value2' => '1200'),
            array('id' => '23','shortcode' => 'com.twoagainaps.vip12month','description' => 'daily likes','value1' => 'daily_like','value2' => '1200'),
            array('id' => '24','shortcode' => 'com.twoagainaps.vip12month','description' => 'super likes','value1' => 'super_like','value2' => '120'),
            array('id' => '25','shortcode' => 'com.twoagainaps.vip12month','description' => 'favorites','value1' => 'favorite','value2' => '120'),
            array('id' => '26','shortcode' => 'com.twoagainaps.bigspender1month','description' => 'gold coins','value1' => 'gold_coin','value2' => '300'),
            array('id' => '27','shortcode' => 'com.twoagainaps.bigspender1month','description' => 'daily likes','value1' => 'daily_like','value2' => '300'),
            array('id' => '28','shortcode' => 'com.twoagainaps.bigspender1month','description' => 'super like','value1' => 'super_like','value2' => '30'),
            array('id' => '29','shortcode' => 'com.twoagainaps.bigspender1month','description' => 'favorites','value1' => 'favorite','value2' => '30'),
            array('id' => '30','shortcode' => 'com.twoagainaps.bigspender3month','description' => 'gold coins','value1' => 'gold_coin','value2' => '900'),
            array('id' => '31','shortcode' => 'com.twoagainaps.bigspender3month','description' => 'daily likes','value1' => 'daily_like','value2' => '900'),
            array('id' => '32','shortcode' => 'com.twoagainaps.bigspender3month','description' => 'super like','value1' => 'super_like','value2' => '90'),
            array('id' => '33','shortcode' => 'com.twoagainaps.bigspender3month','description' => 'favorites','value1' => 'favorite','value2' => '90'),
            array('id' => '34','shortcode' => 'com.twoagainaps.bigspender6month','description' => 'gold coins','value1' => 'gold_coin','value2' => '1800'),
            array('id' => '35','shortcode' => 'com.twoagainaps.bigspender6month','description' => 'daily likes','value1' => 'daily_like','value2' => '1800'),
            array('id' => '36','shortcode' => 'com.twoagainaps.bigspender6month','description' => 'super like','value1' => 'super_like','value2' => '180'),
            array('id' => '37','shortcode' => 'com.twoagainaps.bigspender6month','description' => 'favorites','value1' => 'favorite','value2' => '180'),
            array('id' => '38','shortcode' => 'com.twoagainaps.bigspender12month','description' => 'gold coins','value1' => 'gold_coin','value2' => '3600'),
            array('id' => '39','shortcode' => 'com.twoagainaps.bigspender12month','description' => 'daily likes','value1' => 'daily_like','value2' => '3600'),
            array('id' => '40','shortcode' => 'com.twoagainaps.bigspender12month','description' => 'super like','value1' => 'super_like','value2' => '360'),
            array('id' => '41','shortcode' => 'com.twoagainaps.bigspender12month','description' => 'favorites','value1' => 'favorite','value2' => '360'),
            array('id' => '42','shortcode' => 'EGC','description' => 'download other app','value1' => 'download_other_app','value2' => '10'),
            array('id' => '43','shortcode' => 'EGC','description' => 'watch video ad','value1' => 'watch_video_ad','value2' => '10'),
            array('id' => '44','shortcode' => 'EGC','description' => 'invite friend','value1' => 'invite_friend','value2' => '10'),
            array('id' => '45','shortcode' => 'ESC','description' => 'invite friend','value1' => 'invite_friend','value2' => '100'),
            array('id' => '46','shortcode' => 'PPL','description' => 'public photo limit','value1' => 'public_photo_limit','value2' => '3'),
            array('id' => '47','shortcode' => 'MWLIMIT','description' => 'monthly withdrawal limit','value1' => '1','value2' => '6000'),
            array('id' => '48','shortcode' => 'PUEL','description' => 'per user earning limit silver coin','value1' => NULL,'value2' => '200'),
            array('id' => '49','shortcode' => 'EGC','description' => 'earn gold coin on invite friend business affiliate','value1' => 'invite_friend_business_affiliate','value2' => '100'),
            array('id' => '50','shortcode' => 'SD','description' => 'allow user to set search distance','value1' => 'search_distance','value2' => '1')
          );

          if(!AppSetting::exists()){
            DB::table('app_settings')->insert($app_settings);
          }
    }
}
