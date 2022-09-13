<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FAQs extends Model
{
    use HasFactory;

    protected $table = 'faqs';

    protected $fillable = [
        'question',
        'answer',
        'sort',
        'faq_type_id'
    ];

    public $timestamps = false;

    public function faqType(){
        return $this->belongsTo(FaqTypes::class);
    }
}
