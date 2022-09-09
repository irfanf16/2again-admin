<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait ProfileCompletionTrait
{

    public function getProfileCompletion($user = null){

        $user = $user == null ? auth()->user() : $user;

        $totalFields = 20;
        $countedFields = 0;

        if($user->name != null){

            $countedFields = $countedFields + 1;
        }

        if($user->lastname != null){

            $countedFields = $countedFields + 1;
        }
        if($user->email != null){

            $countedFields = $countedFields + 1;
        }
        if($user->phone != null){
            $countedFields = $countedFields + 1;
        }
        if($user->verified != null){
            $countedFields = $countedFields + 1;
        }

        $verifiedPhotos = $user->verificationImages()->exists();

        if($verifiedPhotos){
            $countedFields = $countedFields + 1;
        }

        if($user->gender_id != null){
            $countedFields = $countedFields + 1;
        }

        if($user->religion_id != null){
            $countedFields = $countedFields + 1;
        }

        if($user->country_id != null){
            $countedFields = $countedFields + 1;
        }

        if($user->language_id != null){
            $countedFields = $countedFields + 1;
        }

        if($user->dob != null){
            $countedFields = $countedFields + 1;
        }

        if($user->bio != null){
            $countedFields = $countedFields + 1;
        }

        if($user->status_id != null){
            $countedFields = $countedFields + 1;
        }

        if(!is_null($user->have_children)){
            $countedFields = $countedFields + 1;
        }
        if(!is_null($user->have_animals)){
            $countedFields = $countedFields + 1;
        }
        if(!is_null($user->is_smoker)){
            $countedFields = $countedFields + 1;
        }
        if($user->profile_pic != null){
            $countedFields = $countedFields + 1;
        }

        $hobbies = $user->hobbies()->exists();

        if($hobbies){
            $countedFields = $countedFields + 1;
        }

        if($user->interested_in != null){
            $countedFields = $countedFields + 1;
        }

        $publicPhotos = $user->media()->where(['media_type' => 'Photo', 'is_private' => 0])->exists();
        if($publicPhotos){
            $countedFields = $countedFields + 1;
        }

        $percent = ($countedFields / $totalFields) * 100;

        return (int) $percent;

    }

}
