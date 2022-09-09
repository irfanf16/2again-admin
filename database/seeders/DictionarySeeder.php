<?php

namespace Database\Seeders;

use App\Models\Dictionary;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DictionarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $dictionaries = array(
            array('id' => '1','word' => 'fuck'),
            array('id' => '2','word' => 'shit'),
            array('id' => '3','word' => 'dick'),
            array('id' => '4','word' => 'ass'),
            array('id' => '5','word' => 'bitch'),
            array('id' => '6','word' => 'bastard'),
            array('id' => '7','word' => 'cunt'),
            array('id' => '8','word' => 'piss')
          );

          if(!Dictionary::exists()){
            DB::table('dictionaries')->insert($dictionaries);
          }

    }
}
