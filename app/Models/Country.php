<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $table = 'countries';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'iso2',
        'phonecode',
        'capital',
        'currency',
        'region'
    ];

    public function countryTranslation(){
        return $this->hasOne(Translation::class, 'record_id', 'id');
    }
}
