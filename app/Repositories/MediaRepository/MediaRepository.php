<?php

namespace App\Repositories\MediaRepository;

use App\Http\Requests\MediaUploadRequest;
use App\Models\AppSetting;
use App\Repositories\MediaRepository\iMediaRepository;
use Illuminate\Http\Request;
use App\Models\Media;
use App\Models\User;
use App\Traits\FileUploadTrait;
use App\Traits\SpendEarnTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Repositories\RekognitionRepository\iRekognitionRepository;
use App\Traits\NotificationTrait;
use App\Traits\checkSubscriptionTrait;

class MediaRepository implements iMediaRepository {

    use SoftDeletes, FileUploadTrait, SpendEarnTrait, NotificationTrait, checkSubscriptionTrait;

    private $rekognition;

    public function __construct(iRekognitionRepository $rekognition)
    {
        $this->rekognition = $rekognition;
    }

    public function add(MediaUploadRequest $request)
    {
        if($request->is_private == 0){
            $result = $this->rekognition->checkFaceExists($request->file('file'));
            if(!$result){
                return 0;
            }

            $result = $this->rekognition->profileFaceMatch($request->file('file'));

            if(!$result){
                return -1;
            }

        }

        if ($image = $this->uploadSingleImage($request)) {
            $request['name'] = $image;

           return auth()->user()->media()->create($request->all());
        }
    }
    public function visitGallery(Request $request)
    {
        $request->validate([
            'user_id'           => 'exists:users,id|required',
            'gallery_type'      =>  'string|required'
        ]);

        if ($request->gallery_type == 'Photo') {

            $gallery = Media::select('id', 'name', 'media_type')->where(['user_id' => $request->user_id, 'media_type' => 'Photo', 'is_private' => 1])->get();
            if ($gallery->isEmpty()) {
                if($request->user_id == auth()->id()){
                    return 'you_do_not_have_any_photo_in_your_folder_yet';
                }else{
                    return 'this_user_does_not_have_any_photo_in_gallery';

                }
            }

            if($request->user_id != auth()->user()->id){

                $item = $this->getCoinSetting('Photo');
                $this->checkAvailability('Gold', $item->deduct_gold_coins);

                $this->updateUserAssets('Gold', $item->deduct_gold_coins, 'Sub');
                $this->createTransaction(auth()->user()->id, 'visit_photo_gallery', 'DEBIT', 'Gold', $item->deduct_gold_coins);

                if($this->checkOtherUserSubscription(['VIP', 'BS'], $request->user_id)){

                    $earnable = $this->checkEarningLimitPerUser(auth()->id(), $request->user_id, $item->earn_silver_coins);
                    if($earnable > 0){
                        if($earnable >=  $item->earn_silver_coins){
                            $earnable = $item->earn_silver_coins;
                        }
                        $this->updateUserAssets('Silver', $earnable, 'Add', $request->user_id);
                        $this->createTransaction($request->user_id, 'visit_photo_gallery', 'CREDIT', 'Silver', $earnable, auth()->id());
                        $this->sendNotification($request->user_id, 'EARN_COUNTER');
                    }

                }else{
                    $this->sendNotification($request->user_id, 'SUB_AND_EARN');
                }

            }

            return [
                'message'   =>  'List of Private Photos',
                'data'      =>  ['gallery'  =>  $gallery, 'gold_coin' => auth()->user()->gold_coin, 'public_photo_count' => 0]
            ];

        } elseif ($request->gallery_type == 'Video') {


            $gallery = Media::select('id', 'name', 'media_type')->where(['user_id' => $request->user_id, 'media_type' => 'Video', 'is_private' => 1])->get();

            if ($gallery->isEmpty()) {

                if($request->user_id == auth()->id()){
                    return 'you_do_not_have_any_video_in_your_folder_yet';
                }else{
                    return 'this_user_does_not_have_any_video_in_gallery';
                }
            }
            if($request->user_id != auth()->user()->id){
                $item = $this->getCoinSetting('Video');
                $this->checkAvailability('Gold', $item->deduct_gold_coins);

                $this->updateUserAssets('Gold', $item->deduct_gold_coins, 'Sub');
                $this->createTransaction(auth()->user()->id, 'visit_video_gallery', 'DEBIT', 'Gold', $item->deduct_gold_coins);

                if($this->checkOtherUserSubscription(['VIP', 'BS'], $request->user_id)){
                    $earnable = $this->checkEarningLimitPerUser(auth()->id(), $request->user_id, $item->earn_silver_coins);
                    if($earnable > 0){
                        if($earnable >=  $item->earn_silver_coins){
                            $earnable = $item->earn_silver_coins;
                        }
                        $this->updateUserAssets('Silver', $earnable, 'Add', $request->user_id);
                        $this->createTransaction($request->user_id, 'visit_video_gallery', 'CREDIT', 'Silver', $earnable, auth()->id());
                        $this->sendNotification($request->user_id, 'EARN_COUNTER');
                    }

                }else{
                    $this->sendNotification($request->user_id, 'SUB_AND_EARN');
                }

            }
            return [
                'message'   =>  'List of Private Videos',
                'data'      =>  ['gallery'  =>  $gallery, 'gold_coin' => auth()->user()->gold_coin, 'public_photo_count' => 0]
            ];

        }elseif($request->gallery_type == 'PublicPhoto'){
            $photoCount = AppSetting::where('shortcode', 'PPL')->first();
            $gallery = Media::select('id', 'name', 'media_type')->where(['user_id' => $request->user_id, 'media_type' => 'Photo', 'is_private' => 0])->get();
            if ($gallery->isEmpty()) {

                if($request->user_id != auth()->id()){
                    $message = 'This user does not have any Photo in gallery';
                    responseNow(0, 'show popup', $message);
                }

            }

            return [
                'message'   =>  'List of Public Photos',
                'data'      =>  ['gallery'  =>  $gallery, 'gold_coin' => auth()->user()->gold_coin, 'public_photo_count' =>  (int) $photoCount->value2]
            ];

        } else {
            responseNow(0, null, 'Invalid gallery type');
        }
    }

    public function delete(Request $request){
        $request->validate([
            'media_id'      =>  'exists:media,id'
        ]);

        $media = auth()->user()->media()->find($request->media_id);

        if (!$media) {
            return responseNow(0, null, 'Invalid Media id', 400);
        }

        if($media->is_private == 1){
            if($media->media_type == 'Photo'){
                $availablePhotoSlots = auth()->user()->available_photo_count;
                $availablePhotoSlots = $availablePhotoSlots - 1;
                auth()->user()->update([
                    'available_photo_count' => $availablePhotoSlots
                ]);
            }

            if($media->media_type == 'Video'){
                $availableVideoSlots = auth()->user()->available_video_count;
                $availableVideoSlots = $availableVideoSlots - 1;
                auth()->user()->update([
                    'available_video_count' => $availableVideoSlots
                ]);
            }
        }

        $media->delete();

        return 1;
    }

    public function rateGallery(Request $request)
    {
        $request->validate([
            'user_id'           => 'exists:users,id|required',
            'gallery_type'      =>  'string|required',
            'rate'               =>  'integer|required'
        ]);

        $user = User::find($request->user_id);
        $action = null;

        if ($request->rate == 1) {
            $action = 'like';
            if ($request->gallery_type == 'Photo') {
                $user->photo_gallery_likes += 1;
                $user->save();
            } elseif ($request->gallery_type == 'Video') {
                $user->video_gallery_likes += 1;
                $user->save();
            } else {
                responseNow(0, null, 'Invalid Gallery Type');
            }
        } elseif ($request->rate == 0) {
            $action = 'dislike';
            if ($request->gallery_type == 'Photo') {
                $user->photo_gallery_dislikes += 1;
                $user->save();
            } elseif ($request->gallery_type == 'Video') {
                $user->video_gallery_dislikes += 1;
                $user->save();
            } else {
                responseNow(0, null, 'Invalid Gallery Type');
            }
        } else {
            responseNow(0, null, 'Invalid Rate type');
        }

        return $action;
    }

    public function deleteAdmin(Request $request){
        $request->validate([
            'media_id'      =>  'required|exists:media,id'
        ]);

        $media = Media::find($request->media_id);
        if (!$media) {
            return 0;
        }

        $media->delete();

        return 1;
    }

    public function restore(Request $request)
    {
        $media = Media::withTrashed()->find($request->media_id);
        if(!$media){
            return 0;
        }

        $media->restore();

        return 1;
    }
}
