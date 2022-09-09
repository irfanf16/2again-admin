<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoinSetting extends Model
{
    use HasFactory;

    protected $table = 'coin_settings';

    protected $fillable = [
        'item',
        'deduct_gold_coins',
        'earn_silver_coins',
    ];
}
