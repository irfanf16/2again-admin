<?php

namespace App\Traits;

trait CreateStripeCustomerTrait
{

    public function createStripeCustomer($user){

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $customer = \Stripe\Customer::create([
            'email' => $user->email,
            'name' => $user->name,
            'phone' => $user->phone,
            'description' => '2again User',

        ]);

        return $customer->id;
    }
}
