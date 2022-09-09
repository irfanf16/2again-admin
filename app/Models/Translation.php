<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    use HasFactory;
    protected $fillable=
    [
        'table_name',
        'column_name',
        'record_id',
        'language_id',
        'translation'
    ];

    public function language(){
        return $this->belongsTo(Language::class,'language_id','id');
    }
}
