<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Emoji;
use App\Models\Lang;
use App\Models\Language;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Traits\FileUploadTrait;

class EmojiController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pages.setting.emoji.emoji');
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = Emoji::all();
             $is_edit=0;
             $is_delete=0;
             if ($request->user()->can('emoji-edit')){
                 $is_edit=1;
             } if ($request->user()->can('emoji-delete')){
                $is_delete=1;
             }

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) use($is_edit,$is_delete) {
                    if($is_edit==1){
                        $edit='<li><a  href="javascript:void(0)" class="edit-emoji" data-emoji="' . $row->id . '">Edit</a></li>';
                    }else{
                        $edit='';
                    }
                    if ($is_delete==1){
                        $delete='<li><a  href="#" class="delete-emoji" data-emoji="' . $row->id . '">Delete</a></li>';
                    }else{
                        $delete='';
                    }
                    $actionBtn = '<div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a  href="' . route('admin.emoji.translation', $row->id) . '">Translations</a></li>
                                    '.$edit.$delete.'

                                </ul>
                            </div>';
                    return $actionBtn;
                })
                ->addColumn('image', function ($row) {
                    $icon_url = env('GIFT_URL');
                    $image = '    <td>
                                <div class="user-profile">
                                    <div class="user-img">
                                        <a href="#"><img src="' . $icon_url . $row->icon . '"></a>
                                    </div>
                                </div>
                            </td>';
                    return $image;
                })
                ->rawColumns(['action', 'image'])
                ->make(true);
        }
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
        if(Emoji::where('name',$request->name)->exists()){
            return back()->with('error','name already exist');
        }
        $image = $this->uploadIconImage($request);
        $request['icon'] = $image;
        $emoji = Emoji::create($request->all());

        if ($emoji) {
            return back()->with('success', 'Emoji added successfully');
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
        $emoji = Emoji::find($id);
        $icon_url = env('GIFT_URL');
        return response([
            'message' => 'Emoji Detail',
            'icon_url' => $icon_url,
            'data' => $emoji
        ]);
    }

    public function detail($id)
    {
        $emoji = Emoji::find($id);
        $translations=Translation::with('language')->where('table_name','emoji')->where('column_name','name')->orderby('language_id','asc')->where('record_id',$id)->get();
//        $languages=DB::table('languages')->where('name','!=','English')->whereNotIn('id',
//        DB::table('translations')->where('table_name','emoji')->where('column_name','name')->where('record_id',$id)->pluck('language_id')
//        )->get();
        $languages=Lang::with('languages')->where('lang','!=','en')
            ->whereNotIn('language_id',Translation::where(['table_name'=>'emoji','column_name'=>'name','record_id'=>$id])
                ->groupBy('language_id')->pluck('language_id'))->get();
        $icon_url = env('GIFT_URL');
        return view('admin.pages.setting.emoji.emojiTranslation', compact('emoji', 'icon_url','emoji','languages','translations'));

    }
    public function updateTranslation(Request $request,$id){

        $emoji=Emoji::find($id);
        $request['table_name']='emoji';
        $request['column_name']='name';
          foreach ($request->language_id as $key=>$translation){
//              if($request->translation[$key] !==null){
                  Translation::updateOrCreate(['table_name'=>'emoji','column_name'=>'name','record_id'=>$id,'language_id'=>$translation],[
                      'table_name'=>'emoji',
                      'column_name'=>'name',
                      'record_id'=>$id,
                      'translation'=>$request->translation[$key],
                  ]);
//              }
          }
        return back()->with('success','Translations added successfully');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $emoji = Emoji::find($request->emoji);
        $emoji->name = $request->name;
        if ($request->has('file')) {
            $image = $this->uploadIconImage($request);
            $emoji->icon = $image;
        }
        $emoji->save();
        if ($emoji) {
            return back()->with('success', 'Emoji Update successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Emoji::findOrFail($request->emoji)->delete();
        return back()->with('success', 'Emoji deleted successfully');
    }
}
