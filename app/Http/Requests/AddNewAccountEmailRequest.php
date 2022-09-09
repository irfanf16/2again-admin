<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddNewAccountEmailRequest extends FormRequest
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
        return [
            'email'                 =>  'required|email',
            'payment_methods_id'     =>  'required|exists:payment_methods,id',
            'otp'                   =>      'required|integer'
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'otp'          => mt_rand(1000, 9999)
        ]);
    }

}
