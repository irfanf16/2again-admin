<?php

namespace App\Repositories\EarnFreeRepository;

use Illuminate\Http\Request;

interface iEarnFreeRepository {

    public function getOtherApp(Request $request);
    public function getReward(Request $request);
    public function giveReward($code);
}
