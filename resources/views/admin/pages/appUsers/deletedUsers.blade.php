@extends('admin.layouts.app')

@section('content')
@section('page_title','Deleted Users')

<div id="content">
    <div class="container-fluid">
        <section class="section">
            <div class="table-responsive">
                <table class="table yajra-datatable">
                    <thead>
                    <tr>
                        <th>
                            #
{{--                            <div class="form-check checkbox">--}}
{{--                                <input class="form-check-input" type="checkbox" value="" id="all">--}}
{{--                                <label class="form-check-label" for="WithStory"></label>--}}
{{--                            </div>--}}
                        </th>
                        <th>User</th>
                        <th>Country</th>
                        <th>Last Active</th>
                        <th>Gold Coins</th>
                        <th>Silver Coins</th>
                        <th>IP</th>
                        <th>Device ID</th>
                        <th>Status</th>
                        @if( request()->user()->can('app-user-unban') ||  request()->user()->can('app-user-delete')  || request()->user()->can('app-user-recover'))

                        <th>Action</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>
<div class="modal fade" id="recoverUser" tabindex="-1">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                    class="fal ico-cross-circle"></i></button>
            <div class="modal-header">
                Are you sure you want to recover this user?
            </div>
            <div class="modal-body">
                <p><span class="text-yellow">Warning!: </span> If you recover this account, user will be able to
                    access this account</p>
            </div>
            <div class="modal-footer justify-content-between">
                <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
                <a href="#" class="btn btn-green" data-user="" id="recoverUserAccountBtn">Recover</a>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {

        var table = $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.manage.users.usersForDatatable') }}",
                type: 'GET',
                data: function (d) {
                    d.deletedUsers = 1;
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {
                    data: 'user',
                    name: 'user',
                    orderable: true,
                    searchable: true
                },
                {data: 'country', name: 'country'},
                {data: 'updated_at', name: 'last active'},
                {data: 'gold_coin', name: 'gold_coin'},
                {data: 'silver_coin', name: 'silver_coin'},
                {data: 'ip', name: 'ip'},
                {data: 'device_id', name: 'device_id'},
                {data: 'status', name: 'status'},
                    @if( request()->user()->can('app-user-unban') ||  request()->user()->can('app-user-delete')  || request()->user()->can('app-user-recover'))

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
