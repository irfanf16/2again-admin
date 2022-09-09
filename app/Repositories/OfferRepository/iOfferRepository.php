<?php

namespace App\Repositories\OfferRepository;

use Illuminate\Http\Request;

interface iOfferRepository {
    public function getOffers();
    public function offerDetail(Request $request);
    public function buy(Request $request);
}
