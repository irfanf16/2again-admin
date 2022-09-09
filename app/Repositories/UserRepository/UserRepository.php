<?php

namespace App\Repositories\UserRepository;

use App\Models\Like;
use App\Repositories\UserRepository\iUserRepository;
use App\Traits\TimeZoneToUTC;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use App\Traits\MakePaginationTrait;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Jobs\UserNotificationJob;
use App\Http\Requests\SetPasswordRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\UserResource;
use App\Http\Requests\ImageUploadRequest;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use App\Http\Resources\UserEditProfileResource;
use App\Http\Resources\UserDetailResource;
use App\Models\BannedUsers;
use App\Models\Block;
use Twilio\Rest\Client;
use App\Models\Role;
use App\Notifications\AddNotificationEmailOTPNotification;
use Illuminate\Support\Carbon;
use App\Models\Notification;

class UserRepository implements iUserRepository
{

    use MakePaginationTrait, FileUploadTrait,TimeZoneToUTC;

    public function nearby($lang){
        $table = 'users';
        $latitude = auth()->user()->latitude;
        $longitude = auth()->user()->longitude;
        $distance = auth()->user()->filter_radius;
        $id = auth()->user()->id;
        $user = auth()->user();
        $likesLIst = Like::select('like_to')->where('like_from', auth()->user()->id)->get()->toArray();
        $ageRange = explode("-", auth()->user()->filter_date_range);

        $myBlocks = Block::select('blocked_user')->where(['blocked_by' => auth()->id()])->get()->toArray();
        $blockedMe = Block::select('blocked_by')->where(['blocked_user' => auth()->id()])->get()->toArray();

        $banned = BannedUsers::where('time_banned_for', '>=', Carbon::now())
                                ->orWhere('banned_forever', 1)->get()->pluck('banned_user')->toArray();

        /////////////////////////////////////
        ////////////////FOR MILES///////////

        // $users = DB::select("SELECT *,

        // (SELECT GROUP_CONCAT(DISTINCT name) FROM media media WHERE media.user_id = users.id and is_private = 0 and media_type = 'Photo'
        // ) AS medias,

        //  3956 * 2 *
        // ASIN(SQRT( POWER(SIN(($latitude - latitude)*pi()/180/2),2)
        // +COS($latitude*pi()/180 )*COS(latitude*pi()/180)
        // *POWER(SIN(($longitude-longitude)*pi()/180/2),2)))
        // as distance FROM $table
        // WHERE longitude between ($longitude-$distance/cos(radians($latitude))*69)
        // and ($longitude+$distance/cos(radians($latitude))*69)
        // and latitude between ($latitude-($distance/69))
        // and ($latitude+($distance/69))
        // and verified = 1
        // and id != '$id'
        // having distance <= $distance ORDER BY distance limit 100");

        ///////////////////////////////
        ////////FOR KILOMETERS////////

        $appearFirsts = DB::table("users")
            ->select("users.*", "countries.name as countryName",

                DB::raw("
             (SELECT GROUP_CONCAT(DISTINCT name) FROM media media WHERE media.user_id = users.id and is_private = 0 and media_type = 'Photo' and deleted_at IS NULL
             ) AS medias,

             (SELECT count(*) FROM media media WHERE media.user_id = users.id and is_private = 1 and media_type = 'Photo' and deleted_at IS NULL
             ) AS totalPhotos,

             (SELECT count(*) FROM media media WHERE media.user_id = users.id and is_private = 1 and media_type = 'Video' and deleted_at IS NULL
             ) AS totalVideos,

             (SELECT id from connections where (send_from = users.id && send_to = '$id') || ( send_from = '$id' && send_to = users.id) LIMIT 1
             ) As connection_id,

             (SELECT count(*) FROM appear_firsts where user_candidate = users.id AND user_target = '$id' AND has_seen = 0)
             AS appearFirst"))
            ->where('users.id', '!=', $id)
            ->whereNull('deleted_at')
            ->whereNotIn('users.id', $likesLIst)
            ->whereNotIn('users.id', $myBlocks)
            ->whereNotIn('users.id', $blockedMe)
            ->whereNotIn('users.id', $banned)
            ->whereRaw("users.id NOT IN (SELECT reported_user from reports where reported_by = '".auth()->id()."')")
            ->whereRaw("'".auth()->id()."'"." NOT IN (SELECT reported_user from reports where reported_by = users.id)")
            ->where('users.profile_pic', '!=', null)
            ->join('countries', 'users.country_id', '=', 'countries.id')
            ->join('appear_firsts', function ($join) use ($id) {
                $join->on('users.id', '=', 'appear_firsts.user_candidate')
                    ->where('appear_firsts.user_target', '=', $id)
                    ->where('appear_firsts.has_seen', 0);
            })
            ->get();

        $sponsered = $appearFirsts->toArray();


        if($latitude && $longitude){
            $boosts = DB::table("users")
            ->select("users.*", "countries.name as countryName",

                DB::raw("
             (SELECT GROUP_CONCAT(DISTINCT name) FROM media media WHERE media.user_id = users.id and is_private = 0 and media_type = 'Photo' and deleted_at IS NULL
             ) AS medias,

             (SELECT count(*) FROM media media WHERE media.user_id = users.id and is_private = 1 and media_type = 'Photo' and deleted_at IS NULL
             ) AS totalPhotos,

             (SELECT count(*) FROM media media WHERE media.user_id = users.id and is_private = 1 and media_type = 'Video' and deleted_at IS NULL
             ) AS totalVideos,

             (SELECT id from connections where (send_from = users.id && send_to = '$id') || ( send_from = '$id' && send_to = users.id) LIMIT 1
             ) As connection_id,

             (SELECT count(*) FROM appear_firsts where user_candidate = users.id AND user_target = '$id' AND has_seen = 0)
             AS appearFirst
             "))
            ->where('users.id', '!=', $id)
            ->whereNull('deleted_at')
            ->whereNotIn('users.id', $likesLIst)
            ->whereNotIn('users.id', $myBlocks)
            ->whereNotIn('users.id', $blockedMe)
            ->whereRaw("users.id NOT IN (SELECT reported_user from reports where reported_by = '" . auth()->id() . "')")
            ->whereRaw("'" . auth()->id() . "'" . " NOT IN (SELECT reported_user from reports where reported_by = users.id)")
            ->where('users.profile_pic', '!=', null)
            ->join('countries', 'users.country_id', '=', 'countries.id')
            ->join('profile_boosts', function ($join) {
                $join->on('users.id', '=', 'profile_boosts.user_id')
                    ->where('profile_boosts.valid_till', '>', Carbon::now())
                    ->orderBy('id', 'DESC')->limit(1);
            })
            ->selectRaw('CASE profile_boosts.is_world_wide WHEN 0 THEN
                    6371 * acos(cos(radians(' . $latitude . '))
                    * cos(radians(users.latitude))
                    * cos(radians(users.longitude) - radians(' . $longitude . '))
                    + sin(radians(' . $latitude . '))
                    * sin(radians(users.latitude)))
                ELSE 0
                END AS boost_distance
             ')
            ->having('boost_distance', '>=', 'profile_boosts.radius')
            ->get();

        $boosts = $boosts->toArray();

        $sponsered = array_merge($sponsered, $boosts);

        }

        if (auth()->user()->filter_all_world) {

            $users = DB::table("users")
                ->select("users.*", "countries.name as countryName",

                    DB::raw("
             (SELECT GROUP_CONCAT(DISTINCT name) FROM media media WHERE media.user_id = users.id and is_private = 0 and media_type = 'Photo' and deleted_at IS NULL
             ) AS medias,

             (SELECT count(*) FROM media media WHERE media.user_id = users.id and is_private = 1 and media_type = 'Photo' and deleted_at IS NULL
             ) AS totalPhotos,

             (SELECT count(*) FROM media media WHERE media.user_id = users.id and is_private = 1 and media_type = 'Video' and deleted_at IS NULL
             ) AS totalVideos,

             (SELECT id from connections where (send_from = users.id && send_to = '$id') || ( send_from = '$id' && send_to = users.id) LIMIT 1
             ) As connection_id,

             (SELECT count(*) FROM appear_firsts where user_candidate = users.id AND user_target = '$id' AND has_seen = 0)
             AS appearFirst"))
             ->selectRaw('CASE users.discovery_my_language WHEN 1 THEN IF(users.language_id = '.$user->language_id.', "0", "1") WHEN 0 THEN 0 ELSE 3 END AS languageMatch')
            ->havingRaw('languageMatch = 0')
            ->where('users.id', '!=', $id)
            ->where('users.profile_pic', '!=', null)
            ->where('users.setting_is_paused', '!=', 1)
            ->when(auth()->user()->filter_big_spender_first == 1, function ($q){
                $q->selectRaw('user_subscriptions.subscription_id, subscriptions.shortcode, user_subscriptions.valid_till');
                $q->join('user_subscriptions', function($join){
                    $join->on('users.id', '=', 'user_subscriptions.user_id');
                });
                $q->join('subscriptions', function($join){
                    $join->on('subscriptions.id', '=', 'user_subscriptions.subscription_id');
                });
                $q->where('shortcode', '=', 'BS');
                $q->where('user_subscriptions.valid_till', '>', Carbon::now());
            })
            ->when(auth()->user()->interested_in != 1, function($q){
                $q->where('users.gender_id', auth()->user()->interested_in);
            })
            ->when(auth()->user()->filter_same_languge == 1, function($qr){
                $qr->where('users.language_id', auth()->user()->language_id);
            })
            ->when(auth()->user()->filter_have_children == 1, function($qr){
                $qr->where('users.have_children', auth()->user()->filter_have_children);
            })
            ->when(auth()->user()->filter_have_animals == 1, function($qr){
                $qr->where('users.have_animals', auth()->user()->filter_have_animals);
            })
            ->when(auth()->user()->filter_is_smoker == 1, function($qr){
                $qr->where('users.is_smoker', auth()->user()->filter_is_smoker);
            })
            ->when(auth()->user()->filter_my_country == 1, function($q){
                $q->where('users.country_id', auth()->user()->country_id);
            })
            ->when(auth()->user()->filter_religion == 1, function($q){
                $q->where('users.religion_id', auth()->user()->religion_id);
            })
            ->when($lang != null, function($q)use ($lang){
                $q->selectRaw('translations.translation as translatedCountry');
                $q->join('translations', function($join) use ($lang){
                    $join->on('users.country_id', '=', 'translations.record_id');
                    $join->where('translations.table_name', '=', 'country');
                    $join->where('translations.column_name', '=', 'name');
                    $join->where('translations.language_id', '=', $lang->language_id);
                });
            })
            ->where('users.age', '>=', $ageRange[0])
            ->where('users.filter_purpose', auth()->user()->filter_purpose)
            ->where('users.age', '<=', $ageRange[1])
            ->where('users.discovery_be_invisible', '=', 0)
            ->whereNull('deleted_at')
            ->whereNotIn('users.id', $likesLIst)
            ->whereNotIn('users.id', $myBlocks)
            ->whereNotIn('users.id', $blockedMe)
            ->whereRaw("users.id NOT IN (SELECT reported_user from reports where reported_by = '".auth()->id()."')")
            ->whereRaw("'".auth()->id()."'"." NOT IN (SELECT reported_user from reports where reported_by = users.id)")
            ->join('countries', 'users.country_id', '=', 'countries.id')
            ->get();

             //dd($data);
             $data = array_merge($sponsered, $users->toArray());

            $data = $this->paginate($data);

            return $data;
        } else {
            $users = DB::table("users")
                ->select("users.*", "countries.name as countryName",

                    DB::raw("
             (SELECT GROUP_CONCAT(DISTINCT name) FROM media media WHERE media.user_id = users.id and is_private = 0 and media_type = 'Photo' and deleted_at IS NULL
             ) AS medias,

             (SELECT count(*) FROM media media WHERE media.user_id = users.id and is_private = 1 and media_type = 'Photo' and deleted_at IS NULL
             ) AS totalPhotos,

             (SELECT count(*) FROM media media WHERE media.user_id = users.id and is_private = 1 and media_type = 'Video' and deleted_at IS NULL
             ) AS totalVideos,

             (SELECT id from connections where (send_from = users.id && send_to = '$id') || ( send_from = '$id' && send_to = users.id) LIMIT 1
             ) As connection_id,

             (SELECT count(*) FROM appear_firsts where user_candidate = users.id AND user_target = '$id' AND has_seen = 0)
             AS appearFirst,

            6371 * acos(cos(radians(" . $latitude . "))
            * cos(radians(users.latitude))
            * cos(radians(users.longitude) - radians(" . $longitude . "))
            + sin(radians(" . $latitude . "))
            * sin(radians(users.latitude))) AS distance"))
                ->selectRaw('CASE users.discovery_my_language WHEN 1 THEN IF(users.language_id = ' . $user->language_id . ', "0", "1") WHEN 0 THEN 0 ELSE 3 END AS languageMatch')
                ->havingRaw('languageMatch = 0')
                ->where('users.id', '!=', $id)
                ->where('users.setting_is_paused', '!=', 1)
                ->when(auth()->user()->interested_in != 1, function ($q) {
                    $q->where('users.gender_id', auth()->user()->interested_in);
                })
                ->when(auth()->user()->filter_same_languge == 1, function ($qr) {
                    $qr->where('users.language_id', auth()->user()->language_id);
                })
                ->when(auth()->user()->filter_have_children == 1, function ($qr) {
                    $qr->where('users.have_children', auth()->user()->filter_have_children);
                })
                ->when(auth()->user()->filter_have_animals == 1, function ($qr) {
                    $qr->where('users.have_animals', auth()->user()->filter_have_animals);
                })
                ->when(auth()->user()->filter_is_smoker == 1, function ($qr) {
                    $qr->where('users.is_smoker', auth()->user()->filter_is_smoker);
                })
                ->when(auth()->user()->filter_my_country == 1, function ($q) {
                    $q->where('users.country_id', auth()->user()->country_id);
                })
                ->when(auth()->user()->filter_religion == 1, function ($q) {
                    $q->where('users.religion_id', auth()->user()->religion_id);
                })
                ->where('users.profile_pic', '!=', null)
                ->where('users.discovery_be_invisible', '=', 0)
                ->when(auth()->user()->interested_in != 1, function ($q) {
                    $q->where('users.gender_id', auth()->user()->interested_in);
                })
                ->whereNull('deleted_at')
                ->whereNotIn('users.id', $likesLIst)
                ->whereNotIn('users.id', $myBlocks)
                ->whereNotIn('users.id', $blockedMe)
                ->whereRaw("users.id NOT IN (SELECT reported_user from reports where reported_by = '" . auth()->id() . "')")
                ->whereRaw("'" . auth()->id() . "'" . " NOT IN (SELECT reported_user from reports where reported_by = users.id)")
                ->orderBy('distance', 'ASC')
                ->having('distance', '<=', auth()->user()->filter_radius)
                ->join('countries', 'users.country_id', '=', 'countries.id')
                ->get();

            $data = array_merge($sponsered, $users->toArray());

            $data = $this->paginate($data);

            //dd($data);

            return $data;
        }
    }

    public function ifUserExists(RegisterRequest $request)
    {
        if ($request->has('email')) {
            $user = User::where('email', $request->email)->first();
        } else {
            $user = User::where('phone', $request->phone)->first();
        }

        if ($user) {
            if ($user->password != null) {
                return 400;
            } else {

                $user->update([
                    'otp' => mt_rand(1000, 9999)
                ]);

                if ($user->email != null) {
                    dispatch(new UserNotificationJob($user));
                } elseif ($user->phone != null) {
                    $message = 'You 2Again OTP code is ' . $user->otp;
                    $account_sid = getenv("TWILIO_ACCOUNT_SID");
                    $auth_token = getenv("TWILIO_AUTH_TOKEN");
                    $twilio_number = getenv("TWILIO_PHONE_NUMBER");
                    $client = new Client($account_sid, $auth_token);
                    $client->messages->create($user->phone,
                        ['from' => $twilio_number, 'body' => $message]);
                }
                return 1;
            }
        }
    }

    public function attachRole($userId)
    {
        $user = User::find($userId);
        $role = Role::where('name', 'User')->first();
        $user->roles()->attach($role);
    }

    public function setPassword(SetPasswordRequest $request)
    {
        $request->store();
    }

    public function updateProfile(ProfileUpdateRequest $request)
    {
        $user = $request->store();
        $user = new UserResource($user);
        return $user;
    }

    public function uploadProfilePic(ImageUploadRequest $request)
    {

        if ($image = $this->uploadSingleImage($request)) {

            if($request->has('ref_used')){
                $attributes = [
                    'profile_pic' => trim($image),
                    'ref_used'    =>    $request->ref_used
                ];
            }else{
                $attributes = ['profile_pic' => trim($image)];
            }

            auth()->user()->update($attributes);
            $url = env('MEDIA_URL');
            return array(
                'url' => $url,
                'profile_pic' => $image
            );

        } else {
            return 0;
        }
    }

    public function ProfileDetail(Request $request)
    {

        $lang = $request->lang;

        $request->validate([
            'id' => 'required|exists:users,id,deleted_at,NULL',
        ]);
        $user = User::with(['hobbies', 'country' => function($query) use($lang){
            $query->when($lang != null, function($query) use($lang){
                $query->with(['countryTranslation' => function($query) use ($lang){
                    $query->select('id', 'table_name', 'column_name', 'language_id', 'translation as trr', 'record_id')
                    ->where('table_name', 'country')
                    ->where('column_name', 'name')
                    ->where('language_id', $lang->language_id);
                }]);
            });
        },
        'language' =>function($query) use($lang){
            $query->when($lang != null, function($query) use($lang){
                $query->with(['languageTranslation' => function($query) use($lang){
                    $query->select('id', 'table_name', 'column_name', 'language_id', 'translation as trr', 'record_id')
                    ->where('table_name', 'language')
                    ->where('column_name', 'name')
                    ->where('language_id', $lang->language_id);
                }]);
            });
        },
        'religion' => function($query) use($lang){
            $query->when($lang != null, function($query) use($lang){
                $query->with(['religionTranslation' => function($query) use ($lang){
                    $query->select('id', 'table_name', 'column_name', 'language_id', 'translation as trr', 'record_id')
                    ->where('table_name', 'religion')
                    ->where('column_name', 'name')
                    ->where('language_id', $lang->language_id);
                }]);
            });
        },
        'status' => function($query) use($lang){
            $query->when($lang != null, function($query) use($lang){
                $query->with(['statusTranslation' => function($query) use ($lang){
                    $query->select('id', 'table_name', 'column_name', 'language_id', 'translation as trr', 'record_id')
                    ->where('table_name', 'status')
                    ->where('column_name', 'name')
                    ->where('language_id', $lang->language_id);
                }]);
            });
        }])
        ->find($request->id);

        $user = new UserDetailResource($user);

        return $user;
    }

    public function profile(Request $request)
    {
       $lang =  $request->lang;
        $user  = User::with(['hobbies',
        'country' => function($query) use($lang){
            $query->when($lang != null, function($query) use($lang){
                $query->with(['countryTranslation' => function($query) use ($lang){
                    $query->select('id', 'table_name', 'column_name', 'language_id', 'translation as trr', 'record_id')
                    ->where('table_name', 'country')
                    ->where('column_name', 'name')
                    ->where('language_id', $lang->language_id);
                }]);
            });
        },
        'language' =>function($query) use($lang){
            $query->when($lang != null, function($query) use($lang){
                $query->with(['languageTranslation' => function($query) use($lang){
                    $query->select('id', 'table_name', 'column_name', 'language_id', 'translation as trr', 'record_id')
                    ->where('table_name', 'language')
                    ->where('column_name', 'name')
                    ->where('language_id', $lang->language_id);
                }]);
            });
        },'religion' => function($query) use($lang){
            $query->when($lang != null, function($query) use($lang){
                $query->with(['religionTranslation' => function($query) use ($lang){
                    $query->select('id', 'table_name', 'column_name', 'language_id', 'translation as trr', 'record_id')
                    ->where('table_name', 'religion')
                    ->where('column_name', 'name')
                    ->where('language_id', $lang->language_id);
                }]);
            });
        }, 'status' => function($query) use($lang){
            $query->when($lang != null, function($query) use($lang){
                $query->with(['statusTranslation' => function($query) use ($lang){
                    $query->select('id', 'table_name', 'column_name', 'language_id', 'translation as trr', 'record_id')
                    ->where('table_name', 'status')
                    ->where('column_name', 'name')
                    ->where('language_id', $lang->language_id);
                }]);
            });
        }])->find(auth()->id());

        return new UserEditProfileResource($user);
    }

    public function pauseProfile()
    {
        $profileStatus = auth()->user()->setting_is_paused;
        if ($profileStatus == 0) {
            auth()->user()->setting_is_paused = 1;
            auth()->user()->save();
            return 1;
        } else {
            auth()->user()->setting_is_paused = 0;
            auth()->user()->save();
            return 0;
        }
    }

    public function deleteProfile()
    {
        auth()->user()->tokens()->delete();
        auth()->user()->delete();
        return 1;
    }

    public function beInvisible()
    {
        $profileStatus = auth()->user()->discovery_be_invisible;
        if ($profileStatus == 0) {
            auth()->user()->discovery_be_invisible = 1;
            auth()->user()->save();
            return 1;
        } else {
            auth()->user()->discovery_be_invisible = 0;
            auth()->user()->save();
            return 0;
        }
    }

    public function myLanguage()
    {
        $profileStatus = auth()->user()->discovery_my_language;
        if ($profileStatus == 0) {
            auth()->user()->discovery_my_language = 1;
            auth()->user()->save();
            return 1;
        } else {
            auth()->user()->discovery_my_language = 0;
            auth()->user()->save();
            return 0;
        }
    }

    public function filterGender(Request $request)
    {
        $request->validate([
            'gender_id' => 'required|exists:genders,id|integer'
        ]);

        auth()->user()->update([
            'interested_in' => $request->gender_id
        ]);

        return 1;
    }

    public function ageRange(Request $request)
    {

        $request->validate([
            'age_from' => 'required|integer',
            'age_to' => 'required|integer'
        ]);

        $combined = $request->age_from . '-' . $request->age_to;

        auth()->user()->update([
            'filter_date_range' => $combined
        ]);

        return $combined;
    }

    public function distance(Request $request)
    {
        $request->validate([
            'radius' => 'required|integer'
        ]);

        auth()->user()->update([
            'filter_radius' => $request->radius
        ]);

        return 1;
    }

    public function allWorld()
    {
        $filterCheck = auth()->user()->filter_all_world;

        if ($filterCheck == 0) {
            auth()->user()->filter_all_world = 1;
            auth()->user()->save();
            return 1;
        }

        auth()->user()->filter_all_world = 0;
        auth()->user()->save();
        return 0;
    }

    public function lookingFor(Request $request)
    {
        $request->validate([
            'looking' => 'required|string'
        ]);

        if ($request->looking != 'Dating' && $request->looking != 'Marriage') {
            responseNow(0, null, 'Invalid looking type');
        }

        auth()->user()->update([
            'filter_purpose' => $request->looking
        ]);

        return 1;
    }

    public function peopleFromMyReligion(Request $request)
    {

        $filterCheck = auth()->user()->filter_religion;

        if ($filterCheck == 0) {
            auth()->user()->filter_religion = 1;
            auth()->user()->save();
            return 1;
        }

        auth()->user()->filter_religion = 0;
        auth()->user()->save();
        return 0;
    }

    public function peopleFromMyCountry()
    {
        $filterCheck = auth()->user()->filter_my_country;

        if ($filterCheck == 0) {
            auth()->user()->filter_my_country = 1;
            auth()->user()->save();
            return 1;
        }

        auth()->user()->filter_my_country = 0;
        auth()->user()->save();
        return 0;
    }

    public function peopleWithSameLanguage()
    {
        $filterCheck = auth()->user()->filter_same_languge;

        if ($filterCheck == 0) {
            auth()->user()->filter_same_languge = 1;
            auth()->user()->save();
            return 1;
        }

        auth()->user()->filter_same_languge = 0;
        auth()->user()->save();
        return 0;
    }

    public function peopleWithChildren()
    {
        $filterCheck = auth()->user()->filter_have_children;

        if ($filterCheck == 0) {
            auth()->user()->filter_have_children = 1;
            auth()->user()->save();
            return 1;
        }

        auth()->user()->filter_have_children = 0;
        auth()->user()->save();
        return 0;
    }

    public function peopleWithAnimals()
    {
        $filterCheck = auth()->user()->filter_have_animals;

        if ($filterCheck == 0) {
            auth()->user()->filter_have_animals = 1;
            auth()->user()->save();
            return 1;
        }

        auth()->user()->filter_have_animals = 0;
        auth()->user()->save();
        return 0;
    }

    public function peopleSmokers()
    {
        $filterCheck = auth()->user()->filter_is_smoker;

        if ($filterCheck == 0) {
            auth()->user()->filter_is_smoker = 1;
            auth()->user()->save();
            return 1;
        }

        auth()->user()->filter_is_smoker = 0;
        auth()->user()->save();
        return 0;
    }

    public function peopleBigSpenderFirst()
    {
        $filterCheck = auth()->user()->filter_big_spender_first;

        if ($filterCheck == 0) {
            auth()->user()->filter_big_spender_first = 1;
            auth()->user()->save();
            return 1;
        }

        auth()->user()->filter_big_spender_first = 0;
        auth()->user()->save();
        return 0;
    }


    public function sound()
    {
        $filterCheck = auth()->user()->setting_sound;

        if ($filterCheck) {
            auth()->user()->setting_sound = 0;
            auth()->user()->save();
            return 0;
        }

        auth()->user()->setting_sound = 1;
        auth()->user()->save();
        return 1;
    }

    public function vibrate()
    {
        $filterCheck = auth()->user()->setting_vibration;

        if ($filterCheck) {
            auth()->user()->setting_vibration = 0;
            auth()->user()->save();
            return 0;
        }

        auth()->user()->setting_vibration = 1;
        auth()->user()->save();
        return 1;
    }

    public function hideAge()
    {
        $filterCheck = auth()->user()->setting_hide_age;

        if ($filterCheck) {
            auth()->user()->setting_hide_age = 0;
            auth()->user()->save();
            return 0;
        }

        auth()->user()->setting_hide_age = 1;
        auth()->user()->save();
        return 1;
    }


    public function readReceipt()
    {
        $filterCheck = auth()->user()->privacy_read_receipt;

        if ($filterCheck) {
            auth()->user()->privacy_read_receipt = 0;
            auth()->user()->save();
            return 0;
        }

        auth()->user()->privacy_read_receipt = 1;
        auth()->user()->save();
        return 1;
    }

    public function lastActiveStatus()
    {
        $filterCheck = auth()->user()->privacy_last_active_status;

        if ($filterCheck) {
            auth()->user()->privacy_last_active_status = 0;
            auth()->user()->save();
            return 0;
        }

        auth()->user()->privacy_last_active_status = 1;
        auth()->user()->save();
        return 1;
    }

    public function setNotificationSettings($userId)
    {

        User::find($userId)->userNotificationSettings()->create([]);
    }

    public function notificationSettings(Request $request)
    {

        $request->validate([
            'notification' => 'required'
        ]);

        $notification = $request->notification;

        $filterCheck = auth()->user()->UserNotificationSettings()->first()->$notification;

        if ($filterCheck) {
            auth()->user()->UserNotificationSettings()->update([
                $notification => 0
            ]);

            return 0;
        }

        auth()->user()->UserNotificationSettings()->update([
            $notification => 1
        ]);

        return 1;
    }

    public function looking(array $lookings)
    {
        auth()->user()->looking()->sync($lookings);
        return $lookings;
    }

    public function boostWorldWide()
    {
        $filterCheck = auth()->user()->discovery_world_wide_boost;

        if ($filterCheck) {
            auth()->user()->discovery_world_wide_boost = 0;
            auth()->user()->save();
            return 0;
        }

        auth()->user()->discovery_world_wide_boost = 1;
        auth()->user()->save();
        return 1;
    }

    public function boostRadius(Request $request)
    {

        $request->validate([
            'radius' => 'required|integer'
        ]);

        auth()->user()->discover_boost_radius = $request->radius;
        auth()->user()->save();

        return $request->radius;
    }

    public function getNotifications(){
        // return  auth()->user()->notifications()->orderBy('id', 'DESC')->paginate(10);
        $notifications = Notification::where('user_id', auth()->id())
        ->orWhere(function($query){
            $query->where('user_id', null);
            $query->where('created_at', '>=', auth()->user()->created_at);
        })
        ->orderBy('id', 'DESC')
        ->paginate(10);
        return $notifications;
    }

    public function markAsReadNotification(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:notifications,id'
        ]);

        $notification = auth()->user()->notifications()->where('id', $request->id)->first();

        if (!$notification) {

            return 1;
        }

        $notification->update([
            'is_read' => 1
        ]);

        return 1;
    }

    public function markAllAsReadNotification()
    {

        auth()->user()->notifications()->update([
            'is_read' => 1
        ]);

        return 1;
    }


    public function changePassword(Request $request)
    {

        return User::find($request->user_id)->update([
            'password' => $request->password
        ]);

    }

    public function ban($request)
    {
        if ($request->action == 1) {
            BannedUsers::create($request->all());
            $user = User::findOrFail($request->user_id);
            $user->fcm_token=null;
            $user->tokens()->delete();
            $user->save();
//            $user->update(['fcm_token' => null]);
            return 1;

        } elseif ($request->action == 0) {
            $bann = BannedUsers::where('banned_user', $request->user_id)->delete();
            return 1;
        } else {
            return null;
        }
    }

    public function updateUserProfile($request)
    {
        if ($request->hasFile('file')) {
            $file = $this->uploadSingleImage($request);
            $request['profile_pic'] = $file;
        }
        $user = User::find($request->id)->update($request->all());
        return $user;
    }

    public function addNotificationEmail($email)
    {
        auth()->user()->update([
            'otp' => mt_rand(1000, 9999)
        ]);


        $user = User::find(auth()->id());

        $user->email = $email;

        $user->notify(new AddNotificationEmailOTPNotification($user));

        return 1;

    }

    public function verifyNotificationEmail(Request $request)
    {
        if (auth()->user()->otp != $request->otp) {
            return 0;
        }

        auth()->user()->update([
            'email' => $request->email
        ]);

        return 1;
    }

}
