<?php

namespace Database\Seeders;

use App\Models\Looking;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lookings = array(
            array('id' => '1','name' => 'Dating'),
            array('id' => '2','name' => 'Marriage'),
            array('id' => '3','name' => 'Flirting'),
            array('id' => '4','name' => 'One Night Stand'),
            array('id' => '5','name' => 'Sugardate'),
            array('id' => '6','name' => 'Couples'),
            array('id' => '7','name' => 'Friends'),
            array('id' => '8','name' => '3rd Wheel'),
            array('id' => '9','name' => 'Partner'),
            array('id' => '10','name' => 'Dinner Date')
          );

          if(!Looking::exists()){
            DB::table('lookings')->insert($lookings);
          }
    }
}
