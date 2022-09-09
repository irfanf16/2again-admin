@extends('admin.layouts.app')

@section('content')
@section('page_title','Add Role')

<div id="content">
    <div class="container-fluid">
        <section class="section">
            <form action="{{ route('admin.roles.add') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="content-box p-3">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Role Name</label>
                            <input type="text" name="name" value="" class="form-control"
                                   placeholder="Enter Name"
                                   required>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="content-box p-3">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <div class="form-check checkbox">
                                <input class="form-check-input" type="checkbox" id="all-permissions">
                                <label class="form-check-label" for="all-permissions">
                                    All Permissions
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="content-box p-3">
                    <div class="row">
                        <div class="form-check checkbox p-3">
                            <input class="form-check-input" type="checkbox" id="dashboard">
                            <label class="form-check-label" for="dashboard">
                                <b>Dashboard</b>
                            </label>
                        </div>
                        @foreach ($permissions as $permission)
                            @if($permission->name=='Dashboard')
                                <div class="col-md-4 form-group">
                                    <div class="form-check checkbox">

                                        <input class="form-check-input dashboard" name="permissions[]"
                                                  value="{{$permission->id}}" type="checkbox"
                                               id="{{$permission->id}}">
                                        <label class="form-check-label" for="{{$permission->id}}">
                                            {{$permission->display_name}}
                                        </label>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <hr>
                <div class="content-box p-3">
                    <div class="row">
                        <div class="form-check checkbox p-3">
                            <input class="form-check-input" type="checkbox" id="App-Users">
                            <label class="form-check-label" for="App-Users">
                                <b>App Users</b> <small class="text-yellow">(Note: To add any permission you must
                                    anable
                                    user read permission first)</small>
                            </label>
                        </div>
                        @foreach ($permissions as $permission)
                            @if($permission->name=='App Users')
                                <div class="col-md-4 form-group">
                                    <div class="form-check checkbox">
                                        <input class="form-check-input app-users" name="permissions[]"
                                                 value="{{$permission->id}}"
                                               type="checkbox"
                                               id="{{$permission->id}}">
                                        <label class="form-check-label" for="{{$permission->id}}">
                                            {{$permission->display_name}}
                                        </label>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <hr>
                <div class="content-box p-3">
                    <div class="row">
                        <div class="form-check checkbox p-3">
                            <input class="form-check-input" type="checkbox" id="Shops">
                            <label class="form-check-label" for="Shops">
                                <b>Shop</b> <small class="text-yellow">(Note: To add any permission you must anable
                                    read
                                    permission first)</small>
                            </label>
                        </div>
                        @foreach ($permissions as $permission)
                            @if($permission->name=='Shop')
                                <div class="col-md-4 form-group">
                                    <div class="form-check checkbox">
                                        <input class="form-check-input shops" name="permissions[]"
                                                 value="{{$permission->id}}"
                                               type="checkbox"
                                               id="{{$permission->id}}">
                                        <label class="form-check-label" for="{{$permission->id}}">
                                            {{$permission->display_name}}
                                        </label>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <hr>
                <div class="content-box p-3">
                    <div class="row">
                        <div class="form-check checkbox p-3">
                            <input class="form-check-input" type="checkbox" id="setting">
                            <label class="form-check-label" for="setting">
                                <b>Setting</b> <small class="text-yellow">(Note: To add any permission you must
                                    anable
                                    read permission first)</small>
                            </label>
                        </div>
                        <hr>
                        <div class="form-check checkbox p-3">
                            <input class="form-check-input setting" type="checkbox" id="Subscriptions">
                            <label class="form-check-label" for="Subscriptions">
                                <b>Subscriptions</b> <small class="text-yellow">(Note: To add any permission you
                                    must
                                    anable read permission first)</small>
                            </label>
                        </div>
                        @foreach ($permissions as $permission)
                            @if($permission->name=='Subscription')
                                <div class="col-md-4 form-group">
                                    <div class="form-check checkbox">
                                        <input class="form-check-input setting Subscriptions" name="permissions[]"
                                                 value="{{$permission->id}}"
                                               type="checkbox"
                                               id="{{$permission->id}}">
                                        <label class="form-check-label" for="{{$permission->id}}">
                                            {{$permission->display_name}}
                                        </label>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <hr>

                        <div class="form-check checkbox p-3">
                            <input class="form-check-input setting" type="checkbox" id="Badges">
                            <label class="form-check-label" for="Badges">
                                <b>Badges</b> <small class="text-yellow">(Note: To add any permission you must
                                    anable
                                    read permission first)</small>
                            </label>
                        </div>
                        @foreach ($permissions as $permission)
                            @if($permission->name=='Badge')
                                <div class="col-md-4 form-group">
                                    <div class="form-check checkbox">
                                        <input class="form-check-input setting badges" name="permissions[]"
                                                 value="{{$permission->id}}"
                                               type="checkbox"
                                               id="{{$permission->id}}">
                                        <label class="form-check-label" for="{{$permission->id}}">
                                            {{$permission->display_name}}
                                        </label>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                        <hr>
                        <div class="form-check checkbox p-3">
                            <input class="form-check-input setting" type="checkbox" id="AppSetting">
                            <label class="form-check-label" for="AppSetting">
                                <b>App Setting</b> <small class="text-yellow">(Note: To add any permission you must
                                    anable read permission first)</small>
                            </label>
                        </div>
                        @foreach ($permissions as $permission)
                            @if($permission->name=='App Setting')
                                <div class="col-md-4 form-group">
                                    <div class="form-check checkbox">
                                        <input class="form-check-input setting AppSetting" name="permissions[]"
                                                 value="{{$permission->id}}"
                                               type="checkbox"
                                               id="{{$permission->id}}">
                                        <label class="form-check-label" for="{{$permission->id}}">
                                            {{$permission->display_name}}
                                        </label>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        {{--                        <hr>--}}
                        {{--                        <div class="form-check checkbox p-3">--}}
                        {{--                            <input class="form-check-input setting" type="checkbox" id="CoinsSetting">--}}
                        {{--                            <label class="form-check-label" for="CoinsSetting">--}}
                        {{--                                <b>Coins Setting</b>  <small class="text-yellow">(Note: To add any permission you must anable read permission first)</small>--}}
                        {{--                            </label>--}}
                        {{--                        </div>--}}
                        {{--                        @foreach ($permissions as $permission)--}}
                        {{--                            @if($permission->name=='Coins Setting')--}}
                        {{--                                <div class="col-md-4 form-group">--}}
                        {{--                                    <div class="form-check checkbox">--}}
                        {{--                                        <input class="form-check-input setting CoinsSetting" name="permissions[]"  @if(in_array($permission->id, $rolePermissions)) checked @endif value="{{$permission->id}}"--}}
                        {{--                                               type="checkbox"--}}
                        {{--                                               id="{{$permission->id}}">--}}
                        {{--                                        <label class="form-check-label" for="{{$permission->id}}">--}}
                        {{--                                           {{$permission->display_name}}--}}
                        {{--                                        </label>--}}
                        {{--                                    </div>--}}
                        {{--                                </div>--}}
                        {{--                            @endif--}}
                        {{--                        @endforeach--}}
                        <hr>
                        <div class="form-check checkbox p-3">
                            <input class="form-check-input setting" type="checkbox" id="giftInvitations">
                            <label class="form-check-label" for="giftInvitations">
                                <b>Gift Invitations</b> <small class="text-yellow">(Note: To add any permission you
                                    must
                                    anable read permission first)</small>
                            </label>
                        </div>
                        @foreach ($permissions as $permission)
                            @if($permission->name=='Gift Invitation')
                                <div class="col-md-4 form-group">
                                    <div class="form-check checkbox">
                                        <input class="form-check-input setting giftInvitations" name="permissions[]"
                                                 value="{{$permission->id}}"
                                               type="checkbox"
                                               id="{{$permission->id}}">
                                        <label class="form-check-label" for="{{$permission->id}}">
                                            {{$permission->display_name}}
                                        </label>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <hr>
                        <div class="form-check checkbox p-3">
                            <input class="form-check-input setting" type="checkbox" id="User-status">
                            <label class="form-check-label" for="User-status">
                                <b>User Status</b> <small class="text-yellow">(Note: To add any permission you must
                                    anable read permission first)</small>
                            </label>
                        </div>
                        @foreach ($permissions as $permission)
                            @if($permission->name=='Status')
                                <div class="col-md-4 form-group">
                                    <div class="form-check checkbox">
                                        <input class="form-check-input setting User-status" name="permissions[]"
                                                 value="{{$permission->id}}"
                                               type="checkbox"
                                               id="{{$permission->id}}">
                                        <label class="form-check-label" for="{{$permission->id}}">
                                            {{$permission->display_name}}
                                        </label>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <hr>
                        <div class="form-check checkbox p-3">
                            <input class="form-check-input setting" type="checkbox" id="Lookingfor">
                            <label class="form-check-label" for="Lookingfor">
                                <b>Looking For</b> <small class="text-yellow">(Note: To add any permission you must
                                    anable read permission first)</small>
                            </label>
                        </div>
                        @foreach ($permissions as $permission)
                            @if($permission->name=='Looking For')
                                <div class="col-md-4 form-group">
                                    <div class="form-check checkbox">
                                        <input class="form-check-input setting Lookingfor" name="permissions[]"
                                                 value="{{$permission->id}}"
                                               type="checkbox"
                                               id="{{$permission->id}}">
                                        <label class="form-check-label" for="{{$permission->id}}">
                                            {{$permission->display_name}}
                                        </label>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <hr>
                        <div class="form-check checkbox p-3">
                            <input class="form-check-input setting" type="checkbox" id="Emoji">
                            <label class="form-check-label" for="Emoji">
                                <b>Daily Mood</b> <small class="text-yellow">(Note: To add any permission you must
                                    anable read permission first)</small>
                            </label>
                        </div>
                        @foreach ($permissions as $permission)
                            @if($permission->name=='Emoji')
                                <div class="col-md-4 form-group">
                                    <div class="form-check checkbox">
                                        <input class="form-check-input setting Emoji" name="permissions[]"
                                                 value="{{$permission->id}}"
                                               type="checkbox"
                                               id="{{$permission->id}}">
                                        <label class="form-check-label" for="{{$permission->id}}">
                                            {{$permission->display_name}}
                                        </label>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <hr>
                        <div class="form-check checkbox p-3">
                            <input class="form-check-input setting" type="checkbox" id="Countries">
                            <label class="form-check-label" for="Countries">
                                <b>Countries</b> <small class="text-yellow">(Note: To add any permission you must
                                    anable
                                    read permission first)</small>
                            </label>
                        </div>
                        @foreach ($permissions as $permission)
                            @if($permission->name=='Country')
                                <div class="col-md-4 form-group">
                                    <div class="form-check checkbox">
                                        <input class="form-check-input setting countries" name="permissions[]"
                                                 value="{{$permission->id}}"
                                               type="checkbox"
                                               id="{{$permission->id}}">
                                        <label class="form-check-label" for="{{$permission->id}}">
                                            {{$permission->display_name}}
                                        </label>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <hr>
                        <div class="form-check checkbox p-3">
                            <input class="form-check-input setting" type="checkbox" id="Religion">
                            <label class="form-check-label" for="Religion">
                                <b>Religion</b> <small class="text-yellow">(Note: To add any permission you must
                                    anable
                                    read permission first)</small>
                            </label>
                        </div>
                        @foreach ($permissions as $permission)
                            @if($permission->name=='Religion')
                                <div class="col-md-4 form-group">
                                    <div class="form-check checkbox">
                                        <input class="form-check-input setting religion" name="permissions[]"
                                                 value="{{$permission->id}}"
                                               type="checkbox"
                                               id="{{$permission->id}}">
                                        <label class="form-check-label" for="{{$permission->id}}">
                                            {{$permission->display_name}}
                                        </label>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <hr>
                        <div class="form-check checkbox p-3">
                            <input class="form-check-input setting" type="checkbox" id="AppVersion">
                            <label class="form-check-label" for="AppVersion">
                                <b>App Version</b> <small class="text-yellow"></small>
                            </label>
                        </div>
                        @foreach ($permissions as $permission)
                            @if($permission->name=='App Version Control')
                                <div class="col-md-6 form-group">
                                    <div class="form-check checkbox">
                                        <input class="form-check-input setting AppVersion" name="permissions[]"
                                                   value="{{$permission->id}}"
                                               type="checkbox"
                                               id="{{$permission->id}}">
                                        <label class="form-check-label" for="{{$permission->id}}">
                                            {{$permission->display_name}}
                                        </label>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                    </div>
                </div>
                <hr>
                <div class="content-box p-3">
                    <div class="row">
                        <div class="form-check checkbox p-3">
                            <input class="form-check-input" type="checkbox" id="OtherApp">
                            <label class="form-check-label" for="OtherApp">
                                <b>Other App</b> <small class="text-yellow">(Note: To add any permission you must
                                    anable
                                    read permission first)</small>
                            </label>
                        </div>
                        @foreach ($permissions as $permission)
                            @if($permission->name=='Other App')
                                <div class="col-md-4 form-group">
                                    <div class="form-check checkbox">
                                        <input class="form-check-input OtherApp" name="permissions[]"
                                                 value="{{$permission->id}}"
                                               type="checkbox"
                                               id="{{$permission->id}}">
                                        <label class="form-check-label" for="{{$permission->id}}">
                                            {{$permission->display_name}}
                                        </label>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <hr>
                <div class="content-box p-3">
                    <div class="row">
                        <div class="form-check checkbox p-3">
                            <input class="form-check-input" type="checkbox" id="Offers">
                            <label class="form-check-label" for="Offers">
                                <b>Offers</b> <small class="text-yellow">(Note: To add any permission you must
                                    anable
                                    read permission first)</small>
                            </label>
                        </div>
                        @foreach ($permissions as $permission)
                            @if($permission->name=='Offers')
                                <div class="col-md-4 form-group">
                                    <div class="form-check checkbox">
                                        <input class="form-check-input offers" name="permissions[]"
                                                 value="{{$permission->id}}"
                                               type="checkbox"
                                               id="{{$permission->id}}">
                                        <label class="form-check-label" for="{{$permission->id}}">
                                            {{$permission->display_name}}
                                        </label>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <hr>
                <div class="content-box p-3">
                    <div class="row">
                        <div class="form-check checkbox p-3">
                            <input class="form-check-input" type="checkbox" id="withdrawal">
                            <label class="form-check-label" for="withdrawal">
                                <b>Withdrawal Requests</b> <small class="text-yellow">(Note: To add any permission
                                    you
                                    must anable read permission first)</small>
                            </label>
                        </div>
                        @foreach ($permissions as $permission)
                            @if($permission->name=='Withdrawal Request')
                                <div class="col-md-4 form-group">
                                    <div class="form-check checkbox">
                                        <input class="form-check-input withdrawal" name="permissions[]"
                                                 value="{{$permission->id}}"
                                               type="checkbox"
                                               id="{{$permission->id}}">
                                        <label class="form-check-label" for="{{$permission->id}}">
                                            {{$permission->display_name}}
                                        </label>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <hr>
                <div class="content-box p-3">
                    <div class="row">
                        <div class="form-check checkbox p-3">
                            <input class="form-check-input" type="checkbox" id="supportRequest">
                            <label class="form-check-label" for="supportRequest">
                                <b>Support Request</b>
                            </label>
                        </div>
                        <hr>

                        <div class="form-check checkbox p-3">
                            <input class="form-check-input supportRequest " type="checkbox" id="SupportEmail">
                            <label class="form-check-label" for="SupportEmail">
                                <b>App User</b>
                            </label>
                        </div>
                        @foreach ($permissions as $permission)
                            @if($permission->name=='Support Email')
                                <div class="col-md-4 form-group">
                                    <div class="form-check checkbox">
                                        <input class="form-check-input supportRequest SupportEmail" name="permissions[]"
                                                 value="{{$permission->id}}"
                                               type="checkbox"
                                               id="{{$permission->id}}">
                                        <label class="form-check-label" for="{{$permission->id}}">
                                            {{$permission->display_name}}
                                        </label>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <hr>
                        <div class="form-check checkbox p-3">
                            <input class="form-check-input supportRequest" type="checkbox" id="ContactUs">
                            <label class="form-check-label" for="ContactUs">
                                <b>Contact Us</b>
                            </label>
                        </div>
                        @foreach ($permissions as $permission)
                            @if($permission->name=='Contact Us')
                                <div class="col-md-4 form-group">
                                    <div class="form-check checkbox">
                                        <input class="form-check-input supportRequest ContactUs" name="permissions[]"
                                                 value="{{$permission->id}}"
                                               type="checkbox"
                                               id="{{$permission->id}}">
                                        <label class="form-check-label" for="{{$permission->id}}">
                                            {{$permission->display_name}}
                                        </label>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <hr>
                        <div class="form-check checkbox p-3">
                            <input class="form-check-input supportRequest" type="checkbox" id="PreRegistration">
                            <label class="form-check-label" for="PreRegistration">
                                <b>Pre Registration</b>
                            </label>
                        </div>
                        @foreach ($permissions as $permission)
                            @if($permission->name=='Pre Registration')
                                <div class="col-md-4 form-group">
                                    <div class="form-check checkbox">
                                        <input class="form-check-input supportRequest PreRegistration" name="permissions[]"
                                                 value="{{$permission->id}}"
                                               type="checkbox"
                                               id="{{$permission->id}}">
                                        <label class="form-check-label" for="{{$permission->id}}">
                                            {{$permission->display_name}}
                                        </label>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <hr>
                <div class="content-box p-3">
                    <div class="row">
                        <div class="form-check checkbox p-3">
                            <input class="form-check-input" type="checkbox" id="CustomNotifications">
                            <label class="form-check-label" for="CustomNotifications">
                                <b>Notifications Center</b> <small class="text-yellow">(Note: To add any permission
                                    you
                                    must anable read permission first)</small>
                            </label>
                        </div>
                        @foreach ($permissions as $permission)
                            @if($permission->name=='Custom Notification')
                                <div class="col-md-4 form-group">
                                    <div class="form-check checkbox">
                                        <input class="form-check-input CustomNotifications" name="permissions[]"
                                                 value="{{$permission->id}}"
                                               type="checkbox"
                                               id="{{$permission->id}}">
                                        <label class="form-check-label" for="{{$permission->id}}">
                                            {{$permission->display_name}}
                                        </label>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <hr>
                <div class="content-box p-3">
                    <div class="row">
                        <div class="form-check checkbox p-3">
                            <input class="form-check-input " type="checkbox" id="Dictionary">
                            <label class="form-check-label" for="Dictionary">
                                <b>Dictionary</b> <small class="text-yellow">(Note: To add any permission you must
                                    anable read permission first)</small>
                            </label>
                        </div>
                        @foreach ($permissions as $permission)
                            @if($permission->name=='Dictionary')
                                <div class="col-md-4 form-group">
                                    <div class="form-check checkbox">
                                        <input class="form-check-input  Dictionary" name="permissions[]"
                                                 value="{{$permission->id}}"
                                               type="checkbox"
                                               id="{{$permission->id}}">
                                        <label class="form-check-label" for="{{$permission->id}}">
                                            {{$permission->display_name}}
                                        </label>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <hr>
                <div class="content-box p-3">
                    <div class="row">

                        <div class="form-check checkbox p-3">
                            <input class="form-check-input " type="checkbox" id="SafetyTips">
                            <label class="form-check-label" for="SafetyTips">
                                <b>Safety Tips</b> <small class="text-yellow">(Note: To add any permission you must
                                    anable read permission first)</small>
                            </label>
                        </div>
                        @foreach ($permissions as $permission)
                            @if($permission->name=='Safety Tips')
                                <div class="col-md-4 form-group">
                                    <div class="form-check checkbox">
                                        <input class="form-check-input setting SafetyTips" name="permissions[]"
                                                 value="{{$permission->id}}"
                                               type="checkbox"
                                               id="{{$permission->id}}">
                                        <label class="form-check-label" for="{{$permission->id}}">
                                            {{$permission->display_name}}
                                        </label>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <hr>
                <div class="content-box p-3">
                    <div class="row">
                        <div class="form-check checkbox p-3">
                            <input class="form-check-input" type="checkbox" id="Faqs">
                            <label class="form-check-label" for="Faqs">
                                <b>Faqs</b> <small class="text-yellow">(Note: To add any permission you must anable
                                    read
                                    permission first)</small>
                            </label>
                        </div>
                        @foreach ($permissions as $permission)
                            @if($permission->name=='Faqs')
                                <div class="col-md-4 form-group">
                                    <div class="form-check checkbox">
                                        <input class="form-check-input Faqs" name="permissions[]"
                                                 value="{{$permission->id}}"
                                               type="checkbox"
                                               id="{{$permission->id}}">
                                        <label class="form-check-label" for="{{$permission->id}}">
                                            {{$permission->display_name}}
                                        </label>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <hr>
                <div class="content-box p-3">
                    <div class="row">
                        <div class="form-check checkbox p-3">
                            <input class="form-check-input" type="checkbox" id="Legal">
                            <label class="form-check-label" for="Legal">
                                <b>Legal</b> <small class="text-yellow">(Note: To add any permission you must anable
                                    read permission first)</small>
                            </label>
                        </div>
                        @foreach ($permissions as $permission)
                            @if($permission->name=='Legal')
                                <div class="col-md-4 form-group">
                                    <div class="form-check checkbox">
                                        <input class="form-check-input Legal" name="permissions[]"
                                                 value="{{$permission->id}}"
                                               type="checkbox"
                                               id="{{$permission->id}}">
                                        <label class="form-check-label" for="{{$permission->id}}">
                                            {{$permission->display_name}}
                                        </label>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <hr>
                <div class="content-box p-3">
                    <div class="row">
                        <div class="form-check checkbox p-3">
                            <input class="form-check-input setting" type="checkbox" id="Language">
                            <label class="form-check-label" for="Language">
                                <b>language</b> <small class="text-yellow">(Note: To add any permission you must
                                    anable
                                    read permission first)</small>
                            </label>
                        </div>
                        @foreach ($permissions as $permission)
                            @if($permission->name=='Language')
                                <div class="col-md-4 form-group">
                                    <div class="form-check checkbox">
                                        <input class="form-check-input setting language" name="permissions[]"
                                                 value="{{$permission->id}}"
                                               type="checkbox"
                                               id="{{$permission->id}}">
                                        <label class="form-check-label" for="{{$permission->id}}">
                                            {{$permission->display_name}}
                                        </label>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <hr>
                <div class="content-box p-3">
                    <div class="row">
                        <div class="form-check checkbox p-3">
                            <input class="form-check-input" type="checkbox" id="Crowdfunding">
                            <label class="form-check-label" for="Crowdfunding">
                                <b>Crowdfunding</b> <small class="text-yellow">(Note: To add any permission you must
                                    anable read permission first)</small>
                            </label>
                        </div>
                        @foreach ($permissions as $permission)
                            @if($permission->name=='Crowdfunding')
                                <div class="col-md-4 form-group">
                                    <div class="form-check checkbox">
                                        <input class="form-check-input Crowdfunding" name="permissions[]"
                                                 value="{{$permission->id}}"
                                               type="checkbox"
                                               id="{{$permission->id}}">
                                        <label class="form-check-label" for="{{$permission->id}}">
                                            {{$permission->display_name}}
                                        </label>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <hr>
                <div class="content-box p-3">
                    <div class="row">
                        <div class="form-check checkbox p-3">
                            <input class="form-check-input" type="checkbox" id="Reporting">
                            <label class="form-check-label" for="Reporting">
                                <b>Reporting</b> <small class="text-yellow">(Note: To add any permission you must
                                    anable
                                    read permission first)</small>
                            </label>
                        </div>
                        @foreach ($permissions as $permission)
                            @if($permission->name=='Reporting')
                                <div class="col-md-4 form-group">
                                    <div class="form-check checkbox">
                                        <input class="form-check-input Reporting" name="permissions[]"
                                                 value="{{$permission->id}}"
                                               type="checkbox"
                                               id="{{$permission->id}}">
                                        <label class="form-check-label" for="{{$permission->id}}">
                                            {{$permission->display_name}}
                                        </label>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <hr>
                <div class="content-box p-3">
                    <div class="row">
                        <div class="form-check checkbox p-3">
                            <input class="form-check-input" type="checkbox" id="purchases">
                            <label class="form-check-label" for="purchases">
                                <b>User Purchase</b> <small class="text-yellow">(Note: To add any permission you must
                                    anable
                                    read permission first)</small>
                            </label>
                        </div>
                        @foreach ($permissions as $permission)
                            @if($permission->name=='Purchase')
                                <div class="col-md-4 form-group">
                                    <div class="form-check checkbox">
                                        <input class="form-check-input purchases" name="permissions[]"
                                                 value="{{$permission->id}}"
                                               type="checkbox"
                                               id="{{$permission->id}}">
                                        <label class="form-check-label" for="{{$permission->id}}">
                                            {{$permission->display_name}}
                                        </label>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <hr>
                <div class="content-box p-3">
                    <div class="row">
                        <div class="form-check checkbox p-3">
                            <input class="form-check-input" type="checkbox" id="SystemUsers">
                            <label class="form-check-label" for="SystemUsers">
                                <b>System Users</b> <small class="text-yellow">(Note: To add any permission you must
                                    anable read permission first)</small>
                            </label>
                        </div>
                        @foreach ($permissions as $permission)
                            @if($permission->name=='System Users')
                                <div class="col-md-4 form-group">
                                    <div class="form-check checkbox">
                                        <input class="form-check-input SystemUsers" name="permissions[]"
                                                 value="{{$permission->id}}"
                                               type="checkbox"
                                               id="{{$permission->id}}">
                                        <label class="form-check-label" for="{{$permission->id}}">
                                            {{$permission->display_name}}
                                        </label>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <hr>
                <div class="content-box p-3">
                    <div class="row">
                        <div class="form-check checkbox p-3">
                            <input class="form-check-input" type="checkbox" id="rolePermissions">
                            <label class="form-check-label" for="rolePermissions">
                                <b>Role Permissions</b> <small class="text-yellow">(Note: To add any permission you
                                    must
                                    anable read permission first)</small>
                            </label>
                        </div>
                        @foreach ($permissions as $permission)
                            @if($permission->name=='Role Permissions')
                                <div class="col-md-4 form-group">
                                    <div class="form-check checkbox">
                                        <input class="form-check-input rolePermissions" name="permissions[]"
                                                 value="{{$permission->id}}"
                                               type="checkbox"
                                               id="{{$permission->id}}">
                                        <label class="form-check-label" for="{{$permission->id}}">
                                            {{$permission->display_name}}
                                        </label>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <hr>

                <div class="text-right m-1 p-1">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>

            </form>
        </section>
    </div>
</div>

@endsection
