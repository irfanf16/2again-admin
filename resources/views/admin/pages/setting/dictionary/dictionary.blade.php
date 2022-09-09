@extends('admin.layouts.app')

@section('content')

@section('page_title','Dictionary')

        <div id="content">
            <div class="container-fluid">
                <section class="section">
                    @can('dictionary-add')
                    <div class="mb-3">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#addWord" class="btn ">Add New</a>
                    </div>
                    @endcan
                    <div class="table-responsive">
                        <table class="table yajra-datatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Abusive Words</th>
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
                    Add New Word
                </div>
            <form action="{{ route('admin.dictionary.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Enter Word</label>
                        <input type="text"  name="word" class="form-control" placeholder="Enter Word" required>
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
<div class="modal fade" id="editWordModal" tabindex="-1">
    <div class="modal-dialog  modal-dialog-centered" id="editWord">

    </div>
</div>

    <div class="modal fade" id="deleteWord" tabindex="-1">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fal ico-cross-circle"></i> </button>
                <div class="modal-header">
                    Are you sure you want to delete this Word?
                </div>
                <form method="POST" action="{{ route('admin.dictionary.delete') }}">
                    @csrf
                    <div class="modal-body">
                        <p><span class="text-yellow">Warning!: </span>If you delete this word, users will be able to send this word in the chat</p>
                    </div>
                    <input type="hidden" name="word" id="word" value="" >
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
              ajax: "{{ route('admin.dictionary.list') }}",
              columns: [
                  {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                  {
                      data: 'word',
                      name: 'word',
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
