@extends('admin.layouts.app')

@section('content')
@section('page_title','Languages')
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
                        <th>Name</th>
                        <th>Short Code</th>
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
    <div class="modal-dialog  modal-sm">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                    class="fal ico-cross-circle"></i></button>
            <div class="modal-header">
                Add New language
            </div>
            <form action="{{ route('admin.languages.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Enter Name</label>
                            <input type="text" name="name" oninput="this.value = this.value.replace(/[^a-z A-Z ()]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" placeholder="Enter Name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Short Code</label>
                            <input type="text" name="short" oninput="this.value = this.value.replace(/[^a-z A-Z]/g, '').replace(/(\..*)\./g,'$1');" class="form-control" placeholder="Enter Short Code"
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
    <div class="modal-dialog  modal-sm" id="editLanguage">

    </div>
</div>
<div class="modal fade" id="deleteLanguage" tabindex="-1">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fal ico-cross-circle"></i> </button>
            <div class="modal-header">
                Are you sure you want to delete this language.?
            </div>
            <form method="POST" action="{{ route('admin.languages.delete') }}">
                @csrf
                <div class="modal-body">
                    <p><span class="text-yellow">Warning!: </span>If you delete this language, users will be able to see this language in language section</p>
                </div>
                <input type="hidden" name="language" id="language" value="" >
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
            ajax: "{{ route('admin.languages.list') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {
                    data: 'name',
                    name: 'name',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'short',
                    name: 'short code',
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
