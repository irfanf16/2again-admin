<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Emoji extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'emoji';

    protected $fillable = [
        'name',
        'icon'
    ];

    public $timestamps = false;

    public function translation(){
    return  $this->hasMany(Translation::class,'record_id','id');
    }
}
