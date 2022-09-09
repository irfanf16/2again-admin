<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Looking extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function lookingTranslation(){
        return $this->hasOne(Translation::class, 'record_id', 'id');
    }

    public $timestamps = false;
}
