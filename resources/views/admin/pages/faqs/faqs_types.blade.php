@extends('admin.layouts.app')
@section('content')
@section('page_title','FAQs Types')

<style>
    .table{
        text-align: center;
    }
</style>
        <div id="content">
            <div class="container-fluid">

                <section class="section">
                    @can('faqs-add')
                    <div class="mb-3">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#addFaqType" class="btn"> Add New </a>
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



    <div class="modal fade" id="addFaqType" tabindex="-1">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fal ico-cross-circle"></i> </button>
                <div class="modal-header">
                    Add New FAQs Type
                </div>
            <form action="{{ route('admin.faqsType.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
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
<div class="modal fade" id="EditFaq" tabindex="-1">
    <div class="modal-dialog  modal-dialog-centered" id="FaqModelEdit">

    </div>
</div>
    <div class="modal fade" id="deleteFaqtype" tabindex="-1">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fal ico-cross-circle"></i> </button>
                <div class="modal-header">
                    Are you sure you want to delete this FAQs Type?
                </div>
            <form method="POST" action="{{ route('admin.faqsType.delete') }}">
                @csrf
                <div class="modal-body">
                    <p><span class="text-yellow">Warning!: </span>If you delete this type, then all linked FAQs will be also deleted.</p>
                </div>
                <input type="hidden" name="faqType" id="faqType" value="" >
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
              ajax: "{{ route('admin.faqsType.list') }}",
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
