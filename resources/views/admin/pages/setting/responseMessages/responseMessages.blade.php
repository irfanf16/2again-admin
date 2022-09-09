@extends('admin.layouts.app')

@section('content')
@section('page_title','Response Messages')
<div id="content">
    <div class="container-fluid">
        <section class="section">
            @can('language-add')
            <div class="mb-3">
                <a href="#" data-bs-toggle="modal" data-bs-target="#addLanguage" class="btn">Add New</a>
            </div>
            @endcan
            <div class="table-responsive">
                <table class="table yajra-datatable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Key</th>
                        <th>String</th>
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


<div class="modal fade" id="addLanguage" tabindex="-1">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                    class="fal ico-cross-circle"></i></button>
            <div class="modal-header">
                Add New Response Message
            </div>
            <form action="{{ route('admin.response.messages.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Enter Key</label>
                            <input type="text" name="key_string" oninput="this.value = this.value.replace(/[^a-z _ A-Z ()]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" placeholder="Enter Key" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Key Translation</label>
                            <input type="text" name="key_translation" class="form-control" placeholder="Enter Translation"
                                   required/>
                        </div>

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

<div class="modal fade" id="editLanguageModal" tabindex="-1">
    <div class="modal-dialog  modal-lg" id="editLanguage">

    </div>
</div>
<div class="modal fade" id="deleteLanguage" tabindex="-1">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fal ico-cross-circle"></i> </button>
            <div class="modal-header">
                Are you sure you want to delete this response message.?
            </div>
            <form method="POST" action="{{ route('admin.response.messages.delete') }}">
                @csrf
                <div class="modal-body">
                    <p><span class="text-yellow">Warning!: </span>If you delete this response message, users will be able to see this response message</p>
                </div>
                <input type="hidden" name="id" id="language" value="" >
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
            ajax: "{{ route('admin.response.messages.list') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {
                    data: 'key_string',
                    name: 'key_string',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'key_translation',
                    name: 'key_translation',
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
