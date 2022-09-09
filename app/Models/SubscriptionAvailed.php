<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionAvailed extends Model
{
    use HasFactory;

    protected $table = 'subscription_availed';

    protected $fillable = [
        'user_id',
        'package_id',
        'is_availed'
    ];

    public $timestamps = false;
}
