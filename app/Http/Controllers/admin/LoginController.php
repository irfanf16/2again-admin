<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\BannedUsers;
use App\Models\User;
use App\Traits\TimeZoneToUTC;
use Carbon\Carbon;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    use TimeZoneToUTC;

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::with('roles')->whereDoesntHave('roles', function ($query) {
            $query->where('name', 'User');
        })->where('email', $request->email)->first();
        if (!$user) {
            return back()->with('error', 'You do not have access to system user');
        }
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return back()->with('error', 'Provided credentials are not valid');
        }
        $bannedRecord = BannedUsers::where('banned_user', auth()->id())->latest()->first();
        if($bannedRecord){
            if ($bannedRecord->banned_forever==1){
                Session::flush();
                Auth::logout();
                return redirect(route('login'))->with('error','You are banned by admin permanently');
            }
            $banned_till = Carbon::parse($bannedRecord->time_banned_for);
            $is_unBanned = Carbon::now()->gt($banned_till);
            if(!$is_unBanned){
                $banned = $this->TimeZoneToLocal($banned_till, $request->zone);
                Session::flush();
                Auth::logout();
                return back()->with('error', 'You are banned by admin till '. $banned);

            }
        }
        $cookieTime = 60 * 24 * 7;
        Cookie::queue('zone', $request->zone, $cookieTime);
        if($request->user()->can('dashboard')){
            return redirect(route('admin.dashboard'))->with('success', 'Welcome To 2Again');
        }
        return redirect(route('admin.home'))->with('success', 'Welcome To 2Again');
    }
    public function checkBanned($id){
        $bannedRecord = BannedUsers::where('banned_user', $id)->latest()->first();
        if($bannedRecord){
            if ($bannedRecord->banned_forever==1){
               return 'banned';
            }
            $banned_till = Carbon::parse($bannedRecord->time_banned_for);
            $is_unBanned = Carbon::now()->gt($banned_till);
            if(!$is_unBanned){
                return $banned_till;
            }else{
                return 0;
            }
        }

        return 0;

    }

    public function logout(Request $request)
    {
        Session::flush();
        Auth::logout();
        return redirect(route('login'));
    }
    public function forbidden(){
        return view('admin.auth.403');
    }
}
