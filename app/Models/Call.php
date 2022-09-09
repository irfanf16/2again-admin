<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    use HasFactory;

    protected $fillable = [
       'call_from',
       'call_to',
       'is_picked_up',
       'call_time',
       'call_type',
       'is_outgoing'
    ];

    public function caller(){
        return $this->belongsTo(User::class, 'call_from', 'id');
    }

    public function receiver(){
        return $this->belongsTo(User::class, 'call_to', 'id');
    }
}
