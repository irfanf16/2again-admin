<?php

namespace App\Traits;

use App\Models\BannedUsers;
use App\Models\Block;
use Carbon\Carbon;
use Illuminate\Http\Request;


trait CheckBanTrait
{

    public function checkBanned($user_id)
    {
        $conditions = [
            'banned_user'   =>  $user_id,
            ['time_banned_for', '>=', Carbon::now()]
        ];

        return    $banned = BannedUsers::where($conditions)
        ->orwhere(function($query) use($user_id){
            $query->where(['banned_user' => $user_id, 'banned_forever' => 1]);
        })
      ->get()->first();
    }
}
