<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KeepInTouch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KeepInTouchController extends Controller
{

    public function store(Request $request){



        $validation = Validator::make($request->all(),[
            'firstname'=>'required',
            'lastname'=>'required',
            'email'=>'required',
            'message'=>'required',
        ]);
        if ($validation->fails()) {
            $response['response'] = $validation->messages();
            $response['data'] =false;

        } else {
            KeepInTouch::create($request->all());
            $response['response'] ='Thank For your feed back';
            $response['data'] =true;
        }
        return response()->json($response);

    }
}
