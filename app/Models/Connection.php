<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    use HasFactory;

    protected $table = 'connections';

    protected $fillable = [
        'send_from',
        'send_to',
        'is_direct_reply'
    ];

    public function messages(){
        return $this->hasMany(Message::class, 'connection_id', 'id');
    }

    public function sender(){
        return $this->belongsTo(User::class, 'send_from', 'id');
    }

    public function receiver(){
        return $this->belongsTo(User::class, 'send_to', 'id');
    }
}
