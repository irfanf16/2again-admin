<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GiftInvitations extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'gifts_invitations';

    protected $fillable = [
            'name',
            'type',
            'price',
            'silver_coin',
            'icon',
    ];

    public $timestamps = false;

    public function user(){
        return $this->belongsToMany(User::class, 'wishlist', 'gifts_invitations_id', 'user_id');
    }

    public function giftInvitationTranslation(){
        return $this->hasOne(Translation::class, 'record_id', 'id');
    }
}
