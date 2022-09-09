<?php

namespace Database\Seeders;

use App\Models\FAQs;
use App\Models\FaqTypes;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faqs = array(
            array('id' => '1','question' => 'Is 2Again free?','answer' => 'Yes. Some of the features of 2Again are free. But some features are only available for VIP members and those are paid.','sort' => '0','faq_type_id' => '1'),
            array('id' => '2','question' => 'What is 2Again?','answer' => '2Again is a dating social platform where you can find your partner in no time.','sort' => '0','faq_type_id' => '1'),
            array('id' => '3','question' => 'Can i use 2Again anywhere in the world?','answer' => 'Yes. 2Again is available in 40+ countries and available in 40+ languages.','sort' => '0','faq_type_id' => '1'),
            array('id' => '4','question' => 'What is the minimum age requirement?','answer' => 'The minimum age requirement is 18 years','sort' => '0','faq_type_id' => '1'),
            array('id' => '5','question' => 'How do I change my language settings on 2Again?','answer' => 'You can change you language setting in the settings.','sort' => '0','faq_type_id' => '1'),
            array('id' => '6','question' => 'How can I earn silver coins?','answer' => 'You can earn silver coins from several different things which includes Receiving Super Likes, Gifts, Invitations, Positive rating on direct messages and calls.','sort' => '1','faq_type_id' => '2'),
            array('id' => '7','question' => 'How can I withdraw silver coins?','answer' => 'You can withdraw silver coins via PayPal.','sort' => '2','faq_type_id' => '2'),
            array('id' => '8','question' => 'What is minimum withdraw limit?','answer' => 'The minimum withdraw limit is silver coins that are equal to $100','sort' => '3','faq_type_id' => '2'),
            array('id' => '9','question' => 'Where can I spend Gold coins?','answer' => 'You can spend gold coins on several things which includes Sending Gifts, Invitations, Direct messages, super like and making calls.','sort' => '4','faq_type_id' => '2'),
            array('id' => '10','question' => 'Are the people on 2Again real?','answer' => 'Yes. People on 2Again are 100% real people as we confirms their identity while sign up process.','sort' => '5','faq_type_id' => '2'),
            array('id' => '11','question' => 'How long will you keep my data?','answer' => 'We will keep your data up to 90 days without any subscription. If you subscribe on 89th day, your time will be reset to 90 days.','sort' => '6','faq_type_id' => '2')
          );

          $faq_types = array(
            array('id' => '1','name' => 'Technical'),
            array('id' => '2','name' => 'Support'),
            array('id' => '4','name' => 'General'),
            array('id' => '5','name' => 'General Technical Support General Technical SupportGeneral Technical SupportGeneral Technical Support'),
            array('id' => '6','name' => 'General Technical Support')
          );

          if(!FAQs::exists()){
            DB::table('faqs')->insert($faqs);
          }

          if(!FaqTypes::exists()){
            DB::table('faq_types')->insert($faq_types);
          }


    }
}
