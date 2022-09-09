<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrowdfundingVoucher extends Model
{
    use HasFactory;

    protected $fillable=['company_id','subscription_type','subscription_month','voucher_code','associate_product_credit'];
    public function company(){
        return $this->belongsTo(Company::class,'company_id','id');
    }
}
