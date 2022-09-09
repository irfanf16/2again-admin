<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!Language::exists()){


        DB::table('languages')->insert([
            'name'   => 'English',
        ]);

        DB::table('languages')->insert([
            'name'   => 'Bengali',

        ]);

        DB::table('languages')->insert([
            'name'   => 'Chinese',

        ]);

        DB::table('languages')->insert([
            'name'   => 'Danish',

        ]);

        DB::table('languages')->insert([
            'name'   => 'French',

        ]);

        DB::table('languages')->insert([
            'name'   => 'German',

        ]);

        DB::table('languages')->insert([
            'name'   => 'Hindi',

        ]);

        DB::table('languages')->insert([
            'name'   => 'Turkish',

        ]);


        DB::table('languages')->insert([
            'name'   => 'Urdu',

        ]);
    }

    }
}
