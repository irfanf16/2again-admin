<?php

namespace App\Traits;

use App\Jobs\UserEmailNotificationJob;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\PushNotificationTrait;

trait NotificationTrait
{
    use PushNotificationTrait;

    public function sendNotification($user_id=null, $event, $data = null, $role = 2)
    {
        if($user_id){
            $user = $this->findUser($user_id);
        }else{
            $user = null;
        }

        if ($event != 'NewGift' && $event != 'NewInvitation' && $event != 'DM' && $event != 'RATE_DM' && $event != 'SUB_AND_EARN' && $event != 'EARN_COUNTER' && $event != 'VIDEO_CALL' && $event != 'CUSTOM' && $event != 'NewsUpdate' && $event != 'Promotions' && $event != 'CHAT_ABUSE' && $event != 'SILVER_COIN_EXPIRED') {

            if ($this->isPushNotificationEnabled($user->userNotificationSettings, $event . 'Push')) {

                $response = $this->sendPushNotification($event, $data, $user, $role);
            }

            if ($this->isEmailNotificationEnabled($user->userNotificationSettings, $event . 'Email')) {
                dispatch(new UserEmailNotificationJob($user, $event,$data));
            }

        } else {
            if ($event == 'CUSTOM' || $event == 'NewsUpdate' || $event == 'Promotions') {

                if($user){
                    $response =  $this->systemNotification($user, $event, $data, $role);
                }else{
                    $users = User::with('userNotificationSettings')->get();
                    foreach ($users as $user) {
                        if($user->userNotificationSettings){
                            $response =  $this->systemNotification($user, $event, $data, $role);

                        }
                    }
                }
            } else if($event == 'CHAT_ABUSE'){

            } else {
                $response = $this->sendPushNotification($event, $data, $user, $role);
                dispatch(new UserEmailNotificationJob($user, $event,$data));
            }


        }

        if (isset($response)) {
            if ($event != 'VIDEO_CALL' && $event != 'EARN_COUNTER') {
                $this->storeNotification($user_id, $response, $role);
            }
        }

        return;
    }

    public function isPushNotificationEnabled($settings, $event)
    {
        if ($settings->$event == 1) {
            return 1;
        }

        return 0;
    }

    public function isEmailNotificationEnabled($settings, $event)
    {
        if ($settings->$event == 1) {
            return 1;
        }

        return 0;
    }

    public function findUser($user_id)
    {
        return User::with('userNotificationSettings')->find($user_id);
    }

    public function storeNotification($user_id, $response, $role)
    {

        Notification::create([
            'user_id' => $user_id,
            'sent_by_admin' => auth()->id(),
            'title' => $response['title'],
            'body' => $response['body'],
            'role_id' => $role,
            'data' => json_encode($response['data'])
        ]);
    }

    public function systemNotification($user, $event, $data, $role){
        if ($event == 'NewsUpdate' || $event == 'Promotions') {

            if ($this->isPushNotificationEnabled($user->userNotificationSettings, $event . 'Push')) {
                $response = $this->sendPushNotification($event, $data, $user, $role);
            }else{
                $response = null;
            }

            if ($this->isEmailNotificationEnabled($user->userNotificationSettings, $event . 'Email')) {
                dispatch(new UserEmailNotificationJob($user, $event,$data));
            }

        } else {
            $response = $this->sendPushNotification($event, $data, $user, $role);
            dispatch(new UserEmailNotificationJob($user, $event,$data));
        }

        return $response;
    }
}
