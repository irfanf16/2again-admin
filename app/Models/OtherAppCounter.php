<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherAppCounter extends Model
{
    use HasFactory;

    protected $table = 'other_app_counters';

    protected $fillable = [
       'user_id',
       'app_id',
      'ip_address',
      'mac_address',
    ];
}
