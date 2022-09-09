<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $table = 'subscriptions';

    protected $fillable = [
        'name',
        'shortcode',
        'badge',
    ];

    public $timestamps = false;

    public function user(){
        return $this->belongsToMany(User::class, 'user_subscriptions', 'subscription_id', 'user_id')
        ->withTimestamps()
        ->withPivot('id', 'valid_till');
    }
}
