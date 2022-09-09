<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Country;
use App\Models\Language;
use App\Models\OtherApp;
use App\Models\OtherAppCompany;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class OtherAppController extends Controller
{

    use FileUploadTrait;

//   companies
    public function companies(){
        $countries=Country::all();
        return view('admin.pages.otherApp.otherAppCompanies',compact('countries'));
    }
    public function companiesList(Request $request){
        if ($request->ajax()) {

            $data = OtherAppCompany::with('country')->get();
            $is_edit=0;
            $is_delete=0;
            if ($request->user()->can('otherApp-edit')){
                $is_edit=1;
            }if ($request->user()->can('otherApp-delete')){
                $is_delete=1;
            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('country',function ($row){
                    return $row->country->name;
                })
                ->addColumn('action', function ($row) use($is_edit,$is_delete) {
                    if ($is_edit){
                        $edit='<li><a  href="javascript:void(0)" class="edit-otherApp-company" data-company="' . $row->id . '">Edit</a></li>';
                    }else{
                        $edit='';
                    }
                    if ($is_delete){
                        $delete='<li><a href="javascript:void(0)" class="delete-otherApp-company" data-company="' . $row->id . '">Delete</a></li>';
                    }else{
                        $delete='';
                    }
                    $actionBtn = '<div class="dropdown" >
                                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                  '.$edit.$delete.'

                                </ul>
                            </div>';
                    return $actionBtn;
                })
                ->make(true);
        }
    }
    public function companiesStore(Request $request){
        $company=OtherAppCompany::create($request->all());
        return back()->with('success','Company added successfully');
    }
    public function companiesEdit($id){
        $company=OtherAppCompany::findorfail($id);
        $countries=Country::all();
        return view('admin.inc.EditOtherAppCompany',compact('company','countries'));
    }
    public function companiesUpdate(Request $request){
        $company=OtherAppCompany::findorfail($request->companyId)->update($request->all());
        return back()->with('success','Company updated successfully');
    }
    public function companiesDelete(Request $request){
        $company=OtherAppCompany::findorfail($request->company)->delete();
        return back()->with('success','Company deleted successfully');
    }

//    apps
    public function index(){
        return view('admin.pages.otherApp.OtherAppSetting');
    }
    public function addOtherApp(){
        $companies=OtherAppCompany::all();
        $countries=Country::all();
        return view('admin.pages.otherApp.addOtherApp',compact('companies','countries'));

    }
    public function OtherAppList(Request $request){

        if ($request->ajax()) {

            $data = OtherApp::with(['company','country','appClicks','appDownloads'])

                ->when($request->has('company_id') && $request->company_id !='',function ($q) use ($request){
                    $q->where('company_id',$request->company_id);
                })
                ->get();
            $is_edit=0;
            $is_delete=0;
            if ($request->user()->can('otherApp-edit')){
                $is_edit=1;
            }if ($request->user()->can('otherApp-delete')){
                $is_delete=1;
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function($row){
                    $urlProfile = env('GIFT_URL');
                    $image = '    <div class="user-profile">
                                    <div class="user-img">
                                        <a ><img src="'.$urlProfile.$row->icon.'"></a>
                                        </div>

                                    </div>';
                    return $image;
                })
                ->editColumn('clicks',function ($row){
                    return $row->appClicks->count();
                })
                ->editColumn('downloads',function ($row){
                    return $row->appDownloads->count();
                })
                ->addColumn('company',function ($row){
                    return $row->company->name ?? 'No Name';
                })
                ->addColumn('country',function ($row){
                    $Countrynames=[];
                    foreach ($row->country as $country){
                        $Countrynames[]=$country->name;
                    }
                    if(count($Countrynames) > 0){
                        return $Countrynames;
                    }else{

                    }
                })
                ->editColumn('all_over_world',function ($row){
                    if ($row->all_over_world==1){
                        return 'Yes';
                    }else{
                        return   'No';
                    }

                })
                ->addColumn('active',function ($row){
                    if ($row->is_active==1){
                       return 'Yes';
                    }else{
                        return   'No';
                    }
                })
                ->addColumn('action', function ($row) use ($is_edit,$is_delete) {
                    if ($is_edit){
                        $edit='<li><a  href="' . route('admin.otherApps.edit', $row->id) . '" >Edit</a></li>';
                    }else{
                        $edit='';
                    }
                    if ($is_delete){
                        $delete='<li><a href="javascript:void(0)" class="delete-OtherApp" data-OtherApp="' . $row->id . '">Delete</a></li>';
                    }else{
                        $delete='';
                    }
                    $actionBtn = '<div class="dropdown" >
                                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    '.$edit.$delete.'

                                </ul>
                            </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'image'])
                ->make(true);
        }

    }
    public function OtherAppStore(Request $request){

        if ($request->hasFile('file')){
            $file = $this->uploadIconImage($request);
            $request['icon'] = $file;
        }

        $otherApp=OtherApp::create($request->all());
        $otherApp->country()->attach($request->countries);

        return redirect(route('admin.otherApps'))->with('success',' Added successfully');
    }
    public function OtherAppDelete(Request $request){
        OtherApp::findorfail($request->OtherApp)->delete();
        return back()->with('success',' Deleted successfully');

    }
    public function OtherAppEdit($id){
        $otherApp=OtherApp::with('country')->findorfail($id);
        $companies=OtherAppCompany::all();
        $countries=Country::all();
        return view('admin.pages.otherApp.editOtherApp',compact('otherApp','companies','countries'));
    }
    public function OtherAppUpdate(Request $request){

        if ($request->hasFile('file')){
            $file = $this->uploadIconImage($request);
            $request['icon'] = $file;
        }
        $otherApp=OtherApp::findorfail($request->OtherApp);
        $otherApp->update($request->all());
        $otherApp->country()->sync($request->countries);
        return redirect(route('admin.otherApps'))->with('success',' Updated successfully');
    }
}
