<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseMessages extends Model
{
    use HasFactory;

    protected $fillable =   [
        'key_string',
        'key_translation'
    ];

    public function responseMessageTranslation(){
        return $this->hasOne(Translation::class, 'record_id', 'id');
    }
}
