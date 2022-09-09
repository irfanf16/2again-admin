<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Events\PushNotificationEvent;
use App\Models\Lang;
use Illuminate\Support\Facades\Http;
use App\Models\Message;
use App\Models\ResponseMessages;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;

trait PushNotificationTrait
{
    public function sendPushNotification($event, $data, $user, $role){

        $notificationCount = $user->notifications()->where('is_read', 0)->count();

        $userLanguage = $user->language_id;
        $lang = $this->getLanguageFromTrait($userLanguage);


        if($event == 'SuperLike'){

            $responseMessage = $this->getResponseMessage('new_super_like', $lang);
            $title = $responseMessage[0]['key_translation'];

            $responseMessage = $this->getResponseMessage('Congratulations_super_like', $lang);
            $body = $responseMessage[0]['key_translation'];

            $data = [
                'value1' => "0",
                'value2' => "0",
                'badge' =>  "$notificationCount",
            ];
        }elseif($event == 'NewMessage'){

            $responseMessage = $this->getResponseMessage('new_message_received', $lang);
            $title = $responseMessage[0]['key_translation'];

            $body = $data->text;
            $data = [
                'value1' => (string) $data->connection_id,
                'value2' => json_encode($data),
                'badge' =>  "$notificationCount",
                'message_count' => (string) $this->getUnreadMessageCound($user)
            ];
        }elseif($event == 'NewGift'){
            $responseMessage = $this->getResponseMessage('new_gift_received', $lang);
            $title = $responseMessage[0]['key_translation'];

            $responseMessage = $this->getResponseMessage('you_have_received_a_new_gift', $lang);
            $body = $responseMessage[0]['key_translation'];

            $data = [
                'value1' => $title,
                'value2' => $body,
                'badge' =>  "$notificationCount",
            ];

        }elseif($event == 'NewInvitation'){

            $responseMessage = $this->getResponseMessage('new_invitation_received', $lang);
            $title = $responseMessage[0]['key_translation'];

            $responseMessage = $this->getResponseMessage('you_have_received_a_new_invitation', $lang);
            $body = $responseMessage[0]['key_translation'];


            $data = [
                'value1' => "0",
                'value2' => "0",
                'badge' =>  "$notificationCount",

            ];
        }elseif($event == 'SeenMe'){

            $responseMessage = $this->getResponseMessage('seen', $lang);
            $title = $responseMessage[0]['key_translation'];

            $responseMessage = $this->getResponseMessage('your_appear_first_user_has_seen_you', $lang);
            $body = $responseMessage[0]['key_translation'];

            $data = [
                'value1' => "0",
                'value2' => "0",
                'badge' =>  "$notificationCount",
            ];
        }elseif($event == 'NewMatch'){

            $responseMessage = $this->getResponseMessage('new_match', $lang);
            $title = $responseMessage[0]['key_translation'];

            $responseMessage = $this->getResponseMessage('congratulations_match', $lang);
            $body = $responseMessage[0]['key_translation'];

            $data = [
                'value1' => "0",
                'value2' => "0",
                'badge' =>  "$notificationCount",
            ];
        }elseif($event == 'DM'){

            $responseMessage = $this->getResponseMessage('direct_message', $lang);
            $title = $responseMessage[0]['key_translation'];

            $responseMessage = $this->getResponseMessage('you_have_received_a_new_direct_message', $lang);
            $body = $responseMessage[0]['key_translation'];

            $data = [
                'value1' => (string) $data->connection_id,
                'value2' => json_encode($data),
                'badge' =>  "$notificationCount",
                'message_count' => (string) $this->getUnreadMessageCound($user)
            ];
        }elseif($event == 'RATE_DM'){

            $responseMessage = $this->getResponseMessage('direct_message_reply', $lang);
            $title = $responseMessage[0]['key_translation'];

            $responseMessage = $this->getResponseMessage('you_have_received_a_reply_on_your_direct_message', $lang);
            $body = $responseMessage[0]['key_translation'];

            $data = [
                'value1' => (string) $data->connection_id,
                'value2' => $data->text,
                'badge' =>  "$notificationCount",
            ];
        }elseif($event == 'SUB_AND_EARN'){

            $responseMessage = $this->getResponseMessage('subscribe_to_earn', $lang);
            $title = $responseMessage[0]['key_translation'];

            $responseMessage = $this->getResponseMessage('please_become_vip_or_big_spender_to_earn_from_direct_message_reply', $lang);
            $body = $responseMessage[0]['key_translation'];

            $data = [
                'value1' => "0",
                'value2' => "0",
                'badge' =>  "$notificationCount",
            ];
        }elseif($event == 'EARN_COUNTER'){

            $responseMessage = $this->getResponseMessage('positive_rating', $lang);
            $title = $responseMessage[0]['key_translation'];

            $responseMessage = $this->getResponseMessage('you_have_got_positive_rating_on_your_direct_reply', $lang);
            $body = $responseMessage[0]['key_translation'];

            $data = [
                'value1' => "0",
                'value2' => "$user->silver_coin",
                'badge' =>  "$notificationCount",
            ];
        }elseif($event == 'VIDEO_CALL'){

            $milliseconds = round(microtime(true) * 1000);

            $title = 'Incomming Call';

            $responseMessage = $this->getResponseMessage('a_call_is_coming', $lang);
            $body = $responseMessage[0]['key_translation'];


            $data = [
                'value1' => "0",
                'value2' => json_encode($data),
                'badge' =>  "$notificationCount",
                'time'  =>  "$milliseconds",
            ];
        }elseif($event == 'CUSTOM'){
            $title =$data['title'];
            $body = $data['body'];
            $data = [
                'value1' => $title,
                'value2' => $data['data'],
                'badge' =>  "$notificationCount",
            ];
        }elseif($event == 'NewsUpdate'){
            $title =$data['title'];
            $body = $data['body'];
            $data = [
                'value1' => $title,
                'value2' => $data['data'],
                'badge' =>  "$notificationCount",
            ];
        }elseif($event == 'Promotions'){
            $title =$data['title'];
            $body = $data['body'];
            $data = [
                'value1' => $title,
                'value2' => $data['data'],
                'badge' =>  "$notificationCount",
            ];
        }elseif($event == 'CHAT_ABUSE'){
            $title = 'User Abuse Report';
            $body =  'A User is abusing in chat';
            $data = [
                'value1' => "0",
                'value2' => json_encode($data),
                'badge' =>  "$notificationCount",
            ];
        }elseif($event == 'SILVER_COIN_EXPIRED'){
            $title = 'Silver Coins Expired';
            $body = 'As per 2Again terms of use, your silver coins has been expired due to inactive subscription of VIP or Big Spender for more than 90 days';
            $data = [
                'value1' => "0",
                'value2' => "0",
                'badge' =>  "$notificationCount",
            ];
        }

        if($user != null){
            if($user->fcm_token != null){

                // event(new PushNotificationEvent($title, $body, $data, $user->fcm_token, $event));
                // $response = Http::acceptJson()->withHeaders([
                //     'KEY' => 'YW1Gb1lXNTZZV2xpTG1GemJHRnRMbTFsYUdGeVFHZHRZV2xzTG1OdmJUb3lZV2RoYVc0dGMyOWphMlYw',
                // ])->post('https://www.socket.performance.2again.com/api/notify', [
                //     'title'         => $title,
                //     'body'          =>  $body,
                //     'data'          =>  $data,
                //     'fcm_token'     =>  $user->fcm_token,
                //     'event'         =>  $event
                // ]);

                $apiURL = 'https://www.socket.performance.2again.com/api/notify';
                $postInput = [
                    'title' => $title,
                    'body' =>  $body,
                    'data' =>  $data,
                    'fcm_token' =>  $user->fcm_token,
                    'event' =>  $event

                ];

                $headers = [
                    'KEY' => 'YW1Gb1lXNTZZV2xpTG1GemJHRnRMbTFsYUdGeVFHZHRZV2xzTG1OdmJUb3lZV2RoYVc0dGMyOWphMlYw'
                ];

                $response = Http::withHeaders($headers)->post($apiURL, $postInput);
                $statusCode = $response->status();
                $responseBody = json_decode($response->getBody(), true);


            }
        }else{
            $role = Role::find($role);

            $users = User::with(['roles' => function($query) use($role){
                $query->where('name', $role->name);
            }]);

            foreach($users as $user){
                if($user->fcm_token != null){
                    event(new PushNotificationEvent($title, $body, $data, $user->fcm_token, $event));
                }
            }
        }

        $data['event']  =   $event;

        return [
            'title' => $title,
            'body'  => $body,
            'data'  => $data
        ];
    }

    public function getUnreadMessageCound($user){
        $connectionIds =  Message::select('connection_id')->groupBy('connection_id')
        ->where(['send_to' => auth()->id(), 'status' => 0])
        ->orwhere(function ($query){
            $query->where(['send_to' => auth()->id(), 'status' => 1]);
        })
        ->get();

    return count($connectionIds);
    }


    public function getLanguageFromTrait($language_id){

        return Lang::where('language_id', $language_id)->where('is_active', 1)->first();

      }


    public function getResponseMessage($key, $lang){
        $responseMessage = ResponseMessages::where('key_string', $key)
        ->when($lang != null, function($query) use($lang){
            $query->with(['responseMessageTranslation' => function($query) use ($lang){
                $query->select('id', 'table_name', 'column_name', 'language_id', 'translation as trr', 'record_id')
                ->where('table_name', 'response_messages')
                ->where('column_name', 'key_translation')
                ->where('language_id', $lang->language_id);
            }]);
        })->get()->toArray();

        $responseMessage = $this->setTranslation($responseMessage, 'response_message_translation', 'trr', 'key_translation');
        return $responseMessage;
    }

    public function setTranslation(array $listOfObjects, $translatedObjectKey, $translationKey, $keyToBeTranslated){
        $translatedObject = array();
        foreach($listOfObjects as $object){
            if(isset($object[$translatedObjectKey][$translationKey])){
                $object[$keyToBeTranslated] = $object[$translatedObjectKey][$translationKey];
                unset($object[$translatedObjectKey]);
                $translatedObject[] = $object;
            }else{
                $translatedObject[] = $object;
            }
        }

        return $translatedObject;
    }
    public function setTranslationmMultiColumn(array $listOfObjects, $translatedObjectKey, $translationKey){
        $translatedObject = array();
            foreach($listOfObjects as $object){
                if(isset($object[$translatedObjectKey])){
                    if(count($object[$translatedObjectKey]) > 0){
                    foreach($object[$translatedObjectKey] as $key =>  $translatedObjectKeyItem){
                            $columnName = $translatedObjectKeyItem['column_name'];
                            $object[$columnName] = $translatedObjectKeyItem[$translationKey];
                    }
                }

                unset($object[$translatedObjectKey]);
                $translatedObject[] = $object;
            }else{
                $translatedObject[] = $object;
            }
        }
        return $translatedObject;
    }

}
