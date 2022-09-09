<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Traits\CheckConnectionTrait;

class UserLessInfoResource extends JsonResource
{
    use CheckConnectionTrait;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {

        $id  = auth()->id();
        $other_user = $this->id;

        $connection = $this->checkConnection($id, $other_user);

        return [
            'id'            =>  $this->id,
            'name'          =>  $this->name,
            'lastname'      =>  $this->lastname,
            'profile_pic'   =>  $this->profile_pic,
            'gender'        =>  $this->gender_id,
            'is_online'     =>  $this->is_online,
            'age'           =>  $this->setting_hide_age == 1 ? null : (int) \Carbon\Carbon::parse($this->dob)->diff(\Carbon\Carbon::now())->format('%y'),
            'connection_id' =>  $connection->id ?? null,
            'is_deleted'    =>  $this->deleted_at ? 1 : 0
        ];
    }
}
