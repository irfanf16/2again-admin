@extends('admin.layouts.app')

@section('content')
@section('page_title','Gifts')

        <div id="content">
            <div class="container-fluid">

                <section class="section">
                    @can('giftInvitation-add')
                    <div class="mb-3">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#addGift" class="btn"> Add New </a>
                    </div>
                    @endcan
                    <div class="table-responsive">
                        <table class="table yajra-datatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Icon</th>
                                <th>Name</th>
                                <th>Deduct Gold Coins</th>
                                <th>Earn Silver Coins</th>
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



    <div class="modal fade" id="addGift" tabindex="-1">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fal ico-cross-circle"></i> </button>
                <div class="modal-header">
                    Add New Gift
                </div>
            <form action="{{ route('admin.giftInvitation.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Enter Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
                    </div>
                    <div class="form-group">
                        <label>Deduct Gold Coins</label>
                        <input type="number" onKeyPress="if(this.value.length==7) return false;" min="0" name="price" class="form-control" placeholder="Enter Gold Coins" required>
                    </div>
                    <div class="form-group">
                        <label>Earn Silver Coins</label>
                        <input type="number" onKeyPress="if(this.value.length==7) return false;" min="0" name="silver_coin" class="form-control" placeholder="Enter Silver Coins" required>
                    </div>
                    <div class="form-group">
                        <label>Select Icon</label>
                       <input type="file" name="file" class="form-control" required>
                    </div>

                    <input type="hidden" name="type" value="Gift">
                </div>
                <div class="modal-footer justify-content-between">
                    <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
                    <input type="submit" class="btn btn-green" value="Add">
                </div>
            </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editGiftInvitationModal" tabindex="-1">
        <div class="modal-dialog  modal-dialog-centered" id="editGiftInvitation">

        </div>
    </div>

    <div class="modal fade" id="deleteGift" tabindex="-1">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fal ico-cross-circle"></i> </button>
                <div class="modal-header">
                    Are you sure you want to delete this Gift?
                </div>
            <form method="POST" action="{{ route('admin.giftInvitation.delete') }}">
                @csrf
                <div class="modal-body">
                    <p><span class="text-yellow">Warning!: </span> This gift will be permanently removed from the system</p>
                </div>
                <input type="hidden" name="gift" id="gift" value="" >
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
              ajax: "{{ route('admin.gifts.list') }}",
              columns: [
                  {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                  {
                      data: 'image',
                      name: 'image',
                      orderable: true,
                      searchable: true
                  },
                  {
                      data: 'name',
                      name: 'name',
                      orderable: true,
                      searchable: true
                  },
                  {
                      data: 'price',
                      name: 'price',
                      orderable: true,
                      searchable: true
                  },
                  {
                      data: 'silver_coin',
                      name: 'silver_coin',
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

        });
    </script>

@endsection
