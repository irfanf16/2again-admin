<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Dictionary;
use App\Models\Lang;
use App\Models\Translation;
use Illuminate\Http\Request;
use App\Models\GiftInvitations;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Traits\FileUploadTrait;

class GiftInvitationController extends Controller
{
    use FileUploadTrait;

    public function giftsView()
    {
        return view('admin.pages.giftInvitations.gifts');
    }

    public function invitationsView()
    {
        return view('admin.pages.giftInvitations.invitations');
    }

    public function giftsList(Request $request)
    {
        if ($request->ajax()) {
            $data = GiftInvitations::where('type', 'Gift')->get();
            $is_edit=0;
            $is_delete=0;
            if ($request->user()->can('giftInvitation-edit')){
                $is_edit=1;
            } if ($request->user()->can('giftInvitation-delete')){
                $is_delete=1;
            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) use($is_edit,$is_delete) {
                    if ($is_edit){
                        $edit='<li><a  href="javascript:void(0)" class="edit-giftInvitation" data-giftInvitation="' . $row->id . '">Edit</a></li>';
                    }else{
                        $edit='';
                    }
                    if ($is_delete){
                        $delete='<li><a  href="javascript:void(0)" class="delete-gift" data-gift="' . $row->id . '">Delete</a></li>';
                    }else{
                        $delete='';
                    }
                    $actionBtn = '<div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a  href="' . route('admin.gifts.translation', $row->id) . '" >Translations</a></li>
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

    public function giftsTranslation($id)
    {
        $gift = GiftInvitations::find($id);
        $translations = Translation::with('language')->where('table_name', 'gift')->where('column_name', 'name')->where('record_id', $id)->get();
//        $languages = DB::table('languages')->where('name', '!=', 'English')->whereNotIn('id',
//            DB::table('translations')->where('table_name', 'gift')->where('column_name', 'name')->where('record_id', $id)->pluck('language_id')
//        )->get();
        $languages=Lang::with('languages')->where('lang','!=','en')
            ->whereNotIn('language_id',Translation::where(['table_name'=>'gift','column_name'=>'name','record_id'=>$id])
                ->groupBy('language_id')->pluck('language_id'))->get();
        $icon_url = env('GIFT_URL');
        return view('admin.pages.giftInvitations.giftDetail', compact('gift', 'icon_url', 'languages', 'translations'));

    }

    public function giftsTranslationUpdate(Request $request, $id)
    {
        $dictionary = GiftInvitations::find($id);
        $request['table_name'] = 'gift';
        $request['column_name'] = 'name';
        foreach ($request->language_id as $key => $translation) {
//            if ($request->translation[$key] !== null) {
                Translation::updateOrCreate(['table_name' => 'gift', 'column_name' => 'name', 'record_id' => $id, 'language_id' => $translation], [
                    'table_name' => 'gift',
                    'column_name' => 'name',
                    'record_id' => $id,
                    'translation' => $request->translation[$key],
                ]);
//            }
        }
        return back()->with('success', 'Translations added successfully');
    }

    public function invitationsList(Request $request)
    {
        if ($request->ajax()) {
            $data = GiftInvitations::where('type', 'Invitation')->get();
            $is_edit=0;
            $is_delete=0;
            if ($request->user()->can('giftInvitation-edit')){
                $is_edit=1;
            } if ($request->user()->can('giftInvitation-delete')){
                $is_delete=1;
            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($is_edit,$is_delete) {
                    if ($is_edit){
                        $edit='<li><a  href="javascript:void(0)" class="edit-giftInvitation" data-giftInvitation="' . $row->id . '">Edit</a></li>';
                    }else{
                        $edit='';
                    }
                    if ($is_delete){
                        $delete='<li><a  href="#" class="delete-gift" data-gift="' . $row->id . '">Delete</a></li>';
                    }else{
                        $delete='';
                    }
                    $actionBtn = '<div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a  href="' . route('admin.invitation.translation', $row->id) . '" >Translations</a></li>
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

    public function invitationTranslation($id)
    {
        $invitation = GiftInvitations::find($id);
        $translations = Translation::with('language')->where('table_name', 'invitation')->where('column_name', 'name')->where('record_id', $id)->get();
//        $languages = DB::table('languages')->where('name', '!=', 'English')->whereNotIn('id',
//            DB::table('translations')->where('table_name', 'invitation')->where('column_name', 'name')->where('record_id', $id)->pluck('language_id')
//        )->get();
        $languages=Lang::with('languages')->where('lang','!=','en')
            ->whereNotIn('language_id',Translation::where(['table_name'=>'invitation','column_name'=>'name','record_id'=>$id])
                ->groupBy('language_id')->pluck('language_id'))->get();
        $icon_url = env('GIFT_URL');
        return view('admin.pages.giftInvitations.invitationDetail', compact('invitation', 'icon_url', 'languages', 'translations'));

    }

    public function invitationTranslationUpdate(Request $request, $id)
    {
        $dictionary = GiftInvitations::find($id);
        $request['table_name'] = 'invitation';
        $request['column_name'] = 'name';
        foreach ($request->language_id as $key => $translation) {
//            if ($request->translation[$key] !== null) {
                Translation::updateOrCreate(['table_name' => 'invitation', 'column_name' => 'name', 'record_id' => $id, 'language_id' => $translation], [
                    'table_name' => 'invitation',
                    'column_name' => 'name',
                    'record_id' => $id,
                    'translation' => $request->translation[$key],
                ]);
//            }
        }
        return back()->with('success', 'Translations added successfully');
    }

    public function store(Request $request)
    {
        if(GiftInvitations::where('name',$request->name)->exists()){
            return back()->with('error','name already exist');
        }
        $image = $this->uploadIconImage($request);

        $request['icon'] = $image;

        $giftInvitation = GiftInvitations::create($request->all());
        if ($giftInvitation) {
            return back()->with('success', $request->type . ' Added successfully');
        }
    }

    public function edit($id){
        $giftInvitation = GiftInvitations::find($id);
        return view('admin.inc.EditGiftInvitation',compact('giftInvitation'));
    }
    public function update(Request $request,$id)
    {
        if($request->has('file')){
            $image = $this->uploadIconImage($request);
            $request['icon'] = $image;
        }
        $giftInvitation = GiftInvitations::find($id)->update($request->all());
        if ($giftInvitation) {
            return back()->with('success', $request->type . ' updated successfully');
        }
    }

    public function delete(Request $request)
    {
        $giftInvitation = GiftInvitations::find($request->gift);
        $type = $giftInvitation->type;
        $giftInvitation->delete();
        return back()->with('success', $type . ' deleted successfully');
    }

}
