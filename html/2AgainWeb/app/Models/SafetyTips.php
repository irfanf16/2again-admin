<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SafetyTips extends Model
{
    use HasFactory;

    protected $table = 'safety_tips';

    protected $fillable = [
        'icon',
        'tip',
        'title'
    ];
}
