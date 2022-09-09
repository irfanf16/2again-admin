<?php

namespace App\Traits;

use App\Http\Requests\AddNewAccountEmailRequest;
use App\Jobs\PaymentMethodEmailVerificationJob;
use App\Models\AppSetting;
use App\Models\PaymentMethod;
use App\Models\UserPaymentMethod;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

trait WithdrawTrait {

    public function getWithdrawals($conditions = array()){
        return Withdrawal::select('id', 'coins', 'amount', 'is_approved', 'created_at')->where($conditions)->orderBy('created_at', 'DESC')->get();
    }

    public function withdrawRequest(Request $request){

        $request->validate([
            'user_payment_methods_id' =>  'required|exists:user_payment_methods,id'
        ]);

        $stu = AppSetting::where('shortcode', 'STU')->first();
        // $minMaxLimit = AppSetting::where('shortcode', 'MWL')->first();
        // $monthlyWithdrawLimit = AppSetting::where('shortcode', 'MWLIMIT')->first()->value2;


        // $maximumWithdrawLimitUSD = $minMaxLimit->value2;
        // $minimumWithdrawLimitUSD = $minMaxLimit->value1;

        // $coins = auth()->user()->silver_coin;
        // $totalInUSD = $coins * $stu->value2;

        // $previousWithdrawalAmount = Withdrawal::whereMonth('created_at', Carbon::now()->month)->sum('amount');

        // if($totalInUSD > $maximumWithdrawLimitUSD){
        //     $remaining = ($totalInUSD - $maximumWithdrawLimitUSD) / $stu->value2;
        //     $withdrawableUSD = $maximumWithdrawLimitUSD;
        //     $withdrawableSilverCoins = $withdrawableUSD / $stu->value2;
        // }else{
        //     $remaining = 0;
        //     $withdrawableUSD = $totalInUSD;
        //     $withdrawableSilverCoins = $withdrawableUSD / $stu->value2;
        // }

        // $monthlyRemainingWithdrawCoins = $monthlyWithdrawLimit - $previousWithdrawalAmount;

        // if($withdrawableUSD > $monthlyRemainingWithdrawCoins){
        //     $remaining = $withdrawableUSD - $monthlyRemainingWithdrawCoins;
        //     $remaining = $withdrawableUSD / $stu->value2;
        //     $withdrawableUSD = $monthlyRemainingWithdrawCoins;
        // }


        // if(auth()->user()->silver_coin < $minimumWithdrawLimitUSD){
        //    responseNow(0, null, 'You have not reached minimum withdraw limit');
        // }

        $response = $this->calculateWithdrawableCoins();
        $withdrawableUSD = $response['withdrawable_coins'];
        $coins = $withdrawableUSD / $stu->value2;

        $request =  auth()->user()->withdrawals()->create([
                'coins'                      =>  $coins,
                'amount'                     =>  $response['withdrawable_coins'],
                'conversion_rate'            =>  $stu->value2,
                'user_payment_methods_id'    =>  $request->user_payment_methods_id
            ]);

            $remaining = auth()->user()->silver_coin - $coins;

        if($request){
            auth()->user()->silver_coin = $remaining;
            auth()->user()->save();
            return $request;
        }

        return null;
    }

    public function getAvailablePaymentOptions(){
        return PaymentMethod::all();
    }

    public function addNewAccountEmail(AddNewAccountEmailRequest $request){

        $ifExists = auth()->user()->userWithdrawMethod()->where(['email' => $request->email])->first();

        if($ifExists){
            if($ifExists->is_verified == 1){
                responseNow(0, null, 'This email is already added', 400);
            }

            $ifExists->update([
                'otp'   =>  $request->otp
            ]);

            dispatch(new PaymentMethodEmailVerificationJob($ifExists));

            return 1;
        }

         $newMethod =  auth()->user()->userWithdrawMethod()->create($request->validated());

         $newMethod->name = auth()->user()->name;

        dispatch(new PaymentMethodEmailVerificationJob($newMethod));

        return $newMethod;

    }

    public function verifyNewAccountEmail(Request $request){

        $validated = $request->validate([
            'email'         =>  'required|email|exists:user_payment_methods,email',
            'otp'           =>  'required|integer'
        ]);

        $method = UserPaymentMethod::where($validated)->first();
        if($method){
            $method->update([
                'is_verified'   => 1
            ]);

            return $method;

        }else{
            return -1;
        }
    }

    public function userPaymentOptions(){
        return auth()->user()->userWithdrawMethod()->with('paymentMethod')->where('is_verified', 1)->get();
    }

    public function removePaymentMethod($id){
        return auth()->user()->userWithdrawMethod()->where('id', $id)->delete();
    }

    public function resendOTP($email){
        $ifExists = auth()->user()->userWithdrawMethod()->where(['email' => $email])->first();

        if($ifExists){
            if($ifExists->is_verified == 1){
                responseNow(0, null, 'This email is already added', 400);
            }

            $ifExists->update([
                'otp'   =>  mt_rand(1000, 9999)
            ]);

            dispatch(new PaymentMethodEmailVerificationJob($ifExists));

            return 1;
        }else{
            return 0;
        }
    }

    public function checkMonthlyLimit($usd, $settings){

        $monthlyWithdrawLimit = $settings->where('shortcode', 'MWLIMIT')->first()->value2;

        $previousWithdrawalAmount = auth()->user()->withdrawals()->whereMonth('created_at', Carbon::now()->month)->sum('amount');
        if($previousWithdrawalAmount >= $monthlyWithdrawLimit){
            $eligibleFor = null;
        }else{
            if($previousWithdrawalAmount > 0){
                $eligibleFor = $monthlyWithdrawLimit - $previousWithdrawalAmount;
            }else{
                $eligibleFor =  $monthlyWithdrawLimit;
            }
        }

        if($usd <= $eligibleFor){
            $withdrawAble = $usd;
        }else{
            $withdrawAble = $eligibleFor;
        }

        return $withdrawAble;
    }

    public function calculateWithdrawableCoins(){
        $settings = AppSetting::all();
        $STU = $settings->where('shortcode', 'STU')->first();
        $maximumWithdrawLimit = $settings->where('shortcode', 'MWL')->first()->value2;
        $minimumWithdrawLimit = $settings->where('shortcode', 'MWL')->first()->value1;

        $monthlyWithdrawLimit = $settings->where('shortcode', 'MWLIMIT')->first()->value2;

        $coins = auth()->user()->silver_coin;

        $usd = $coins * $STU->value2;

        if($usd < $minimumWithdrawLimit){

            $withdrawableCoins = 0;
            $statusCode = 2;
            return [
                'withdrawable_coins'         => $withdrawableCoins,
                'maximum_withdraw_limit'     => $maximumWithdrawLimit,
                'minimum_withdraw_limit'    =>  $minimumWithdrawLimit,
                'monthly_withdraw_limit'    =>  $monthlyWithdrawLimit,
                'status'                    =>  $statusCode,
                'coins'                     =>  $coins
            ];
        }

        if($usd > $maximumWithdrawLimit){

            $withdrawableCoins = $maximumWithdrawLimit;
            $Withdrawable = $this->checkMonthlyLimit($withdrawableCoins, $settings);
            if($Withdrawable){
                $statusCode = 1;
            }else{
                $statusCode = 2;
                $Withdrawable = 0;
            }
            return [
                'withdrawable_coins'         => $Withdrawable,
                'maximum_withdraw_limit'     => $maximumWithdrawLimit,
                'minimum_withdraw_limit'    =>  $minimumWithdrawLimit,
                'monthly_withdraw_limit'    =>  $monthlyWithdrawLimit,
                'status'                    =>  $statusCode,
                'coins'                     =>  $coins
            ];
        }else{
            $withdrawableCoins = $usd;
            $Withdrawable = $this->checkMonthlyLimit($withdrawableCoins, $settings);

            if($Withdrawable){
                $statusCode = 1;
            }else{
                $statusCode = 2;
                $Withdrawable = 0;
            }

            return [
                'withdrawable_coins'         => $Withdrawable,
                'maximum_withdraw_limit'     => $maximumWithdrawLimit,
                'minimum_withdraw_limit'    =>  $minimumWithdrawLimit,
                'monthly_withdraw_limit'    =>  $monthlyWithdrawLimit,
                'status'                    =>  $statusCode,
                'coins'                     =>  $coins
            ];
        }
    }

}
