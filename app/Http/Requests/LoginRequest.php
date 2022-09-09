<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if($this->has('email')){
            return [
                'email'             =>  'required|email|exists:users,email,deleted_at,NULL',
                'password'          =>  'required',
                'ip'                =>  'required',
                'device_type'       =>  'required',
                'latitude'          =>  'required|sometimes|nullable',
                'longitude'         =>  'required|sometimes|nullable',
                'fcm_token'         =>  'required',
                'time_zone'         =>  'required',
                'device_id'     =>  'required'
            ];
        }elseif($this->has('phone')){
            $this->phone = trim($this->phone);
            return [
                'phone'             =>  'required|exists:users,phone,deleted_at,NULL',
                'password'          =>  'required',
                'ip'                =>  'required',
                'device_type'       =>  'required',
                'latitude'          =>  'required|sometimes|nullable',
                'longitude'         =>  'required|sometimes|nullable',
                'fcm_token'         =>  'required',
                'time_zone'         =>  'required',
                'device_id'     =>  'required'
            ];
        }elseif($this->has('social_id')){
            return [
                'social_id'         =>  'required|string',
                'ip'                =>  'required',
                'device_type'       =>  'required',
                'latitude'          =>  'required|sometimes|nullable',
                'longitude'         =>  'required|sometimes|nullable',
                'fcm_token'         =>  'required',
                'time_zone'         =>  'required',
                'device_id'         =>  'required'
            ];
        }

    }

    public function createSocialUser(){
        return User::updateOrCreate(['social_id' => $this->social_id, 'verified' => 1], $this->validated());
    }
}
