<?php

namespace Database\Seeders;

use App\Models\LikeType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LikeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!LikeType::exists())
        {


        DB::table('like_types')->insert([
            'name' => 'Like'
        ]);

        DB::table('like_types')->insert([
            'name' => 'Nope'
        ]);

        DB::table('like_types')->insert([
            'name' => 'SuperLike'
        ]);
    }
    }
}
