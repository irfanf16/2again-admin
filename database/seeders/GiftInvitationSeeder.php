<?php

namespace Database\Seeders;

use App\Models\GiftInvitations;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GiftInvitationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!GiftInvitations::exists()){


        DB::table('gifts_invitations')->insert([
            'name'  => 'Treasure',
            'type'  => 'Gift',
            'price' => '55',
            'silver_coin' => 10,
            'icon'  => '1.png'
        ]);

        DB::table('gifts_invitations')->insert([
            'name'  => 'Cake',
            'type'  => 'Gift',
            'price' => '150',
            'silver_coin' => 20,
            'icon'  => '2.png'
        ]);

        DB::table('gifts_invitations')->insert([
            'name'  => 'Flowers',
            'type'  => 'Gift',
            'price' => '250',
            'silver_coin' => 15,
            'icon'  => '4.png'
        ]);

        DB::table('gifts_invitations')->insert([
            'name'  => 'Present',
            'type'  => 'Gift',
            'price' => '55',
            'silver_coin' => 20,
            'icon'  => '5.png'
        ]);

        DB::table('gifts_invitations')->insert([
            'name'  => 'Heart Candy',
            'type'  => 'Gift',
            'price' => '55',
            'silver_coin' => 30,
            'icon'  => '6.png'
        ]);

        DB::table('gifts_invitations')->insert([
            'name'  => 'Birthday',
            'type'  => 'Gift',
            'price' => '55',
            'silver_coin' => 35,
            'icon'  => '14.png'
        ]);

        ////////////////////////////////
        ////////// Invitations /////////

        DB::table('gifts_invitations')->insert([
            'name'  => 'Dinner',
            'type'  => 'Invitation',
            'price' => '200',
            'silver_coin' => 100,
            'icon'  => '3.png'
        ]);

        DB::table('gifts_invitations')->insert([
            'name'  => 'Date',
            'type'  => 'Invitation',
            'price' => '400',
            'silver_coin' => 200,
            'icon'  => '15.png'
        ]);

        DB::table('gifts_invitations')->insert([
            'name'  => 'Birthday',
            'type'  => 'Invitation',
            'price' => '300',
            'silver_coin' => 150,
            'icon'  => '13.png'
        ]);

        DB::table('gifts_invitations')->insert([
            'name'  => 'Marriage',
            'type'  => 'Invitation',
            'price' => '300',
            'silver_coin' => 150,
            'icon'  => '24.png'
        ]);

        DB::table('gifts_invitations')->insert([
            'name'  => 'Coffee',
            'type'  => 'Invitation',
            'price' => '300',
            'silver_coin' => 150,
            'icon'  => '16.png'
        ]);

        DB::table('gifts_invitations')->insert([
            'name'  => 'Shopping',
            'type'  => 'Invitation',
            'price' => '300',
            'silver_coin' => 150,
            'icon'  => '23.png'
        ]);
    }

    }
}
