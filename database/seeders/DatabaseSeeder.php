<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(
                [
                   GenderSeeder::class,
                   LikeTypeSeeder::class,
                   GiftInvitationSeeder::class,
                   SubscriptionSeeder::class,
                   LanguageSeeder::class,
                   ReligionSeeder::class,
                   CoinSettingSeeder::class,
                   ReportReasonsSeeder::class,
                   EmojiSeeder::class,
                   RoleSeeder::class,
                   PaymentMethodSeeder::class,
                   ConsumableSeeder::class,
                    //Permissions::class,
                   CountrySeeder::class,
                   AppSettingsSeeder::class,
                   ShopSeeder::class,
                   DictionarySeeder::class,
                   FaqSeeder::class,
                   LookingSeeder::class,
                   SafetyTipsSeeder::class,
                ]
            );
    }
}
