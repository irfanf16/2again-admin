<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotificationSetting extends Model
{
    use HasFactory;

    protected $table = 'user_notification_settings';

    protected $fillable = [
        'user_id',
        'NewMatchEmail',
        'NewMessageEmail',
        'SuperLikeEmail',
        'PromotionsEmail',
        'NewsUpdateEmail',
        'NewMatchPush',
        'NewMessagePush',
        'SuperLikePush',
        'PromotionsPush',
        'NewsUpdatePush',
    ];
}
