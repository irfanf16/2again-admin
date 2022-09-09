<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGiftInvitation extends Model
{
    use HasFactory;

    protected $table = 'users_gifts_invitations';

    protected $fillable = [
    'from_user',
     'to_user',
     'gifts_invitations_id',
     'price',
     'is_accepted'
    ];


    public function fromUser(){
        return $this->belongsTo(User::class, 'from_user', 'id');
    }

    public function toUser(){
        return $this->belongsTo(User::class, 'to_user', 'id');
    }

    public function giftInvitation(){
        return $this->belongsTo(GiftInvitations::class, 'gifts_invitations_id',  'id');
    }
}
