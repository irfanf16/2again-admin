<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lang extends Model
{
    use HasFactory;

    protected $fillable = [
        'language_id',
        'lang',
        'translation',
        'is_active'
    ];
    public $timestamps=false;
    public function languages(){
        return $this->belongsTo(Language::class,'language_id','id');
    }
}
