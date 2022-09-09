<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MediaUploadRequest extends FormRequest
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
            'media_type'    => 'required|string',
            'is_private'    => 'required|boolean',
            'file'          => 'mimes:jpeg,jpg,png,mp43gpp,3gp,ts,mp4,mpeg,mpg,mov,webm,flv,m4v,mng,asx,asf,wmv,avi|required|max:20480'
        ];
    }
}
