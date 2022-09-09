<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannedUsers extends Model
{
    use HasFactory;

    protected $table = 'banned_users';

    protected $fillable = [
        'banned_user',
        'banned_by',
        'time_banned_for',
        'banned_forever'
    ];
}
