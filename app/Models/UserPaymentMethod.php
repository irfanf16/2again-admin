<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class UserPaymentMethod extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'user_payment_methods';

    protected $fillable = [
            'user_id',
            'payment_methods_id',
            'email',
            'otp',
            'is_verified',
    ];

    public function paymentMethod(){
        return $this->belongsTo(PaymentMethod::class, 'payment_methods_id', 'id');
    }
}
