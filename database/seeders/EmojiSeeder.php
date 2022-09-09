<?php

namespace Database\Seeders;

use App\Models\Emoji;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmojiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!Emoji::exists()){
            DB::table('emoji')->insert([
               [
                   'name' => 'happy',
                   'icon'   =>  'emoji_happy.png'
               ],
               [
                   'name' => 'sad',
                   'icon'   => 'emoji_sad.png'
               ],
               [
                   'name' => 'tired',
                   'icon'   => 'emoji_tired.png'
               ],
               [
                   'name' => 'hopeless',
                   'icon'   => 'emoji_hopeless.png'
               ],
               [
                   'name' => 'surprised',
                   'icon'   => 'emoji_surprised.png'
               ],
               [
                   'name' => 'angry',
                   'icon'   => 'emoji_angry.png'
               ],
               [
                   'name' => 'laughing',
                   'icon'   => 'emoji_laughing.png'
               ],
               [
                   'name' => 'love',
                   'icon'   => 'emoji_love.png'
               ]
            ]);
        }
    }
}
