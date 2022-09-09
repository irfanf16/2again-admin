<?php

namespace Database\Seeders;

use App\Models\Subscription;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!Subscription::exists()){

        DB::table('subscriptions')->insert([
            'name'      => 'Greet And Meet',
            'shortcode' => 'GAM',
            'badge'     => 'greet_and_meet.png',
        ]);

        DB::table('subscriptions')->insert([
            'name'      => 'VIP',
            'shortcode' => 'VIP',
            'badge'     => 'vip.png',
        ]);

        DB::table('subscriptions')->insert([
            'name'      => 'Big Spender',
            'shortcode' => 'BS',
            'badge'     => 'big_spender.png',
        ]);
    }
    }
}
