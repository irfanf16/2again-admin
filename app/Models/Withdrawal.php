<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    protected $table = 'withdrawals';

    protected $fillable = [
       'user_id',
        'coins',
        'amount', 6,
        'conversion_rate',
        'is_approved',
        'declined_reason',
        'user_payment_methods_id'
    ];
//    public function paymentMethod(){
//        return $this->belongsToMany(PaymentMethod::class,'user_payment_methods','user_payment_methods_id','payment_method_id','id')->withPivot('email');
//    }
    public function userPaymentMethod(){
        return $this->belongsTo(UserPaymentMethod::class,'user_payment_methods_id','id');
    }

    public function users(){
        return $this->belongsTo(User::class,'user_id','id')->withTrashed();
    }
}
