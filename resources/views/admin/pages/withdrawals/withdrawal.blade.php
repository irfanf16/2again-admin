@extends('admin.layouts.app')

@section('content')
@section('page_title','Withdrawals')

        <div id="content">
            <div class="container-fluid">
                @include('admin.inc.alerts')
                <section class="section">
                    <div class="content-box p-3">
                        <form>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Withdrawal Method</label>
                                    <select class="form-select" id="payment_method">
                                        <option value="">All</option>
                                        @foreach($paymentMethods as $paymentMethod)
                                            <option value="{{$paymentMethod->id}}">{{$paymentMethod->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Withdrawal Status</label>
                                    <select class="form-select" id="withdrawal_status">
                                        <option value="">All</option>
                                        <option value="0">Pending</option>
                                        <option value="1">Approved</option>
                                        <option value="-1">Declined</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>

                <section class="section">
                    <div class="table-responsive">
                        <table class="table yajra-datatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Country</th>
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
        </div>



    <script type="text/javascript">
        $(function () {

          var table = $('.yajra-datatable').DataTable({
              processing: true,
              serverSide: true,
              ajax: {
                  url: "{{ route('admin.withdrawal.list') }}",
                  type: 'GET',
                  data: function (d) {
                      d.payment_method=$('#payment_method').val()
                      d.withdrawal_status=$('#withdrawal_status').val()
                  }
              },
              columns: [
                  {data: 'DT_RowIndex', name: 'DT_RowIndex'},

                  {
                      data: 'image',
                      name: 'image',
                      orderable: true,
                      searchable: true

                  },
                  {
                      data: 'country',
                      name: 'country',
                      orderable: true,
                      searchable: true

                  },
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
