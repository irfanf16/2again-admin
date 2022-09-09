<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = [
        'user_id',
        'title',
        'role_id',
        'body',
        'data',
        'is_read',
        'sent_by_admin'
    ];
    public function admin(){
        return $this->belongsTo(User::class,'sent_by_admin','id')->withTrashed();
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id','id')->withTrashed();
    }
}
