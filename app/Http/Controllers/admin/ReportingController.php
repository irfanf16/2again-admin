<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ReportingController extends Controller
{
    public function index(){

        $users=User::all();

        $IOSUsers=$users->where('device_type','IOS')->count();
        $AndroidUsers=$users->where('device_type','ANDROID')->count();
        $WEBUsers=$users->where('device_type','WEB')->count();

        dd($IOSUsers,$AndroidUsers,$WEBUsers);


        return view('admin.pages.reporting');
    }
}
