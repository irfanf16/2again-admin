@extends('admin.layouts.app')
@section('content')
@section('page_title','System Users')
<div id="content">
    <div class="container-fluid">

        <section class="section">
            <div class="mb-3">
                @can('system-user-add')
                <a href="#" class="btn " data-bs-toggle="modal" data-bs-target="#createnewuser"><i
                        class="fas fa-user-plus"></i>Add New</a>
                @endcan
            </div>
            <div class="table-responsive">
                <table class="table yajra-datatable">
                    <thead>
                    <tr>
                        <th>
                            <div class="form-check checkbox">
                                <input class="form-check-input" type="checkbox" value="" id="all">
                                <label class="form-check-label" for="WithStory"></label>
                            </div>
                        </th>
                        <th>Image</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        @if(request()->user()->can('system-user-change-password') || request()->user()->can('system-user-ban') || request()->user()->can('system-user-unban') || request()->user()->can('system-user-delete') || request()->user()->can('system-user-recover'))
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
<div class="modal fade" id="createnewuser" tabindex="-1">
    <div class="modal-dialog  modal-dialog-centered modal-lg">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                    class="fal ico-cross-circle"></i></button>
            <div class="modal-header">
                Create New User
            </div>
            <form method="POST" action="{{route('admin.system.users.store')}}" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>First Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Add first name">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Last Name</label>
                            <input type="text" name="lastname" class="form-control" placeholder="Add last name ">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Email</label>
                            <input type="Email" name="email" class="form-control" autocomplete="off" placeholder="Add Email">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" autocomplete="off" placeholder="Add Password">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Gender</label>
                            <select class="form-select" name="gender_id">
                                <option value="2">Male</option>
                                <option value="3">Female</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Assign Role</label>
                            <select class="form-select" name="role_id">
                                @foreach($roles as $role)
                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="ip" value="{{request()->ip()}}">
                        <div class="col-md-6 form-group">
                            <label>Profile Pic</label>
                            <input type="file" class="form-control" name="file" placeholder="add image" required>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
                    <button type="submit" class="btn btn-green">Create new user</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{--<form id="user_live_profile" method="post" action="{{ route('visitProfile') }}">--}}
{{--    @csrf--}}
{{--    <input type="hidden" id="user" name="id" value="">--}}
{{--</form>--}}
<div class="modal fade" id="changePassword" tabindex="-1">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                    class="fal ico-cross-circle"></i></button>
            <div class="modal-header">
                Change User Password
            </div>
            <div class="modal-body">
                <p><span class="text-yellow">Warning!: </span> If you change the password, this user will not be
                    able to login with old password</p>
                <form>
                    <div class="form-group">
                        <label>Enter Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Enter Password">
                    </div>
                    <form>
                        <div class="form-group">
                            <label>Re-enter Password</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                   placeholder="Enter Password Again">
                        </div>
                    </form>
            </div>
            <div class="modal-footer justify-content-between">
                <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
                <a href="#" class="btn btn-green" data-user="" id="passwordChangeBtn">Chnage</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteAccount" tabindex="-1">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                    class="fal ico-cross-circle"></i></button>
            <div class="modal-header">
                Are you sure you want to delete this user?
            </div>
            <div class="modal-body">
                <p><span class="text-yellow">Warning!: </span> If you delete this account, user will not be able to
                    access this account but it will still be exist in 2Aagain database</p>
            </div>
            <div class="modal-footer justify-content-between">
                <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
                <a href="#" class="btn btn-green" data-user="" id="deleteUserAccountBtn">Delete</a>
            </div>
        </div>
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
<div class="modal fade" id="bannUser" tabindex="-1">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                    class="fal ico-cross-circle"></i></button>
            <div class="modal-header">
                Select Banned Time
            </div>
            <div class="modal-body">
                <p><span class="text-yellow">Warning!: </span> User will be automatically unbanned after the time
                    selected</p>
                <div class="form-group">
                    <label>Ban Till</label>
                    <input class="form-control" id="ban_for_time" type="datetime-local" name="time" required
                           value="">
                </div>
                <div class="form-group p-1 m-1">
                    <div class="form-check checkbox">
                        <input class="form-check-input banned_forever" value="1" name="banned_forever"  type="checkbox"
                               id="banned_forever">
                        <label class="form-check-label" for="banned_forever">
                            Ban Forever
                        </label>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
                    <a href="#" class="btn btn-green" data-user="" id="banUserBtn">Ban</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="UnbannUser" tabindex="-1">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                    class="fal ico-cross-circle"></i></button>
            <div class="modal-header">
                Are you sure you want to UnBan this user?
            </div>
            <div class="modal-body">
                <p><span class="text-yellow">Warning!: </span> If you UnBan, user will be able to access this account
                </p>
            </div>
            <div class="modal-footer justify-content-between">
                <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
                <a href="#" class="btn btn-green" data-user="" id="unBanUserBtn">UnBan</a>
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
                url: "{{ route('admin.system.users.list') }}",
                type: 'GET',
                data: function (d) {
                    d.gender = $('#search_gender').val(),
                        d.date1 = $('#date1').val(),
                        d.date2 = $('#date2').val(),
                        d.country = $('#search_country').val(),
                        d.age1 = $('#age1').val(),
                        d.age2 = $('#age2').val()
                    d.deletedUsers = $('#deletedUsers').val()
                    d.bannedUsers = $('#bannedUsers').val()
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
                {data: 'email', name: 'email'},
                {data: 'roles', name: 'roles'},
                // {data: 'country.name', name: 'country'},
                {data: 'status', name: 'status'},
                    @if(request()->user()->can('system-user-change-password') || request()->user()->can('system-user-ban') || request()->user()->can('system-user-unban') || request()->user()->can('system-user-delete') || request()->user()->can('system-user-recover'))

                {
                    data: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: true
                },
                @endif
            ]
        });

        $('#search_gender').on('change', function () {
            table.draw();
        });

        $('#date1').on('change', function () {
            table.draw();
        });
        $('#date2').on('change', function () {
            table.draw();
        });

        $('#search_country').on('change', function () {
            table.draw();
        });

        $('#age1').on('keyup', function () {
            table.draw();
        });

        $('#age2').on('keyup', function () {
            table.draw();
        });
        $('#deletedUsers').on('click', function () {
            var val = $(this).val();
            if (val == 1) {
                $(this).val(0);
            } else {
                $(this).val(1);
            }
            table.draw();
        });
        $('#bannedUsers').on('click', function () {
            var val = $(this).val();
            if (val == 1) {
                $(this).val(0);
            } else {
                $(this).val(1);
            }
            table.draw();
        });
    });
    $(window).bind("pageshow", function () {
        $("#newForm").trigger('reset');
        $('select').prop('selectedIndex', 0);
    });

    $('.banned_forever').on('click', function () {

        var val = $(this).val();
        if (val == 1) {
            document.getElementById('ban_for_time').value='';
            $(this).val(0);
            $("#ban_for_time").prop('disabled', true); //disable
        } else {
            $(this).val(1);
            document.getElementById('ban_for_time').value='';
            $("#ban_for_time").prop('disabled', false); //disable
        }
    });
</script>
@endsection
