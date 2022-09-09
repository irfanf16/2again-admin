<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserEditProfileResource extends JsonResource
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
            'name'                          => $this->name,
            'lastname'                      =>  $this->lastname,
            'gender'                        =>  $this->gender_id,
            'dob'                           =>  $this->dob,
            'languge'                       =>  array('id' => $this->language->id, 'name' => isset($this->language->languageTranslation->trr) ? $this->language->languageTranslation->trr : $this->language->name),
            'status'                        =>  $this->status == null ? null : (array('id' => $this->status->id, 'name' => isset($this->status->statusTranslation->trr) ? $this->status->statusTranslation->trr : $this->status->name)),
            'have_children'                 =>  $this->have_children,
            'have_animals'                  =>  $this->have_animals,
            'is_smoker'                     =>  $this->is_smoker,
            'bio'                           =>  $this->bio,
            'country'                       =>  array('id' => $this->country->id, 'name' => isset($this->country->countryTranslation->trr) ? $this->country->countryTranslation->trr : $this->country->name),
            'religion'                      =>  $this->religion == null ? null : (array('id' => $this->religion->id, 'name' => isset($this->religion->religionTranslation->trr) ? $this->religion->religionTranslation->trr : $this->religion->name)),
            'hobbies'                       =>  $this->hobbies()->select('id', 'name')->get()
        ];
    }
}
