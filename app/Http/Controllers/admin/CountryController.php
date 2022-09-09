<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Dictionary;
use App\Models\Emoji;
use App\Models\Lang;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class CountryController extends Controller
{
    public function index(){
        return view('admin.pages.setting.countries.countries');
    }
    public function countriesList(Request $request){
        if ($request->ajax()) {
            $data = Country::all();
            $is_edit=null;
            $is_delete=null;
            if ($request->user()->can('country-edit')){
                $is_edit=1;
            }if ($request->user()->can('country-delete')){
                $is_delete=1;
            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) use($is_edit,$is_delete) {
                    if ($is_edit){
                        $edit=' <li><a  href="javascript:void(0)" class="edit-country" data-country="' . $row->id . '">Edit</a></li>';
                    }else{
                        $edit='';
                    }
                    if ($is_delete){
                        $delete='<li><a  href="javascript:void(0)" class="delete-country" data-country="' . $row->id . '">Delete</a></li>';
                    }else{
                        $delete='';
                    }
                    $actionBtn = '<div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a  href="' . route('admin.countries.translation', $row->id) . '">Translations</a></li>

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
        if(Country::where('name',$request->name)->exists()){
            return back()->with('error','Country name already exist');
        }
        Country::create($request->all());
        return back()->with('success','Country added successfully');
    }
    public function edit($id){

        $country=Country::find($id);
        return view('admin.inc.EditCountry',compact('country'));
    }
    public function update(Request $request,$id){
        Country::find($id)->update($request->all());
        return back()->with('success','Country updated successfully');
    }
    public function translation($id){
        $country = Country::find($id);
        $translations=Translation::with('language')->where('table_name','country')->orderby('language_id','asc')->where('column_name','name')->where('record_id',$id)->get();
//        $languages=DB::table('languages')->where('name','!=','English')->whereNotIn('id',
//            DB::table('translations')->where('table_name','country')->where('column_name','name')->where('record_id',$id)->pluck('language_id')
//        )->get();
        $languages=Lang::with('languages')->where('lang','!=','en')
            ->whereNotIn('language_id',Translation::where(['table_name'=>'country','column_name'=>'name','record_id'=>$id])
                ->groupBy('language_id')->pluck('language_id'))->get();
        $icon_url = env('GIFT_URL');
        return view('admin.pages.setting.countries.countryTranslation', compact('country', 'icon_url','languages','translations'));

    }
    public function translationUpdate(Request $request,$id){
        $dictionary=Country::find($id);
        foreach ($request->language_id as $key=>$translation){
//            if($request->translation[$key] !==null){
                Translation::updateOrCreate(['table_name'=>'country','column_name'=>'name','record_id'=>$id,'language_id'=>$translation],[
                    'table_name'=>'country',
                    'column_name'=>'name',
                    'record_id'=>$id,
                    'translation'=>$request->translation[$key],
                ]);
//            }
        }
        return back()->with('success','Translations added successfully');
    }
    public function delete(Request $request){
        Country::find($request->country)->delete();
        return back()->with('success','Country deleted successfully');

    }
}
