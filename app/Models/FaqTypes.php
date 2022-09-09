<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqTypes extends Model
{
    use HasFactory;

    public $fillable = [
        'name'
    ];

    public $timestamps = false;

    public function faqs(){
        return $this->hasMany(FAQs::class,'faq_type_id');
    }

    public function faqtypeTranslation(){
        return $this->hasOne(Translation::class, 'record_id', 'id');
    }
}
