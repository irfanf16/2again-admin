<?php

namespace App\Repositories\StripeRepository;

use Illuminate\Http\Request;

interface iStripeRepository {

    public function addCard(Request $request);
    public function removeCard(Request $request);
    public function getCardList(Request $request);
}
