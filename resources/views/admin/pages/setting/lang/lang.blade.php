@extends('admin.layouts.app')

@section('content')
@section('page_title','App Translated Language')
<div id="content">
    <div class="container-fluid">
        <section class="section">
            @can('language-add')
            <div class="mb-3">
                <a href="#" data-bs-toggle="modal" data-bs-target="#addLang" class="btn ">Add New</a>
            </div>
            @endcan
            <div class="table-responsive">
                <table class="table yajra-datatable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Language Name</th>
                        <th>Short Code</th>
                        <th>Is Active</th>
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


<div class="modal fade" id="addLang" tabindex="-1">
    <div class="modal-dialog  modal-lg" id="editLanguage">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                    class="fal ico-cross-circle"></i></button>
            <div class="modal-header">
                Add New
            </div>
            <form id="form" action="" method="POST"
                  enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group">
                            <label>Language</label>
                            <select class="form-select" id="language_id" name="language_id" required>
                                {{--                                <option value="">Select Languages</option>--}}
                                @foreach($languages as $language)
                                    <option value="{{$language->id}}">{{$language->name}} ( {{$language->short}})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Json Data</label>
                            <textarea id="data" name="translation" cols="50" rows="20"></textarea>

                        </div>
                        <code id="results"></code>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
                    <input id="submit" type="submit" class="btn btn-green" value="Add">
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editLanguageModal" tabindex="-1">
    <div class="modal-dialog  modal-lg" id="">

    </div>
</div>
<div class="modal fade" id="deleteLanguage" tabindex="-1">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                    class="fal ico-cross-circle"></i></button>
            <div class="modal-header">
                Are you sure you want to delete this app language translation.?
            </div>
            <form method="POST" action="{{ route('admin.app.translated.languages.delete') }}">
                @csrf
                <div class="modal-body">
                    <p><span class="text-yellow">Warning!: </span>If you delete this app language, users will not be able to see
                        this language translation in app</p>
                </div>
                <input type="hidden" name="language" id="language" value="">
                <div class="modal-footer justify-content-between">
                    <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
                    <input type="submit" class="btn btn-green" value="Delete">
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="enableLangModal" tabindex="-1">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                    class="fal ico-cross-circle"></i></button>
            <div class="modal-header">
                Are you sure you want to Enable this app language translation.?
            </div>
            <form method="POST" action="{{ route('admin.app.translated.languages.enable') }}">
                @csrf
                <div class="modal-body">
                    <p><span class="text-yellow">Warning!: </span>If you enable this app language, users will be able to see
                        this language translation in app</p>
                </div>
                <input type="hidden" name="is_active" id="enableLang" value="">
                <div class="modal-footer justify-content-between">
                    <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
                    <input type="submit" class="btn btn-green" value="Enable">
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="disableLangModal" tabindex="-1">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                    class="fal ico-cross-circle"></i></button>
            <div class="modal-header">
                Are you sure you want to disable this app language translation.?
            </div>
            <form method="POST" action="{{ route('admin.app.translated.languages.disable') }}">
                @csrf
                <div class="modal-body">
                    <p><span class="text-yellow">Warning!: </span>If you enable this app language, users will not be able to see
                        this language translation in app</p>
                </div>
                <input type="hidden" name="is_active" id="disableLang" value="">
                <div class="modal-footer justify-content-between">
                    <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
                    <input type="submit" class="btn btn-green" value="Disable">
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
            ajax: "{{ route('admin.app.translated.languages.list') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {
                    data: 'languageName',
                    name: 'languageName',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'lang',
                    name: 'lang',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'is_active',
                    name: 'is_active',
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


    $(document).ready(function (){
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            try {
                JSON.parse(data.value);
                results.innerHTML = 'Valid Json!';
                $.ajax({
                    method: "POST",
                    url: window.location.origin + '/admin/app/translated/languages/store',
                    data: {
                        language_id: $('#language_id').val(),
                        translation: $('#data').val(),
                        _token: $('meta[name="csrf_token"]').attr('content')
                    }
                }).done(function (response) {
                    if(response.code==1){
                        toastr.success(response.message);
                        $('#addLang').modal('hide')
                        var table = $('.yajra-datatable').DataTable();
                        table.ajax.reload();
                    }
                    if(response.code==0){
                        toastr.error(response.message);
                    }
                })
            } catch (e) {
                results.innerHTML = e;
            }
        });

    })
</script>
@endsection
