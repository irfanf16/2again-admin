<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dictionary;
use App\Models\FAQs;
use App\Models\FaqTypes;
use App\Models\Lang;
use App\Models\Offer;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\DataTables;

class FaqController extends Controller
{

    public function faqsTypeView()
    {
        return view('admin.pages.faqs.faqs_types');
    }
    public function faqsTypeList(Request $request)
    {

        if ($request->ajax()) {
            $data = FaqTypes::all();
             $is_edit=0;
             $is_delete=0;
             if ($request->user()->can('faqs-edit')){
                 $is_edit=1;
             }if ($request->user()->can('faqs-delete')){
                $is_delete=1;
             }
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) use($is_edit,$is_delete) {
                    if ($is_edit){
                        $edit='<li><a  href="#" class="edit-faqType" data-faqType="' . $row->id . '">Edit</a></li>';
                    }else{
                        $edit='';
                    }
                    if ($is_delete){
                        $delete='<li><a  href="#" class="delete-faqType" data-faqType="' . $row->id . '">Delete</a></li>';
                    }else{
                        $delete='';
                    }
                    $actionBtn = '<div class="dropdown" >
                                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a  href="'.route('admin.faqsType.translation',$row->id).'" >Translation</a></li>
                                    '.$edit.$delete.'

                                </ul>
                            </div>';
                    return $actionBtn;
                })
                ->make(true);


        }

    }
    public function faqsTypeEdit($id){
        $faqType=FaqTypes::findorfail($id);
        return view('admin.inc.EditFaqType',compact('faqType'));
    }
    public function faqsTypeStore(Request $request){

        $faqtype=FaqTypes::create($request->all());
        return back()->with('success',' Added successfully');
    }
    public function faqsTypeUpdate(Request $request,$id){

        FaqTypes::findorfail($id)->update($request->all());
        return back()->with('success',' Updated successfully');
    }
    public function faqsTypeDelete(Request $request){

        FaqTypes::findorfail($request->faqType)->delete();
        FAQs::where('faq_type_id',$request->faqType)->delete();

        return back()->with('success',' Deleted successfully');
    }
    public function faqsTypeTranslation($id){
        $faqtype = FaqTypes::find($id);
        $translations=Translation::with('language')->where('table_name','faqType')->orderby('language_id','asc')->where('column_name','name')->where('record_id',$id)->get();
//        $languages=DB::table('languages')->where('name','!=','English')->whereNotIn('id',
//            DB::table('translations')->where('table_name','dictionary')->where('column_name','word')->where('record_id',$id)->pluck('language_id')
//        )->get();
        $languages=Lang::with('languages')->where('lang','!=','en')
            ->whereNotIn('language_id',Translation::where(['table_name'=>'faqType','column_name'=>'name','record_id'=>$id])
                ->groupBy('language_id')->pluck('language_id'))->get();
        return view('admin.pages.faqs.faqTypeTranslation', compact('translations','faqtype','languages'));


    }
    public function faqsTypeTranslationSave(Request $request,$id){
        $dictionary=FaqTypes::find($id);
        foreach ($request->language_id as $key=>$translation){
//            if($request->translation[$key] !==null){
                Translation::updateOrCreate(['table_name'=>'faqType','column_name'=>'name','record_id'=>$id,'language_id'=>$translation],[
                    'table_name'=>'faqType',
                    'column_name'=>'name',
                    'record_id'=>$id,
                    'translation'=>$request->translation[$key],
                ]);
//            }
        }
        return back()->with('success','Translations added successfully');
    }


    public function faqsView()
    {
        $faqsTypes=FaqTypes::all();
        return view('admin.pages.faqs.faqs',compact('faqsTypes'));
    }
    public function faqsList(Request $request)
    {

        if ($request->ajax()) {

            $data = FAQs::with('faqType')
                ->when($request->has('Faq_types') && $request->filled('Faq_types'),function ($q) use ($request){
                    $q->where('faq_type_id',$request->Faq_types);
                })
                ->get();
            $is_edit=0;
            $is_delete=0;
            if ($request->user()->can('faqs-edit')){
                $is_edit=1;
            }if ($request->user()->can('faqs-delete')){
                $is_delete=1;
            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('faqType',function ($row){
                   return $row->faqType->name ?? 'N/A';
                })
                ->addColumn('action', function ($row) use($is_edit,$is_delete) {
                    if ($is_edit){
                        $edit='<li><a  href="javascript:void(0)" class="edit-faq" data-faq="' . $row->id . '">Edit</a></li>';
                    }else{
                        $edit='';
                    }
                    if ($is_delete){
                        $delete='<li><a href="javascript:void(0)" class="delete-faq" data-faq="' . $row->id . '">Delete</a></li>';
                    }else{
                        $delete='';
                    }
                    $actionBtn = '<div class="dropdown" >
                                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a  href="'.route('admin.faqs.translation',$row->id).'" >Translation</a></li>
                                    '.$edit.$delete.'

                                </ul>
                            </div>';
                    return $actionBtn;
                })
                ->make(true);


        }

    }
    public function faqsStore(Request $request){

        $faqtype=FAQs::create($request->all());
        return back()->with('success',' Added successfully');
    }
    public function faqsEdit($id){
        $faq=FAQs::findorfail($id);
        $faqsTypes=FaqTypes::all();


        return view('admin.inc.EditFaq',compact('faq','faqsTypes'));
    }
    public function faqsUpdate(Request $request){

        FAQs::findorfail($request->faq)->update($request->all());
        return back()->with('success',' Update successfully');
    }

    public function faqsTranslation($id){
        $faqs = FAQs::find($id);
        $translations = Translation::with('language')
            ->where('table_name','faqs')
//            ->groupby('language_id','column_name')
            ->orderby('language_id','asc')
            ->where('record_id',$id)->get()->toArray();

        $translations = array_chunk($translations,2);
        $data=[];
        foreach ($translations as $translation){
            foreach ($translation as $translate)
            {
                if($translate['column_name']=='answer'){
                    $data[$translate['language_id']]['answer']=$translate;
                }else{
                    $data[$translate['language_id']]['question']=$translate;
                }
            }
        }

//        $languages=DB::table('languages')->where('name','!=','English')->whereNotIn('id',
//            DB::table('translations')->where('table_name','faqs')->groupBy('language_id')->where('record_id',$id)->pluck('language_id')
//        )->get();
        $languages=Lang::with('languages')->where('lang','!=','en')
            ->whereNotIn('language_id',Translation::where(['table_name'=>'faqs','record_id'=>$id])
                ->groupBy('language_id')->pluck('language_id'))->get();
//        dd($translations,$data,$languages);
        $icon_url = env('GIFT_URL');
        return view('admin.pages.faqs.faqsTranslation', compact('faqs', 'icon_url','languages','data'));

    }
    public function faqsTranslationUpdate(Request $request,$id){
        $safetyTip=FAQs::find($id);
        foreach ($request->language_id as $key=>$translation){
//            if($request->questions[$key] !==null && $request->answers[$key] !==null ){
                Translation::updateOrCreate(['table_name'=>'faqs','column_name'=>'question','record_id'=>$id,'language_id'=>$translation],[
                    'table_name'=>'faqs',
                    'column_name'=>'question',
                    'record_id'=>$id,
                    'translation'=>$request->questions[$key],
                ]);
                Translation::updateOrCreate(['table_name'=>'faqs','column_name'=>'answer','record_id'=>$id,'language_id'=>$translation],[
                    'table_name'=>'faqs',
                    'column_name'=>'answer',
                    'record_id'=>$id,
                    'translation'=>$request->answers[$key],
                ]);
//            }
        }
        return back()->with('success','Translations added successfully');
    }



    public function faqsDelete(Request $request){

        FAQs::findorfail($request->faq)->delete();

        return back()->with('success',' Deleted successfully');
    }

}
