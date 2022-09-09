<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Traits\FileUploadTrait;
use App\Traits\TimeZoneToUTC;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class SystemUserController extends Controller
{
    use FileUploadTrait,TimeZoneToUTC;
    public function index()
    {
        $countries = Country::all();
        $roles = Role::where('name', '!=', 'User')->get();
        return view('admin.pages.systemUsers.systemUsers', compact('countries', 'roles'));
    }

    public function systemUserList(Request $request)
    {

        if ($request->ajax()) {
            $zone = Cookie::get('zone');

            $data = User::withTrashed()->with(['country', 'roles', 'banned'])
                ->whereDoesntHave('roles', function ($q) {
                    $q->where('name', '=', 'User');
                })->whereHas('roles')
//                ->whereHas('banned',function ($q) use ($zone){
//               return $q->where($this->TimeZoneToLocal($q->time_banned_for, $zone),'>=', $this->TimeZoneToLocal(Carbon::now(), $zone));
//            })
                ->whereNotNull('profile_pic')
                ->when($request->has('gender') && $request->filled('gender'), function ($q) use ($request) {
                    return $q->where('gender_id', $request->gender)->where('gender_id', '!=', null);
                })
                ->when($request->has('date1') && $request->filled('date1') && $request->has('date2') && $request->filled('date2'), function ($q) use ($request) {
                    return $q->whereDate('created_at', '>=', $request->date1)->whereDate('created_at', '<=', $request->date2);
                })
                ->when($request->has('country') && $request->filled('country'), function ($q) use ($request) {
                    return $q->where('country_id', $request->country);
                })
                ->when($request->has('Onlinenow') && $request->get('Onlinenow') == 1, function ($q) use ($request) {
                    return $q->where('is_online', '=', 1)->where('deleted_at', '=', null);
                })
                ->when($request->has('age1') && $request->filled('age1') && $request->has('age2') && $request->filled('age2'), function ($q) use ($request) {
                    return $q->where('age', '>=', $request->age1)->where('age', '<=', $request->age2);
                })
                ->when($request->has('vip') && $request->filled('vip') && $request->vip == 1, function ($q) use ($request) {
                    return $q->with(['subscription'])->whereHas('subscription', function ($query) {
                        $query->where('shortcode', 'VIP')->where('valid_till', '>', Carbon::now());
                    });
                })
                ->when($request->has('bigSpender') && $request->filled('bigSpender') && $request->bigSpender == 1, function ($q) use ($request) {
                    return $q->with(['subscription'])->whereHas('subscription', function ($query) {
                        $query->where('shortcode', 'BS')->where('valid_till', '>', Carbon::now());
                    });
                })
                ->when($request->has('customBadge') && $request->filled('customBadge') && $request->customBadge == 1, function ($q) use ($request) {
                    return $q->with(['subscription'])->whereHas('subscription', function ($query) {
                        $query->where('shortcode', 'CUSTOM')->where('valid_till', '>', Carbon::now());
                    });
                })
                ->when($request->has('gam') && $request->filled('gam') && $request->gam == 1, function ($q) use ($request) {
                    return $q->with(['subscription'])
                        ->whereDoesntHave('subscription', function ($query) {
                            $query->where('shortcode', 'BS')->where('valid_till', '>', Carbon::now());
                        })
                        ->whereDoesntHave('subscription', function ($query) {
                            $query->where('shortcode', 'VIP')->where('valid_till', '>', Carbon::now());
                        });
                })
                ->when($request->has('bannedUsers') && $request->filled('bannedUsers') && $request->bannedUsers == 1, function ($q) use ($request, $zone) {
//                    return $q->whereHas('banned');

                    return $q->whereHas('banned', function ($query) use ($zone) {
                        $query->where('time_banned_for', '>=', Carbon::now())->orwhere('banned_forever',1);
                    });
                })
                ->when($request->has('deletedUsers') && $request->filled('deletedUsers') && $request->deletedUsers == 1, function ($q) use ($request) {
                    return $q->where('deleted_at', '!=', null);
                })
                ->when($request->has('accountStatus') && $request->filled('accountStatus'), function ($q) use ($request, $zone) {
                    if ($request->accountStatus == 'deleted') {
                        return $q->where('deleted_at', '!=', null);
                    }
                    if ($request->accountStatus == 'banned') {
//                        return $q->whereHas('banned');
                        return $q->whereHas('banned', function ($query) use ($zone) {
                            $query->where('time_banned_for', '>=', Carbon::now())->orwhere('banned_forever',1);
                        });
//                        return $q->whereHas('banned',function ($query) use($zone){
//                            $query->where($this->TimeZoneToLocal($query->banned->time_banned_for, $zone),'>=', $this->TimeZoneToLocal(Carbon::now(), $zone));
//                        });
                    }
                    if ($request->accountStatus == 'active') {
                        return $q->where('deleted_at', '=', null)->whereDoesntHave('banned');
                    }

                })
                ->latest()->get();
            $app_user_change_password=0;
            $app_user_ban=0;
            $app_user_unban=0;
            $app_user_delete=0;
            $app_user_recover=0;
            if($request->user()->can('system-user-change-password')){
                $app_user_change_password=1;
            }
            if($request->user()->can('system-user-ban')){
                $app_user_ban=1;
            }
            if($request->user()->can('system-user-unban')){
                $app_user_unban=1;
            }
            if($request->user()->can('system-user-delete')){
                $app_user_delete=1;
            } if($request->user()->can('system-user-recover')){
                $app_user_recover=1;
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->toDayDateTimeString();
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->created_at->toDayDateTimeString();
                })
                ->editColumn('roles', function ($row) {
                    $roles=[];
                    foreach ($row->roles as $role){
                        $roles[]=$role->name;
                    }
                    return $roles;
                })
                ->addColumn('country', function ($row) {
                    return $row->country->name ?? 'N/A';
                })
                ->addColumn('status', function ($row) use ($zone) {
                    if ($row->deleted_at == null) {
                        if ($row->banned != null) {
//                            if ($this->TimeZoneToLocal($row->banned->time_banned_for, $zone) >= $this->TimeZoneToLocal(Carbon::now(), $zone)) {
                            if($row->banned->banned_forever==1){
                                return 'Banned';
                            }
                            if ($row->banned->time_banned_for >= Carbon::now()) {
                                return 'Banned';
                            }
                            return 'Active';
                        } else {
                            return 'Active';
                        }
                    }else if($row->deleted_at != null && $row->banned != null){
                        return 'Banned, Deleted';
                    }
                    else {
                        return 'Deleted';
                    }
                })
                ->addColumn('action', function ($row) use($app_user_change_password,$app_user_ban,$app_user_unban,$app_user_delete,$app_user_recover){

//                    if($app_user_change_password==1 || $app_user_ban==1 || $app_user_unban==1 || $app_user_delete==1 || $app_user_recover==1){
                    $changePassword='';
                    $banUser='';
                    $unbanUser='';
                    $deleteAccount='';
                    $recoveryAccount='';
                    if($app_user_change_password==1){
                        $changePassword=' <li><a  href="" class="change_password"  data-user="' . $row->id . '">  Change password</a></li>';
                    }
                    if($app_user_ban==1){
                        $banUser=' <li><a id="banUserModalBtn"  href="" class="ban_user" data-user="' . $row->id . '" >Ban user</a></li>';
                    }
                    if($app_user_unban==1){
                        $unbanUser=' <li><a id="banUserModalBtn"  href="" class="unBan_user" data-user="' . $row->id . '">UnBan user</a></li>';
                    }
                    if($app_user_delete==1){
                        $deleteAccount='  <li><a  href="" class="delete_user"  data-user="' . $row->id . '">Delete account</a></li>';
                    } if($app_user_recover==1){
                        $recoveryAccount=' <li><a  href="" class="recover_user"  data-user="' . $row->id . '"> Recover User</a></li>';
                    }

                    if ($row->deleted_at == null) {
                        if ($row->banned != null) {
                            if($row->banned->banned_forever==1){
                                $is_ban = $unbanUser.$deleteAccount;
                            } elseif ($row->banned->time_banned_for >= Carbon::now()) {
                                $is_ban = $unbanUser.$deleteAccount;
                            }else{
                                $is_ban =$changePassword.$banUser.$deleteAccount;
                            }
                        }else{
                            $is_ban =$changePassword.$banUser.$deleteAccount;
                        }
                        $actionBtn = '<div class="dropdown">
                                    <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        ' . $is_ban . '
                                    </ul>
                                </div>';
                    } else {
                        $actionBtn = '<div class="dropdown">
                                    <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        '.$recoveryAccount.'
                                    </ul>
                                </div>';
                    }
                    return $actionBtn;
//                    }else{
//                        return 'No Action';
//                    }

                })
                ->addColumn('user', function ($row) use ($zone) {
                    $urlProfile = env('MEDIA_URL');
                    $is_online = '';
                    if ($row->deleted_at == null) {
                        if ($row->banned != null) {

                            if($row->banned->banned_forever==1){
                                $is_online='';
                            }else{
                                if ($this->TimeZoneToLocal($row->banned->time_banned_for, $zone) >= $this->TimeZoneToLocal(Carbon::now(), $zone)) {
                                    $is_online = ' ';
                                }else{
                                    $is_online = $row->is_online == 0 ? '<span class="active-status bg-red">' : ' <span class="active-status bg-green">';
                                }
                            }


                        } else {
                            $is_online = $row->is_online == 0 ? '<span class="active-status bg-red">' : ' <span class="active-status bg-green">';
                        }
                    }
                    $image = '    <div class="user-profile">
                                    <div class="user-img">
                                        <a href="' . route('admin.system.users.edit', $row->id) . '"></span><img src="' . $urlProfile . $row->profile_pic . '"></a>

                                        </div>
                                        <div class="description">
                                            <div class="user-title">  ' . $row->name . ' ' . $row->lastname . '  </div>

                                        </div>
                                    </div>';
                    return $image;
                })
                ->rawColumns(['action', 'user'])
                ->make(true);
        }

    }

    public function systemUserStore(Request $request)
    {

        $role = Role::with('permissions')->findorfail($request->role_id);
        $image = $this->uploadSingleImage($request);
        $user = User::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => $request->password,
            'gender_id' => $request->gender_id,
            'profile_pic'=>$image,
            'ip'=>$request->ip,
        ]);
        $user->roles()->sync($role);
//        $user->permissions()->sync($role->permissions);
        return back()->with('success','User added Successfully');
    }
    public function systemUserEdit($id){

        $user=User::findorfail($id);
        $permissions=Permission::all();
        $roles = Role::where('name', '!=', 'User')->get();

        return view('admin.pages.systemUsers.editSystemUser',compact('user','permissions','roles'));
    }
    public function systemUserUpdate(Request $request,$id){

//        $request->validate([
//            'name' => 'required',
//            'lastname' => 'required',
//            'email' => 'required',
//            'dob' => 'required',
//            'gender_id' => 'required',
//        ]);
        $image = $this->uploadSingleImage($request);
        $request['profile_pic'] = $image;
        $user=User::find($id);
        $role = Role::with('permissions')->findorfail($request->role_id);
        $user->roles()->sync($role);
//        $user->permissions()->sync($request->permissions);
        $user->update($request->all());
        return redirect(route('admin.system.users'))->with('success','User updated Successfully');
    }

}
