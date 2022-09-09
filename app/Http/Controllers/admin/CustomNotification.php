<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Offer;
use App\Models\User;
use App\Traits\NotificationTrait;
use App\Traits\TimeZoneToUTC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Yajra\DataTables\DataTables;

class CustomNotification extends Controller
{
    use NotificationTrait,TimeZoneToUTC;

    public function index()
    {
        return view('admin.pages.notification.customNotification');
    }
    public function appNotification()
    {
        return view('admin.pages.notification.appNotification');
    }

    public function notificationSend(Request $request)
    {

//        dd($request->all());
        if ($request->has('userId')) {
            $this->sendNotification($request->userId, $request->type, $request->all());
        } else {
            $this->sendNotification(null, $request->type, $request->all());
        }
        return back()->with('success', 'Notification send successfully');
    }
    public function notificationList(Request $request){
        if ($request->ajax()) {
            $data = Notification::with('user','admin')->where('sent_by_admin','!=',null)->latest()->get();
            $zone=Cookie::get('zone');
            return Datatables::of($data)
                ->addIndexColumn()

                ->addColumn('sent_by_admin', function ($row) {
                    $urlProfile = env('MEDIA_URL');
                    $image = '    <div class="user-profile">
                                    <div class="user-img">
                                        <a href="' . route('admin.system.users.edit', $row->admin->id) . '"></span><img src="' . $urlProfile . $row->admin->profile_pic . '"></a>

                                        </div>
                                        <div class="description">
                                            <a href="' . route('admin.system.users.edit', $row->admin->id) . '"><div class="user-title">  ' . $row->admin->name . ' ' . $row->admin->lastname . '  </div></a>

                                        </div>
                                    </div>';

                    return $image;
                })
                ->addColumn('user', function ($row) {
                    $urlProfile = env('MEDIA_URL');
                    if (!$row->user){
                        return 'To All Users';
                    }
                    $image = '    <div class="user-profile">
                                    <div class="user-img">
                                        <a href="' . route('admin.manage.users.detail', $row->user->id) . '"></span><img src="' . $urlProfile . $row->user->profile_pic . '"></a>

                                        </div>
                                        <div class="description">
                                           <a href="' . route('admin.manage.users.detail', $row->user->id) . '"> <div class="user-title">  ' . $row->user->name . ' ' . $row->user->lastname . '  </div></a>

                                        </div>
                                    </div>';

                    return $image;
                })

                ->editColumn('created_at',function ($row) use($zone){

                    return $this->TimeZoneToLocal($row->created_at,$zone);
                })

                ->rawColumns([ 'user','sent_by_admin'])
                ->make(true);
        }
    }
    public function appNotificationList(Request $request){
        if ($request->ajax()) {
            $zone=Cookie::get('zone');
            $data = Notification::with('user')->where('role_id',1)->latest()->get();


            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('user', function ($row) {
                    $picture = $row->user->profile_pic ?? '2AgainLogo_1646725849.png';
                    $name = $row->user->name ?? '2Again User';
                    $route='#';
                    if ($row->user){
                        $route=route('admin.manage.users.detail', $row->user->id);
                    }
                    $lastname = $row->user->lastname ?? ' ';
                    $icon_url = env('MEDIA_URL');
                    $picture = $row->user->profile_pic ?? '2AgainLogo_1646725849.png';
                    $name = $row->user->name ?? '2Again User';
                    $route='#';
                    if ($row->user){
                        $route=route('admin.manage.users.detail', $row->user->id);
                    }
                    $lastname = $row->user->lastname ?? ' ';
//                $country = $row->user->country->name ?? 'No Country';
                    $image = '    <td>
                                <div class="user-profile">
                                    <div class="user-img">
                                        <a href="' . $route . '"><img src="'.$icon_url.$picture.'"></a>
                                    </div>

                                <div class="description">
                                <a href="' . $route . '"><div class="user-title">'.$name.' '.$lastname.'</div></a>

                                </div>
                                 </div>
                            </td>';
                    return $image;
                })

                ->editColumn('created_at',function ($row) use($zone){

                    return $this->TimeZoneToLocal($row->created_at,$zone);
                })

                ->rawColumns([ 'user'])
                ->make(true);
        }
    }
}
