<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Dictionary;
use App\Models\Lang;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use function back;
use function env;
use function view;

class DictionaryController extends Controller
{
    public function dictionary(){
        return view('admin.pages.setting.dictionary.dictionary');
    }

    public function dictionaryList(Request $request){
        if($request->ajax()){
            $data = Dictionary::all();
            $p_edit=0;
            $is_delete=0;
            if ($request->user()->can('dictionary-edit')){
                $p_edit=1;
            }
            if ($request->user()->can('dictionary-delete')){
                $is_delete=1;
            }


            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row) use($p_edit,$is_delete){
                if ($p_edit==1){
                    $edit='<li><a  href="javascript:void(0)" class="edit-word"  data-dictionary="'.$row->id.'">Edit</a></li>';
                }else{
                    $edit='';
                }
                if ($is_delete==1){
                    $delete='<li><a  href="javascript:void(0)" class="deleteWord" data-word="'.$row->id.'">Delete</a></li>';
                }else{
                    $delete='';
                }
                $actionBtn = '<div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a  href="'. route('admin.dictionary.translations',$row->id) .'">Translations</a></li>
                                    '.$edit.$delete.'

                                </ul>
                            </div>';
                return $actionBtn;
            })
            ->addColumn('image', function($row){
                $icon_url = env('GIFT_URL');
                $image = '    <td>
                                <div class="user-profile">
                                    <div class="user-img">
                                        <a href="#"><img src="'.$icon_url.$row->icon.'"></a>
                                    </div>
                                </div>
                            </td>';
                return $image;
            })

            ->rawColumns(['action', 'image'])
            ->make(true);
        }
    }

    public function store(Request $request){

        $request->validate([
            'word' => 'required'
        ]);
        if(Dictionary::where('word',$request->word)->exists()){
            return back()->with('error','Word already exist');
        }

        Dictionary::create($request->all());

        return back()->with('success','New word added successfully');

    }
    public function edit($id){
        $dictionary=Dictionary::find($id);
        return view('admin.inc.dictionaryEdit',compact('dictionary'));
    }
    public function update(Request $request,$id){
        Dictionary::find($id)->update($request->all());
        return back()->with('success','Dictionary updated successfully');
    }
    public function dictionaryTranslation($id){
        $dictionary = Dictionary::find($id);
        $translations=Translation::with('language')->where('table_name','dictionary')->orderby('language_id','asc')->where('column_name','word')->where('record_id',$id)->get();
//        $languages=DB::table('languages')->where('name','!=','English')->whereNotIn('id',
//            DB::table('translations')->where('table_name','dictionary')->where('column_name','word')->where('record_id',$id)->pluck('language_id')
//        )->get();
        $languages=Lang::with('languages')->where('lang','!=','en')
            ->whereNotIn('language_id',Translation::where(['table_name'=>'dictionary','column_name'=>'word','record_id'=>$id])
                ->groupBy('language_id')->pluck('language_id'))->get();
        $icon_url = env('GIFT_URL');
        return view('admin.pages.setting.dictionary.dictionaryTranslation', compact('dictionary', 'icon_url','languages','translations'));

    }
    public function dictionaryTranslationSave(Request $request,$id){
        $dictionary=Dictionary::find($id);
        foreach ($request->language_id as $key=>$translation){
//            if($request->translation[$key] !==null){
                Translation::updateOrCreate(['table_name'=>'dictionary','column_name'=>'word','record_id'=>$id,'language_id'=>$translation],[
                    'table_name'=>'dictionary',
                    'column_name'=>'word',
                    'record_id'=>$id,
                    'translation'=>$request->translation[$key],
                ]);
//            }
        }
        return back()->with('success','Translations added successfully');
    }

    public function delete(Request $request){
        Dictionary::findOrFail($request->word)->delete();
        return back()->with('success', 'Word deleted successfully');
    }
}
