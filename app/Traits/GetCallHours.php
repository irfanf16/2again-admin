<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

trait GetCallHours
{
    public function getCallHorus($user){

        $available_call_seconds = $user->available_call_min;
        unset($user['available_call_min']);

        $totalMinuts = (int) ($available_call_seconds / 60);

        $user->available_call_min = $totalMinuts;
        $user->media_url= env('MEDIA_URL');
        $user->icon_url= env('GIFT_URL');
        $user->audio_url  =  env('AUDIO_MESSAGE_URL');

        return $user;
    }
}
