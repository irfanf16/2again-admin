<?php

namespace Database\Seeders;

use App\Models\Gender;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!Gender::exists()){
            DB::table('genders')->insert([
                'name' => 'Everyone'
            ]);
            DB::table('genders')->insert([
                'name' => 'Man'
            ]);

            DB::table('genders')->insert([
                'name' => 'Woman'
            ]);

            DB::table('genders')->insert([
                'name' => 'Other'
            ]);
        }

    }
}
