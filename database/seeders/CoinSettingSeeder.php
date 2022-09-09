<?php

namespace Database\Seeders;

use App\Models\CoinSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoinSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!CoinSetting::exists()){

            DB::table('coin_settings')->insert([
                'item'                  => 'DM',
                'deduct_gold_coins'     => 300.00,
                'earn_silver_coins'     =>  150.00,
            ]);

            DB::table('coin_settings')->insert([
                'item'                  => 'Call',
                'deduct_gold_coins'     => 10.00,
                'earn_silver_coins'     =>  5.00,
            ]);

            DB::table('coin_settings')->insert([
                'item'                  => 'SuperLike',
                'deduct_gold_coins'     => null,
                'earn_silver_coins'     =>  25.00,
            ]);

            DB::table('coin_settings')->insert([
                'item'                  => 'Photo',
                'deduct_gold_coins'     => 50.00,
                'earn_silver_coins'     =>  25.00,
            ]);

            DB::table('coin_settings')->insert([
                'item'                  => 'Video',
                'deduct_gold_coins'     => 50.00,
                'earn_silver_coins'     =>  25.00,
            ]);

            DB::table('coin_settings')->insert([
                'item'                  => 'Emoji',
                'deduct_gold_coins'     => 10.00,
                'earn_silver_coins'     =>  null,
            ]);

            DB::table('coin_settings')->insert([
                'item'                  => 'AF',
                'deduct_gold_coins'     => 500.00,
                'earn_silver_coins'     =>  null,
            ]);

        }

    }
}
