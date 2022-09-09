<?php

namespace Database\Seeders;

use App\Models\Religion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReligionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!Religion::exists()){


        DB::table('religions')->insert([
            'name'      => 'Islam',
        ]);

        DB::table('religions')->insert([
            'name'      => 'Christianity',
        ]);

        DB::table('religions')->insert([
            'name'      => 'Hinduism',
        ]);

        DB::table('religions')->insert([
            'name'      => 'Buddhist',
        ]);

        DB::table('religions')->insert([
            'name'      => 'Ethiest',
        ]);

        DB::table('religions')->insert([
            'name'      => 'Folk Religions',
        ]);

        DB::table('religions')->insert([
            'name'      => 'Other',
        ]);
    }
    }
}
