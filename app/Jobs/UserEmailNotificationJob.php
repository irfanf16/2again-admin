<?php

namespace App\Jobs;

use App\Mail\CustomEmail;
use App\Mail\DirectMessageEmail;
use App\Mail\NewMatchEmail;
use App\Mail\NewsUpdateEmail;
use App\Mail\PreRegistrationMail;
use App\Mail\PromotionsEmail;
use App\Mail\SeenMeEmail;
use App\Mail\SuperLikeEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Notifications\DirectMessageEmailNotification;
use App\Notifications\NewMatchEmailNotification;
use App\Notifications\NewsUpdateEmailNotification;
use App\Notifications\PromotionsEmailNotification;
use App\Notifications\SeenMeEmailNotification;
use App\Notifications\SuperLikeEmailNotification;
use Illuminate\Support\Facades\Mail;

class UserEmailNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $notificationEvent;
    public $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $notificationEvent,$data)
    {
        $this->user = $user;
        $this->notificationEvent = $notificationEvent;
        $this->data=$data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::find($this->user->id);

        if($this->notificationEvent == 'DM'){
            Mail::to($user->email)->send(new DirectMessageEmail($user));
//            $user->notify(new DirectMessageEmailNotification($user));
        }elseif($this->notificationEvent == 'NewMatch'){
            Mail::to($user->email)->send(new NewMatchEmail($user));
//            $user->notify(new NewMatchEmailNotification($user));
        }elseif($this->notificationEvent == 'SuperLike'){
            Mail::to($user->email)->send(new SuperLikeEmail($user));
//            $user->notify(new SuperLikeEmailNotification($user));
        }elseif($this->notificationEvent == 'Promotions'){
            Mail::to($user->email)->send(new PromotionsEmail($this->notificationEvent,$this->data));
//            $user->notify(new PromotionsEmailNotification($user));
        }elseif($this->notificationEvent == 'CUSTOM'){
            Mail::to($user->email)->send(new CustomEmail($this->notificationEvent,$this->data));
//            $user->notify(new PromotionsEmailNotification($user));
        }elseif($this->notificationEvent == 'NewsUpdate'){
            Mail::to($user->email)->send(new NewsUpdateEmail($this->notificationEvent,$this->data));
//            $user->notify(new NewsUpdateEmailNotification($user));
        }elseif($this->notificationEvent == 'SeenMe'){
            Mail::to($user->email)->send(new SeenMeEmail($user));
//            $user->notify(new SeenMeEmailNotification($user));
        }
    }
}
