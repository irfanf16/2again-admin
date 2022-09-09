<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CallHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'user'                  =>  new UserLessInfoResource($this->caller->id == auth()->id() ? $this->receiver : $this->caller),
            'is_picked_up'          =>  $this->is_picked_up,
            'call_time'             =>  $this->call_time,
            'call_type'             =>  $this->call_type,
            'is_outgoing'           =>  $this->caller->id == auth()->id() ? 1 : 0,
            'created'               =>  $this->created_at->diffForHumans()
        ];
    }
}
