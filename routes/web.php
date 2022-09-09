<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\CallController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//new web routes

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('admin.auth.login');
    })->name('login');
});

//Route::get('/', [HomeController::class, 'home'])->name('landing.page');
//Route::middleware('guest')->group(function () {
//    Route::prefix('login')->group(function () {
//        Route::get('email', [AuthController::class, 'LoginEmailPhone'])->name('login.email');
//        Route::get('phone', [AuthController::class, 'LoginEmailPhone'])->name('login.phone');
//        Route::post('signIn', [AuthController::class, 'login'])->name('signIn');
//    });
//    Route::prefix('register')->group(function (){
//        Route::get('email', [AuthController::class, 'RegisterEmailPhone'])->name('register.email');
//        Route::get('phone', [AuthController::class, 'RegisterEmailPhone'])->name('register.phone');
//        Route::post('signUp', [UserController::class, 'store'])->name('signUp');
//
//    });
//});
//Route::middleware(['auth'])->group(function () {
////  home
//    Route::get('/home', [HomeController::class, 'index'])->name('home');
//
//});


//  old web routes

//   landingpage route//

//Route::get('/', [HomeController::class, 'home'])->name('landingpage');
Route::any('call/voice', [CallController::class, 'voice']);
// Route::post('appStoreServerNotification', [GeneralController::class, 'appStoreServerNotification']);

//
////Login Routes//
//
//Route::middleware('guest')->group(function () {
//
//    Route::get('/login', [AuthController::class, 'login_register'])->name('loginregister');
////    Route::post('/login', [AuthController::class, 'login'])->name('login');
//    Route::get('/login_with_email', [AuthController::class, 'login_email_phone'])->name('login_with_email');
//    Route::get('/login_with_phone', [AuthController::class, 'login_email_phone'])->name('login_with_phone');
////  register with email phone
//    Route::get('/register_with_email', [AuthController::class, 'register_email_and_phone'])->name('register_email');
//    Route::get('/register_with_phone', [AuthController::class, 'register_email_and_phone'])->name('register_phone');
//    Route::get('/otp_verification', [AuthController::class, 'otp_verification'])->name('otp_verification');
//    Route::get('/setPassword', [AuthController::class, 'setPassword'])->name('setPassword');
//    Route::post('/setPassword', [UserController::class, 'setPassword'])->name('setPassword');
//    Route::post('/verifyUser', [AuthController::class, 'verifyUser'])->name('verifyUser');
//    Route::get('otp/resend', [AuthController::class, 'resendOTP'])->name('otp/resend');
//
//    Route::post('social_media', [AuthController::class, 'social_media'])->name('social_media');
//
//
////  login with google
//    Route::get('/auth/google', [AuthController::class, 'redirectTo'])->name('auth/google');
//    Route::get('/auth/google/callback', [AuthController::class, 'handleCallback'])->name('auth/google/callback');
////  facebook login
//    Route::get('/auth/facebook', [AuthController::class, 'redirectTo'])->name('auth/facebook');
//    Route::get('/auth/facebook/callback', [AuthController::class, 'handleCallback'])->name('auth/facebook/callback');
////  forget password
//    Route::get('/forget/email/password', [AuthController::class, 'forget_password'])->name('forget_email_password');
//    Route::get('/forget/phone/password', [AuthController::class, 'forget_password'])->name('forget_phone_password');
//    Route::post('/forget/password', [AuthController::class, 'forgotpassword'])->name('forgot_password');
//    Route::get('/verifyOTP', [AuthController::class, 'OTP'])->name('verifyOTP');
//    Route::get('/verifyOTP/resend', [AuthController::class, 'OTPreSend'])->name('verifyOTP/resend');
//    Route::post('/verifyOTP', [AuthController::class, 'verifyOTP'])->name('verifyOTP');
//    Route::get('/ResetPassword', [AuthController::class, 'ResetPassword'])->name('ResetPassword');
//    Route::post('/ResetPassword', [AuthController::class, 'passwordReset'])->name('ResetPassword');
//
//});

//Route::middleware(['auth'])->group(function () {
//
////  profile update
//    Route::get('/updateProfile', [AuthController::class, 'updateProfile'])->name('updateProfile');
//    Route::post('/updateProfile', [UserController::class, 'updateProfile'])->name('updateProfile');
//    Route::post('/uploadProfilePic', [UserController::class, 'uploadProfilePic'])->name('uploadProfilePic');
//    //      token receive
//    Route::post('/fcm_token', [UserController::class, 'fcmToken'])->name('fcm_token');
//
//    Route::middleware(['CheckProfile'])->group(function () {
////      profile setting
//        Route::get('/Profile', [UserController::class, 'Profile'])->name('Profile');
//        Route::get('/ProfileSetting', [UserController::class, 'ProfileSetting'])->name('ProfileSetting');
////        visitProfile
//        Route::post('visitProfile', [UserController::class, 'visitProfile'])->name('visitProfile');
//        Route::get('visitPhotos', [MediaController::class, 'visitGallery'])->name('visitPhotos');
//        Route::post('visitPhotos', [MediaController::class, 'visitGallery'])->name('visitPhotos');
//        Route::get('visitVideos', [MediaController::class, 'visitGallery'])->name('visitVideos');
//        Route::post('visitVideos', [MediaController::class, 'visitGallery'])->name('visitVideos');
//        Route::post('appearFirst', [InteractionController::class, 'appearFirst'])->name('appearFirst');
//        Route::post('rateGallery', [MediaController::class, 'rateGallery'])->name('rateGallery');
//
//
//        Route::post('/addHobby', [HobbyController::class, 'addHobby'])->name('addHobby');
//        Route::get('suggestions', [HobbyController::class, 'suggestions'])->name('suggestions');
//        Route::post('/removeHobby', [HobbyController::class, 'removeHobby'])->name('removeHobby');
//        Route::post('setMood', [GeneralController::class, 'setMood'])->name('setMood');
////      preferences
//        Route::get('/Preferences', [UserController::class, 'Preferences'])->name('Preferences');
//        Route::get('/other/Preferences', [UserController::class, 'other_Preferences'])->name('other/Preferences');
////       discover
//        Route::get('beInvisible', [UserController::class, 'beInvisible'])->name('beInvisible');
//        Route::get('myLanguage', [UserController::class, 'myLanguage'])->name('myLanguage');
//        Route::post('boostRadius', [UserController::class, 'boostRadius'])->name('boostRadius');
//        Route::get('boostWorldWide', [UserController::class, 'boostWorldWide'])->name('boostWorldWide');
////        search
//        Route::post('gender', [UserController::class, 'filterGender'])->name('gender');
//        Route::post('ageRange', [UserController::class, 'ageRange'])->name('ageRange');
//        Route::post('distance', [UserController::class, 'distance'])->name('distance');
//        Route::get('allWorld', [UserController::class, 'allWorld'])->name('allWorld');
////        Last active status
//        Route::get('readReceipt', [UserController::class, 'readReceipt'])->name('readReceipt');
//        Route::get('lastActiveStatus', [UserController::class, 'lastActiveStatus'])->name('lastActiveStatus');
//
//        Route::post('lookingFor', [UserController::class, 'lookingFor'])->name('lookingFor');
//        Route::get('peopleFromMyReligion', [UserController::class, 'peopleFromMyReligion'])->name('peopleFromMyReligion');
//        Route::get('peopleFromMyCountry', [UserController::class, 'peopleFromMyCountry'])->name('peopleFromMyCountry');
//        Route::get('peopleWithSameLanguage', [UserController::class, 'peopleWithSameLanguage'])->name('peopleWithSameLanguage');
////      Email Notifications
//        Route::get('email/notification', [UserController::class, 'email_notification'])->name('email/notification');
//
////      Push Notifications
//        Route::get('push/notification', [UserController::class, 'push_notification'])->name('push/notification');
//        Route::post('notificationSettings', [UserController::class, 'notificationSettings'])->name('notificationSettings');
////      account setting
//        Route::get('account/setting', [UserController::class, 'account_setting'])->name('account/setting');
//        Route::get('pause', [UserController::class, 'pauseProfile'])->name('pause');
//        Route::get('delete', [UserController::class, 'deleteProfile'])->name('delete');
//
////      addMedia
//        Route::get('photos', [MediaController::class, 'userGallery'])->name('photos');
//        Route::post('photos', [MediaController::class, 'userGallery'])->name('photos');
//        Route::get('videos', [MediaController::class, 'userGallery'])->name('videos');
//        Route::post('videos', [MediaController::class, 'userGallery'])->name('videos');
//        Route::post('addMedia', [MediaController::class, 'add'])->name('addMedia');
//        Route::post('deleteMedia', [MediaController::class, 'delete'])->name('deleteMedia');
//
////      coins
//        Route::get('goldCoinWallet', [CoinController::class, 'goldCoinWallet'])->name('goldCoinWallet');
//        Route::get('silverCoinWallet', [CoinController::class, 'silverCoinWallet'])->name('silverCoinWallet');
//        Route::get('convertCoins', [AppSettingsController::class, 'convertCoins'])->name('convertCoins');
////      interactions
//        Route::post('/like_to', [InteractionController::class, 'like'])->name('like_to');
//        Route::post('/favorite_to', [InteractionController::class, 'favorite'])->name('favorite_to');
//        Route::get('/rewind', [InteractionController::class, 'rewind'])->name('rewind');
//        Route::get('/interactions', [InteractionController::class, 'interactions'])->name('interactions');
//        Route::post('myInteractions', [InteractionController::class, 'myInteractions'])->name('myInteractions');
//        Route::post('interactedMe', [InteractionController::class, 'interactedMe'])->name('interactedMe');
//        Route::post('likeMe', [InteractionController::class, 'interactedMe'])->name('likeMe');
//        Route::get('myFavorites', [InteractionController::class, 'myFavorites'])->name('myFavorites');
//        Route::get('myMatches', [InteractionController::class, 'myMatches'])->name('myMatches');
//        Route::post('seenMe', [InteractionController::class, 'seenMe'])->name('seenMe');
//        Route::post('seen', [InteractionController::class, 'seen'])->name('seen');
////        actions
//        Route::post('unmatch', [InteractionController::class, 'unmatch'])->name('unmatch');
//        Route::post('report', [InteractionController::class, 'report'])->name('report');
//        Route::get('reportReasons', [InteractionController::class, 'reportReasons']);
//        Route::post('block', [InteractionController::class, 'block'])->name('block');
//        Route::get('blockList', [InteractionController::class, 'blockList'])->name('blockList');
//        Route::post('unBlock', [InteractionController::class, 'unBlock'])->name('unblock');
//
//
////      GiftOrInvitation
//        Route::post('sendGiftOrInvitation', [GiftAndInvitationController::class, 'sendGiftOrInvitation'])->name('sendGiftOrInvitation');
//        Route::get('giftInvitations', [GiftAndInvitationController::class, 'giftInvitations'])->name('giftInvitations');
//        Route::post('giftInvitations', [GiftAndInvitationController::class, 'giftInvitations'])->name('giftInvitations');
//        Route::post('acceptRejectGiftInvitation', [GiftAndInvitationController::class, 'acceptRejectGiftInvitation'])->name('acceptRejectGiftInvitation');
//        Route::get('wishlist', [GiftAndInvitationController::class, 'wishlist'])->name('wishlist');
//        Route::post('AddWishList', [GiftAndInvitationController::class, 'AddWishList'])->name('AddWishList');
////      Shops
//        Route::get('shops', [ShopController::class, 'shops'])->name('shops');
//        Route::get('goldCoins', [ShopController::class, 'shops'])->name('goldCoins');
//        Route::post('buy/items', [ShopController::class, 'buy'])->name('buy/items');
//        Route::post('buy/gold', [ShopController::class, 'buyGold'])->name('buy/gold');
//        Route::post('getTiers', [ShopController::class, 'getTiers'])->name('getTiers');
//
////        subscription
//        Route::get('greetMeetPackage', [GeneralController::class, 'greetMeetPackage'])->name('greetMeetPackage');
//        Route::get('vipPackage', [GeneralController::class, 'vipPackage'])->name('vipPackage');
//        Route::get('bigSpenderPackage', [GeneralController::class, 'bigSpenderPackage'])->name('bigSpenderPackage');
//        Route::post('vip/package/detail', [GeneralController::class, 'subscriptionSettings'])->name('vip/package/detail');
//        Route::post('BS/package/detail', [GeneralController::class, 'subscriptionSettings'])->name('BS/package/detail');
//        Route::get('subscriptions', [ShopController::class, 'shops'])->name('subscriptions');
//        Route::post('subscribe', [ShopController::class, 'subscribe'])->name('subscribe');
//        Route::get('unsubscribe', [GeneralController::class, 'unsubscribe'])->name('unsubscribe');
//
//
////        calling
//
//        Route::get('user/calling', [ChatController::class, 'call'])->name('user.calling');
//        Route::get('messages', [ChatController::class, 'getConversationsList'])->name('messages');
//        Route::post('messages', [ChatController::class, 'getConversationsList'])->name('messages');
//
//        Route::post('sendMessage', [ChatController::class, 'sendMessage'])->name('sendMessage');
//        Route::get('getConversationsList', [ChatController::class, 'getConversationsList'])->name('getConversationsList');
//        Route::post('getConversationMessages', [ChatController::class, 'getConversationMessages'])->name('getConversationMessages');
//        Route::post('rateReply', [ChatController::class, 'rateReply'])->name('rateReply');
////      payment Detail
//        Route::get('card/list', [StripeController::class, 'getCardList'])->name('card/list');
//        Route::post('add/card', [StripeController::class, 'addCard'])->name('add/card');
//        Route::post('card/remove', [StripeController::class, 'removeCard'])->name('card/remove');
////      offers
//        Route::get('offers', [OfferController::class, 'getOffers'])->name('offers');
//        Route::post('offer/detail', [OfferController::class, 'offerDetail'])->name('offer/detail');
//        Route::post('buy/offer', [OfferController::class, 'buy'])->name('buy/offer');
////      notifications
//
//        Route::get('notifications/get', [UserController::class, 'getNotifications'])->name('notifications/get');
//        Route::post('markAsRead', [UserController::class, 'markAsReadNotification']);
//        Route::get('markAllAsReadNotification', [UserController::class, 'markAllAsReadNotification']);
//
////   helpCenter
//
//        Route::get('help/center', [SupportController::class, 'faqs'])->name('help/center');
//        Route::post('chatbot', [SupportController::class, 'chatbot'])->name('chatbot');
//        Route::post('contactUs', [SupportController::class, 'contactUs'])->name('contactUs');
//
////      logout
//        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
//
//    });
//
//    Route::get('call/view', [CallController::class, 'view']);
//    Route::post('call/token', [CallController::class, 'token']);
//});

Route::get('/privacy', [CommunityController::class, 'privacy'])->name('privacy');
Route::get('/term/condition', [CommunityController::class, 'termCondition'])->name('term/condition');


Route::get('/migrate', function () {
    Artisan::call('migrate');
});
//
//Route::get('/seed', function () {
//    Artisan::call('db:seed');
//});
//Route::get('/rollback', function () {
//    Artisan::call('migrate:rollback');
//});
