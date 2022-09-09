<?php

namespace App\Repositories\ChatRepository;

use App\Http\Resources\MessageResource;
use App\Repositories\ChatRepository\iChatRepository;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Connection;
use App\Traits\CheckMatchTrait;
use App\Traits\checkSubscriptionTrait;
use App\Traits\MakePaginationTrait;
use App\Traits\SpendEarnTrait;
use Twilio\Jwt\Grants\VoiceGrant;
use App\Traits\NotificationTrait;
use App\Traits\FileUploadTrait;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;
use App\Models\Call;
use App\Traits\CheckBlockTrait;
use Carbon\Carbon;


class ChatRepository implements iChatRepository
{

    use MakePaginationTrait, CheckMatchTrait, checkSubscriptionTrait, SpendEarnTrait, NotificationTrait, FileUploadTrait, CheckBlockTrait;

    public function sendMessage(Request $request)
    {
        $request->validate([
            'send_to'       =>  'exists:users,id|required',
            'type'          =>  'string|max:5|min:4|required',
            'text'          =>  'string|max:2000|required|nullable|sometimes',
            'message_id'    =>  'string|required',
            'file'        =>  'required|sometimes|required|max:20480',
        ]);

        $block = $this->getBlock($request->send_to);

        if($block){
            if($block->blocked_by == auth()->id()){
                responseNow(3, null, 'You blocked this person. Please unblock to send message');
            }
            responseNow(4, null, 'This person blocked you.');
        }

        $request['send_from'] = auth()->user()->id;

        $connection = $this->getConnection($request->send_from, $request->send_to);

        $is_matched = $this->checkMatch($request->send_to);

        if (!$connection) {
            if (!$is_matched) {
                $item = $this->getCoinSetting('DM');
                $this->checkAvailability('Gold', $item->deduct_gold_coins);
                $this->updateUserAssets('Gold', $item->deduct_gold_coins, 'Sub');
                $this->createTransaction(auth()->id(), 'sent_direct_message' , 'DEBIT', 'Gold', $item->deduct_gold_coins);
                $messageType = 'DM';
            }else{
                $messageType = 'NewMessage';
            }
            $connection = $this->createConnection($request->send_from, $request->send_to, 0);
        } else {
            if (!$is_matched) {
                $messages = $this->getConversationMessages($connection->id);
                if(count($messages) > 0){
                    $message = $messages[0];
                    $initiator = $message->send_from;
                    $receiver = $message->send_to;

                    $repliedMessage = Message::where(['send_from' => $receiver, 'send_to' => $initiator])->first();

                    if (!$repliedMessage) {
                        if ($request->send_to == $initiator) {
                            $connection->update([
                                'is_direct_reply'   =>  1
                            ]);

                            $messageType = 'RATE_DM';
                        } else {
                            $messageType = 'DM';
                        }
                    } else {
                        $messageType = 'NewMessage';
                    }

                }else{
                    $messageType = 'NewMessage';
                }

            } else {
                $messageType = 'NewMessage';
            }
        }

        $request['connection_id'] = $connection->id;

        if(!is_null($request->file)){

           $name =  $this->uploadAudioMessage($request);

           $request['attachment'] = $name;
        }

        $message = Message::create($request->all());

        $connection->updated_at = Carbon::now();

        $connection->save();

        $message['message_type'] = $messageType;
        $message['connection_id'] = $request->connection_id;

        return [
            'message'   =>  $message,
            'type'      =>  $messageType
        ];
    }

    public function getConversationsList($user=null)
    {

        if($user==null){
            $user=auth()->user()->id;
        }

         $reportList =  auth()->user()->report()->get()->pluck('reported_user');

        $conversations = Connection::with([
            'sender' => function ($query) use ($user, $reportList){
                $query->whereDoesntHave('report', function($query) use ($user){
                    $query->where('reported_user', $user);
                })->select('id', 'name', 'lastname', 'profile_pic', 'is_online', 'privacy_read_receipt')
                ->where('id', '!=', $user)
                ->whereNotIn('id', $reportList);
            },
            'receiver' => function ($query) use ($user, $reportList) {
                $query->whereDoesntHave('report', function($query) use($user){
                    $query->where('reported_user', $user);
                })
                ->select('id', 'name', 'lastname', 'profile_pic', 'is_online', 'privacy_read_receipt')
                ->where('id', '!=', $user)
                ->whereNotIn('id', $reportList);
            },
            'messages' => function ($query) {
                $query->orderBy('id', 'desc');
            }
        ])
            ->where('send_from', $user)
            ->orwhere('send_to', $user)
            ->orderBy('updated_at', 'DESC')
            ->get()
            ->map(function ($query) {
                $query->setRelation('messages', $query->messages->take(1));
                return $query;
            });

        return $conversations;
    }

    public function getConversationMessages($connection_id)
    {
        $connection = Connection::find($connection_id);
        $column = $this->getClearColumn($connection);

        $messages = Message::where('connection_id', $connection_id)
        ->where($column, '!=', 1)
        ->orderBy('id', 'DESC')->paginate(10);
        return $messages;
    }

    public function clearChat($user_id){
        $connection  = $this->getConnection(auth()->id(), $user_id);
        $column = $this->getClearColumn($connection);

        Message::where('connection_id', $connection->id)->update([
            $column => 1
        ]);

        return 1;
    }

    public function getClearColumn($connection){
        if($connection-> send_from == auth()->id()){
            $column = 'sender_clear';
        }else{
            $column = 'receiver_clear';
        }

        return $column;
    }

    public function getConnection($sender_id, $receiver_id)
    {

        return Connection::where(['send_from' => $sender_id, 'send_to' => $receiver_id])

            ->orwhere(function ($query) use ($sender_id, $receiver_id) {
                $query->where(['send_from' => $receiver_id, 'send_to' => $sender_id]);
            })

            ->first();
    }

    public function createConnection($sender_id, $receiver_id, $is_direct_reply)
    {

        return Connection::create([
            'send_from' => $sender_id,
            'send_to'   => $receiver_id,
            'is_direct_reply' => $is_direct_reply
        ]);
    }

    public function rateReply(Request $request)
    {
        $request->validate([
            'user_id'   =>  'required|exists:users,id',
            'connection_id' =>  'required|integer|exists:connections,id',
            'rate'          =>  'required|integer',
            'message_id'    =>  'required|integer'
        ]);

        $connection =  Connection::find($request->connection_id);

        if ($connection->is_direct_reply == 1) {
            $connection->update([
                'is_direct_reply'   =>  0
            ]);

            $message = Message::find($request->message_id);

            if ($request->rate == 1) {
                if (!$this->checkOtherUserSubscription(['VIP', 'BS'], $request->user_id)) {
                    $this->sendNotification($request->user_id, 'SUB_AND_EARN');
                } else {
                    $item = $this->getCoinSetting('DM');
                    $earnable = $this->checkEarningLimitPerUser(auth()->id(), $request->user_id, $item->earn_silver_coins);
                    if($earnable > 0){
                        if($earnable >= $item->earn_silver_coins){
                            $earnable = $item->earn_silver_coins;
                        }
                        $this->updateUserAssets('Silver', $earnable, 'Add', $request->user_id);
                        $this->createTransaction($request->user_id, 'direct_message_reply', 'CREDIT', 'Silver', $earnable, auth()->id());
                        $this->sendNotification($request->user_id, 'EARN_COUNTER');
                    }
                }
                $message->update([
                    'reply_rating' => 1
                ]);

            }else{
                $message->update([
                    'reply_rating' => -1
                ]);
            }

            $message = new MessageResource($message);
            return $message;

        } else {
            responseNow(0, null, 'Not a Direct Reply');
        }
    }

    public function readAll($connection_id)
    {
        Message::where(['send_to' => auth()->id(), 'connection_id' => $connection_id, ['status', '!=', 2]])->update([
            'status'  => 2
        ]);
    }

    public function getAccessToken(Request $request, $identity){

        $account_sid = getenv("TWILIO_ACCOUNT_SID");
        $apiKeySid = getenv("TWILIO_API_KEY_SID");
        $apiKeySecret = getenv("TWILIO_API_KEY_SECRET");
        $outgoingApplicationSid = env("TWILIO_SID");
        // $push_sid   = env('TWILIO_PUSH_SID');
        // $push_sid_ios = env('TWILIO_PUSH_SID_IOS');

        if($request->device_type == 'IOS'){
            $push_sid = env('TWILIO_PUSH_SID_IOS');
        }elseif($request->device_type == 'ANDROID'){
            $push_sid   = env('TWILIO_PUSH_SID');
        }else{
            responseNow(0, null, 'Invalid device type');
        }

        // $identity = uniqid();

        $token = new AccessToken(
            $account_sid,
            $apiKeySid,
            $apiKeySecret,
            3600,
            $identity
        );

        if($request->call_type == 'AUDIO'){

            // Create Voice grant
            $voiceGrant = new VoiceGrant();
            $voiceGrant->setOutgoingApplicationSid($outgoingApplicationSid);
            $voiceGrant->setPushCredentialSid($push_sid);

            // Optional: add to allow incoming calls
            $voiceGrant->setIncomingAllow(true);

            $token->addGrant($voiceGrant);

        }elseif($request->call_type == 'VIDEO'){

            //  Grant access to Video
            $video = new VideoGrant();
            $video->setRoom($request->room_id);
            $token->addGrant($video);

        }else{
            responseNow(0, null, 'Invalid call type');
        }

         // Grant access to Video
        //  $grant = new VideoGrant();
        //  $grant->setRoom('cool room');
        //  $token->addGrant($grant);

        return $token->toJWT();
    }


    public function getVideoAccessToken(){

        $account_sid = getenv("TWILIO_ACCOUNT_SID");
        $apiKeySid = getenv("TWILIO_API_KEY_SID");
        $apiKeySecret = getenv("TWILIO_API_KEY_SECRET");

        // $identity = uniqid();
        $identity = auth()->user()->id;

        $token = new AccessToken(
            $account_sid,
            $apiKeySid,
            $apiKeySecret,
            3600,
            $identity
        );

        return $token->toJWT();
    }

    public function callHistory($user=null){
        if($user==null){
            $user= auth()->id();
        }

        Call::where('call_to', auth()->id())->where('has_seen', 0 )->update([
            'has_seen'  =>  1
        ]);

       $calls =  Call::with([
            'caller' => function($query){
            $query->withTrashed();
        },
       'receiver' => function($query){
           $query->withTrashed();
       }])
       ->whereHas('caller', function($query){
           $query;
       })
       ->where(['call_from' => $user])
        ->orwhere(function ($query) use($user){
            $query->where(['call_to' => $user]);
        })->latest()
        ->get();

       return $calls;
    }

    public function translate(Request $request)
    {

        $message = Message::where('message_id', $request->message_id)->first();

        $tr = new GoogleTranslate('en');
        $language = auth()->user()->language()->first();
        $tr->setSource(); // Detect language automatically
        $tr->setTarget($language->short); // Translate to Georgian

       $text =  $tr->translate($message->text);

       $message->text = $text;
       $message = MessageResource::make($message);
       return $message;

    }

}
