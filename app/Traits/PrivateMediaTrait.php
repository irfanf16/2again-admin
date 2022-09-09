<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Models\Media;

trait PrivateMediaTrait
{
    public function privatePhotos($user_id, $limit = null){

        return Media::select('name')->where(['media_type' => 'Photo', 'is_private' => 1, 'user_id' => $user_id])->limit($limit)->get();
    }

    public function privateVideos($user_id, $limit = null){
        return Media::select('name')->where(['media_type' => 'Video', 'is_private' => 1, 'user_id' => $user_id])->limit($limit)->get();
    }

    public function privatePhotoCount($user_id, $sub = null){
        $count = Media::where(['media_type' => 'Photo', 'is_private' => 1, 'user_id' => $user_id])->count();
        $rem = $count-$sub;
        if($rem < 0){
            return 0;
        }
        return $rem;
    }
    public function privateVideoCount($user_id, $sub = null){
        $count = Media::where(['media_type' => 'Video', 'is_private' => 1, 'user_id' => $user_id])->count();
        $rem = $count-$sub;
        if($rem < 0){
            return 0;
        }
        return $rem;
    }

}
