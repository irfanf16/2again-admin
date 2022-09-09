<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $table = 'languages';

    protected $fillable = [
        'name',
        'short'
    ];

    public $timestamps = false;

    public function languageTranslation(){
        return $this->hasOne(Translation::class, 'record_id', 'id');
    }

}
