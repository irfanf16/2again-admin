@extends('admin.layouts.app')

@section('content')
@section('page_title','Withdrawals History')
<div id="content">
    <div class="container-fluid">
        <section class="section section-banner">
            <div class="col">
                <div class="content-center">
                    <div class="user-img mx-2">
                        <img class=""
                             src="{{ $urlProfile}}{{ $silverCoinWithdrawal->users->profile_pic }}">
                    </div>
                    <p><strong
                            class="text-yellow">{{$silverCoinWithdrawal->users->name.' '.$silverCoinWithdrawal->users->lastname }}  </strong>
                        ( {{$silverCoinWithdrawal->users->country['name']}} ) </p>
                </div>
                <p>Request Amount</p>
                <h3 class="text-yellow">{{$silverCoinWithdrawal->coins}} = ${{$silverCoinWithdrawal->amount}} </h3>
                <p><small> {{$silverCoinWithdrawal->userPaymentMethod->paymentMethod->name}}</small>: <small class="text-yellow">{{$silverCoinWithdrawal->userPaymentMethod->email}}</small> </p>
               <p><small>Date: {{$silverCoinWithdrawal->created_at}}</small></p>
                <p><small>Current Status: @if($silverCoinWithdrawal->is_approved==0)
                            Pending @elseif($silverCoinWithdrawal->is_approved==1) <strong
                                class="text-green">Approved</strong>  @else <strong class="text-red">Declined</strong>
                            @endif </small></p>
                @if($silverCoinWithdrawal->is_approved==0)
                    @can('withdrawal-request-approved')
                        <a href="" class="btn btn-green approvedWithdrawal"
                           data-withdrawal="{{$silverCoinWithdrawal->id}}">Approve</a>
                    @endcan
                    @can('withdrawal-request-decline')
                        <a href="" class="btn bg-danger decclinedWithdrawal"
                           data-withdrawal="{{$silverCoinWithdrawal->id}}">Decline</a>
                    @endcan
{{--                @elseif($silverCoinWithdrawal->is_approved==1)--}}
{{--                    @can('withdrawal-request-pending')--}}
{{--                        <a href="" class="btn btn-warning pendingWithdrawal"--}}
{{--                           data-withdrawal="{{$silverCoinWithdrawal->id}}">Pending</a>--}}
{{--                    @endcan--}}
{{--                    @can('withdrawal-request-decline')--}}
{{--                        <a href="" class="btn bg-danger decclinedWithdrawal"--}}
{{--                           data-withdrawal="{{$silverCoinWithdrawal->id}}">Decline</a>--}}
{{--                    @endcan--}}
{{--                @else--}}
{{--                    @can('withdrawal-request-pending')--}}
{{--                        <a href="" class="btn btn-warning pendingWithdrawal"--}}
{{--                           data-withdrawal="{{$silverCoinWithdrawal->id}}">Pending</a>--}}
{{--                    @endcan--}}
{{--                    @can('withdrawal-request-approved')--}}
{{--                        <a href="" class="btn btn-green approvedWithdrawal"--}}
{{--                           data-withdrawal="{{$silverCoinWithdrawal->id}}">Approve</a>--}}
{{--                    @endcan--}}
                @endif
            </div>
            <div class="col">
                <div class="img-box pull-right">
                    <img src="{{asset('frontend/images/silvercoinbox.svg')}}">
                </div>
            </div>
        </section>

        <section class="section">
            <ul class="tabset">
                <li class="active"><a href="#withdrawalRequest">Withdrawal Requests</a></li>
                <li><a href="#silverCoins">Earning History</a></li>
            </ul>
            <div class="tab-content overflow-hidden mt-4 ">
                <div class="tab active" id="withdrawalRequest">
                    <section class="section">
                        <div class="table-responsive">
                            <table class="table yajra-datatable">
                                <thead>
                                <tr>
                                    <th>#</th>
{{--                                    <th>User</th>--}}
{{--                                    <th>Country</th>--}}
                                    <th>Withdrawal Method</th>
                                    <th>Withdrawal Email</th>
                                    <th>Silver Coins</th>
                                    <th>USD</th>
                                    <th>Conversion Rate</th>
                                    <th>Requested Date</th>
                                    <th>Approved</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
                <div class="tab" id="silverCoins">
                    <ul class="icon-list large list2" id="silver-coin-transaction-list">
                        @foreach ($silverCoinsTransaction as $transaction)
                            <li>
                                <div class="description">
                                    <div class="text">
                                        <div
                                            class="title @if($transaction->type == 'CREDIT') text-green @else text-red @endif">
                                            {{ $transaction->type == 'CREDIT' ? 'Received' : 'Spent' }} {{ $transaction->amount }} {{ $transaction->coin }}
                                            Coins
                                        </div>
                                        <p class="text-gray font-12">{{ $transaction->source }}</p>
                                    </div>
                                    <div class="info text-gray  w-auto">
                                        {{ $transaction->created_at }}
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <div class="text-center">
                        <input type="button" class="btn small w-100 " id="getMoreSilverCoinTransactions"
                               data-user="{{ $silverCoinWithdrawal->users->id }}"
                               data-offset="2"
                               value="@if(count($silverCoinsTransaction) > 4) Load More @else No More Data @endif">
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<div class="modal fade" id="withdrawalApproved" tabindex="-1">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <form action="{{route('admin.withdrawal.action')}}" method="POST">
                @csrf
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fal ico-cross-circle"></i></button>
                <div class="modal-header">
                    Are you sure you want to approve this user Withdrawal Request?
                </div>
                <div class="modal-body">
                    <p><span class="text-yellow">Warning!: </span> If you Approved this request, user will be able to
                        withdrawal this request</p>
                </div>
                <input type="hidden" id="withdrawalApprovedBtn" name="withdrawal">
                <input type="hidden" value="1" name="is_approved">
                <div class="modal-footer justify-content-between">
                    <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
                    <button type="submit" class="btn btn-green">Approved</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="withdrawalPending" tabindex="-1">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <form action="{{route('admin.withdrawal.action')}}" method="POST">
                @csrf
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fal ico-cross-circle"></i></button>
                <div class="modal-header">
                    Are you sure you want to pending this user Withdrawal Request?
                </div>
                <div class="modal-body">
                    <p><span class="text-yellow">Warning!: </span> If you pending this request, user will not be able to
                        withdrawal this request</p>
                </div>
                <input type="hidden" id="withdrawalPendingBtm" name="withdrawal">
                <input type="hidden" value="0" name="is_approved">
                <div class="modal-footer justify-content-between">
                    <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
                    <button type="submit" class="btn btn-green">Pending</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="withdrawalDeclined" tabindex="-1">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <form action="{{route('admin.withdrawal.action')}}" method="POST">
                @csrf
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fal ico-cross-circle"></i></button>
                <div class="modal-header">
                    Are you sure you want to decline this user Withdrawal Request?
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Decline Reason</label>
                        <textarea name="declined_reason" class="form-control" placeholder="Enter declined reason"
                                  required style="height: 100%"></textarea>
                    </div>
                </div>
                <input type="hidden" id="withdrawalDeclinedBtn" name="withdrawal">
                <input type="hidden" value="-1" name="is_approved">
                <input type="hidden" value="{{ $silverCoinWithdrawal->users->id }}" name="userId">
                <div class="modal-footer justify-content-between">
                    <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
                    <button type="submit" class="btn btn-warning">Decline</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {

        var table = $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.withdrawal.user.list') }}",
                type: 'GET',
                data: function (d) {
                    d.user_id='{{$silverCoinWithdrawal->user_id}}'
                    d.withdrawal_id='{{$silverCoinWithdrawal->id}}'
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},

                // {
                //     data: 'image',
                //     name: 'image',
                //     orderable: true,
                //     searchable: true
                //
                // },
                // {
                //     data: 'country',
                //     name: 'country',
                //     orderable: true,
                //     searchable: true
                //
                // },
                {
                    data: 'payment_method',
                    name: 'payment method',
                    orderable: true,
                    searchable: true

                },
                {
                    data: 'email',
                    name: 'email',
                    orderable: true,
                    searchable: true

                },
                {
                    data: 'coins',
                    name: 'coins',
                    orderable: true,
                    searchable: true

                },
                {
                    data: 'amount',
                    name: 'amount',
                    orderable: true,
                    searchable: true

                },
                {
                    data: 'conversion_rate',
                    name: 'conversion_rate',
                    orderable: true,
                    searchable: true

                },
                {
                    data: 'created_at',
                    name: 'date',
                    orderable: true,
                    searchable: true

                },
                {
                    data: 'approved',
                    name: 'approved',
                    orderable: true,
                    searchable: true

                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: true
                },
            ]
        });
        $('#payment_method').on('change', function () {
            table.draw();
        });
        $('#withdrawal_status').on('change', function () {
            table.draw();
        });
    });

</script>



@endsection
