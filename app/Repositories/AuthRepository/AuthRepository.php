<?php

namespace App\Repositories\AuthRepository;

use App\Jobs\SendOTPOnSMSJob;
use App\Repositories\AuthRepository\iAuthRepository;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Jobs\UserNotificationJob;
use Twilio\Rest\Client;

class AuthRepository implements iAuthRepository{

    public function checkVeriy(User $user){
        if($user->verified != 1){
            return false;
        }
        return true;
    }

    public function checkProfileData(User $user){
        if($user->name == null){
            return false;
        }

        return true;
    }

    public function checkOTPValidation(Request $request)
    {
        $request->validate([
            'email'     => 'required_without:phone|exists:users,email',
            'phone'     => 'required_without:email',
            'otp'       => 'required',
        ]);

        $request->phone = trim($request->phone);

        if ($request->has('email')) {
            $user = User::where($request->all())->first();
        } else {
            $user = User::where($request->all())->first();
        }

        if (!$user) {
         return false;
        }
        return $user;
    }

    public function subscribe(User $user){
        $greetAndMeet = Subscription::where('shortcode', 'GAM')->first();
        $user->subscription()->attach($greetAndMeet);
    }

    public function verify(User $user){
        $user->update([
            'verified' => true,
            'otp' => mt_rand(1000, 9999)
        ]);
    }

    public function otpResend(Request $request){

        $user = $this->getUser($request);

        $otp = mt_rand(1000, 9999);
        $user->update(['otp' => $otp]);

        if($user->email != null){
            dispatch(new UserNotificationJob($user));
        }elseif($user->phone != null){

            $message = 'You 2Again OTP code is '. $user->otp;
            $account_sid = getenv("TWILIO_ACCOUNT_SID");
            $auth_token = getenv("TWILIO_AUTH_TOKEN");
            $twilio_number = getenv("TWILIO_PHONE_NUMBER");
            $client = new Client($account_sid, $auth_token);
            $client->messages->create($user->phone,
            ['from' => $twilio_number, 'body' => $message] );
        }
    }

    public function forgetPassword(Request $request){

        $user = $this->getUser($request);

        $user->update([
            'otp' => mt_rand(1000, 9999),
        ]);

        if($user->email != null){
            dispatch(new UserNotificationJob($user));
        }elseif($user->phone != null){

            $message = 'You 2Again OTP code is '. $user->otp;
            $account_sid = getenv("TWILIO_ACCOUNT_SID");
            $auth_token = getenv("TWILIO_AUTH_TOKEN");
            $twilio_number = getenv("TWILIO_PHONE_NUMBER");
            $client = new Client($account_sid, $auth_token);
            $client->messages->create($user->phone,
            ['from' => $twilio_number, 'body' => $message] );
        }
    }

    public function verifyOTP(Request $request){
        $user = $this->checkOTPValidation($request);
        if(!$user){
            return 0;
        }
        $newCode = mt_rand(1000, 9999);
        $user->update(['otp' => $newCode]);
        return $newCode;
    }

    public function resetPassword(Request $request){

        $request->validate([
            'email'                  => 'required_without:phone|exists:users,email',
            'phone'                  => 'required_without:email|exists:users,phone',
            'password'               => 'required|string|min:8|confirmed',
            'password_confirmation'  => 'required|same:password',
            'otp'                    =>  'required|exists:users,otp'
        ]);

        $user = $this->getUser($request);

        $newCode = mt_rand(1000, 9999);

        $user->update(['password' => $request->password, 'otp' => $newCode]);

    }

    public function deleteUser(){
        auth()->user()->tokens()->delete();
        auth()->user()->delete();
    }

    public function getUser(Request $request)
    {

        $request->validate([
            'email' => 'required_without:phone|exists:users,email',
            'phone' => 'required_without:email|exists:users,phone',
        ]);

        if (($request->has('email') && $request->filled('email'))) {
            $user = User::with('looking')->where('email', $request->email)->first();
        } else {
            $user = User::with('looking')->where('phone', $request->phone)->first();
        }

        if($user){
            return $user;
        }else{
            responseNow(0, null, 'The selected Phone number is invalid', 400);
        }

        return $user;
    }

    public function CheckSocialUserExists(Request $request){
        $user = User::with('looking')->where('social_id', $request->social_id)->first();
        if($user){
            return $user;
        }else{
            return false;
        }
    }
}
