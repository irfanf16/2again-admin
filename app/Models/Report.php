<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $table = 'reports';

    protected $fillable = [
        'reported_by',
        'reported_user',
        'reason',
        'message',
        'is_viewed',
        'reported_reason_id'
    ];


    public function reportedBy(){
        return $this->belongsTo(User::class,'reported_by','id')->withTrashed();
    }
    public function reportedUser(){
        return $this->belongsTo(User::class,'reported_user','id')->withTrashed();
    }
    public function reportReason(){
        return $this->belongsTo(ReportReason::class,'reason','id');
    }
}
