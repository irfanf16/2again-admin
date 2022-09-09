<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\InAppTransaction;
use App\Models\OtherApp;
use App\Models\PaymentMethod;
use App\Models\User;
use App\Models\Withdrawal;
use App\Traits\TimeZoneToUTC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Yajra\DataTables\DataTables;

class WithdrwalContrroller extends Controller
{
    use TimeZoneToUTC;
    public function index()
    {
        $paymentMethods = PaymentMethod::all();

        return view('admin.pages.withdrawals.withdrawal', compact('paymentMethods'));
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $zone=Cookie::get('zone');
            $data = Withdrawal::with('userPaymentMethod.paymentMethod', 'users')
                ->when($request->has('payment_method') && $request->filled('payment_method'), function ($q) use ($request) {
                    $q->whereHas('userPaymentMethod.paymentMethod', function ($q) use ($request) {
                        $q->where('id', $request->payment_method);
                    });
                })
                ->when($request->has('withdrawal_status') && $request->filled('withdrawal_status'), function ($q) use ($request) {
                    $q->where('is_approved', $request->withdrawal_status);
                })
                ->get();


            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    $icon_url = env('MEDIA_URL');
                    $picture = $row->users->profile_pic ?? 'default.png';
                    $name = $row->users->name ?? 'No Name';
                    $lastname = $row->users->lastname ?? ' ';
                    $country = $row->users->country->name ?? 'No Country';
                    $image = '    <td>
                                <div class="user-profile">
                                    <div class="user-img">
                                        <a href="' . route('admin.manage.users.detail', $row->users->id) . '"><img src="' . $icon_url . $picture . '"></a>
                                    </div>

                                <div class="description">
                                <a href=""><div class="user-title">' . $name .' '. $lastname.'</div></a>
                                </div>
                                </div>
                            </td>';
                    return $image;
                })
                ->addColumn('country', function ($row) {
                    return $row->users->country->name ?? 'No Country';
                })
                ->addColumn('payment_method', function ($row) {
                    return $row->userPaymentMethod->paymentMethod->name ?? 'N/A';
                })
                ->addColumn('email', function ($row) {
                    return $row->userPaymentMethod->email ?? 'N/A';
                })
                ->editColumn('created_at', function ($row) use($zone) {
                    return $this->TimeZoneToLocal($row->created_at,$zone);

                })
                ->addColumn('approved', function ($row) {
                    if ($row->is_approved == 0) {
                        $approved = '<span class="badge bg-info">Pending</span>';
                    } elseif ($row->is_approved == 1) {
                        $approved = '<span class="badge bg-success">Approved</span>';
                    } else {
                        $approved = '<span class="badge bg-danger">Declined</span>';
                    }
                    return $approved;
                })
                ->addColumn('action', function ($row) {

                    $actionBtn = '<div class="dropdown" >
                                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a  href="' . route('admin.withdrawal.detail', $row->id) . '" class="withdrawal-decline" data-status="-1" data-withdrawal="' . $row->id . '">View Detail</a></li>
                                </ul>
                            </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'image', 'approved'])
                ->make(true);
        }
    }
    public function userList(Request $request)
    {
        if ($request->ajax()) {
            $zone=Cookie::get('zone');
            $data = Withdrawal::with('userPaymentMethod.paymentMethod', 'users')
                ->when($request->has('user_id') && $request->filled('user_id'), function ($q) use ($request) {
                    $q->where('user_id', $request->user_id);
                })
                ->when($request->has('withdrawal_id') && $request->filled('withdrawal_id'), function ($q) use ($request) {
                    $q->where('id','!=', $request->withdrawal_id);
                })
                ->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    $icon_url = env('MEDIA_URL');
                    $picture = $row->users->profile_pic ?? 'default.png';
                    $name = $row->users->name ?? 'No Name';
                    $lastname = $row->users->lastname ?? ' ';
                    $country = $row->users->country->name ?? 'No Country';
                    $image = '    <td>
                                <div class="user-profile">
                                    <div class="user-img">
                                        <a href="' . route('admin.manage.users.detail', $row->users->id) . '"><img src="' . $icon_url . $picture . '"></a>
                                    </div>

                                <div class="description">
                                <a href=""><div class="user-title">' . $name .' '. $lastname.'</div></a>
                                </div>
                                </div>
                            </td>';
                    return $image;
                })
                ->addColumn('country', function ($row) {
                    return $row->users->country->name ?? 'No Country';
                })
                ->addColumn('payment_method', function ($row) {
                    return $row->userPaymentMethod->paymentMethod->name ?? 'N/A';
                })
                ->addColumn('email', function ($row) {
                    return $row->userPaymentMethod->email ?? 'N/A';
                })
                ->editColumn('created_at', function ($row) use($zone) {
                    return $this->TimeZoneToLocal($row->created_at,$zone);
                })
                ->addColumn('approved', function ($row) {
                    if ($row->is_approved == 0) {
                        $approved = '<span class="badge bg-info">Pending</span>';
                    } elseif ($row->is_approved == 1) {
                        $approved = '<span class="badge bg-success">Approved</span>';
                    } else {
                        $approved = '<span class="badge bg-danger">Declined</span>';
                    }
                    return $approved;
                })
                ->addColumn('action', function ($row) {

                    $actionBtn = '<div class="dropdown" >
                                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a  href="' . route('admin.withdrawal.detail', $row->id) . '" class="withdrawal-decline" data-status="-1" data-withdrawal="' . $row->id . '">View Detail</a></li>
                                </ul>
                            </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'image', 'approved'])
                ->make(true);
        }
    }

    public function detail($id)
    {
        $zone=Cookie::get('zone');
        $silverCoinWithdrawal = Withdrawal::with('userPaymentMethod', 'users.country')->findOrFail($id);
        $silverCoinWithdrawal->created_at=$this->TimeZoneToLocal($silverCoinWithdrawal->created_at,$zone);
//        $transactions = InAppTransaction::where('user_id', $silverCoinWithdrawal->user_id)->paginate(5);
        $silverCoinsTransaction=InAppTransaction::where('user_id', $silverCoinWithdrawal->user_id)->where('coin','Silver')
            ->take(5)->latest()->get();
        $withdrawals=Withdrawal::with('userPaymentMethod.paymentMethod', 'users.country')->where('user_id',$silverCoinWithdrawal->user_id)->where('id','!=',$id)->get();

        $urlProfile = env('MEDIA_URL');
        return view('admin.pages.withdrawals.userSilverCoinsWithdrawal',
            compact('silverCoinWithdrawal', 'silverCoinsTransaction', 'urlProfile','withdrawals'));
    }

    public function withdrawalActions(Request $request)
    {

        $withdrawal = Withdrawal::findorfail($request->withdrawal);
        if ($request->is_approved==-1){
            $user=User::findorfail($request->userId);
            $user->silver_coin +=$withdrawal->coins;
            $user->save();
        }
        $withdrawal->update($request->all());
        return back()->with('success', 'Withdrawal Updated Successfully');
    }
}
