<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $table = 'likes';

    protected $fillable = [
        'like_to',
        'like_type',
    ];

    public function like_type(){
        return $this->hasMany(LikeType::class,'like_type','id');
    }


}
