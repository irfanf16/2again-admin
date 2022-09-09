<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherApp extends Model
{
    use HasFactory;

    protected $table = 'other_apps';

    protected $fillable = [
        'name',
        'icon',
        'url_android',
        'uri_android',
        'url_ios',
        'uri_ios',
        'bundle_id_ios',
        'bundle_id_android',
        'other_app_company_id',
        'all_over_world',
        'is_active',
    ];

//    public function country(){
//        return $this->hasMany(OtherAppCountry::class, 'other_apps_id', 'id');
//    }
    public function company(){
        return $this->belongsTo(OtherAppCompany::class,'other_app_company_id','id');
    }
    public function appClicks(){
        return $this->hasMany(OtherAppCounter::class,'app_id','id');
    }
    public function appDownloads(){
        return $this->hasMany(OtherAppDownload::class,'other_apps_id','id');
    }
    public function user(){
        return $this->belongsToMany(User::class, 'other_apps_downloads', 'other_apps_id', 'user_id');
    }
    public function country(){
        return $this->belongsToMany(Country::class,OtherAppCountry::class,'other_apps_id','country_id');
    }


}
