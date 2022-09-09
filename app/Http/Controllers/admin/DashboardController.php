<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\Offer;
use App\Models\Purchase;
use App\Models\Report;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Withdrawal;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use FileUploadTrait;

    public function home()
    {
        return view('admin.pages.home');
    }

    public function dashboardView()
    {

        $totalUsers = User::withTrashed()->whereHas('roles', function ($query) {
            $query->where('name', 'User');
        })->where('profile_pic', '!=', null)
            ->count();

        $bannedUsers = User::withTrashed()->with('banned')->whereHas('banned',function($query){
            $query->where('time_banned_for', '>=', Carbon::now())->orwhere('banned_forever',1);
        })
            ->whereHas('roles', function ($query) {
                $query->where('name', 'User');
            })
            ->where('profile_pic', '!=', null)
            ->count();
        $deletedUsers = User::onlyTrashed()->whereHas('roles', function ($query) {
            $query->where('name', 'User');
        })->where('profile_pic', '!=', null)
            ->count();
//        $totalActiveUsers =$totalUsers-($bannedUsers+$deletedUsers);
        $totalActiveUsers = User::withTrashed()->with('banned')->whereDoesntHave('banned',function ($query){
            $query->where('time_banned_for', '>=', Carbon::now())->orwhere('banned_forever',1);
        })
            ->whereHas('roles', function ($query) {
                $query->where('name', 'User');
            })
            ->where('profile_pic', '!=', null)
            ->where('deleted_at', '=', null)
            ->count();
        $todayUsers = User::withTrashed()->whereHas('roles', function ($query) {
            $query->where('name', 'User');
        })->whereDate('created_at', Carbon::today())->count();
        $totalBS = User::with(['subscription' => function ($query) {
            $query->where('shortcode', 'BS');
        }])->whereHas('subscription', function ($query) {
            $query->where('shortcode', 'BS')->where('valid_till', '>', Carbon::now());
        })->whereHas('roles', function ($query) {
            $query->where('name', 'User');
        })->count();

        $totalVIP = User::with(['subscription' => function ($query) {
            $query->where('shortcode', 'VIP');
        }])->whereHas('subscription', function ($query) {
            $query->where('shortcode', 'VIP')->where('valid_till', '>', Carbon::now());
        })->whereHas('roles', function ($query) {
            $query->where('name', 'User');
        })->count();

        $totalCustom = User::with(['subscription' => function ($query) {
            $query->where('shortcode', 'CUSTOM');
        }])->whereHas('subscription', function ($query) {
            $query->where('shortcode', 'CUSTOM')->where('valid_till', '>', Carbon::now());
        })->whereHas('roles', function ($query) {
            $query->where('name', 'User');
        })->count();

        $totalGAM = $totalUsers - ($totalBS + $totalVIP);

        $latestFive = User::with('country')->whereHas('roles', function ($query) {
            $query->where('name', 'User');
        })->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get();
        $onlineUsers = User::where('is_online', 1)->where('profile_pic','!=',null)->where('deleted_at',null)->count();
        $convertionRate = AppSetting::where('shortcode', 'STU')->first()->value2;
        $pendingPayable = Withdrawal::where('is_approved', 0)->sum('coins');
        $pendingPayableConvertions = Withdrawal::where('is_approved', 0)->sum('amount');
        $approvedPayable = Withdrawal::where('is_approved', 1)->sum('coins');
        $approvedPayableConvertions =Withdrawal::where('is_approved', 1)->sum('amount');
        $declinedPayable = Withdrawal::where('is_approved', -1)->sum('coins');
        $declinedPayableConvertions = Withdrawal::where('is_approved', -1)->sum('amount');
        $totalearned = User::sum('silver_coin');
        $totalearnedConvertions = $totalearned * $convertionRate;
        $totalearned +=Withdrawal::sum('coins');
        $totalearnedConvertions +=Withdrawal::sum('amount');
        $totalpayable = User::sum('silver_coin');
        $totalPayableConvertions = $totalpayable * $convertionRate;
        $totalpayable +=$pendingPayable;
        $totalPayableConvertions +=$pendingPayableConvertions;

        $goldCoins = User::sum('gold_coin');
        $silverCoins = User::sum('silver_coin');
        $silverCoinsConvertions = $silverCoins * $convertionRate;
        $badges = Subscription::count();
        $offers = Offer::where('valid_till', '>', Carbon::now())->count();
        $purchase = Purchase::count();
        $subscriptionBadges = Subscription::all();
        $GIFT_URL = env('GIFT_URL');
        $reportedUsers=Report::count();

        return view('admin.pages.dashboard')->with(compact('totalUsers', 'todayUsers', 'totalBS',
            'totalVIP', 'totalGAM', 'latestFive',
            'deletedUsers', 'bannedUsers', 'onlineUsers', 'totalpayable', 'totalPayableConvertions', 'goldCoins', 'badges', 'offers',
            'pendingPayable', 'pendingPayableConvertions',
            'approvedPayable', 'approvedPayableConvertions',
            'declinedPayable', 'declinedPayableConvertions',
            'silverCoins', 'silverCoinsConvertions', 'purchase',
            'totalearned', 'totalearnedConvertions', 'subscriptionBadges', 'GIFT_URL',
            'totalCustom','totalActiveUsers','reportedUsers'

        ));

    }

    public function ProfileSetting()
    {
        return view('admin.pages.profileSetting');
    }

    public function profileUpdate(Request $request)
    {

        if ($request->hasFile('file')) {
            $file = $this->uploadSingleImage($request);
            $request['profile_pic'] = $file;
        }
        auth()->user()->update($request->all());
        return back()->with('success', 'Profile updated successfully.!');
    }

}
