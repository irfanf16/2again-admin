<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Lang;
use App\Models\Language;
use http\Env\Response;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LangController extends Controller
{
    public function index()
    {
        $languages = Language::all();
        return view('admin.pages.setting.lang.lang', compact('languages'));
    }

    public function list(Request $request)
    {

        if ($request->ajax()) {

            $data = Lang::with('languages')->get();


            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('languageName', function ($row) {
                    return $row->languages->name ?? 'No Name';
                })
                ->editColumn('is_active',function ($row){
                    return $row->is_active==0 ? 'No':'Yes';
                })
                ->addColumn('action', function ($row) {
                    $delete='<li><a  href="javascript:void(0)" class="delete-lang" data-lang="' . $row->id . '">Delete</a></li>';
                    if ($row->is_active==0){
                        $enable='<li><a  href="javascript:void(0)" class="enable-lang" data-lang="' . $row->id . '">Enable</a></li>';
                    }else{
                        $enable='<li><a  href="javascript:void(0)" class="disable-lang" data-lang="' . $row->id . '">Disable</a></li>';
                    }

                    if ($row->languages->short=='en'){
                        $delete='';
                        $enable='';
                    }
                    $actionBtn = '<div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                     <li><a  href="'.route('admin.app.translated.languages.edit',$row->id).'" >Update Json</a></li>
                                     '.$enable.$delete.'

                                </ul>
                            </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $language = Language::find($request->language_id);
        if (!$language) {
            return response()->json([
                'code' => 0,
                'message' => 'Language not found'
            ]);
        }
        $lang=Lang::with('languages')->where('language_id',$request->language_id)->first();
        if($lang != null){
            return response()->json([
                'code'=>0,
                'message'=> $lang->languages->name.' language translation already exist'
            ]);
        }
        Lang::create([
            'lang' => $language->short,
            'language_id' => $request->language_id,
            'translation' => $request->translation
        ]);
        return response()->json([
            'code' => 1,
            'message' => 'App language added successfully'
        ]);
    }
    public function edit($id){

        $lang=Lang::with('languages')->find($id);
        return view('admin.pages.setting.lang.edit',compact('lang'));
    }
    public function update(Request $request){

        $lang=Lang::with('languages')->find($request->lang)->update(['translation'=>$request->translation]);
        return response()->json([
            'code' => 1,
            'message' => 'App language updated successfully'
        ]);
    }
    public function delete(Request $request){
        Lang::find($request->language)->delete();
        return back()->with('success','App language deleted successfully');

    }
    public function enable(Request $request){
        Lang::find($request->is_active)->update(['is_active'=>1]);
        return back()->with('success','App language enabled successfully');

    } public function disable(Request $request){
        Lang::find($request->is_active)->update(['is_active'=>0]);
        return back()->with('success','App language disabled successfully');

    }
}
