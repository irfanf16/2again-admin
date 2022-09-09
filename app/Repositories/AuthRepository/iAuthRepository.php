<?php

namespace App\Repositories\AuthRepository;
use App\Models\User;
use Illuminate\Http\Request;

interface iAuthRepository {

    public function checkVeriy(User $user);

    public function checkProfileData(User $user);
    public function checkOTPValidation(Request $request);
    public function subscribe(User $user);
    public function verify(User $user);
    public function otpResend(Request $request);
    public function forgetPassword(Request $request);
    public function verifyOTP(Request $request);
    public function resetPassword(Request $request);
    public function deleteUser();
    public function getUser(Request $request);
    public function CheckSocialUserExists(Request $request);

}
