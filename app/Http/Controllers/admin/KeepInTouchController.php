<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use App\Models\KeepInTouch;
use App\Models\Subscriber;
use App\Traits\TimeZoneToUTC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class KeepInTouchController extends Controller
{
    use TimeZoneToUTC;
    public function keepInTouch(){
        return view('admin.pages.KeepInTouch');
    }
    public function list(Request $request){
        if ($request->ajax()) {
            $zone=Cookie::get('zone');
            $data=KeepInTouch::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('created_at',function ($row) use($zone){
                    return $this->TimeZoneToLocal($row->created_at,$zone);
                })
                ->addColumn('name',function ($row) {
                    return $row->firstname.' '.$row->lastname;
                })
                ->make(true);
        }
    }

}
