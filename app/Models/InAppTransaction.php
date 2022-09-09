<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InAppTransaction extends Model
{
    use HasFactory;

    protected $table = 'in_app_transactions';

    protected $fillable = [
          'user_id',
          'earned_from',
          'source',
          'type',
          'coin',
          'amount',
    ];
}
