@extends('admin.layouts.app')

@section('content')
@section('page_title','Purchases')

        <div id="content">
            <div class="container-fluid">
                <section class="section">
                    <div class="table-responsive">
                        <table class="table yajra-datatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Country</th>
                                <th>Purchase Type</th>
                                <th>Item Purchased</th>
                                <th>Quantity</th>
                                <th>Amount</th>
                                <th>Currency</th>
                                <th>Purchased At</th>
{{--                                <th>action</th>--}}
                            </tr>
                            </thead>
                            <tbody>


                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>


    </div>

    <div class="modal fade" id="addEmoji" tabindex="-1">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fal ico-cross-circle"></i> </button>
                <div class="modal-header">
                    Add New Tip
                </div>
            <form action="{{ route('admin.safety.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Enter title</label>
                        <input type="text" name="title" class="form-control" placeholder="Enter Name" required>
                    </div>
                    <div class="form-group">
                        <label>Enter Tip</label>
                        <input type="text" name="tip" class="form-control" placeholder="Enter Name" required>
                    </div>
                    <div class="form-group">
                        <label>Select Icon (Only PNG)</label>
                        <input type="file" name="file" class="form-control" accept="image/png" required />
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
                    <input type="submit" class="btn btn-green" value="Add">
                </div>
            </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteTip" tabindex="-1">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fal ico-cross-circle"></i> </button>
                <div class="modal-header">
                    Are you sure you want to delete this Tip?
                </div>
                <form method="POST" action="{{ route('admin.safety.destroy') }}">
                    @csrf
                    <div class="modal-body">
                        <p><span class="text-yellow">Warning!: </span>If you delete this Tip, users will be able to see this tip in tips section</p>
                    </div>
                    <input type="hidden" name="tip" id="tip" value="" >
                    <div class="modal-footer justify-content-between">
                        <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
                    <input type="submit" class="btn btn-green" value="Delete">
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
              ajax: "{{ route('admin.purchases.list') }}",
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
                      data: 'purchase_type',
                      name: 'purchase_type',
                      orderable: true,
                      searchable: true
                  },
                  {
                      data: 'item_purchased',
                      name: 'item_purchased',
                      orderable: true,
                      searchable: true
                  },
                  {
                      data: 'quantity',
                      name: 'quantity',
                      orderable: true,
                      searchable: true
                  },
                  {
                      data: 'spend_amount',
                      name: 'spend_amount',
                      orderable: true,
                      searchable: true
                  },
                  {
                      data: 'currency',
                      name: 'currency',
                      orderable: true,
                      searchable: true
                  },
                  {
                      data: 'created_at',
                      name: 'created_at',
                      orderable: true,
                      searchable: true
                  },
                  // {
                  //     data: 'action',
                  //     name: 'action',
                  //     orderable: true,
                  //     searchable: true
                  // },
              ]
          });

        });
    </script>
@endsection
