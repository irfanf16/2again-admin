<?php

namespace App\Models;

use App\Traits\HasPermissionsTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable, SoftDeletes, HasPermissionsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'social_id',
        'stripe_customer_id',
        'fcm_token',
        'is_online',
        'last_active',
        'name',
        'lastname',
        'email',
        'phone',
        'facebook_id',
        'google_id',
        'apple_id',
        'password',
        'verified',
        'is_welcome_bonus_claimed',
        'gender_id',
        'religion_id',
        'country_id',
        'language_id',
        'otp',
        'latitude',
        'longitude',
        'dob',
        'status_id',
        'have_children',
        'have_animals',
        'is_smoker',
        'age',
        'bio',
        'profile_pic',
        'interested_in',

        'gold_coin',
        'silver_coin',
        'gold_ref_code',
        'silver_ref_code',
        'ref_used',
        'crowdfunding_ref_used',

        'filter_radius',
        'filter_gender',
        'filter_date_range',
        'filter_all_world',
        'filter_purpose',
        'filter_religion',
        'filter_my_country',
        'filter_same_languge',
        'filter_big_spender_first',
        'filter_is_smoker',
        'filter_have_animals',
        'filter_have_children',

        'privacy_read_receipt',
        'privacy_last_active_status',
        'photo_gallery_dislikes',
        'video_gallery_dislikes ',
        'photo_gallery_likes',
        'video_gallery_likes',

        'available_photo_count',
        'available_video_count',
        'available_call_min',
        'available_super_likes',
        'available_favorite',
        'available_likes',

        'setting_sound',
        'setting_vibration',
        'setting_light_mode',
        'setting_is_paused',
        'setting_is_deleted',
        'setting_sound_on_notification',
        'setting_hide_age',

        'discovery_be_invisible',
        'discovery_my_language',
        'discover_boost_radius',
        'discovery_world_wide_boost',
        'ip',
        'device_type',
        'time_zone',
        'device_id',
        'terms_of_user',
        'privacy_policy',
        'consent'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            $post->{$post->getKeyName()} = (string) Str::uuid();
        });
    }

    public function getKeyType()
    {
        return 'string';
    }

    public $incrementing = false;


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'id' => 'string'
    ];


    //    public function roles(){
    //        return $this->belongsToMany(Role::class, 'user_role')->withTimestamps();
    //    }
    //
    //    public function hasRole($role){
    //        if($this->roles()->where('name', $role)->first()){
    //            return true;
    //        }
    //        return false;
    //    }


    public function setPasswordAttribute($value)
    {
        $pswd       = Hash::make($value);
        $this->attributes['password'] = $pswd;
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function media()
    {
        return $this->hasMany(Media::class, 'user_id', 'id');
    }

    public function sentLike()
    {
        return $this->belongsToMany(User::class, 'likes', 'like_from', 'like_to')
            ->withPivot('like_type')
            ->withTimestamps();
    }

    public function getLike()
    {
        return $this->belongsToMany(User::class, 'likes', 'like_to', 'like_from')
            ->withPivot('like_type')
            ->withTimestamps();
    }

    public function sentLikePivot()
    {
        return $this->hasMany(Like::class, 'like_from', 'id');
    }

    public function getLikePivot()
    {
        return $this->hasMany(Like::class, 'like_to', 'id');
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites', 'favorite_by', 'favorite_to');
    }

    public function myGiftsInvitations()
    {
        return $this->hasMany(UserGiftInvitation::class, 'to_user', 'id');
    }

    public function mySentGiftInvitations()
    {
        return $this->hasMany(UserGiftInvitation::class, 'from_user', 'id');
    }

    public function wishlist()
    {
        return $this->belongsToMany(GiftInvitations::class, 'wishlist', 'user_id', 'gifts_invitations_id');
    }

    public function hobbies()
    {
        return $this->hasMany(Hobby::class, 'user_id', 'id');
    }
    public function interestedIn(){
        return $this->belongsTo(Gender::class, 'interested_in', 'id');
    }
    public function filterGender(){
        return $this->belongsTo(Gender::class, 'filter_gender', 'id');
    }
    public function subscription()
    {
        return $this->belongsToMany(Subscription::class, 'user_subscriptions', 'user_id', 'subscription_id')
            ->withTimestamps()
            ->withPivot('id', 'valid_till', 'valid_till_appstore', 'start_date', 'package_id', 'downgraded_price', 'is_downgraded', 'ios_original_transaction_id', 'android_order_id');
    }

    public function transactions()
    {
        return $this->hasMany(InAppTransaction::class, 'user_id', 'id');
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class, 'gender_id', 'id');
    }

    public function religion()
    {
        return $this->belongsTo(Religion::class, 'religion_id', 'id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }

    public function contact_support()
    {
        return $this->hasMany(ContactUs::class, 'user_id', 'id');
    }

    public function report()
    {
        return $this->hasMany(Report::class, 'reported_by', 'id');
    }

    public function block()
    {
        return $this->belongsToMany(User::class, 'blocks', 'blocked_by', 'blocked_user')
            ->withTimestamps();
    }

    public function userNotificationSettings()
    {
        return $this->hasOne(UserNotificationSetting::class, 'user_id', 'id');
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class, 'user_id', 'id');
    }

    public function boost()
    {
        return $this->hasMany(ProfileBoost::class, 'user_id', 'id');
    }

    public function appearFirst()
    {
        return $this->belongsToMany(User::class, 'appear_firsts', 'user_candidate', 'user_target')
            ->withTimestamps()
            ->withPivot('has_seen');
    }

    public function userWithdrawMethod()
    {
        return $this->hasMany(UserPaymentMethod::class, 'user_id', 'id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id', 'id');
    }

    public function banned()
    {
        return $this->hasOne(BannedUsers::class, 'banned_user', 'id')->latest();
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function looking()
    {
        return $this->belongsToMany(Looking::class, 'user_looking', 'user_id', 'looking_id')
            ->withTimestamps();
    }

    public function callHistory()
    {
        return $this->belongsToMany(User::class, 'calls', 'call_from', 'call_to')
            ->withPivot('is_picked_up', 'call_time', 'call_type', 'is_outgoing')
            ->withTimestamps();
    }

    public function mood()
    {
        return $this->belongsToMany(Emoji::class, 'today_mood', 'user_id', 'emoji_id')
            ->withPivot('valid_till', 'emoji_id')
            ->withTimestamps();
    }

    public function referral_link()
    {
        return $this->hasOne(ReferralLink::class, 'user_id', 'id');
    }

    public function verificationImages()
    {
        return $this->hasMany(VerificationImages::class, 'user_id', 'id');
    }

    public function otherAppCounter()
    {
        return $this->hasOne(OtherAppCounter::class, 'user_id', 'id');
    }

    public function referralCodeAttempts()
    {
        return $this->hasOne(ReferralCodeAttempts::class, 'user_id', 'id');
    }

    public function offers()
    {
        return $this->hasMany(UserPurchasedOffers::class, 'user_id', 'id');
    }

    public function subscription_availed()
    {
        return $this->hasMany(SubscriptionAvailed::class, 'user_id', 'id');
    }
}
