<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\badges;
use App\Models\Subscription;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use function Composer\Autoload\includeFile;

class BadgeController extends Controller
{
    use FileUploadTrait;
    public function index(){
        return view('admin.pages.badges');
    }
    public function badgesList(Request $request){

        if ($request->ajax()) {

            $data = Subscription::all();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function($row){
                    $icon_url = env('GIFT_URL');
                    $image = '
                                <div class="user-profile">
                                    <div class="user-img">
                                        <a href="javascript:void(0)"><img src="'.$icon_url.$row->badge.'"></a>
                                    </div>
                                </div>
                            ';
                    return $image;
                })
                ->addColumn('action', function ($row) use($request){
                    return  '<button  href="javascript:void(0)" class="edit-badge" data-badge="' . $row->id . '">Edit</a>' ;
                })
                ->rawColumns(['action', 'image'])
                ->make(true);


        }
    }
    public function addBadge(Request $request){

        if($request->has('file')){
            $badge = $this->uploadIconImage($request);
            $request['badge'] = $badge;
        }
        $request['shortcode']='CUSTOM';
        $badge=Subscription::create($request->all());
        if ($badge){
            return back()->with('success','Badge added successfully');
        }
    }
    public function editBadge($id){
        $badge=Subscription::findorfail($id);
        return view('admin.inc.EditBadge',compact('badge'));

    }
    public function updateBadge(Request $request){

        if($request->has('file')){
            $badge = $this->uploadIconImage($request);
            $request['badge'] = $badge;
        }
        $badge=Subscription::findorfail($request->badgeId)->update($request->all());
        if ($badge){
            return back()->with('success','Badge updated successfully');
        }
    }
    public function deleteBadge(Request $request){
        $badge=Subscription::findorfail($request->badge)->delete();
        if ($badge){
            return back()->with('success','Badge deleted successfully');
        }
    }
}
