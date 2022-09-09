<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Country;
use App\Models\Gender;
use App\Models\InAppTransaction;
use App\Models\Language;
use App\Models\Media;
use App\Models\Religion;
use App\Models\Shop;
use App\Models\Subscription;
use App\Repositories\ShopRepository\iShopRepository;
use App\Traits\checkSubscriptionTrait;
use App\Traits\FileUploadTrait;
use App\Traits\TimeZoneToUTC;
use App\Traits\TransactionTrait;
use Illuminate\Support\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Traits\GetUserSubscriptionTrait;
use App\Repositories\UserRepository\iUserRepository;

class ManageUsersController extends Controller
{

    use GetUserSubscriptionTrait, FileUploadTrait, TimeZoneToUTC, TransactionTrait;

    private $user;

    public function __construct(iUserRepository $user, iShopRepository $shop)
    {
        $this->user = $user;
        $this->shop = $shop;

    }

    public function manageUsersView()
    {

        $urlProfile = env('MEDIA_URL');
        $subscription = Subscription::where('shortcode', '=', 'CUSTOM')->first();
        $countries = Country::all();

        return view('admin.pages.appUsers.manageUsers')->with(compact('urlProfile', 'countries', 'subscription'));
    }

    public function usersForDatatable(Request $request)
    {
        if ($request->ajax()) {
            $zone = Cookie::get('zone');

            $data = User::withTrashed()->with(['country', 'roles'=>function($query){

            }, 'banned'])
                ->whereHas('roles', function ($q) {
                $q->where('name', 'User');
            })
//                ->whereHas('banned',function ($q) use ($zone){
//               return $q->where($this->TimeZoneToLocal($q->time_banned_for, $zone),'>=', $this->TimeZoneToLocal(Carbon::now(), $zone));
//            })
                ->where('profile_pic', '!=', null)
                ->when($request->has('gender') && $request->filled('gender'), function ($q) use ($request) {
                    return $q->where('gender_id', $request->gender)->where('gender_id', '!=', null);
                })
                ->when($request->has('date1') && $request->filled('date1') && $request->has('date2') && $request->filled('date2'), function ($q) use ($request) {
                    return $q->whereDate('created_at', '>=', $request->date1)->whereDate('created_at', '<=', $request->date2);
                })
                ->when($request->has('country') && $request->filled('country'), function ($q) use ($request) {
                    return $q->where('country_id', $request->country);
                })
                ->when($request->has('Onlinenow') && $request->get('Onlinenow') == 1, function ($q) use ($request) {
                    return $q->where('is_online', '=', 1)->where('deleted_at', '=', null);
                })
                ->when($request->has('age1') && $request->filled('age1') && $request->has('age2') && $request->filled('age2'), function ($q) use ($request) {
                    return $q->where('age', '>=', $request->age1)->where('age', '<=', $request->age2);
                })
                ->when($request->has('vip') && $request->filled('vip') && $request->vip == 1, function ($q) use ($request) {
                    return $q->where('deleted_at','=',null)->with(['subscription'])->whereHas('subscription', function ($query) {
                        $query->where('shortcode', 'VIP')->where('valid_till', '>=', Carbon::now());
                    });
                })
                ->when($request->has('bigSpender') && $request->filled('bigSpender') && $request->bigSpender == 1, function ($q) use ($request) {
                    return $q->where('deleted_at','=',null)->with(['subscription'])->whereHas('subscription', function ($query) {
                        $query->where('shortcode', 'BS')->where('valid_till', '>=', Carbon::now());
                    });
                })
                ->when($request->has('customBadge') && $request->filled('customBadge') && $request->customBadge == 1, function ($q) use ($request) {
                    return $q->where('deleted_at','=',null)->with(['subscription'])->whereHas('subscription', function ($query) {
                        $query->where('shortcode', 'CUSTOM')->where('valid_till', '>=', Carbon::now());
                    });
                })
                ->when($request->has('gam') && $request->filled('gam') && $request->gam == 1, function ($q) use ($request) {
                    return $q->where('deleted_at','=',null)->with(['subscription'])
                        ->whereDoesntHave('subscription', function ($query) {
                            $query->where('shortcode', 'BS')->where('valid_till', '>=', Carbon::now());
                        })
                        ->whereDoesntHave('subscription', function ($query) {
                            $query->where('shortcode', 'VIP')->where('valid_till', '>=', Carbon::now());
                        });
                })
                ->when($request->has('bannedUsers') && $request->filled('bannedUsers') && $request->bannedUsers == 1, function ($q) use ($request, $zone) {
//                    return $q->whereHas('banned');

                    return $q->whereHas('banned', function ($query) use ($zone) {
                        $query->where('time_banned_for', '>=', Carbon::now())->orwhere('banned_forever',1);
                    });
                })
                ->when($request->has('deletedUsers') && $request->filled('deletedUsers') && $request->deletedUsers == 1, function ($q) use ($request) {
                    return $q->where('deleted_at', '!=', null);
                })
                ->when($request->has('accountStatus') && $request->filled('accountStatus'), function ($q) use ($request, $zone) {
                    if ($request->accountStatus == 'deleted') {
                        return $q->where('deleted_at', '!=', null);
                    }
                    if ($request->accountStatus == 'banned') {
//                        return $q->whereHas('banned');
                        return $q->whereHas('banned', function ($query) use ($zone) {
                            $query->where('time_banned_for', '>=', Carbon::now())->orwhere('banned_forever',1);
                        });
//                        return $q->whereHas('banned',function ($query) use($zone){
//                            $query->where($this->TimeZoneToLocal($query->banned->time_banned_for, $zone),'>=', $this->TimeZoneToLocal(Carbon::now(), $zone));
//                        });
                    }
                    if ($request->accountStatus == 'active') {
                        return $q->where('deleted_at', '=', null)->whereDoesntHave('banned',function ($query){
                            $query->where('time_banned_for', '>=', Carbon::now())->orwhere('banned_forever',1);
                        });
                    }

                })
                ->latest()->get();
            $app_user_change_password=0;
            $app_user_ban=0;
            $app_user_unban=0;
            $app_user_delete=0;
            $app_user_recover=0;
            if($request->user()->can('app-user-change-password')){
                $app_user_change_password=1;
            }
            if($request->user()->can('app-user-ban')){
                $app_user_ban=1;
            }
            if($request->user()->can('app-user-unban')){
                $app_user_unban=1;
            }
            if($request->user()->can('app-user-delete')){
                $app_user_delete=1;
            } if($request->user()->can('app-user-recover')){
                $app_user_recover=1;
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->toDayDateTimeString();
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->created_at->toDayDateTimeString();
                })
                ->addColumn('country', function ($row) {
                    return $row->country->name ?? 'N/A';
                })
                ->addColumn('status', function ($row) use ($zone) {
                    if ($row->deleted_at == null) {
                        if ($row->banned != null) {
//                            if ($this->TimeZoneToLocal($row->banned->time_banned_for, $zone) >= $this->TimeZoneToLocal(Carbon::now(), $zone)) {
                            if($row->banned->banned_forever==1){
                                return 'Banned';
                            }
                            if ($row->banned->time_banned_for >= Carbon::now()) {
                                return 'Banned';
                            }
                            return 'Active';
                        } else {
                            return 'Active';
                        }
                    }else if($row->deleted_at != null && $row->banned != null){
                        return 'Banned, Deleted';
                    }
                    else {
                        return 'Deleted';
                    }
                })
                ->addColumn('action', function ($row) use($app_user_change_password,$app_user_ban,$app_user_unban,$app_user_delete,$app_user_recover){

//                    if($app_user_change_password==1 || $app_user_ban==1 || $app_user_unban==1 || $app_user_delete==1 || $app_user_recover==1){
                        $changePassword='';
                        $banUser='';
                        $unbanUser='';
                        $deleteAccount='';
                        $recoveryAccount='';
                        if($app_user_change_password==1){
                            $changePassword=' <li><a  href="" class="change_password"  data-user="' . $row->id . '">  Change password</a></li>';
                        }
                        if($app_user_ban==1){
                            $banUser=' <li><a id="banUserModalBtn"  href="" class="ban_user" data-user="' . $row->id . '" >Ban user</a></li>';
                        }
                        if($app_user_unban==1){
                            $unbanUser=' <li><a id="banUserModalBtn"  href="" class="unBan_user" data-user="' . $row->id . '">UnBan user</a></li>';
                        }
                        if($app_user_delete==1){
                            $deleteAccount='  <li><a  href="" class="delete_user"  data-user="' . $row->id . '">Delete account</a></li>';
                        } if($app_user_recover==1){
                            $recoveryAccount=' <li><a  href="" class="recover_user"  data-user="' . $row->id . '"> Recover User</a></li>';
                        }

                        if ($row->deleted_at == null) {
                            if ($row->banned != null) {
                                if($row->banned->banned_forever==1){
                                    $is_ban = $unbanUser.$deleteAccount;
                                } elseif ($row->banned->time_banned_for >= Carbon::now()) {
                                    $is_ban = $unbanUser.$deleteAccount;
                                }else{
                                    $is_ban =$changePassword.$banUser.$deleteAccount;
                                }
                            }else{
                                $is_ban =$changePassword.$banUser.$deleteAccount;
                            }
                            $actionBtn = '<div class="dropdown">
                                    <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        ' . $is_ban . '
                                    </ul>
                                </div>';
                        } else {
                            $actionBtn = '<div class="dropdown">
                                    <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        '.$recoveryAccount.'
                                    </ul>
                                </div>';
                        }
                        return $actionBtn;
//                    }else{
//                        return 'No Action';
//                    }

                })
                ->addColumn('user', function ($row) use ($zone) {
                    $urlProfile = env('MEDIA_URL');
                    $is_online = '';
                    if ($row->deleted_at == null) {
                        if ($row->banned != null) {

                            if($row->banned->banned_forever==1){
                                $is_online='';
                            }else{
                                if ($this->TimeZoneToLocal($row->banned->time_banned_for, $zone) >= $this->TimeZoneToLocal(Carbon::now(), $zone)) {
                                    $is_online = ' ';
                                }else{
                                    $is_online = $row->is_online == 0 ? '<span class="active-status bg-red">' : ' <span class="active-status bg-green">';
                                }
                            }


                        } else {
                            $is_online = $row->is_online == 0 ? '<span class="active-status bg-red">' : ' <span class="active-status bg-green">';
                        }
                    }
                    $image = '    <div class="user-profile">
                                    <div class="user-img">
                                        <a href="' . route('admin.manage.users.detail', $row->id) . '" style="background-image: url( '. $urlProfile . $row->profile_pic .')"></span></a>
                                          ' . $is_online . '
                                        </div>
                                        <div class="description">
                                            <a href="' . route('admin.manage.users.detail', $row->id) . '"> <div class="user-title">  ' . $row->name . ' ' . $row->lastname . '  </div></a>

                                        </div>
                                    </div>';
                    return $image;
                })
                ->rawColumns(['action', 'user'])
                ->make(true);
        }
    }


    public function userMedia(Request $request)
    {


        if ($request->ajax()) {
//            $data = User::withTrashed()->with(['media' => function($query){
//                $query->withTrashed();
//            }])
//
//                ->findOrFail($request->id);
//            dd($request->all());

            $media = Media::withTrashed()
                ->when($request->has('media_type') && $request->media_type == 'photo' && $request->filled('media_type'), function ($q) use ($request) {
                    return $q->where(['media_type' => 'Photo', 'is_private' => 0]);
                })
                ->when($request->has('media_type') && $request->media_type == 'private_photo' && $request->filled('media_type'), function ($q) use ($request) {
                    return $q->where(['media_type' => 'Photo', 'is_private' => 1]);
                })
                ->when($request->has('media_type') && $request->media_type == 'video' && $request->filled('media_type'), function ($q) use ($request) {
                    return $q->where(['media_type' => 'Video']);
                })
                ->when($request->has('media_status') && $request->filled('media_status') && $request->media_status == 1, function ($q) use ($request) {
                    return $q->where('deleted_at', '!=', null);
                })
                ->when($request->has('media_status') && $request->filled('media_status') && $request->media_status == 0, function ($q) use ($request) {
                    return $q->where('deleted_at', '=', null);
                })
                ->where('user_id', $request->user_id)->get();


            $media_url = env('MEDIA_URL');
            return response()->json([
                'status' => true,
                'media_url' => $media_url,
                'data' => $media
            ]);
        }
    }

    public function userDetail($id)
    {
        $zone = Cookie::get('zone');


        $user = User::withTrashed()->with(['banned'=>function($query){
            $query->latest()->first();
        }, 'hobbies', 'looking', 'media' => function ($query) {
            $query->withTrashed();
        }, 'transactions' => function ($query) {
            $query->take(5)->latest();
        }
        ])
            ->orderBy('created_at', 'desc')
            ->findOrFail($id);

//         $activities=$this->sortArrayonDateTime($user);
        $goldCoinsTransaction = InAppTransaction::where('user_id', $id)->where('coin', 'Gold')
            ->take(5)->latest()->get();
        $referralGoldCoinsTransaction = InAppTransaction::where('user_id', $id)->where(['coin' => 'Gold', 'source' => 'Referral Code'])
            ->take(5)->latest()->get();
        $silverCoinsTransaction = InAppTransaction::where('user_id', $id)->where('coin', 'Silver')
            ->take(5)->latest()->get();
        $referralSilverCoinsTransaction = InAppTransaction::where('user_id', $id)->where(['coin' => 'Silver', 'source' => 'Referral Code'])
            ->take(5)->latest()->get();
        $urlProfile = env('MEDIA_URL');
        $user->currentSubscription = $this->getSubscription($user->id);
        $user->custombadge = $this->getUserSecondBadge($user);
        if ($user->banned) {
//        dd($user->banned->time_banned_for,$this->TimeZoneToLocal($user->banned->time_banned_for,$zone) , Carbon::now(),$this->TimeZoneToLocal(Carbon::now(), $zone),$zone);
            if ($user->banned->banned_forever == 0) {

                if ($this->TimeZoneToLocal($user->banned->time_banned_for, $zone) >= $this->TimeZoneToLocal(Carbon::now(), $zone)) {
                    $user->banned_time_for = $this->TimeZoneToLocal($user->banned->time_banned_for, $zone);
                } else {
                    $user->banned = null;
                }
            }

        }
        $genders = Gender::all();
        $religions = Religion::all();
        $countries = Country::select('name', 'id')->get();
        $languages = Language::all();
        $subscriptions = Subscription::where('shortcode', '!=', 'GAM')->where('shortcode', '!=', 'CUSTOM')->get();
        $subscriptionsCustom = Subscription::where('shortcode', '=', 'CUSTOM')->get();
        return view('admin.pages.appUsers.userDetail')->with(compact('goldCoinsTransaction', 'referralGoldCoinsTransaction', 'silverCoinsTransaction', 'referralSilverCoinsTransaction', 'user', 'urlProfile', 'genders', 'religions', 'countries', 'languages', 'subscriptions', 'subscriptionsCustom'));
    }

    public function sortArrayonDateTime($user)
    {

        $activities = [];
        foreach ($user->sentLike as $userSentLike) {
            $activities[(string)$userSentLike->created_at] = $userSentLike;
        }

        foreach ($user->transactions as $userTransactions) {
            $activities[(string)$userTransactions->created_at] = $userTransactions;
        }
        foreach ($user->report as $userReport) {
            $activities[(string)$userReport->created_at] = $userReport;
        }
        foreach ($user->block as $userBlock) {
            $activities[(string)$userBlock->created_at] = $userBlock;
        }
        dd($activities);
        $collection = collect($activities);
        $sorted = $collection->sortDesc();

        return $sorted->values()->all();


    }

    public function getTransactions(Request $request)
    {
        return InAppTransaction::where('user_id', $request->user_id)
            ->paginate(5);

    }

    public function getGoldTransactions(Request $request)
    {
        return InAppTransaction::where(['user_id' => $request->user_id, 'coin' => 'Gold'])
            ->paginate(5);
    }

    public function getSilverTransactions(Request $request)
    {
        return InAppTransaction::where(['user_id' => $request->user_id, 'coin' => 'Silver'])
            ->paginate(5);
    }

    public function getReferralGoldTransactions(Request $request)
    {
        return InAppTransaction::where(['user_id' => $request->user_id, 'coin' => 'Gold', 'source' => 'Referral Code'])
            ->paginate(5);
    }

    public function getReferralSilverTransactions(Request $request)
    {
        return InAppTransaction::where(['user_id' => $request->user_id, 'coin' => 'Silver', 'source' => 'Referral Code'])
            ->paginate(5);
    }

//    public function userActivites(Request $request){
//        return InAppTransaction::where('user_id', $request->user_id)
//            ->paginate(5);
//    }

    public function changePassword(Request $request)
    {

        $request->validate([
            'password' => 'required|confirmed|min:8',
            'user_id' => 'required|exists:users,id'
        ]);
        $changePassword = $this->user->changePassword($request);
        if ($changePassword) {
            return response()->success(1, 'password changed', null);
        }
    }

    public function deleteUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);
        $user = User::findorfail($request->user_id);
        $user->fcm_token=null;
        $user->tokens()->delete();
        $user->save();
        $user->delete();
        if ($request->ajax()) {
            return $user;
        } else {
            return back()->with('success', 'user deleted successfully');
        }
    }

    public function recoverUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);
        $user = User::withTrashed()->find($request->user_id);
        $user->deleted_at = null;
        $user->Save();
        if ($request->ajax()) {
            return 1;
        } else {
            return back()->with('success', 'user recover successfully');
        }

    }

    public function banUser(Request $request)
    {
        $zone = Cookie::get('zone');
        if (!$request->has('time') || $request->time == 0) {
            $request['time'] = '2022-03-01 12:12:22';
        }

        if($request->has('banned_forever')){
            $request['banned_forever'] = 1;
        }

        $request['banned_by']=auth()->id();
        $request['banned_user'] = $request->user_id;
        $request['time_banned_for']= $this->TimeZoneToUTC($request->time, $zone);
        $data = $this->user->ban($request);
        if ($request->ajax()) {
            return $data;
        } else {
            if ($request->action == 1) {
                return back()->with('success', 'User banned successfully');

            } else {
                return back()->with('success', 'User unban successfully');
            }
        }
    }

    public function updateUserProfile(Request $request)
    {
        $user = $this->user->updateUserProfile($request);
        if ($user) {
            return response()->success(1, 'User User Profile Successfully.!', null);
        }
    }

    public function permanentDelete(Request $request)
    {

        $user = User::withTrashed()->find($request->userId);
//            $user->media()->delete();
//            $user->sentLike()->delete();
//            $user->getLike()->delete();
//            $user->favorites()->delete();
//            $user->myGiftsInvitations()->delete();
//            $user->wishlist()->delete();
//            $user->hobbies()->delete();
//            $user->subscription()->delete();
//            $user->transactions()->delete();
//            $user->report()->delete();
//            $user->block()->delete();
//            $user->userNotificationSettings()->delete();
//            $user->withdrawals()->delete();
//            $user->boost()->delete();
//            $user->appearFirst()->delete();
//            $user->userWithdrawMethod()->delete();
//            $user->notifications()->delete();
//            $user->looking()->delete();
//            $user->callHistory()->delete();
//            $user->referral_link()->delete();
        $user->forceDelete();
        return redirect(route('admin.manage.users'))->with('success', 'User successfully deleted from database');
    }

    public function addCredit(Request $request)
    {

        $user = User::withTrashed()->findOrFail($request->get('userId'));
        if ($request->get('coinsType') == 'goldCoins') {
            $user->gold_coin += $request->coins;
            $coin = 'Gold';
        } else {
            $user->silver_coin += $request->coins;
            $coin = 'Silver';
        }
        $user->save();
        $this->createTransaction($user->id, 'By 2Again', 'CREDIT', $coin, $request->coins);
        return back()->with('success', 'add credit Successfully.!');

    }

    public function assignBadge(Request $request)
    {
        $zone = Cookie::get('zone');
        $request['start_date'] = $this->TimeZoneToUTC($request->start_date, $zone);
        $request['valid_till'] = $this->TimeZoneToUTC($request->valid_till, $zone);
        $this->shop->assignBadge($request);
        return back()->with('success', 'Badge assigned successfully');
    }

    public function bannedUser()
    {
        return view('admin.pages.appUsers.userBanned');
    }

    public function deletedUser()
    {
        return view('admin.pages.appUsers.deletedUsers');
    }

    public function userActivity($user)
    {
//        $user=User::with('like')->findorfail($user);
//        dd($user->sentLike[0]);
    }

}
