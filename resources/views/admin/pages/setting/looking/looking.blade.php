@extends('admin.layouts.app')

@section('content')

@section('page_title','Looking For')

        <div id="content">
            <div class="container-fluid">
                <section class="section">
                    @can('looking-for-read')
                    <div class="mb-3">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#addWord" class="btn">Add New</a>
                    </div>
                    @endcan
                    <div class="table-responsive">
                        <table class="table yajra-datatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
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




    <div class="modal fade" id="addWord" tabindex="-1">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fal ico-cross-circle"></i> </button>
                <div class="modal-header">
                    Add New
                </div>
            <form action="{{ route('admin.looking.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Enter Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Word" required>
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
<div class="modal fade" id="editLookingModal" tabindex="-1">
    <div class="modal-dialog  modal-dialog-centered" id="editLooking">

    </div>
</div>
    <div class="modal fade" id="deleteLookingFor" tabindex="-1">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fal ico-cross-circle"></i> </button>
                <div class="modal-header">
                    Are you sure you want to delete this Looking for?
                </div>
                <form method="POST" action="{{ route('admin.looking.delete') }}">
                    @csrf
                    <div class="modal-body">
                        <p><span class="text-yellow">Warning!: </span>If you delete this Looking for, users will be able to set this looking for</p>
                    </div>
                    <input type="hidden" name="name" id="lookingFor" value="" >
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
              ajax: "{{ route('admin.looking.list') }}",
              columns: [
                  {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                  {
                      data: 'name',
                      name: 'name',
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
