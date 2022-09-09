<?php

namespace App\Exports;

use App\Models\CrowdfundingVoucher;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class CrowdfundingVouchers implements FromView
{
    public $data;
    public function __construct(Request $request){
       $this->data=$request;
    }
    /**
    * @return \Illuminate\Support\Collection
    */


    public function view(): View
    {
        $request=$this->data;
        $data = CrowdfundingVoucher::with('company',)
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
        return view('admin.exports.crowdfundingVouchers', [
            'vouchers' =>$data,
            'index'=>1,
        ]);
    }
}
