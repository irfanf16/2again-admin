<?php

namespace App\Repositories\ShopRepository;

use Illuminate\Http\Request;

interface iShopRepository {
    public function buy($item);
    public function getTierList($item);
    public function subscribe(Request $request);
    public function assignBadge(Request $request);
    public function buyGold(Request $request);
    public function purchaseHistory();
    public function goldCoinsQuantity();
    public function downgradeSubscription($package_id, $price);
}
