<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $table = 'offers';

    protected $fillable = [
        'title',
        'description',
        'cost',
        'icon',
        'valid_till',
        'start_date',
    ];

    public function consumables(){
        return $this->belongsToMany(Consumable::class, 'offer_item', 'offers_id', 'consumables_id')->withPivot('quantity');
    }
}
