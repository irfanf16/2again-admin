<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class RolePermissionsController extends Controller
{
    public function index(){

//        $role->permissions()->sync($permissions);
////        auth()->user()->permissions()->attach($permissions);

        return view('admin.pages.rolePermissions.roles');
    }
    public function roleslist(Request $request){

        if ($request->ajax()) {
            $data = Role::where('name','!=','User')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $action=null;
                    if($row->name !='Admin' && $row->name !='User'){
                        $action='
                          <li><a  href="' . route('admin.roles.edit', $row->id) . '" >Edit</a></li>
                                    <li><a href="javascript:void(0)" class="delete-Roles" data-Roles="' . $row->id . '">Delete</a></li>
                        ';
                    }else{
                        $action='
                          <li><a  href="' . route('admin.roles.edit', $row->id) . '" >Edit</a></li>
                        ';
                    }

                    $actionBtn = '<div class="dropdown" >
                                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                  '.$action.'
                                </ul>
                            </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

    }
    public function createRole(){
        $permissions=Permission::all();
        return view('admin.pages.rolePermissions.addRole',compact('permissions'));

    }
    public function addRole(Request $request){
        $role=Role::create([
            'name'=>$request->name,
        ]);
        $role->permissions()->sync($request->permissions);
        return redirect(route('admin.roles'))->with('success','Role added successfully');


    }
    public function editRole($id){

        $permissions=Permission::all();
        $role=Role::findOrFail($id);
        $rolePermissions = DB::table("roles_permissions")->where("roles_permissions.role_id",$id)
            ->pluck('roles_permissions.permission_id')
            ->all();

        return view('admin.pages.rolePermissions.editRole',compact('permissions','role','rolePermissions'));

    }
    public function updateRole(Request $request ,$id){
//        dd($request->permissions->id);
        $role=Role::findOrFail($id);
        $role->update(['name'=>$request->name]);
        $role->permissions()->sync($request->permissions);
        return redirect(route('admin.roles'))->with('success','Role Updated Successfully');
    }
    public function deleteRole(Request $request){

        $role=Role::findOrFail($request->roles);
//        $role->permissions()->delete();
        $role->delete();
        return back()->with('success','Role deleted successfully');
    }

    public function permissions(){
        return view('admin.pages.rolePermissions.permissions');
    }
    public function permissionslist(Request $request){

        if ($request->ajax()) {
            $data = Permission::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<button  href="javascript:void(0)" class="edit-permissions-display-name" data-permission="' . $row->id . '">Edit</a>';

                })
                ->rawColumns(['action'])
                ->make(true);
        }

    }
    public function editPermission($id){
        $permission=Permission::find($id);
        return view('admin.inc.EditPermission',compact('permission'));
    }
    public function updatePermission(Request $request,$id){
        Permission::find($id)->update(['display_name'=>$request->display_name]);
        return back()->with('success','Permission updated successfuully');

    }


}
