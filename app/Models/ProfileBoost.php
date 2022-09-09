<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileBoost extends Model
{
    use HasFactory;

    protected $table = 'profile_boosts';

    protected $fillable = [
        'user_id',
        'radius',
        'is_world_wide',
        'valid_till'
    ];
}
