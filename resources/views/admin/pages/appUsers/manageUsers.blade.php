@extends('admin.layouts.app')
@section('content')
@section('page_title','App Users')
<div id="content">
    <div class="container-fluid">
        <section class="section">
            <div class="content-box p-3">
                <form id="newForm">
                    <div class="row">

                        <div class="col-md-6 form-group">
                            <label>Registration Date Range</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="date" id="date1" placeholder="From" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <input type="date" id="date2" placeholder="To" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Age Range (Years)</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="number" min="18" id="age1" placeholder="From" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <input type="number" min="18" id="age2" placeholder="To" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 form-group">
                            <label>Gender</label>
                            <select class="form-select" id="search_gender">
                                <option value="">All</option>
                                <option value="2">Male</option>
                                <option value="3">Female</option>
                                <option value="4">Other</option>
                            </select>
                        </div>

                        <div class="col-md-3 form-group">
                            <label>Country</label>
                            <select class="form-select" id="search_country">
                                <option value="">All</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 form-group">
                            <label>Account Status</label>
                            <select class="form-select" id="accountStatus">
                                <option value="">All</option>
                                <option value="active">Active</option>
                                <option value="banned">Banned</option>
                                <option value="deleted">Deleted</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2 form-group">
                            <label for="gam">Greet & Read </label>
                            <div class="form-check checkbox">
                                <input class="form-check-input" type="checkbox" id="gam">
                                <label class="form-check-label" for="gam">
                                    Yes
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="vip">VIP </label>
                            <div class="form-check checkbox">
                                <input class="form-check-input" type="checkbox" id="vip">
                                <label class="form-check-label" for="vip">
                                    Yes
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="bigSpender">Big Spender </label>
                            <div class="form-check checkbox">
                                <input class="form-check-input" type="checkbox" id="bigSpender">
                                <label class="form-check-label" for="bigSpender">
                                    Yes
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="gam">{{$subscription->name}} </label>
                            <div class="form-check checkbox">
                                <input class="form-check-input" type="checkbox" id="customBadge">
                                <label class="form-check-label" for="customBadge">
                                    Yes
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="Onlinenow">Online Now </label>
                            <div class="form-check checkbox">
                                <input class="form-check-input" type="checkbox" value="" id="Onlinenow">
                                <label class="form-check-label" for="Onlinenow">
                                    Yes
                                </label>
                            </div>
                        </div>
{{--                        <div class="col-md-2 form-group">--}}
{{--                            <label for="gam">Banned Users </label>--}}
{{--                            <div class="form-check checkbox">--}}
{{--                                <input class="form-check-input" type="checkbox" id="bannedUsers">--}}
{{--                                <label class="form-check-label" for="bannedUsers">--}}
{{--                                    Yes--}}
{{--                                </label>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-2 form-group">--}}
{{--                            <label for="gam">Deleted Users </label>--}}
{{--                            <div class="form-check checkbox">--}}
{{--                                <input class="form-check-input" type="checkbox" id="deletedUsers">--}}
{{--                                <label class="form-check-label" for="deletedUsers">--}}
{{--                                    Yes--}}
{{--                                </label>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                </form>
            </div>
        </section>
        <section class="section">
            {{--                    <div class="mb-3">--}}
            {{--                        <a href="#" class="btn btn-green" data-bs-toggle="modal" data-bs-target="#createnewuser"><i class="fas fa-user-plus"></i> Create new user</a>--}}
            {{--                    </div>--}}
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
                        <th class="user">User</th>
                        <th>Country</th>
                        <th>Last Active</th>
                        <th>Gold Coins</th>
                        <th>Silver Coins</th>
                        <th>IP</th>
                        <th>Device ID</th>
                        <th>Status</th>
                        @if(request()->user()->can('app-user-change-password') || request()->user()->can('app-user-ban') || request()->user()->can('app-user-unban') || request()->user()->can('app-user-delete') || request()->user()->can('app-user-recover'))
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
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" placeholder="Add Name">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" placeholder="Add Username">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Email</label>
                            <input type="Email" class="form-control" placeholder="Add Email">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" placeholder="Add Password">
                        </div>
                        <div class="col-md-12">
                            <label>Birthday</label>
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <select class="form-select">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                        <option value="19">19</option>
                                        <option value="20">20</option>
                                        <option value="21">21</option>
                                        <option value="22">22</option>
                                        <option value="23">23</option>
                                        <option value="24">24</option>
                                        <option value="25">25</option>
                                        <option value="26">26</option>
                                        <option value="27">27</option>
                                        <option value="28">28</option>
                                        <option value="29">29</option>
                                        <option value="30">30</option>
                                        <option value="31">31</option>
                                    </select>
                                </div>
                                <div class="col-md-4 form-group">
                                    <select class="form-select">
                                        <option value="1">January</option>
                                        <option value="2">February</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7">July</option>
                                        <option value="8">August</option>
                                        <option value="9">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </div>
                                <div class="col-md-4 form-group">
                                    <select class="form-select">
                                        <option value="2003">2003</option>
                                        <option value="2002">2002</option>
                                        <option value="2001">2001</option>
                                        <option value="2000">2000</option>
                                        <option value="1999">1999</option>
                                        <option value="1998">1998</option>
                                        <option value="1997">1997</option>
                                        <option value="1996">1996</option>
                                        <option value="1995">1995</option>
                                        <option value="1994">1994</option>
                                        <option value="1993">1993</option>
                                        <option value="1992">1992</option>
                                        <option value="1991">1991</option>
                                        <option value="1990">1990</option>
                                        <option value="1989">1989</option>
                                        <option value="1988">1988</option>
                                        <option value="1987">1987</option>
                                        <option value="1986">1986</option>
                                        <option value="1985">1985</option>
                                        <option value="1984">1984</option>
                                        <option value="1983">1983</option>
                                        <option value="1982">1982</option>
                                        <option value="1981">1981</option>
                                        <option value="1980">1980</option>
                                        <option value="1979">1979</option>
                                        <option value="1978">1978</option>
                                        <option value="1977">1977</option>
                                        <option value="1976">1976</option>
                                        <option value="1975">1975</option>
                                        <option value="1974">1974</option>
                                        <option value="1973">1973</option>
                                        <option value="1972">1972</option>
                                        <option value="1971">1971</option>
                                        <option value="1970">1970</option>
                                        <option value="1969">1969</option>
                                        <option value="1968">1968</option>
                                        <option value="1967">1967</option>
                                        <option value="1966">1966</option>
                                        <option value="1965">1965</option>
                                        <option value="1964">1964</option>
                                        <option value="1963">1963</option>
                                        <option value="1962">1962</option>
                                        <option value="1961">1961</option>
                                        <option value="1960">1960</option>
                                        <option value="1959">1959</option>
                                        <option value="1958">1958</option>
                                        <option value="1957">1957</option>
                                        <option value="1956">1956</option>
                                        <option value="1955">1955</option>
                                        <option value="1954">1954</option>
                                        <option value="1953">1953</option>
                                        <option value="1952">1952</option>
                                        <option value="1951">1951</option>
                                        <option value="1950">1950</option>
                                        <option value="1949">1949</option>
                                        <option value="1948">1948</option>
                                        <option value="1947">1947</option>
                                        <option value="1946">1946</option>
                                        <option value="1945">1945</option>
                                        <option value="1944">1944</option>
                                        <option value="1943">1943</option>
                                        <option value="1942">1942</option>
                                        <option value="1941">1941</option>
                                        <option value="1940">1940</option>
                                        <option value="1939">1939</option>
                                        <option value="1938">1938</option>
                                        <option value="1937">1937</option>
                                        <option value="1936">1936</option>
                                        <option value="1935">1935</option>
                                        <option value="1934">1934</option>
                                        <option value="1933">1933</option>
                                        <option value="1932">1932</option>
                                        <option value="1931">1931</option>
                                        <option value="1930">1930</option>
                                        <option value="1929">1929</option>
                                        <option value="1928">1928</option>
                                        <option value="1927">1927</option>
                                        <option value="1926">1926</option>
                                        <option value="1925">1925</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>City</label>
                            <input type="text" class="form-control" placeholder="Add Location">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Gender</label>
                            <select class="form-select">
                                <option value="1">Male</option>
                                <option value="2">Female</option>
                                <option value="3">Lesiban</option>
                                <option value="4">Gay</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Looking for</label>
                            <select class="form-select">
                                <option value="1">Male</option>
                                <option value="2">Female</option>
                                <option value="3">Lesiban</option>
                                <option value="4">Gay</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Looking age</label>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <input type="number" class="form-control" placeholder="18">
                                </div>
                                <div class="col-md-6 form-group">
                                    <input type="number" class="form-control" placeholder="30">
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6 form-group">
                            <label>Site language</label>
                            <select class="form-select">
                                <option>English</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
                <a href="#" class="btn btn-green" data-bs-dismiss="modal">Create new user</a>
            </div>
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
                Are you sure you want to Unban this user?
            </div>
            <div class="modal-body">
                <p><span class="text-yellow">Warning!: </span> If you Unban, user will be able to access this account
                </p>
            </div>
            <div class="modal-footer justify-content-between">
                <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
                <a href="#" class="btn btn-green" data-user="" id="unBanUserBtn">Unban</a>
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
                    // d.gender = $('#search_gender').val(),
                    d.gender = $('#search_gender :selected').val();
                    d.date1 = $('#date1').val(),
                        d.date2 = $('#date2').val(),
                        d.country = $('#search_country').val(),
                        d.age1 = $('#age1').val(),
                        d.age2 = $('#age2').val()
                    d.vip = $('#vip').val()
                    d.bigSpender = $('#bigSpender').val()
                    d.gam = $('#gam').val()
                    d.customBadge = $('#customBadge').val()
                    d.deletedUsers = $('#deletedUsers').val()
                    d.bannedUsers = $('#bannedUsers').val()
                    d.Onlinenow = $('#Onlinenow').val()
                    d.accountStatus = $('#accountStatus').val()

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
                {
                    data: 'country', name: 'country',
                    orderable: true,
                    searchable: true
                },
                {data: 'updated_at', name: 'last active'},
                {data: 'gold_coin', name: 'gold_coin'},
                {data: 'silver_coin', name: 'silver_coin'},
                {data: 'ip', name: 'ip'},
                {data: 'device_id', name: 'device_id'},
                {data: 'status', name: 'status'},

                    @if(request()->user()->can('app-user-change-password') || request()->user()->can('app-user-ban') || request()->user()->can('app-user-unban') || request()->user()->can('app-user-delete') || request()->user()->can('app-user-recover'))
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
        $('#accountStatus').on('change', function () {
            table.draw();
        });

        $('#age1').on('keyup', function () {
            table.draw();
        });

        $('#age2').on('keyup', function () {
            table.draw();
        });
        $('#vip').on('click', function () {
            var val = $(this).val();
            if (val == 1) {
                $(this).val(0);
            } else {
                $(this).val(1);
            }
            table.draw();
        });
        $('#Onlinenow').on('click', function () {
            var val = $(this).val();
            if (val == 1) {
                $(this).val(0);
            } else {
                $(this).val(1);
            }
            table.draw();
        });
        $('#bigSpender').on('click', function () {
            var val = $(this).val();
            if (val == 1) {
                $(this).val(0);
            } else {
                $(this).val(1);
            }
            table.draw();
        });
        $('#gam').on('click', function () {
            var val = $(this).val();
            if (val == 1) {
                $(this).val(0);
            } else {
                $(this).val(1);
            }
            table.draw();
        });
        $('#customBadge').on('click', function () {
            var val = $(this).val();
            if (val == 1) {
                $(this).val(0);
            } else {
                $(this).val(1);
            }
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
