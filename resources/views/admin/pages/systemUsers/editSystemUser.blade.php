@extends('admin.layouts.app')

@section('content')
@section('page_title','Edit System User ')

<div id="content">
    <div class="container-fluid">
        <section class="section">
            <form @can('system-user-edit') action="{{ route('admin.system.users.update',$user->id) }}" @endcan method="POST"
                  enctype="multipart/form-data">
                @csrf
                {{--                    @dd($user->can('dashboard'))--}}
                <div class="content-box p-3">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>First Name</label>
                            <input type="text" name="name" value="{{$user->name}}" class="form-control"
                                   placeholder="Add first name">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Last Name</label>
                            <input type="text" name="lastname" value="{{$user->lastname}}" class="form-control"
                                   placeholder="Add last name ">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Email</label>
                            <input type="Email" name="email" disabled value="{{$user->email}}" class="form-control"
                                   placeholder="Add Email">
                        </div>
{{--                        <div class="col-md-6">--}}
{{--                            <label>Birthday</label>--}}
{{--                            <div class="row">--}}
{{--                                <input type="date" name="dob" value="{{$user->dob}}" class="form-control"--}}
{{--                                       placeholder="Add Password">--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="col-md-6 form-group">
                            <label>Gender</label>
                            <select class="form-select" name="gender_id">

                                <option @if($user->gender_id==2) selected @endif value="2">Male</option>
                                <option @if($user->gender_id==3) selected @endif value="3">Female</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Assign Role</label>
                            <select class="form-select" id="role_id"  name="role_id">
                                @foreach($roles as $role)
                                    @if($user->roles[0]->name == $role->name)
                                        <option selected value="{{$role->id}}">{{$role->name}}</option>
                                    @else
                                        <option value="{{$role->id}}">{{$role->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Profile Pic</label>
                            <input type="file" class="form-control" name="file" placeholder="add image" >
                        </div>
                    </div>
                    @can('system-user-edit')
                    <div class="text-right m-1 p-1">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                    @endcan

                </div>

{{--                <hr>--}}
{{--                <div class="content-box p-3">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-md-4 form-group">--}}
{{--                            <div class="form-check checkbox">--}}
{{--                                <input class="form-check-input" type="checkbox" id="all-permissions">--}}
{{--                                <label class="form-check-label" for="all-permissions">--}}
{{--                                    All Permissions--}}
{{--                                </label>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <hr>--}}
{{--                <div class="content-box p-3">--}}
{{--                    <div class="row">--}}
{{--                        <div class="form-check checkbox p-3">--}}
{{--                            <input class="form-check-input" type="checkbox" id="dashboard">--}}
{{--                            <label class="form-check-label" for="dashboard">--}}
{{--                                <b>Dashboard</b>--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                        @foreach ($permissions as $permission)--}}
{{--                            @if($permission->name=='Dashboard')--}}
{{--                                <div class="col-md-4 form-group">--}}
{{--                                    <div class="form-check checkbox">--}}

{{--                                        <input class="form-check-input dashboard"--}}
{{--                                               @if($user->can($permission->slug)) checked @endif name="permissions[]"--}}
{{--                                               value="{{$permission->id}}" type="checkbox"--}}
{{--                                               id="{{$permission->id}}">--}}
{{--                                        <label class="form-check-label" for="{{$permission->id}}">--}}
{{--                                            {{preg_replace('/-/', ' ', $permission->slug )}}--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <hr>--}}
{{--                <div class="content-box p-3">--}}
{{--                    <div class="row">--}}
{{--                        <div class="form-check checkbox p-3">--}}
{{--                            <input class="form-check-input" type="checkbox" id="App-Users">--}}
{{--                            <label class="form-check-label" for="App-Users">--}}
{{--                                <b>App Users</b>--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                        @foreach ($permissions as $permission)--}}
{{--                            @if($permission->name=='App Users')--}}
{{--                                <div class="col-md-4 form-group">--}}
{{--                                    <div class="form-check checkbox">--}}
{{--                                        <input class="form-check-input app-users"--}}
{{--                                               @if($user->can($permission->slug)) checked @endif name="permissions[]"--}}
{{--                                               value="{{$permission->id}}"--}}
{{--                                               type="checkbox"--}}
{{--                                               id="{{$permission->id}}">--}}
{{--                                        <label class="form-check-label" for="{{$permission->id}}">--}}
{{--                                            {{preg_replace('/-/', ' ', $permission->slug )}}--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <hr>--}}
{{--                <div class="content-box p-3">--}}
{{--                    <div class="row">--}}
{{--                        <div class="form-check checkbox p-3">--}}
{{--                            <input class="form-check-input" type="checkbox" id="Shops">--}}
{{--                            <label class="form-check-label" for="Shops">--}}
{{--                                <b>Shop</b>--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                        @foreach ($permissions as $permission)--}}
{{--                            @if($permission->name=='Shop')--}}
{{--                                <div class="col-md-4 form-group">--}}
{{--                                    <div class="form-check checkbox">--}}
{{--                                        <input class="form-check-input shops" @if($user->can($permission->slug)) checked--}}
{{--                                               @endif name="permissions[]" value="{{$permission->id}}"--}}
{{--                                               type="checkbox"--}}
{{--                                               id="{{$permission->id}}">--}}
{{--                                        <label class="form-check-label" for="{{$permission->id}}">--}}
{{--                                            {{preg_replace('/-/', ' ', $permission->slug )}}--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <hr>--}}
{{--                <div class="content-box p-3">--}}
{{--                    <div class="row">--}}
{{--                        <div class="form-check checkbox p-3">--}}
{{--                            <input class="form-check-input" type="checkbox" id="Badges">--}}
{{--                            <label class="form-check-label" for="Badges">--}}
{{--                                <b>Badges</b>--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                        @foreach ($permissions as $permission)--}}
{{--                            @if($permission->name=='Badge')--}}
{{--                                <div class="col-md-4 form-group">--}}
{{--                                    <div class="form-check checkbox">--}}
{{--                                        <input class="form-check-input badges"--}}
{{--                                               @if($user->can($permission->slug)) checked @endif name="permissions[]"--}}
{{--                                               value="{{$permission->id}}"--}}
{{--                                               type="checkbox"--}}
{{--                                               id="{{$permission->id}}">--}}
{{--                                        <label class="form-check-label" for="{{$permission->id}}">--}}
{{--                                            {{preg_replace('/-/', ' ', $permission->slug )}}--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <hr>--}}
{{--                <div class="content-box p-3">--}}
{{--                    <div class="row">--}}
{{--                        <div class="form-check checkbox p-3">--}}
{{--                            <input class="form-check-input" type="checkbox" id="Offers">--}}
{{--                            <label class="form-check-label" for="Offers">--}}
{{--                                <b>Offers</b>--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                        @foreach ($permissions as $permission)--}}
{{--                            @if($permission->name=='Offers')--}}
{{--                                <div class="col-md-4 form-group">--}}
{{--                                    <div class="form-check checkbox">--}}
{{--                                        <input class="form-check-input offers"--}}
{{--                                               @if($user->can($permission->slug)) checked @endif name="permissions[]"--}}
{{--                                               value="{{$permission->id}}"--}}
{{--                                               type="checkbox"--}}
{{--                                               id="{{$permission->id}}">--}}
{{--                                        <label class="form-check-label" for="{{$permission->id}}">--}}
{{--                                            {{preg_replace('/-/', ' ', $permission->slug )}}--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <hr>--}}
{{--                <div class="content-box p-3">--}}
{{--                    <div class="row">--}}
{{--                        <div class="form-check checkbox p-3">--}}
{{--                            <input class="form-check-input" type="checkbox" id="purchases">--}}
{{--                            <label class="form-check-label" for="purchases">--}}
{{--                                <b>Purchase</b>--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                        @foreach ($permissions as $permission)--}}
{{--                            @if($permission->name=='Purchase')--}}
{{--                                <div class="col-md-4 form-group">--}}
{{--                                    <div class="form-check checkbox">--}}
{{--                                        <input class="form-check-input purchases"--}}
{{--                                               @if($user->can($permission->slug)) checked @endif name="permissions[]"--}}
{{--                                               value="{{$permission->id}}"--}}
{{--                                               type="checkbox"--}}
{{--                                               id="{{$permission->id}}">--}}
{{--                                        <label class="form-check-label" for="{{$permission->id}}">--}}
{{--                                            {{preg_replace('/-/', ' ', $permission->slug )}}--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <hr>--}}
{{--                <div class="content-box p-3">--}}
{{--                    <div class="row">--}}
{{--                        <div class="form-check checkbox p-3">--}}
{{--                            <input class="form-check-input" type="checkbox" id="setting">--}}
{{--                            <label class="form-check-label" for="setting">--}}
{{--                                <b>Setting</b>--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                        <hr>--}}
{{--                        <div class="form-check checkbox p-3">--}}
{{--                            <input class="form-check-input setting" type="checkbox" id="Subscriptions">--}}
{{--                            <label class="form-check-label" for="Subscriptions">--}}
{{--                                <b>Subscriptions</b>--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                        @foreach ($permissions as $permission)--}}
{{--                            @if($permission->name=='Subscription')--}}
{{--                                <div class="col-md-4 form-group">--}}
{{--                                    <div class="form-check checkbox">--}}
{{--                                        <input class="form-check-input setting Subscriptions"--}}
{{--                                               @if($user->can($permission->slug)) checked @endif name="permissions[]"--}}
{{--                                               value="{{$permission->id}}"--}}
{{--                                               type="checkbox"--}}
{{--                                               id="{{$permission->id}}">--}}
{{--                                        <label class="form-check-label" for="{{$permission->id}}">--}}
{{--                                            {{preg_replace('/-/', ' ', $permission->slug )}}--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                        <hr>--}}
{{--                        <div class="form-check checkbox p-3">--}}
{{--                            <input class="form-check-input setting" type="checkbox" id="AppSetting">--}}
{{--                            <label class="form-check-label" for="AppSetting">--}}
{{--                                <b>App Setting</b>--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                        @foreach ($permissions as $permission)--}}
{{--                            @if($permission->name=='App Setting')--}}
{{--                                <div class="col-md-4 form-group">--}}
{{--                                    <div class="form-check checkbox">--}}
{{--                                        <input class="form-check-input setting AppSetting"--}}
{{--                                               @if($user->can($permission->slug)) checked @endif name="permissions[]"--}}
{{--                                               value="{{$permission->id}}"--}}
{{--                                               type="checkbox"--}}
{{--                                               id="{{$permission->id}}">--}}
{{--                                        <label class="form-check-label" for="{{$permission->id}}">--}}
{{--                                            {{preg_replace('/-/', ' ', $permission->slug )}}--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                        <hr>--}}
{{--                        <div class="form-check checkbox p-3">--}}
{{--                            <input class="form-check-input setting" type="checkbox" id="CoinsSetting">--}}
{{--                            <label class="form-check-label" for="CoinsSetting">--}}
{{--                                <b>Coins Setting</b>--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                        @foreach ($permissions as $permission)--}}
{{--                            @if($permission->name=='Coins Setting')--}}
{{--                                <div class="col-md-4 form-group">--}}
{{--                                    <div class="form-check checkbox">--}}
{{--                                        <input class="form-check-input setting CoinsSetting"--}}
{{--                                               @if($user->can($permission->slug)) checked @endif name="permissions[]"--}}
{{--                                               value="{{$permission->id}}"--}}
{{--                                               type="checkbox"--}}
{{--                                               id="{{$permission->id}}">--}}
{{--                                        <label class="form-check-label" for="{{$permission->id}}">--}}
{{--                                            {{preg_replace('/-/', ' ', $permission->slug )}}--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                        <hr>--}}
{{--                        <div class="form-check checkbox p-3">--}}
{{--                            <input class="form-check-input setting" type="checkbox" id="Dictionary">--}}
{{--                            <label class="form-check-label" for="Dictionary">--}}
{{--                                <b>Dictionary</b>--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                        @foreach ($permissions as $permission)--}}
{{--                            @if($permission->name=='Dictionary')--}}
{{--                                <div class="col-md-4 form-group">--}}
{{--                                    <div class="form-check checkbox">--}}
{{--                                        <input class="form-check-input setting Dictionary"--}}
{{--                                               @if($user->can($permission->slug)) checked @endif name="permissions[]"--}}
{{--                                               value="{{$permission->id}}"--}}
{{--                                               type="checkbox"--}}
{{--                                               id="{{$permission->id}}">--}}
{{--                                        <label class="form-check-label" for="{{$permission->id}}">--}}
{{--                                            {{preg_replace('/-/', ' ', $permission->slug )}}--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                        <hr>--}}
{{--                        <div class="form-check checkbox p-3">--}}
{{--                            <input class="form-check-input setting" type="checkbox" id="Emoji">--}}
{{--                            <label class="form-check-label" for="Emoji">--}}
{{--                                <b>Emoji</b>--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                        @foreach ($permissions as $permission)--}}
{{--                            @if($permission->name=='Emoji')--}}
{{--                                <div class="col-md-4 form-group">--}}
{{--                                    <div class="form-check checkbox">--}}
{{--                                        <input class="form-check-input setting Emoji"--}}
{{--                                               @if($user->can($permission->slug)) checked @endif name="permissions[]"--}}
{{--                                               value="{{$permission->id}}"--}}
{{--                                               type="checkbox"--}}
{{--                                               id="{{$permission->id}}">--}}
{{--                                        <label class="form-check-label" for="{{$permission->id}}">--}}
{{--                                            {{preg_replace('/-/', ' ', $permission->slug )}}--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                        <hr>--}}
{{--                        <div class="form-check checkbox p-3">--}}
{{--                            <input class="form-check-input setting" type="checkbox" id="SafetyTips">--}}
{{--                            <label class="form-check-label" for="SafetyTips">--}}
{{--                                <b>Safety Tips</b>--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                        @foreach ($permissions as $permission)--}}
{{--                            @if($permission->name=='Safety Tips')--}}
{{--                                <div class="col-md-4 form-group">--}}
{{--                                    <div class="form-check checkbox">--}}
{{--                                        <input class="form-check-input setting SafetyTips"--}}
{{--                                               @if($user->can($permission->slug)) checked @endif name="permissions[]"--}}
{{--                                               value="{{$permission->id}}"--}}
{{--                                               type="checkbox"--}}
{{--                                               id="{{$permission->id}}">--}}
{{--                                        <label class="form-check-label" for="{{$permission->id}}">--}}
{{--                                            {{preg_replace('/-/', ' ', $permission->slug )}}--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                        <hr>--}}
{{--                        <div class="form-check checkbox p-3">--}}
{{--                            <input class="form-check-input setting" type="checkbox" id="Countries">--}}
{{--                            <label class="form-check-label" for="Countries">--}}
{{--                                <b>Countries</b>--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                        @foreach ($permissions as $permission)--}}
{{--                            @if($permission->name=='Country')--}}
{{--                                <div class="col-md-4 form-group">--}}
{{--                                    <div class="form-check checkbox">--}}
{{--                                        <input class="form-check-input setting countries" name="permissions[]"   @if($user->can($permission->slug)) checked @endif  value="{{$permission->id}}"--}}
{{--                                               type="checkbox"--}}
{{--                                               id="{{$permission->id}}">--}}
{{--                                        <label class="form-check-label" for="{{$permission->id}}">--}}
{{--                                            {{preg_replace('/-/', ' ', $permission->slug )}}--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                        <hr>--}}
{{--                        <div class="form-check checkbox p-3">--}}
{{--                            <input class="form-check-input setting" type="checkbox" id="Religion">--}}
{{--                            <label class="form-check-label" for="Religion">--}}
{{--                                <b>Religion</b>--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                        @foreach ($permissions as $permission)--}}
{{--                            @if($permission->name=='Religion')--}}
{{--                                <div class="col-md-4 form-group">--}}
{{--                                    <div class="form-check checkbox">--}}
{{--                                        <input class="form-check-input setting religion" @if($user->can($permission->slug)) checked @endif name="permissions[]" value="{{$permission->id}}"--}}
{{--                                               type="checkbox"--}}
{{--                                               id="{{$permission->id}}">--}}
{{--                                        <label class="form-check-label" for="{{$permission->id}}">--}}
{{--                                            {{preg_replace('/-/', ' ', $permission->slug )}}--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                        <hr>--}}
{{--                        <div class="form-check checkbox p-3">--}}
{{--                            <input class="form-check-input setting" type="checkbox" id="Language">--}}
{{--                            <label class="form-check-label" for="Language">--}}
{{--                                <b>language</b>--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                        @foreach ($permissions as $permission)--}}
{{--                            @if($permission->name=='Language')--}}
{{--                                <div class="col-md-4 form-group">--}}
{{--                                    <div class="form-check checkbox">--}}
{{--                                        <input class="form-check-input setting language" @if($user->can($permission->slug)) checked @endif name="permissions[]" value="{{$permission->id}}"--}}
{{--                                               type="checkbox"--}}
{{--                                               id="{{$permission->id}}">--}}
{{--                                        <label class="form-check-label" for="{{$permission->id}}">--}}
{{--                                            {{preg_replace('/-/', ' ', $permission->slug )}}--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                        <hr>--}}
{{--                        <div class="form-check checkbox p-3">--}}
{{--                            <input class="form-check-input setting" type="checkbox" id="User-status">--}}
{{--                            <label class="form-check-label" for="User-status">--}}
{{--                                <b>User Status</b>--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                        @foreach ($permissions as $permission)--}}
{{--                            @if($permission->name=='Status')--}}
{{--                                <div class="col-md-4 form-group">--}}
{{--                                    <div class="form-check checkbox">--}}
{{--                                        <input class="form-check-input setting User-status"  @if($user->can($permission->slug)) checked @endif name="permissions[]" value="{{$permission->id}}"--}}
{{--                                               type="checkbox"--}}
{{--                                               id="{{$permission->id}}">--}}
{{--                                        <label class="form-check-label" for="{{$permission->id}}">--}}
{{--                                            {{preg_replace('/-/', ' ', $permission->slug )}}--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <hr>--}}
{{--                <div class="content-box p-3">--}}
{{--                    <div class="row">--}}
{{--                        <div class="form-check checkbox p-3">--}}
{{--                            <input class="form-check-input" type="checkbox" id="giftInvitations">--}}
{{--                            <label class="form-check-label" for="giftInvitations">--}}
{{--                                <b>Gift Invitations</b>--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                        @foreach ($permissions as $permission)--}}
{{--                            @if($permission->name=='Gift Invitation')--}}
{{--                                <div class="col-md-4 form-group">--}}
{{--                                    <div class="form-check checkbox">--}}
{{--                                        <input class="form-check-input giftInvitations"--}}
{{--                                               @if($user->can($permission->slug)) checked @endif name="permissions[]"--}}
{{--                                               value="{{$permission->id}}"--}}
{{--                                               type="checkbox"--}}
{{--                                               id="{{$permission->id}}">--}}
{{--                                        <label class="form-check-label" for="{{$permission->id}}">--}}
{{--                                            {{preg_replace('/-/', ' ', $permission->slug )}}--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <hr>--}}
{{--                <div class="content-box p-3">--}}
{{--                    <div class="row">--}}
{{--                        <div class="form-check checkbox p-3">--}}
{{--                            <input class="form-check-input" type="checkbox" id="Faqs">--}}
{{--                            <label class="form-check-label" for="Faqs">--}}
{{--                                <b>Faqs</b>--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                        @foreach ($permissions as $permission)--}}
{{--                            @if($permission->name=='Faqs')--}}
{{--                                <div class="col-md-4 form-group">--}}
{{--                                    <div class="form-check checkbox">--}}
{{--                                        <input class="form-check-input Faqs" @if($user->can($permission->slug)) checked--}}
{{--                                               @endif name="permissions[]" value="{{$permission->id}}"--}}
{{--                                               type="checkbox"--}}
{{--                                               id="{{$permission->id}}">--}}
{{--                                        <label class="form-check-label" for="{{$permission->id}}">--}}
{{--                                            {{preg_replace('/-/', ' ', $permission->slug )}}--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <hr>--}}
{{--                <div class="content-box p-3">--}}
{{--                    <div class="row">--}}
{{--                        <div class="form-check checkbox p-3">--}}
{{--                            <input class="form-check-input" type="checkbox" id="Crowdfunding">--}}
{{--                            <label class="form-check-label" for="Crowdfunding">--}}
{{--                                <b>Crowdfunding</b>--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                        @foreach ($permissions as $permission)--}}
{{--                            @if($permission->name=='Crowdfunding')--}}
{{--                                <div class="col-md-4 form-group">--}}
{{--                                    <div class="form-check checkbox">--}}
{{--                                        <input class="form-check-input Crowdfunding"--}}
{{--                                               @if($user->can($permission->slug)) checked @endif name="permissions[]"--}}
{{--                                               value="{{$permission->id}}"--}}
{{--                                               type="checkbox"--}}
{{--                                               id="{{$permission->id}}">--}}
{{--                                        <label class="form-check-label" for="{{$permission->id}}">--}}
{{--                                            {{preg_replace('/-/', ' ', $permission->slug )}}--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <hr>--}}
{{--                <div class="content-box p-3">--}}
{{--                    <div class="row">--}}
{{--                        <div class="form-check checkbox p-3">--}}
{{--                            <input class="form-check-input" type="checkbox" id="OtherApp">--}}
{{--                            <label class="form-check-label" for="OtherApp">--}}
{{--                                <b>Other App</b>--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                        @foreach ($permissions as $permission)--}}
{{--                            @if($permission->name=='Other App')--}}
{{--                                <div class="col-md-4 form-group">--}}
{{--                                    <div class="form-check checkbox">--}}
{{--                                        <input class="form-check-input OtherApp"--}}
{{--                                               @if($user->can($permission->slug)) checked @endif name="permissions[]"--}}
{{--                                               value="{{$permission->id}}"--}}
{{--                                               type="checkbox"--}}
{{--                                               id="{{$permission->id}}">--}}
{{--                                        <label class="form-check-label" for="{{$permission->id}}">--}}
{{--                                            {{preg_replace('/-/', ' ', $permission->slug )}}--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <hr>--}}
{{--                <div class="content-box p-3">--}}
{{--                    <div class="row">--}}
{{--                        <div class="form-check checkbox p-3">--}}
{{--                            <input class="form-check-input" type="checkbox" id="withdrawal">--}}
{{--                            <label class="form-check-label" for="withdrawal">--}}
{{--                                <b>Withdrawal Requests</b>--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                        @foreach ($permissions as $permission)--}}
{{--                            @if($permission->name=='Withdrawal Request')--}}
{{--                                <div class="col-md-4 form-group">--}}
{{--                                    <div class="form-check checkbox">--}}
{{--                                        <input class="form-check-input withdrawal"--}}
{{--                                               @if($user->can($permission->slug)) checked @endif name="permissions[]"--}}
{{--                                               value="{{$permission->id}}"--}}
{{--                                               type="checkbox"--}}
{{--                                               id="{{$permission->id}}">--}}
{{--                                        <label class="form-check-label" for="{{$permission->id}}">--}}
{{--                                            {{preg_replace('/-/', ' ', $permission->slug )}}--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <hr>--}}
{{--                <div class="content-box p-3">--}}
{{--                    <div class="row">--}}
{{--                        <div class="form-check checkbox p-3">--}}
{{--                            <input class="form-check-input" type="checkbox" id="SupportEmail">--}}
{{--                            <label class="form-check-label" for="SupportEmail">--}}
{{--                                <b>Support Email</b>--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                        @foreach ($permissions as $permission)--}}
{{--                            @if($permission->name=='Support Email')--}}
{{--                                <div class="col-md-4 form-group">--}}
{{--                                    <div class="form-check checkbox">--}}
{{--                                        <input class="form-check-input SupportEmail"--}}
{{--                                               @if($user->can($permission->slug)) checked @endif name="permissions[]"--}}
{{--                                               value="{{$permission->id}}"--}}
{{--                                               type="checkbox"--}}
{{--                                               id="{{$permission->id}}">--}}
{{--                                        <label class="form-check-label" for="{{$permission->id}}">--}}
{{--                                            {{preg_replace('/-/', ' ', $permission->slug )}}--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <hr>--}}
{{--                <div class="content-box p-3">--}}
{{--                    <div class="row">--}}
{{--                        <div class="form-check checkbox p-3">--}}
{{--                            <input class="form-check-input" type="checkbox" id="CustomNotifications">--}}
{{--                            <label class="form-check-label" for="CustomNotifications">--}}
{{--                                <b>Custom Notifications</b>--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                        @foreach ($permissions as $permission)--}}
{{--                            @if($permission->name=='Custom Notification')--}}
{{--                                <div class="col-md-4 form-group">--}}
{{--                                    <div class="form-check checkbox">--}}
{{--                                        <input class="form-check-input CustomNotifications"--}}
{{--                                               @if($user->can($permission->slug)) checked @endif name="permissions[]"--}}
{{--                                               value="{{$permission->id}}"--}}
{{--                                               type="checkbox"--}}
{{--                                               id="{{$permission->id}}">--}}
{{--                                        <label class="form-check-label" for="{{$permission->id}}">--}}
{{--                                            {{preg_replace('/-/', ' ', $permission->slug )}}--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <hr>--}}
{{--                <div class="content-box p-3">--}}
{{--                    <div class="row">--}}
{{--                        <div class="form-check checkbox p-3">--}}
{{--                            <input class="form-check-input" type="checkbox" id="Reporting">--}}
{{--                            <label class="form-check-label" for="Reporting">--}}
{{--                                <b>Reporting</b>--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                        @foreach ($permissions as $permission)--}}
{{--                            @if($permission->name=='Reporting')--}}
{{--                                <div class="col-md-4 form-group">--}}
{{--                                    <div class="form-check checkbox">--}}
{{--                                        <input class="form-check-input Reporting"--}}
{{--                                               @if($user->can($permission->slug)) checked @endif name="permissions[]"--}}
{{--                                               value="{{$permission->id}}"--}}
{{--                                               type="checkbox"--}}
{{--                                               id="{{$permission->id}}">--}}
{{--                                        <label class="form-check-label" for="{{$permission->id}}">--}}
{{--                                            {{preg_replace('/-/', ' ', $permission->slug )}}--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <hr>--}}
{{--                <div class="content-box p-3">--}}
{{--                    <div class="row">--}}
{{--                        <div class="form-check checkbox p-3">--}}
{{--                            <input class="form-check-input" type="checkbox" id="SystemUsers">--}}
{{--                            <label class="form-check-label" for="SystemUsers">--}}
{{--                                <b>System Users</b>--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                        @foreach ($permissions as $permission)--}}
{{--                            @if($permission->name=='System Users')--}}
{{--                                <div class="col-md-4 form-group">--}}
{{--                                    <div class="form-check checkbox">--}}
{{--                                        <input class="form-check-input SystemUsers"--}}
{{--                                               @if($user->can($permission->slug)) checked @endif name="permissions[]"--}}
{{--                                               value="{{$permission->id}}"--}}
{{--                                               type="checkbox"--}}
{{--                                               id="{{$permission->id}}">--}}
{{--                                        <label class="form-check-label" for="{{$permission->id}}">--}}
{{--                                            {{preg_replace('/-/', ' ', $permission->slug )}}--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <hr>--}}
{{--                <div class="content-box p-3">--}}
{{--                    <div class="row">--}}
{{--                        <div class="form-check checkbox p-3">--}}
{{--                            <input class="form-check-input" type="checkbox" id="rolePermissions">--}}
{{--                            <label class="form-check-label" for="rolePermissions">--}}
{{--                                <b>Role Permissions</b>--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                        @foreach ($permissions as $permission)--}}
{{--                            @if($permission->name=='Role Permissions')--}}
{{--                                <div class="col-md-4 form-group">--}}
{{--                                    <div class="form-check checkbox">--}}
{{--                                        <input class="form-check-input rolePermissions"--}}
{{--                                               @if($user->can($permission->slug)) checked @endif name="permissions[]"--}}
{{--                                               value="{{$permission->id}}"--}}
{{--                                               type="checkbox"--}}
{{--                                               id="{{$permission->id}}">--}}
{{--                                        <label class="form-check-label" for="{{$permission->id}}">--}}
{{--                                            {{preg_replace('/-/', ' ', $permission->slug )}}--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <hr>--}}
{{--                <div class="content-box p-3">--}}
{{--                    <div class="row">--}}
{{--                        <div class="form-check checkbox p-3">--}}
{{--                            <input class="form-check-input" type="checkbox" id="Legal">--}}
{{--                            <label class="form-check-label" for="Legal">--}}
{{--                                <b>Legal</b>--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                        @foreach ($permissions as $permission)--}}
{{--                            @if($permission->name=='Legal')--}}
{{--                                <div class="col-md-4 form-group">--}}
{{--                                    <div class="form-check checkbox">--}}
{{--                                        <input class="form-check-input Legal" name="permissions[]"  @if($user->can($permission->slug)) checked @endif value="{{$permission->id}}"--}}
{{--                                               type="checkbox"--}}
{{--                                               id="{{$permission->id}}">--}}
{{--                                        <label class="form-check-label" for="{{$permission->id}}">--}}
{{--                                            {{preg_replace('/-/', ' ', $permission->slug )}}--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                </div>--}}
            </form>
        </section>
    </div>
</div>
<div class="modal fade" id="roleChangedModal" tabindex="-1">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                    class="fal ico-cross-circle"></i></button>
            <div class="modal-header">
                Are you sure you want to update role?
            </div>
            <div class="modal-body">
                <p><span class="text-yellow">Warning!: </span> If you change role of this user, all permissions will be changed according to new role.
                </p>
            </div>
            <div class="modal-footer justify-content-between">
                <a href="#" class="btn btn-red" id="btnReset" >Cancel</a>
                <a href="#" class="btn btn-green" data-bs-dismiss="modal"   id="changeRole">Change</a>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function (){

        $('#role_id').on('change',function (e){
            e.preventDefault();
            $('#roleChangedModal').modal('show')
        })
        $("#btnReset").bind("click", function () {
            var roleId = $(this).attr('data-roleId');
            const select = document.querySelector('#role_id');
            select.value ='{{$user->roles[0]->id}}'
            $('#roleChangedModal').modal('hide')

        });
    })
</script>

@endsection
