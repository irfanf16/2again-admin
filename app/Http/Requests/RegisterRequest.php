<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class RegisterRequest extends FormRequest
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

        if ($this->has('social_id') && $this->filled('social_id')) {
            return [
                'social_id'     => 'required|unique:users',
                'otp'           => 'required',
                'ip'            => 'required',
                'device_type'   =>  'required',
                'verified'      => 'required',
                'latitude'      => 'required|sometimes|nullable',
                'longitude'     =>  'required|sometimes|nullable',
                'time_zone'     =>  'required',
                'device_id'     =>  'required'
            ];
        }  elseif ($this->has('phone') && $this->filled('phone')) {
            $this->phone = trim($this->phone);
            return [
                'phone'         => 'required',
                'otp'           => 'required',
                'ip'            => 'required',
                'device_type'   =>  'required',
                'latitude'      => 'required|sometimes|nullable',
                'longitude'     =>  'required|sometimes|nullable',
                'time_zone'     =>  'required',
                'device_id'     =>  'required'
            ];
        } elseif ($this->has('email') && $this->filled('email')) {
            return [
                'email'         => 'required|string|email|max:225',
                'otp'           => 'required',
                'ip'            => 'required',
                'device_type'   =>  'required',
                'latitude'      => 'required|sometimes|nullable',
                'longitude'     =>  'required|sometimes|nullable',
                'time_zone'     =>  'required',
                'device_id'     =>  'required'
            ];
        }
    }

    protected function prepareForValidation(): void
    {

        if (($this->has('social_id') && $this->filled('social_id'))) {
            $verified = 1;
        } else {
            $verified = 0;
        }

        $this->merge([
            'otp'          => mt_rand(1000, 9999),
            'verified'          => $verified,
        ]);

        if (auth()->check()) {
            $this->merge([
                'id' => auth()->user()->id
            ]);
        }
    }

    public function store()
    {
        return User::updateOrCreate(['id' => $this->id], $this->validated());
    }
}
