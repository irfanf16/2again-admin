<?php

namespace App\Jobs;

use App\Models\UserPaymentMethod;
use App\Notifications\PaymentMethodCodeNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Notifications\UserNotification;

class PaymentMethodEmailVerificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

     public $method;

    public function __construct($method)
    {
        $this->method = $method;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $method = UserPaymentMethod::find($this->method->id);
        $method->notify(new PaymentMethodCodeNotification($method));
    }
}
