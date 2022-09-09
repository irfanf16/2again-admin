@extends('admin.layouts.app')
@section('content')
@section('page_title','Dashboard')
<div id="content">
    <div class="container-fluid">
        <section class="section">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="small-box gradient-blue radius-10">
                        <div class="inner">
                            <p>Total Users</p>
                            <h3 class="m-0">{{ $totalUsers }}</h3>
                        </div>

                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="small-box bg-green radius-10">
                        <div class="inner">
                            <p>Active Users</p>
                            <h3 class="m-0">{{ $totalActiveUsers }}</h3>
                        </div>

                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="small-box bg-warning radius-10">
                        <div class="inner">
                            <p>Today Accounts</p>
                            <h3 class="m-0">{{ $todayUsers }}</h3>
                        </div>

                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="small-box gradient-purple radius-10">
                        <div class="inner">
                            <p>Online Users</p>
                            <h3 class="m-0">{{$onlineUsers}}</h3>
                        </div>

                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="small-box bg-warning radius-10">
                        <div class="inner">
                            <p>Banned Accounts</p>
                            <h3 class="m-0">{{ $bannedUsers }}</h3>
                        </div>

                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="small-box gradient-red radius-10">
                        <div class="inner">
                            <p>Deleted Accounts</p>
                            <h3 class="m-0">{{ $deletedUsers }}</h3>
                        </div>

                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="small-box bg-warning radius-10">
                        <div class="inner">
                            <p>Reported Users</p>
                            <h3 class="m-0">{{ $reportedUsers }}</h3>
                        </div>

                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="small-box bg-green radius-10">
                        <div class="inner">
                            <p>Count of Purchases with Currency</p>
                            <h3 class="m-0"> {{ $purchase }}</h3>
                        </div>

                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="small-box bg-purple radius-10">
                        <div class="inner">
                            <p>Total Gold Coins (In User Accounts)</p>
                            <h3 class="m-0"> {{ $goldCoins }}</h3>
                        </div>

                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="small-box bg-green radius-10">
                        <div class="inner">
                            <p>Badges</p>
                            <h3 class="m-0"> {{ $badges }}</h3>
                        </div>

                    </div>
                </div>
                @foreach($subscriptionBadges as $badge)

                    <div class="col-md-4 mb-3">
                        <div class="small-box gradient-darkblue radius-10">
                            <div class="inner">
                                <p>{{$badge->name}}</p>
                                @if($badge->shortcode=='GAM')
                                    <h3 class="m-0">{{ $totalGAM }}</h3>
                                @elseif($badge->shortcode=='VIP')
                                    <h3 class="m-0">{{ $totalVIP }}</h3>
                                @elseif($badge->shortcode=='BS')
                                    <h3 class="m-0">{{ $totalBS }}</h3>
                                @else
                                    <h3 class="m-0">{{ $totalCustom }}</h3>
                                @endif
                            </div>
                            <div class="">
                                <img width="50px" src="{{ $GIFT_URL.$badge->badge }}">
                            </div>
                        </div>
                    </div>
                @endforeach
                {{--                    <div class="col-md-4 mb-3">--}}
                {{--                        <div class="small-box gradient-darkblue radius-10">--}}
                {{--                            <div class="inner">--}}
                {{--                                <p>VIP</p>--}}
                {{--                                <h3 class="m-0">{{ $totalVIP }}</h3>--}}
                {{--                            </div>--}}
                {{--                            <div class="">--}}
                {{--                                <img src="{{ asset('admin/images/vipbadge.svg') }}"  width="48px;" >--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                    <div class="col-md-4 mb-2">--}}
                {{--                        <div class="small-box gradient-darkblue radius-10">--}}
                {{--                            <div class="inner">--}}
                {{--                                <p>Big spenders</p>--}}
                {{--                                <h3 class="m-0">{{ $totalBS }}</h3>--}}
                {{--                            </div>--}}
                {{--                            <div class="">--}}
                {{--                                <img src="{{ asset('admin/images/bigspender.svg') }}">--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}


                <h4 class="text-yellow">Silver Coins Analytics</h4>

                <div class="col-md-4 mb-3">
                    <div class="small-box bg-secondary radius-10">
                        <div class="inner">
                            <p>Total Earned <br>
                                <small> (In User Accounts + Requested )</small></p>
                            <h3 class="m-0"> {{ $totalearned }} = ${{$totalearnedConvertions}}</h3>
                        </div>

                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="small-box bg-secondary radius-10">
                        <div class="inner">
                            <p>Total Payable <br>
                                <small> (In User Accounts + Pending For Approval )</small></p>
                            <h3 class="m-0"> {{ $totalpayable }} = ${{$totalPayableConvertions}}</h3>
                        </div>

                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="small-box bg-dark-blue radius-10">
                        <div class="inner">
                            <p>Total In User Accounts</p>
                            <h3 class="m-0"> {{ $silverCoins }} = ${{$silverCoinsConvertions}}</h3>
                        </div>

                    </div>
                </div>


                <div class="col-md-4 mb-3">
                    <div class="small-box bg-info radius-10">
                        <div class="inner">
                            <p>Total Pending for Approval</p>
                            <h3 class="m-0"> {{ $pendingPayable }} = ${{$pendingPayableConvertions}}</h3>
                        </div>

                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="small-box bg-green radius-10">
                        <div class="inner">
                            <p>Total Approved</p>
                            <h3 class="m-0"> {{ $approvedPayable }} = ${{$approvedPayableConvertions}}</h3>
                        </div>

                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="small-box gradient-red radius-10">
                        <div class="inner">
                            <p>Total Declined</p>
                            <h3 class="m-0"> {{ $declinedPayable }} = ${{$declinedPayableConvertions}}</h3>
                        </div>

                    </div>
                </div>

                {{--                    <div class="col-md-4 mb-3">--}}
                {{--                        <div class="small-box gradient-red radius-10">--}}
                {{--                            <div class="inner">--}}
                {{--                                <p>Active Offers</p>--}}
                {{--                                <h3 class="m-0"> {{ $offers }}</h3>--}}
                {{--                            </div>--}}
                {{--                            <div class="icon-box">--}}
                {{--                                <i class="fas fa-users"></i>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
            </div>
        </section>
        {{--            <section class="section">--}}
        {{--                <div class="row">--}}
        {{--                    <div class="col-md-6">--}}
        {{--                        <div class="img-box">--}}
        {{--                            <img src="images/chart.jpg" alt="">--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                    <div class="col-md-6">--}}
        {{--                        <div class="img-box">--}}
        {{--                            <img src="images/map.jpg" alt="">--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </section>--}}

    </div>
</div>
@endsection
