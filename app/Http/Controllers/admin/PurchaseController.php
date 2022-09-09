<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Traits\TimeZoneToUTC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Yajra\DataTables\DataTables;

class PurchaseController extends Controller
{
    use TimeZoneToUTC;
    public function purchases(){
        return view('admin.pages.purchases');
    }

    public function list(Request $request){
        if($request->ajax()){
            $zone=Cookie::get('zone');
            $data = Purchase::with(['user' => function($query){
                $query->with('country')->withTrashed();
            }])->orderBy('id', 'DESC')->get();

            return Datatables::of($data)
            ->addIndexColumn()
//            ->addColumn('action', function($row){
//                $actionBtn = '<div class="dropdown">
//                                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
//                                    <i class="fas fa-ellipsis-v"></i>
//                                </button>
//                                <ul class="dropdown-menu">
//                                    <li><a  href="'.route('admin.offers.detail', $row->id).'">View Detail</a></li>
//                                </ul>
//                            </div>';
//                return $actionBtn;
//            })
                ->addColumn('country',function ($row){
                   return $row->user->country->name ?? 'No Country';
                })
                ->editColumn('created_at',function ($row) use ($zone){
                    return $this->TimeZoneToLocal($row->created_at,$zone);
//                    return $row->created_at->format('Y-m-d H:i:s');
                })
            ->addColumn('image', function($row){
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

            ->rawColumns(['action', 'image'])
            ->make(true);
        }
    }
}
