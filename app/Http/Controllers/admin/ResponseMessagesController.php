<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Lang;
use App\Models\Language;
use App\Models\ResponseMessages;
use App\Models\Translation;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ResponseMessagesController extends Controller
{
    public function index()
    {
        return view('admin.pages.setting.responseMessages.responseMessages');
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = ResponseMessages::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $edit = '<li><a  href="javascript:void(0)" class="edit-response-messages" data-response-messages="' . $row->id . '">Edit</a></li>';
                    $delete = ' <li><a  href="javascript:void(0)" class="delete-language" data-language="' . $row->id . '">Delete</a></li>';

                    $actionBtn = '<div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a  href="' . route('admin.response.messages.translation', $row->id) . '">Translations</a></li>
                                     ' . $edit . $delete . '


                                </ul>
                            </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    public function store(Request $request){
        if(ResponseMessages::where('key_string',$request->key_string)->exists()){
            return back()->with('error','Key already exist');
        }
        ResponseMessages::create($request->all());
        return back()->with('success','Added successfully');
    }
    public function update(Request $request,$id){

        ResponseMessages::findorfail($id)->update(['key_translation'=>$request->key_translation]);
        return back()->with('success','updated successfully');
    }
    public function edit($id){
        $responseMessage=ResponseMessages::find($id);
        return view('admin.inc.EditResponseMessages',compact('responseMessage'));

    }  public function delete(Request $request){
        ResponseMessages::find($request->id)->delete();
        return back()->with('success','deleted successfully');
    }
    public function translation($id){
        $response = ResponseMessages::find($id);
        $translations=Translation::with('language')->where('table_name','response_messages')->orderby('language_id','asc')->where('column_name','key_translation')->where('record_id',$id)->get();
//        $languages=DB::table('languages')->where('name','!=','English')->whereNotIn('id',
//            DB::table('translations')->where('table_name','language')->where('column_name','name')->where('record_id',$id)->pluck('language_id')
//        )->get();
        $languages=Lang::with('languages')->where('lang','!=','en')
            ->whereNotIn('language_id',Translation::where(['table_name'=>'response_messages','column_name'=>'key_translation','record_id'=>$id])
                ->groupBy('language_id')->pluck('language_id'))->get();
        $icon_url = env('GIFT_URL');
        return view('admin.pages.setting.responseMessages.responseTranslation', compact('response', 'icon_url','languages','translations'));

    }
    public function translationUpdate(Request $request,$id){
        $dictionary=ResponseMessages::find($id);
        foreach ($request->language_id as $key=>$translation){
//            if($request->translation[$key] !==null){
            Translation::updateOrCreate(['table_name'=>'response_messages','column_name'=>'key_translation','record_id'=>$id,'language_id'=>$translation],[
                'table_name'=>'response_messages',
                'column_name'=>'key_translation',
                'record_id'=>$id,
                'translation'=>$request->translation[$key],
            ]);
//            }
        }
        return back()->with('success','Translations added successfully');
    }
}
