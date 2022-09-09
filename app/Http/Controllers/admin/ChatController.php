<?php

namespace App\Http\Controllers\admin;

use App\Events\SendMessageEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\CallHistoryResource;
use App\Http\Resources\ConversationListResource;
use App\Http\Resources\MessageResource;
use App\Http\Resources\UserLessInfoResource;
use App\Models\Connection;
use App\Models\Message;
use App\Models\User;
use App\Repositories\ChatRepository\iChatRepository;
use Illuminate\Http\Request;

class ChatController extends Controller
{

    private $message;

    public function __construct(iChatRepository $message)
    {
        $this->message = $message;
    }

    public function getConversationsList($user)
    {
         $conversations = $this->message->getConversationsList($user);
        $conversations = ConversationListResource::collection($conversations);
        $audio_url = env('AUDIO_MESSAGE_URL');
        return $this->response(['ResponseCode' => 1, 'ResponseMessage' => 'List of conversations',
            'data' => ['audio_url' => $audio_url, 'conversations' => $conversations]], 200);
    }

    public function getConversationMessages(Request $request)
    {
        $request->validate([
            'connection_id' => 'exists:connections,id'
        ]);

        $messages = $this->message->getConversationMessages($request->connection_id);
        $this->message->readAll($request->connection_id);

//        $messages = MessageResource::collection($messages);

        if(isset($messages[0])){
            $singleMessage = $messages[0];
            if($singleMessage->send_to == $request->sender_id){
                $sender_id  =   $singleMessage->send_from;
            }else{
                $sender_id = $singleMessage->send_to;
            }
            $sender = User::find($sender_id);
            $sender = new UserLessInfoResource($sender);
        }else{
            $sender = null;
        }
        $connection = Connection::find($request->connection_id);
        $sender = new UserLessInfoResource($sender);

        return $this->response(['ResponseCode' => 1, 'ResponseMessages' => 'List of Messages', 'data' => ['sender' => $sender, 'is_direct_reply' => $connection->is_direct_reply, 'conversation' => $messages]], 200);
    }
    public function callHistory($user){
        $history = $this->message->callHistory($user);
        return response()->success(1, 'call history', $history);
    }
}
