<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\SendRegistrationEmailJob;
use App\Mail\PreRegistrationMail;
use App\Models\Subscriber;
use App\Notifications\PreRegistrationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class SubscriberController extends Controller
{
    public function subscriber(Request $request){
        $validation = Validator::make($request->all(),[
            'email'=>'required|unique:subscribers',
        ]);
        if ($validation->fails()) {
            $response['response'] = $validation->messages();
            $response['data'] =false;

        } else {
            dispatch(new SendRegistrationEmailJob($request->email));
//            dispatch(new PreRegistrationNotification($request->email));
//            Subscriber::create($request->all());
            $response['response'] ='Thank For your Pre-launching Registration we will contact you soon.!';
            $response['data'] =true;
        }
        return response()->json($response);
    }
}
