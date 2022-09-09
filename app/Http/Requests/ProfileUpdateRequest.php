<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class ProfileUpdateRequest extends FormRequest
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
            'name'              => 'sometimes|required|string|max:15|min:2',
            'lastname'          =>  'sometimes|required|string|max:15',
            'gender_id'         => 'sometimes|required|numeric|gt:0',
            'university'        => 'string|max:50|nullable',
            'passion'           => 'string|max:50|nullable',
            'dob'               =>  'sometimes|date',
            'bio'               => 'string|max:250|nullable',
            'status_id'         =>  'sometimes|required',
            'have_children'     =>  'sometimes|required',
            'have_animals'      =>  'sometimes|required',
            'is_smoker'         =>  'sometimes|required',
            'country_id'        => 'sometimes|required|numeric|gt:0',
            'interested_in'     => 'sometimes|required|numeric|gt:0',
            'religion_id'       => 'numeric|nullable|gt:0',
            'language_id'       => 'sometimes|required|numeric|gt:0',
            'age'               =>  'sometimes|required',
        ];
    }

    protected function prepareForValidation(): void
    {

        if (($this->has('dob'))) {
            $this->merge([
                'age'          => \Carbon\Carbon::parse($this->dob)->diff(\Carbon\Carbon::now())->format('%y')
            ]);
        }
    }

    public function store(){
        return  User::updateOrCreate(['id' => auth()->user()->id], $this->validated());
    }
}
