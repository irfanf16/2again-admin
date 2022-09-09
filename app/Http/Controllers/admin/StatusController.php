<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Dictionary;
use App\Models\Lang;
use App\Models\Status;
use App\Models\Translation;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class StatusController extends Controller
{
    public function status(){
        return view('admin.pages.setting.status.status');
    }

    public function statusList(Request $request){
        if($request->ajax()){
            $data = Status::all();
            $is_edit=0;
            $is_delete=0;
            if ($request->user()->can('status-edit')){
                $is_edit=1;
            }if ($request->user()->can('status-delete')){
                $is_delete=1;
            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) use($is_edit,$is_delete){
                    if ($is_edit){
                        $edit='<li><a  href="#" class="edit-status" data-status="'.$row->id.'">Edit</a></li>';
                    }else{
                        $edit='';
                    }
                    if($is_delete){
                        $delete='<li><a  href="#" class="deleteWord" data-word="'.$row->id.'">Delete</a></li>';
                    }else{
                        $delete='';
                    }
                    $actionBtn = '<div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a  href="'. route('admin.status.translations',$row->id) .'">Translations</a></li>
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

        $request->validate([
            'name' => 'required'
        ]);

        Status::create($request->all());

        return back()->with('success','Status added successfully');

    }
    public function edit($id){
        $status=Status::find($id);
        return view('admin.inc.statusEdit',compact('status'));
    }
    public function update(Request $request,$id){
        Status::find($id)->update($request->all());
        return back()->with('success','Status updated successfully');

    }
    public function statusTranslation($id){
        $status = Status::find($id);
        $translations=Translation::with('language')->where('table_name','status')->orderby('language_id','asc')->where('column_name','name')->where('record_id',$id)->get();
//        $languages=DB::table('languages')->where('name','!=','English')->whereNotIn('id',
//            DB::table('translations')->where('table_name','dictionary')->where('column_name','word')->where('record_id',$id)->pluck('language_id')
//        )->get();
        $languages=Lang::with('languages')->where('lang','!=','en')
            ->whereNotIn('language_id',Translation::where(['table_name'=>'status','column_name'=>'name','record_id'=>$id])
                ->groupBy('language_id')->pluck('language_id'))->get();
        $icon_url = env('GIFT_URL');
        return view('admin.pages.setting.status.statusTranslation', compact('status', 'icon_url','languages','translations'));

    }
    public function statusTranslationSave(Request $request,$id){
        $dictionary=Status::find($id);
        foreach ($request->language_id as $key=>$translation){
//            if($request->translation[$key] !==null){
                Translation::updateOrCreate(['table_name'=>'status','column_name'=>'name','record_id'=>$id,'language_id'=>$translation],[
                    'table_name'=>'status',
                    'column_name'=>'name',
                    'record_id'=>$id,
                    'translation'=>$request->translation[$key],
                ]);
//            }
        }
        return back()->with('success','Translations added successfully');
    }

    public function delete(Request $request){
        Status::findOrFail($request->name)->delete();
        return back()->with('success', 'Status deleted successfully');
    }
}
