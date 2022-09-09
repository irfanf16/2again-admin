<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Jobs\PreRegisterationJob;
use App\Jobs\UserNotificationJob;
use App\Mail\PreRegistrationMail;
use App\Models\KeepInTouch;
use App\Models\Subscriber;
use App\Traits\TimeZoneToUTC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class SubscriberController extends Controller
{
    use TimeZoneToUTC;
    public function subscribers(){
        return view('admin.pages.subscriber');
    }
    public function list(Request $request){
        if ($request->ajax()) {
            $zone=Cookie::get('zone');
            $data=Subscriber::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('created_at',function ($row) use($zone){
                    return $this->TimeZoneToLocal($row->created_at,$zone);
                })
                ->make(true);
        }
    }
}
