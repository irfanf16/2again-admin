<?php

namespace App\Http\Controllers\admin;

use App\Exports\CrowdfundingVouchers;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Country;
use App\Models\CrowdfundingVoucher;
use App\Models\FAQs;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class CrowdfundingController extends Controller
{
    public function companies(){
        $countries=Country::all();
        $languages=Language::all();
        return view('admin.pages.crowdfunding.crowdfundingCompanies',compact('countries','languages'));
    }
    public function companiesList(Request $request){
        if ($request->ajax()) {

            $data = Company::with('country','language')->get();
            $is_edit=0;
            $is_delete=0;
            if ($request->user()->can('crowdfunding-edit')){
                $is_edit=1;
            } if ($request->user()->can('crowdfunding-delete')){
                $is_delete=1;
            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('country',function ($row){
                    return $row->country->name;
                })
                ->addColumn('language',function ($row){
                    return $row->language->name;
                })
                ->addColumn('action', function ($row) use($is_edit,$is_delete) {
                    if ($is_edit){
                        $edit='<li><a  href="javascript:void(0)" class="edit-company" data-company="' . $row->id . '">Edit</a></li>';
                    }else{
                        $edit='';
                    }
                    if ($is_delete){
                        $delete='<li><a href="javascript:void(0)" class="delete-company" data-company="' . $row->id . '">Delete</a></li>';
                    }else{
                        $delete='';
                    }
                    $actionBtn = '<div class="dropdown" >
                                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    '.$edit.$delete.'
                                </ul>
                            </div>';
                    return $actionBtn;
                })
                ->make(true);
        }
    }
    public function companiesStore(Request $request){
        $company=Company::create($request->all());
        return back()->with('success','Company added successfully');
    }
    public function companiesEdit($id){
        $company=Company::findorfail($id);
        $countries=Country::all();
        $languages=Language::all();
        return view('admin.inc.EditCompany',compact('company','countries','languages'));
    }
    public function companiesUpdate(Request $request){
        $company=Company::findorfail($request->companyId)->update($request->all());
        return back()->with('success','Company updated successfully');
    }
    public function companiesDelete(Request $request){
        $company=Company::findorfail($request->company)->delete();
        return back()->with('success','Company deleted successfully');
    }
//    vouchers
    public function vouchers(){
        $companies=Company::all();
       return view('admin.pages.crowdfunding.crowdfundingVouchers',compact('companies'));
    }
    public function vouchersList(Request $request){
        if ($request->ajax()) {
             $data=CrowdfundingVoucher::with('company')
                ->when($request->has('company_id') && $request->company_id !='',function ($q) use ($request){
                    $q->where('company_id',$request->company_id);
                })
                ->when($request->has('subscription_type') && $request->subscription_type !='',function ($q) use ($request){
                    $q->where('subscription_type',$request->subscription_type);
                })
                ->when($request->has('subscription_month') && $request->subscription_month !='',function ($q) use ($request){
                    $q->where('subscription_month',$request->subscription_month);
                })
                ->when($request->has('associate') && $request->associate !='',function ($q) use ($request){
                    $q->where('associate_product_credit',$request->associate);
                })
                ->when($request->has('used') && $request->used !='',function ($q) use ($request){
                    $q->where('is_used',$request->used);
                })
                ->get();
//                ->paginate(10000);

            return Datatables::of($data)
                ->addIndexColumn()
//                ->chunk(100)
//                ->with('count', function() use ($data) {
//                    return $data->count();
//                })
                ->addColumn('company',function ($row){
                    return $row->company->name;
                })
                ->editColumn('associate_product_credit',function ($row){
                    if($row->associate_product_credit==1){
                        return 'Yes';
                    }else{
                        return 'No';
                    }
                })
                ->editColumn('used',function ($row){
                    if($row->is_used==1){
                        return 'Yes';
                    }else{
                        return 'No';
                    }
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="dropdown" >
                                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="javascript:void(0)" class="delete-companyVoucher" data-companyVoucher="' . $row->id . '">Delete</a></li>
                                </ul>
                            </div>';
                    return $actionBtn;
                })
                ->make(true);

        }
    }
    public function vouchersStore(Request $request)
    {
        for($i=1;$i <= $request->quantity;$i++){
            if($request->subscription_type=='vip'){
                $request['voucher_code']=strtoupper('V'.$request->subscription_month.Str::random(5));
            }else{
                $request['voucher_code']=strtoupper('B'.$request->subscription_month.Str::random(5));
            }
            CrowdfundingVoucher::create($request->all());
        }
        return back()->with('success','Vouchers added successfully');
    }
    public function vouchersDelete(Request $request){
        CrowdfundingVoucher::findorfail($request->voucher)->delete();
        return back()->with('success','Vouchers deleted successfully');

    }
    public function voucherExport(Request $request){

//        $type=$request->subscription_type ='vip' ? 'V'.$request->subscription_month:'B'.$request->subscription_month;
//        $company=Company::findorfail($request->company_id);
//        $name=$company.$type;

        return Excel::download(new CrowdfundingVouchers($request),'vouchers.xlsx' );

    }
}
