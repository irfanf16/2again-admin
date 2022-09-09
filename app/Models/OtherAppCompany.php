<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherAppCompany extends Model
{
    use HasFactory;
    protected $fillable=['name','email','country_id','phone'];

    public function country(){
        return $this->belongsTo(Country::class,'country_id','id');
    }
}
