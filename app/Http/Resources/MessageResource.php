<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'message_id'            =>  $this->id,
            'message_identifier'    =>  $this->message_id,
            'send_from'             =>  $this->send_from,
            'send_to'               =>  $this->send_to,
            'type'                  =>  $this->type,
            'attachment'            =>  $this->attachment,
            'text'                  =>  $this->text,
            'time'                  =>  $this->created_at,
            'time_string'           =>  $this->created_at->diffForHumans(),
            'status'                =>  $this->status,
            'message_type'          =>  $this->message_type,
            'connection_id'         =>  $this->connection_id,
            'reply_rating'          =>  $this->reply_rating
        ];
    }
}
