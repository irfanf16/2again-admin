<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherAppCountry extends Model
{
    use HasFactory;

    protected $table = 'other_app_country';

    protected $fillable = [
        'other_apps_id',
        'country_id'
    ];
}
