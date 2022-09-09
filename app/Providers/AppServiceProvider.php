<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use Illuminate\Pagination\Paginator;


use App\Repositories\UserRepository\iUserRepository;
use App\Repositories\UserRepository\UserRepository;

use App\Repositories\ChatRepository\iChatRepository;
use App\Repositories\ChatRepository\ChatRepository;


use App\Repositories\ShopRepository\iShopRepository;
use App\Repositories\ShopRepository\ShopRepository;

use App\Repositories\SupportRepository\iSupportRepository;
use App\Repositories\SupportRepository\SupportRepository;

use App\Repositories\AuthRepository\iAuthRepository;
use App\Repositories\AuthRepository\AuthRepository;

use App\Repositories\AppSettingRepository\iAppSettingRepository;
use App\Repositories\AppSettingRepository\AppSettingRepository;

use App\Repositories\InteractionRepository\iInteractionRepository;
use App\Repositories\InteractionRepository\InteractionRepository;

use App\Repositories\MediaRepository\iMediaRepository;
use App\Repositories\MediaRepository\MediaRepository;

use App\Repositories\GiftInvitationRepository\iGiftInvitationRepository;
use App\Repositories\GiftInvitationRepository\GiftInvitationRepository;

use App\Repositories\StripeRepository\iStripeRepository;
use App\Repositories\StripeRepository\StripeRepository;

use App\Repositories\CallRepository\iCallRepository;
use App\Repositories\CallRepository\CallRepository;

use App\Repositories\OfferRepository\iOfferRepository;
use App\Repositories\OfferRepository\OfferRepository;

use App\Repositories\EarnFreeRepository\iEarnFreeRepository;
use App\Repositories\EarnFreeRepository\EarnFreeRepository;

use App\Repositories\FirebaseRepository\iFirebaseRepository;
use App\Repositories\FirebaseRepository\FirebaseRepository;

use App\Repositories\RekognitionRepository\iRekognitionRepository;
use App\Repositories\RekognitionRepository\RekognitionRepository;



use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       Schema::defaultStringLength(191);
        view()->composer('*', function ($view) {

            if(Auth::check()){
                if(auth()->user()->profile_pic != null){
                    $profile_pic = auth()->user()->profile_pic;
                }else{
                    $profile_pic = 'default.png';
                }
            }else{
                $profile_pic = 'default.png';
            }

            $profile_pic =  env('MEDIA_URL') . $profile_pic;

            $view->with(compact('profile_pic'));
        });


        Response::macro('success', function ($code, $message, $data = null){
             response()->json([
                'ResponseCode'      =>  $code,
                'ResponseMessage'   =>  $message,
                'data'              =>  $data
            ])->send();
            die;
        });

        Response::macro('error', function ($code, $message, $error, $status = 400){
            return response()->json([
                'ResponseCode'      =>  $code,
                'ResponseMessage'   =>  $message,
                'error'              =>  [$error]
            ], $status);
        });

        Paginator::useBootstrap();

        $this->app->singleton(iUserRepository::class, UserRepository::class);
        $this->app->singleton(iChatRepository::class, ChatRepository::class);
        $this->app->singleton(iShopRepository::class, ShopRepository::class);
        $this->app->singleton(iSupportRepository::class, SupportRepository::class);
        $this->app->singleton(iAuthRepository::class, AuthRepository::class);
        $this->app->singleton(iAppSettingRepository::class, AppSettingRepository::class);
        $this->app->singleton(iInteractionRepository::class, InteractionRepository::class);
        $this->app->singleton(iMediaRepository::class, MediaRepository::class);
        $this->app->singleton(iGiftInvitationRepository::class, GiftInvitationRepository::class);
        $this->app->singleton(iStripeRepository::class, StripeRepository::class);
        $this->app->singleton(iCallRepository::class, CallRepository::class);
        $this->app->singleton(iOfferRepository::class, OfferRepository::class);
        $this->app->singleton(iEarnFreeRepository::class, EarnFreeRepository::class);
        $this->app->singleton(iFirebaseRepository::class, FirebaseRepository::class);
        $this->app->singleton(iRekognitionRepository::class, RekognitionRepository::class);
    }
}
