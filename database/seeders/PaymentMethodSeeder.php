<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!PaymentMethod::exists())
        {
            DB::table('payment_methods')->insert([
                [
                    'name' => 'Paypal',
                    'icon'   =>  'paypal.png',
                    'is_active' =>  1
                ],
                [
                    'name' => 'Stripe',
                    'icon'   => 'stripe.png',
                    'is_active' =>  1
                ]
            ]);
        }
    }
}
