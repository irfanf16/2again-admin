<?php

namespace App\Jobs;

use App\Mail\PreRegistrationMail;
use App\Notifications\PreRegistrationNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class SendRegistrationEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $send_mail;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($send_mail)
    {
        $this->send_mail = $send_mail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        // Notification::route('mail', $this->send_mail)
        // ->notify(new PreRegistrationNotification($this->send_mail));

        // $this->send_mail->notify(new PreRegistrationNotification($this->send_mail));
//        $email =new PreRegistrationMail();
//        Mail::to($this->send_mail)->send($email);

        $email =new PreRegistrationMail();
        Mail::to($this->send_mail)->send($email);
    }
}
