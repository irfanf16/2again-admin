<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


trait FileUploadTrait
{
    public function uploadSingleImage(Request $request)
    {

        if ($request->has('file')) {

            $filNameWithExtention = $request->file('file')->getClientOriginalName();
            $fileName = pathinfo($filNameWithExtention, PATHINFO_FILENAME);
            $extention = $request->file('file')->getClientOriginalExtension();
            $image = trim(str_replace(' ', '', $fileName . '_' . time() . '.' . $extention));
            str_replace(' ', '', $image);
            $path = $request->file('file')->storeAs('/users/posts', $image, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            return $image;
        }

        return null;
    }
    public function uploadVerificationPhotos($photo)
    {
        if ($photo) {
            $filNameWithExtention = $photo->getClientOriginalName();
            $fileName = pathinfo($filNameWithExtention, PATHINFO_FILENAME);
            $extention = $photo->getClientOriginalExtension();
            $image = trim(str_replace(' ', '', $fileName . '_' . time() . '.' . $extention));
            str_replace(' ', '', $image);
            $path = $photo->storeAs('users/posts', $image, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            return $image;
        }

        return null;
    }

    public function uploadAudioMessage(Request $request)
    {
        if ($request->has('file')) {

            $filNameWithExtention = $request->file('file')->getClientOriginalName();
            $fileName = pathinfo($filNameWithExtention, PATHINFO_FILENAME);
            $extention = $request->file('file')->getClientOriginalExtension();
            $audio = trim(str_replace(' ', '', $fileName . '_' . time() . '.' . $extention));
            $path = $request->file('file')->storeAs('users/chat/audio', $audio, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            return $audio;
        }

        return null;
    }

    public function uploadIconImage(Request $request)
    {
        if ($request->has('file')) {
            $filNameWithExtention = $request->file('file')->getClientOriginalName();
            $fileName = pathinfo($filNameWithExtention, PATHINFO_FILENAME);
            $extention = $request->file('file')->getClientOriginalExtension();
            $audio = trim(str_replace(' ', '', $fileName . '_' . time() . '.' . $extention));
            $path = $request->file('file')->storeAs('icons', $audio, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            return $audio;
        }

        return null;
    }
}
