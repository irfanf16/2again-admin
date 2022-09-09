<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Lang;
use App\Models\Looking;
use App\Models\Status;
use App\Models\Translation;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LookingController extends Controller
{
    public function status(){
        return view('admin.pages.setting.looking.looking');
    }

    public function list(Request $request){
        if($request->ajax()){
            $data = Looking::all();
            $is_edit=0;
            $is_delete=0;
            if ($request->user()->can('looking-for-edit')){
                $is_edit=1;
            }if ($request->user()->can('looking-for-delete')){
                $is_delete=1;
            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) use($is_edit,$is_delete){
                    if ($is_edit){
                        $edit='<li><a  href="javascript:void(0)" class="edit-looking" data-looking="'.$row->id.'">Edit</a></li>';
                    }else{
                        $edit='';
                    }
                    if($is_delete){
                        $delete='<li><a  href="javascript:void(0)" class="delete-looking" data-looking="'.$row->id.'">Delete</a></li>';
                    }else{
                        $delete='';
                    }
                    $actionBtn = '<div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a  href="'. route('admin.looking.translations',$row->id) .'">Translations</a></li>
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

        Looking::create($request->all());

        return back()->with('success','Looking For added successfully');

    }
    public function edit($id){
        $looking=Looking::find($id);
        return view('admin.inc.EditLooking',compact('looking'));
    }
    public function update(Request $request,$id){
        Looking::find($id)->update($request->all());
        return back()->with('success','Looking For updated successfully');

    }
    public function Translation($id){
        $looking = Looking::find($id);
        $translations=Translation::with('language')->where('table_name','looking')->orderby('language_id','asc')->where('column_name','name')->where('record_id',$id)->get();
//        $languages=DB::table('languages')->where('name','!=','English')->whereNotIn('id',
//            DB::table('translations')->where('table_name','dictionary')->where('column_name','word')->where('record_id',$id)->pluck('language_id')
//        )->get();
        $languages=Lang::with('languages')->where('lang','!=','en')
            ->whereNotIn('language_id',Translation::where(['table_name'=>'looking','column_name'=>'name','record_id'=>$id])
                ->groupBy('language_id')->pluck('language_id'))->get();
        $icon_url = env('GIFT_URL');
        return view('admin.pages.setting.looking.lookingTranslation', compact('looking', 'icon_url','languages','translations'));

    }
    public function TranslationSave(Request $request,$id){
        $dictionary=Looking::find($id);
        foreach ($request->language_id as $key=>$translation){
//            if($request->translation[$key] !==null){
            Translation::updateOrCreate(['table_name'=>'looking','column_name'=>'name','record_id'=>$id,'language_id'=>$translation],[
                'table_name'=>'looking',
                'column_name'=>'name',
                'record_id'=>$id,
                'translation'=>$request->translation[$key],
            ]);
//            }
        }
        return back()->with('success','Translations added successfully');
    }

    public function delete(Request $request){
        Looking::findOrFail($request->name)->delete();
        return back()->with('success', 'Looking For deleted successfully');
    }
}
