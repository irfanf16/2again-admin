@extends('admin.layouts.app')

@section('content')
@section('page_title','Permissions')

<div id="content">
    <div class="container-fluid">
        <section class="section">
            <div class="mb-3">
{{--                <a href="{{ route('admin.roles.create') }}" class="btn btn-green"><i class="fas fa-user-plus"></i> Create new Role</a>--}}
            </div>
            <div class="table-responsive">
                <table class="table yajra-datatable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Menu Name</th>
                        <th>Slug</th>
                        <th>Display Name</th>
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

<div class="modal fade" id="editPermissionmodal" tabindex="-1">
    <div class="modal-dialog  modal-dialog-centered" id="editPermission">

    </div>
</div>
<script type="text/javascript">
    $(function () {

        var table = $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.permissions.list') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},

                {
                    data: 'name',
                    name: 'name',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'slug',
                    name: 'slug',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'display_name',
                    name: 'display_name',
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
