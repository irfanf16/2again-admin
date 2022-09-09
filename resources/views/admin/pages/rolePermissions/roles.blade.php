@extends('admin.layouts.app')

@section('content')
@section('page_title','Roles')



<div id="content">
    <div class="container-fluid">
        <section class="section">
            <div class="mb-3">
                <a href="{{ route('admin.roles.create') }}" class="btn btn-green">Add New</a>
            </div>
            <div class="table-responsive">
                <table class="table yajra-datatable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Roles Name</th>
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

<div class="modal fade" id="deleteRoles" tabindex="-1">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                    class="fal ico-cross-circle"></i></button>
            <div class="modal-header">
                Are you sure you want to delete this Role?
            </div>
            <form method="POST" action="{{route('admin.roles.delete')}}">
                @csrf
                <div class="modal-body">
                    <p><span class="text-yellow">Warning!: </span> This Role will be permanently removed from the
                        system</p>
                </div>
                <input type="hidden" name="roles" id="roles" value="">
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
            ajax: "{{ route('admin.roles.list') }}",
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
