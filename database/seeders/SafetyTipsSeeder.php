<?php

namespace Database\Seeders;

use App\Models\SafetyTips;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SafetyTipsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $safety_tips = array(
            array('id' => '1','icon' => 'abc.png','title' => 'You can always retrieve your GDPR information','tip' => 'You can always retrieve your GDPR information that we have about you on the GDPR button in the menu.','created_at' => NULL,'updated_at' => '2022-02-17 07:55:43'),
            array('id' => '2','icon' => 'abc.png','title' => 'Block people you don’t like to continue with','tip' => 'You can always block or report someone who crosses your personal limits.','created_at' => NULL,'updated_at' => '2022-02-17 07:55:18'),
            array('id' => '3','icon' => 'abc.png','title' => 'Know people before you send a gift or invitation.','tip' => 'Know who you are sending gifts and invitations to, by making a video call to see the person live before sending larger gifts.','created_at' => NULL,'updated_at' => '2022-02-17 07:54:56'),
            array('id' => '4','icon' => 'abc_1645084578.png','title' => 'Don’t share your credentials with others','tip' => 'Never share your credentials and personal details as addresses. etc. with anyone.','created_at' => '2021-12-09 13:41:10','updated_at' => '2022-02-17 07:56:18'),
            array('id' => '5','icon' => 'abc_1645084612.png','title' => 'Do not buy more in the shop than you want to use','tip' => 'Do not buy more in the shop than you want to use, as there is no possibility of returning your purchases.','created_at' => '2022-02-17 07:56:52','updated_at' => '2022-02-17 07:56:52'),
            array('id' => '6','icon' => 'abc_1645084635.png','title' => 'Don’t use inappropriate or prohibited content','tip' => 'Photos with people under 18 and without clothes are illegal and cause immediate closure of your account without any kind of notice and/or refund if it happens.','created_at' => '2022-02-17 07:57:15','updated_at' => '2022-02-17 07:57:15'),
            array('id' => '7','icon' => 'abc_1645084666.png','title' => 'Don’t share your email or phone number','tip' => 'Sharing mail and phone number in “about me” . Will result in immediate closure of your account without any refund and is not recreatable.','created_at' => '2022-02-17 07:57:46','updated_at' => '2022-02-17 07:57:46')
          );

          if(!SafetyTips::exists()){
            DB::table('safety_tips')->insert($safety_tips);
          }
    }
}
