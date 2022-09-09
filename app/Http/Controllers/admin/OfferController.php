<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Consumable;
use App\Models\Lang;
use App\Models\Offer;
use App\Models\SafetyTips;
use App\Models\Translation;
use App\Traits\TimeZoneToUTC;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Traits\FileUploadTrait;

class OfferController extends Controller
{
    use FileUploadTrait,TimeZoneToUTC;

    public function offersView(Request $request)
    {
        return view('admin.pages.offers.offers');
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $zone=Cookie::get('zone');
            $data = Offer::with('consumables')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a  href="' . route('admin.offers.translation', $row->id) . '">Translations</a></li>
                                    <li><a  href="' . route('admin.offers.detail', $row->id) . '">View Detail</a></li>
                                </ul>
                            </div>';
                    return $actionBtn;
                })
                ->editColumn('start_date', function ($row) use($zone) {

                    return $this->TimeZoneToLocal($row->start_date,$zone);
//                    return  Carbon::parse($row->start_date)->format('Y-m-d H:i:s');
                })
                ->editColumn('valid_till', function ($row) use($zone)  {
                    return $this->TimeZoneToLocal($row->valid_till,$zone);

//                    return  Carbon::parse($row->valid_till)->format('Y-m-d H:i:s');
                })
                ->addColumn('image', function ($row) {
                    $icon_url = env('GIFT_URL');
                    $image = '    <td>
                                <div class="user-profile">
                                    <div class="user-img">
                                        <a href="'.route('admin.offers.detail',$row->id).'"><img src="' . $icon_url . $row->icon . '"></a>
                                    </div>
                                </div>
                            </td>';
                    return $image;
                })
                ->rawColumns(['action', 'image'])
                ->make(true);
        }
    }

    public function detail(Offer $offer)
    {
        $zone=Cookie::get('zone');
        $offer->start_date=$this->TimeZoneToLocal($offer->start_date,$zone);
        $offer->valid_till=$this->TimeZoneToLocal($offer->valid_till,$zone);
        $url = env('GIFT_URL');
        $consumables = Consumable::all();
        return view('admin.pages.offers.offerDetail')->with(compact('offer', 'url', 'consumables'));
    }

    public function addItem(Request $request)
    {
        $request->validate([
            'offer_id' => 'required|exists:offers,id',
            'consumable_id' => 'required|exists:consumables,id',
            'quantity' => 'required|integer'
        ]);

        $itemCheck = Offer::whereHas('consumables', function ($query) use ($request) {
            $query->where('consumables.id', $request->consumable_id);
        })->where('id', $request->offer_id)->first();

        if ($itemCheck) {
            return back()->with('error', 'Item already exists in this offer');
        }

        Offer::find($request->offer_id)->consumables()->attach($request->consumable_id, [
            'quantity' => $request->quantity
        ]);

        return back()->with('success', 'Item Added Successfully');

    }

    public function deleteItem(Request $request)
    {
        $offer = Offer::find($request->offer);
        $offer->consumables()->detach($request->item);
        return back()->with('success', 'Item Removed successfully');
    }

    public function update(Request $request)
    {
        $zone=Cookie::get('zone');
        $icon = $this->uploadIconImage($request);

        if ($icon) {
            $request['icon'] = $icon;
        }
        if ($request->start_date == null) {
            unset($request['start_date']);
        } else{
            $request['start_date']= $this->TimeZoneToUTC($request->start_date,$zone);

        }
        if ($request->valid_till == null) {
            unset($request['valid_till']);
        }else{
            $request['valid_till']= $this->TimeZoneToUTC($request->valid_till,$zone);

        }

        Offer::find($request->id)->update($request->all());
        return back()->with('success', 'Offer updated successfully');
    }

    public function delete(Request $request)
    {
        $offer = Offer::findOrFail($request->offer);
        $offer->consumables()->detach();
        $offer->delete();
        return redirect(route('admin.offers'))->with('success', 'offer deleted successfully');
    }

    public function createOfferView()
    {
        return view('admin.pages.offers.createOffer');
    }

    public function store(Request $request)
    {
        $zone=Cookie::get('zone');
        $icon = $this->uploadIconImage($request);

        if ($icon) {
            $request['icon'] = $icon;
        }
        $request['start_date']= $this->TimeZoneToUTC($request->start_date,$zone);
        $request['valid_till']= $this->TimeZoneToUTC($request->valid_till,$zone);
        $offer = Offer::create($request->all());

        if ($offer) {
            return redirect(route('admin.offers'))->with('success', 'offer Created successfully');
        }
    }

    public function editItem($consumable_id, $offer_id)
    {
        $item= DB::table('offer_item')
            ->where(['offers_id' => $offer_id, 'consumables_id' =>$consumable_id])
            ->first();

        return view('admin.inc.EditOfferItem', compact('item'));
    }

    public function updateItem(Request $request)
    {

        DB::table('offer_item')
            ->where('id',$request->item_id)
            ->update(['quantity' => $request->quantity]);
        return back()->with('success', 'item updated successfully');
    }

    public function translationDetail($id)
    {
        $offers = Offer::find($id);
        $translations = Translation::with('language')
            ->where('table_name', 'offers')
//            ->groupby('language_id','column_name')
            ->orderby('language_id', 'asc')
            ->where('record_id', $id)->get()->toArray();
        $translations = array_chunk($translations, 2);
        $data = [];
        foreach ($translations as $translation) {
            foreach ($translation as $translate) {
                if ($translate['column_name'] == 'description') {
                    $data[$translate['language_id']]['description'] = $translate;
                } else {
                    $data[$translate['language_id']]['title'] = $translate;
                }
            }
        }
//        $languages=DB::table('langs')->where('lang','!=','en')->whereNotIn('id',
//            DB::table('translations')->where('table_name','offers')->groupBy('language_id')->where('record_id',$id)->pluck('language_id')
//        )->get();
        $languages = Lang::with('languages')->where('lang', '!=', 'en')
            ->whereNotIn('language_id', Translation::where(['table_name' => 'offers', 'record_id' => $id])
                ->groupBy('language_id')->pluck('language_id'))->get();

        $icon_url = env('GIFT_URL');
        return view('admin.pages.offers.offersTranslation', compact('offers', 'icon_url', 'languages', 'data'));

    }

    public function translationUpdate(Request $request, $id)
    {
        $offer = Offer::find($id);
        foreach ($request->language_id as $key => $translation) {
//            if ($request->title[$key] !== null && $request->description[$key] !== null) {
                Translation::updateOrCreate(['table_name' => 'offers', 'column_name' => 'title', 'record_id' => $id, 'language_id' => $translation], [
                    'table_name' => 'offers',
                    'column_name' => 'title',
                    'record_id' => $id,
                    'translation' => $request->title[$key],
                ]);
                Translation::updateOrCreate(['table_name' => 'offers', 'column_name' => 'description', 'record_id' => $id, 'language_id' => $translation], [
                    'table_name' => 'offers',
                    'column_name' => 'description',
                    'record_id' => $id,
                    'translation' => $request->description[$key],
                ]);
//            }
        }
        return back()->with('success', 'Translations added successfully');
    }
}
