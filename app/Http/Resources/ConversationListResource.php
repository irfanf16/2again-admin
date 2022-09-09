<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConversationListResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */


    public function toArray($request)
    {

        if($this->sender == null){
            $user = $this->receiver;
            $myClearColumn = 'sender_clear';
        }else{
            $user = $this->sender;
            $myClearColumn = 'receiver_clear';
        }


        if($this->messages[0]->$myClearColumn == 1){
            $message = null;
        }else{
            $message = new MessageResource($this->messages[0]);
        }

        $response =  [
            'conversation_id'           =>  $this->id,
            'message'                   =>  $message
        ];

        $response['user'] = $user;

        return $response;
    }
}
