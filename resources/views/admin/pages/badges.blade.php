@extends('admin.layouts.app')

@section('content')
@section('page_title','Badges')

        <div id="content">
            <div class="container-fluid">
{{--                @include('admin.inc.alerts')--}}
                <section class="section">
{{--                    <div class="mb-3">--}}
{{--                        <a href="#" data-bs-toggle="modal" data-bs-target="#addBadge" class="btn btn-green"> Add Badge</a>--}}
{{--                    </div>--}}
                    <div class="table-responsive">
                        <table class="table yajra-datatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Badge Name</th>
                                @can('badge-edit')
                                <th>Action</th>
                                @endcan
                            </tr>
                            </thead>
                            <tbody >

                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>



    <div class="modal fade" id="addBadge" tabindex="-1">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fal ico-cross-circle"></i> </button>
                <div class="modal-header">
                    Add custom badge
                </div>
            <form action="{{ route('admin.badges.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter badge name" required>
                    </div>
                    <div class="form-group">
                        <label>Badge Icon</label>
                        <input type="file" name="file" class="form-control" required>
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
    <div class="modal fade" id="EditBadge" tabindex="-1">
        <div class="modal-dialog  modal-dialog-centered" id="BadgeModelEdit">

        </div>
    </div>
    <div class="modal fade" id="deleteBadge" tabindex="-1">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fal ico-cross-circle"></i> </button>
                <div class="modal-header">
                    Are you sure you want to delete this Badge?
                </div>
            <form method="POST" action="{{route('admin.badges.delete')}}">
                @csrf
                <div class="modal-body">
                    <p><span class="text-yellow">Warning!: </span> This Badge will be permanently removed from the system</p>
                </div>
                <input type="hidden" name="badge" id="badge" value="" >
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
              ajax: {
                  url: "{{ route('admin.badges.list') }}",
                  type: 'GET',
                  data: function (d) {
                      d.Faq_types=$('#Faq_types').val()
                  }
              },
              columns: [
                  {data: 'DT_RowIndex', name: 'DT_RowIndex'},

                  {
                      data: 'image',
                      name: 'name',
                      orderable: true,
                      searchable: true
                  },
                  {
                      data: 'name',
                      name: 'name',
                      orderable: true,
                      searchable: true
                  },
                @can('badge-edit')
                  {
                      data: 'action',
                      name: 'action',
                      orderable: true,
                      searchable: true
                  },
                  @endif
              ]
          });
        });
    </script>
@endsection
