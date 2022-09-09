<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Dictionary;
use App\Models\Emoji;
use App\Models\Lang;
use App\Models\SafetyTips;
use App\Models\Translation;
use Illuminate\Http\Request;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;

class SafetyTipsController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tips = SafetyTips::all();
        $icon_url = env('GIFT_URL');
        return view('admin.pages.setting.safetyTip.safetyTips')->with(compact('tips', 'icon_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $image = $this->uploadIconImage($request);

        $request['icon'] = $image;

        $tip = SafetyTips::create($request->all());

        if ($tip) {
            return back()->with('success' , 'Safety Tip added successfully6');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $tip = SafetyTips::findorfail($id);

        return view('admin.inc.EditTip', compact('tip'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->has('file')) {
            $image = $this->uploadIconImage($request);
            $request['icon'] = $image;
        }
        SafetyTips::findorfail($id)->update($request->all());
        return back()->with('success' , 'Safety Tip updated successfully');

    }
    public function safetyTipTranslation($id){
        $safetyTips = SafetyTips::find($id);
        $translations = Translation::with('language')
            ->where('table_name','safetyTip')
//            ->groupby('language_id','column_name')
            ->orderby('language_id','asc')
            ->where('record_id',$id)->get()->toArray();
        $translations = array_chunk($translations,2);
        $data=[];
        foreach ($translations as $translation){
            foreach ($translation as $translate)
            {
                if($translate['column_name']=='tip'){
                    $data[$translate['language_id']]['tip']=$translate;
                }else{
                    $data[$translate['language_id']]['title']=$translate;
                }
            }
        }
//        $languages=DB::table('languages')->where('name','!=','English')->whereNotIn('id',
//            DB::table('translations')->where('table_name','safetyTip')->groupBy('language_id')->where('record_id',$id)->pluck('language_id')
//        )->get();
        $languages=Lang::with('languages')->where('lang','!=','en')
            ->whereNotIn('language_id',Translation::where(['table_name'=>'safetyTip','record_id'=>$id])
                ->groupBy('language_id')->pluck('language_id'))->get();
        $icon_url = env('GIFT_URL');
        return view('admin.pages.setting.safetyTip.safetyTipTranslation', compact('safetyTips', 'icon_url','languages','data'));

    }
    public function safetyTipTranslationUpdate(Request $request,$id){

        $safetyTip=SafetyTips::find($id);
        foreach ($request->language_id as $key=>$translation){
//            if($request->title[$key] !==null && $request->tip[$key] !==null ){
                Translation::updateOrCreate(['table_name'=>'safetyTip','column_name'=>'title','record_id'=>$id,'language_id'=>$translation],[
                    'table_name'=>'safetyTip',
                    'column_name'=>'title',
                    'record_id'=>$id,
                    'translation'=>$request->title[$key],
                ]);
                Translation::updateOrCreate(['table_name'=>'safetyTip','column_name'=>'tip','record_id'=>$id,'language_id'=>$translation],[
                    'table_name'=>'safetyTip',
                    'column_name'=>'tip',
                    'record_id'=>$id,
                    'translation'=>$request->tip[$key],
                ]);
//            }
        }
        return back()->with('success','Translations added successfully');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        SafetyTips::findOrFail($request->tip)->delete();
        return back()->with('success' , 'Tip deleted successfully');
    }
}
