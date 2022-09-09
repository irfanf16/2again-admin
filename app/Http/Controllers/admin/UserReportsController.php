<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use App\Models\Report;
use App\Traits\TimeZoneToUTC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Yajra\DataTables\DataTables;

class UserReportsController extends Controller
{
    use TimeZoneToUTC;

    public function reportsView(){
        return view('admin.pages.userReports');
    }
    public function getReportsList(Request $request){
        if ($request->ajax()) {
            $data = Report::with('reportedBy', 'reportedUser', 'reportReason')->get();
            return Datatables::of($data)
            ->addIndexColumn()
                ->addColumn('reported_user', function($row){
                    $icon_url = env('MEDIA_URL');
                    $picture = $row->reportedUser->profile_pic ?? '2AgainLogo_1646725849.png';
                    $name = $row->reportedUser->name ?? '2Again User';
                    $lastname = $row->reportedUser->lastname ?? ' ';
                    $country = $row->reportedUser->country->name ?? 'No Country';
                    $route=$row->reportedUser ? route('admin.manage.users.detail', $row->reportedUser->id) : '#';
                    $image = '    <td>
                                <div class="user-profile">
                                    <div class="user-img">
                                        <a href="'.$route.'"><img src="'.$icon_url.$picture.'"></a>
                                    </div>

                                <div class="description">
                                <a href="'.$route.'"><div class="user-title">'.$name.' '.$lastname.'</div></a>

                                </div>
                                </div>
                            </td>';
                    return $image;
                })
                ->addColumn('reported_by', function($row){
                    $icon_url = env('MEDIA_URL');
                    $picture = $row->reportedBy->profile_pic ?? '2AgainLogo_1646725849.png';
                    $name = $row->reportedBy->name ?? '2Again User';
                    $lastname = $row->reportedBy->lastname ?? ' ';
                    $country = $row->reportedBy->country->name ?? 'No Country';
                    $route=$row->reportedUser ? route('admin.manage.users.detail', $row->reportedBy->id) : '#';

                    $image = '    <td>
                                <div class="user-profile">
                                    <div class="user-img">
                                        <a href="'.$route.'"><img src="'.$icon_url.$picture.'"></a>
                                    </div>

                                <div class="description">
                                <a href="'.$route.'"><div class="user-title">'.$name.' '.$lastname.'</div></a>

                                </div>
                                </div>
                            </td>';
                    return $image;
                })
                ->addColumn('reported_reason',function ($row){
                    return $row->reportReason->reason ?? 'N/A';
                })
                ->addColumn('reported_date',function ($row){
                    return $row->created_at->toDayDateTimeString();
                })
                ->rawColumns(['reported_user', 'reported_by'])

            ->make(true);
        }
    }
    public function supportEmail(){
        return view('admin.pages.supportEmail');
    }
    public function emailSupportList(Request $request){

        $data=ContactUs::all();

        if ($request->ajax()) {
            $zone=Cookie::get('zone');

            $data=ContactUs::with('user')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function($row){
                    $icon_url = env('MEDIA_URL');
                    $picture = $row->user->profile_pic ?? '2AgainLogo_1646725849.png';
                    $name = $row->user->name ?? '2Again User';
                    $route='#';
                    if ($row->user){
                        $route=route('admin.manage.users.detail', $row->user->id);
                    }
                    $lastname = $row->user->lastname ?? ' ';
                    $country = $row->user->country->name ?? 'No Country';
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
                ->addColumn('country',function ($row){
                    return $row->user->country->name ?? 'No Country';
                })
                ->addColumn('created_at',function ($row) use($zone){
                    return $this->TimeZoneToLocal($row->created_at,$zone);

                })
                ->rawColumns(['image'])

                ->make(true);
        }
    }
}
