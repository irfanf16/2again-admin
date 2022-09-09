<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Religion extends Model
{
    use HasFactory;

    protected $table = 'religions';

    protected $fillable = [
        'name'
    ];

    public $timestamps = false;

    public function religionTranslation(){
        return $this->hasOne(Translation::class, 'record_id', 'id');
    }
}
