<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable=['name','site_url','country_id','language_id','audience','fee'];

    public function country(){
        return $this->belongsTo(Country::class,'country_id','id');
    }
    public function language(){
        return $this->belongsTo(Language::class,'language_id','id');
    }
}
