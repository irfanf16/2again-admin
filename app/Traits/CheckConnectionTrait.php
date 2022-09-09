<?php

namespace App\Traits;
use App\Models\Connection;

trait CheckConnectionTrait {
    public function checkConnection($user1, $user2){
        return  Connection::select('id')->where(['send_from' => $user1, 'send_to' => $user2])

        ->orwhere(function ($query) use ($user1, $user2) {
            $query->where(['send_from' => $user2, 'send_to' => $user1]);
        })
        ->first();
    }
}
