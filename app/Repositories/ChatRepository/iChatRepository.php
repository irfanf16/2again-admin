<?php

namespace App\Repositories\ChatRepository;

use App\Http\Requests\AudioUploadRequest;
use Illuminate\Http\Request;

interface iChatRepository {

    public function sendMessage(Request $request);
    public function getConversationsList($user=null);
    public function getConversationMessages($connection_id);
    public function rateReply(Request $request);
    public function readAll($connection_id);
    public function getAccessToken(Request $request, $identity);
    public function clearChat($user_id);
    public function getVideoAccessToken();
    public function getConnection($sender_id, $receiver_id);
    public function callHistory($user=null);
    public function translate(Request $request);
}
