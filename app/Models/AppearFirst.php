<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppearFirst extends Model
{
    use HasFactory;

    protected $table = 'appear_firsts';

    protected $fillable = [
        'user_candidate',
        'user_target',
        'has_seen'
    ];
}
