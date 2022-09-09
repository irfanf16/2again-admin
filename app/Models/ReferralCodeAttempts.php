<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralCodeAttempts extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'attempts',
        'timer'
    ];

    public $timestamps = false;
}
