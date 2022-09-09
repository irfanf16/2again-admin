<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Lang;
use App\Models\Religion;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ReligionController extends Controller
{
    public function index(){
        return view('admin.pages.setting.religions.religions');
    }
    public function list(Request $request){
        if ($request->ajax()) {
            $data = Religion::all();
            $is_edit=0;
            $is_delete=0;
            if ($request->user()->can('religion-edit')){
                $is_edit=1;
            }if ($request->user()->can('religion-delete')){
                $is_delete=1;
            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($is_edit,$is_delete) {
                      if ($is_edit){
                      $edit='<li><a  href="javascript:void(0)" class="edit-religion" data-religion="' . $row->id . '">Edit</a></li>';
                      }else{
                          $edit='';
                      }
                      if ($is_delete){
                          $delete='<li><a  href="javascript:void(0)" class="delete-religion" data-religion="' . $row->id . '">Delete</a></li>';
                      }else{
                          $delete='';
                      }
                    $actionBtn = '<div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a  href="' . route('admin.religions.translation', $row->id) . '">Translations</a></li>
                                     '.$edit.$delete.'
                                </ul>
                            </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    public function store(Request $request){
        if(Religion::where('name',$request->name)->exists()){
            return back()->with('error','Religion name already exist');
        }
        Religion::create($request->all());
        return back()->with('success','Religion added successfully');
    }
    public function edit($id){

        $religion=Religion::find($id);
        return view('admin.inc.EditReligion',compact('religion'));
    }
    public function update(Request $request,$id){
        Religion::find($id)->update($request->all());
        return back()->with('success','Religion updated successfully');
    }
    public function translation($id){
        $religion = Religion::find($id);
        $translations=Translation::with('language')->where('table_name','religion')->orderby('language_id','asc')->where('column_name','name')->where('record_id',$id)->get();
//        $languages=DB::table('languages')->where('name','!=','English')->whereNotIn('id',
//            DB::table('translations')->where('table_name','religion')->where('column_name','name')->where('record_id',$id)->pluck('language_id')
//        )->get();
        $languages=Lang::with('languages')->where('lang','!=','en')
            ->whereNotIn('language_id',Translation::where(['table_name'=>'religion','column_name'=>'name','record_id'=>$id])
                ->groupBy('language_id')->pluck('language_id'))->get();
        $icon_url = env('GIFT_URL');
        return view('admin.pages.setting.religions.religionTranslation', compact('religion', 'icon_url','languages','translations'));

    }
    public function translationUpdate(Request $request,$id){
        $religion=Religion::find($id);
        foreach ($request->language_id as $key=>$translation){
//            if($request->translation[$key] !==null){
                Translation::updateOrCreate(['table_name'=>'religion','column_name'=>'name','record_id'=>$id,'language_id'=>$translation],[
                    'table_name'=>'religion',
                    'column_name'=>'name',
                    'record_id'=>$id,
                    'translation'=>$request->translation[$key],
                ]);
//            }
        }
        return back()->with('success','Translations added successfully');
    }
    public function delete(Request $request){
        Religion::find($request->religion)->delete();
        return back()->with('success','Religion deleted successfully');

    }
}
