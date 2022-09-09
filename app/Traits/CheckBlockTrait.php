<?php

namespace App\Traits;

use App\Models\Block;
use Illuminate\Http\Request;


trait CheckBlockTrait
{

    public function getBlock($user_id)
    {
        return  Block::where(['blocked_by' => $user_id, 'blocked_user' => auth()->id()])

        ->orwhere(function ($query) use ($user_id) {
            $query->where(['blocked_by' => auth()->id(), 'blocked_user' => $user_id]);
        })
        ->first();
    }
}
