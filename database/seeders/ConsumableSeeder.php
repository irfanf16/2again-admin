<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Consumable;

class ConsumableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         if(!Consumable::exists()){
            DB::table('consumables')->insert([
               [
                   'name' => 'Like'
               ],
               [
                   'name' => 'SuperLike'
               ],
               [
                   'name' => 'Favorite'
               ],
               [
                   'name' => 'Photo'
               ],
               [
                   'name' => 'Video'
               ],
               [
                   'name' => 'Call'
               ]
            ]);
        }
    }
}
