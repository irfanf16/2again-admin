@extends('admin.layouts.app')
@section('content')

@section('page_title','App User Profile')

<style>
    #fade {
        display: none;
        position: fixed;
        top: 0%;
        left: 0%;
        width: 100%;
        height: 100%;
        background-color: black;
        z-index: 1001;
        -moz-opacity: 0.8;
        opacity: .80;
        filter: alpha(opacity=80);
    }

    #light {
        display: none;
        position: absolute;
        top: 50%;
        left: 50%;
        max-width: 600px;
        max-height: 360px;
        border: 2px solid #FFF;
        background: #FFF;
        z-index: 1002;
        transform: translate(-50%, -50%);
        overflow: hidden;
    }
    #light video{
        width: 100%;
        height: 100%;
    }

    #boxclose {
        float: right;
        cursor: pointer;
        color: #fff;
        border: 1px solid #AEAEAE;
        border-radius: 3px;
        background: #222222;
        font-size: 31px;
        font-weight: bold;
        display: inline-block;
        line-height: 0px;
        padding: 11px 3px;
        position: absolute;
        right: 2px;
        top: 2px;
        z-index: 1002;
        opacity: 0.9;
    }

    .boxclose:before {
        content: "×";
    }

    #fade:hover ~ #boxclose {
        display: none;
    }

    .test:hover ~ .test2 {
        display: none;
    }
</style>

<div id="light">
    <a class="boxclose" id="boxclose" onclick="lightbox_close();"></a>
    <video id="VisaChipCardVideo" controls></video>
</div>
{{--<div>--}}
{{--    <a href="#" onclick="lightbox_open();">Watch video</a>--}}
{{--</div>--}}

<div id="fade" onClick="lightbox_close();"></div>
<div>


    <div id="content">
        <div class="container-fluid">
            <section class="section">
                <div class="profile-header">

                    <div class="btn-group">
                        @if(request()->user()->can('app-user-change-password') || request()->user()->can('app-user-delete') || request()->user()->can('app-user-ban') || request()->user()->can('app-user-unban'))

                        <div class="dropdown mx-1">
                            <button class="btn btn-light medium dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown">
                                Actions <i class="fas fa-ellipsis-v mx-2"></i>
                            </button>
                            <ul class="dropdown-menu">
                                {{--                                    <li><a  href="#" onclick="event.preventDefault(); document.getElementById('user_live_profile').submit();"> {{ $user->name }} live profile</a></li>--}}
                                @if($user->deleted_at==null)
                                    @if($user->banned==null)
                                        @can('app-user-change-password')
                                            <li><a href="#" data-bs-toggle="modal" data-bs-target="#changePassword">
                                                    Change
                                                    Password</a>
                                            </li>
                                        @endcan
                                        @can('app-user-delete')
                                            <li><a href="#" data-bs-toggle="modal" data-bs-target="#deleteAccount">Delete
                                                    Account</a>
                                            </li>
                                        @endcan

                                        @can('app-user-ban')
                                            <li><a id="banUserModalBtn" href="#" data-bs-toggle="modal"
                                                   data-bs-target="#bannUser">Ban
                                                    User</a></li>
                                        @endcan
                                    @else

                                        @can('app-user-unban')
                                            <li><a href="#" data-bs-toggle="modal"
                                                   data-bs-target="#UnbannUser">Unban user</a></li>
                                            <li><a href="#" data-bs-toggle="modal" data-bs-target="#deleteAccount">Delete
                                                    Account</a>
                                            </li>
                                        @endcan
                                    @endif
                                @else
                                    <li><a id="banUserModalBtn" href="#" data-bs-toggle="modal"
                                           data-bs-target="#recoverUser">Recover user</a></li>
                                @endif
                            </ul>
                        </div>
                        @endif
                        @if(request()->user()->can('app-user-add-credit') || request()->user()->can('app-user-assign--badge') || request()->user()->can('send-custom-notification'))
                            <div class="dropdown mx-1">
                                <button class="btn btn-light medium dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown">
                                    Admin Actions <i class="fas fa-ellipsis-v mx-2"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    @can('app-user-add-credit')
                                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#addcredits">Add
                                                Coins</a>
                                        </li>
                                    @endcan
                                    @can('app-user-assign--badge')
                                        {{--                                <li><a href="#" data-bs-toggle="modal" data-bs-target="#addpremium">Assign VIP & BS--}}
                                        {{--                                        Badge</a></li>--}}

                                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#custombadgeassgin">Assign
                                                Custom
                                                Badge</a></li>
                                    @endcan
                                        @can('send-custom-notification')
                                    <li><a href="#" data-bs-toggle="modal" data-bs-target="#cutomNotification">Custom
                                            Notification</a></li>
                                        @endcan
                                </ul>
                            </div>
                        @endif
                    </div>
                    <ul class="tabset">
                        <li class="active"><a href="#Profile">Profile</a></li>
                        @can('app-user-media-read')
                        <li><a href="#Media">Media ({{ count($user->media) }})</a></li>
                        @endcan
                        @can('app-user-credit-read')
                        <li><a href="#Credits">Coins</a></li>
                        @endcan
                        @can('app-user-assets-read')
                        <li><a href="#assets">Assets</a></li>
                        @endcan
                        @can('app-user-chat-read')
                        <li><a href="#ChatHistory">Chat History</a></li>
                        @endcan
                        {{--                    <li><a href="#Activity">Activity</a></li>--}}


                    </ul>
                </div>
                <div class="content">
                    <div class="profile-sidebar">
                        <div class="content-center">
                            <div class="user-img">
                                <img id="userUpdateProfilePic" src="{{ $urlProfile }}{{ $user->profile_pic }}">
                            </div>
                            <div class="user-title flex-column align-items-start">
                                <h4>{{ $user->name }} {{ $user->lastname }}, <span>{{ $user->age }}</span></h4>
                                @if($user->deleted_at==null)
                                    @if($user->banned==null)
                                        @if($user->is_online==1)
                                            <small class="text-green">Online Now</small>
                                        @else
                                            <small class="text-red">Offline</small>
                                        @endif
                                    @else
                                        <small class="text-red"> Banned
                                           @if($user->banned->banned_forever==0)
                                            (till {{ $user->banned_time_for}}
                                            )
                                            @else
                                               (Forever)
                                            @endif
                                        </small>
                                    @endif

                                @else
                                    <small class="text-red">Deleted user</small>
                                @endif
                            </div>
                        </div>

                        {{-- <div class="text-gray mb-3">@salmanmirza</div> --}}
                        {{--                    <p>{{ $user->bio }}</p>--}}
                        <ul>
                            {{--                        <li><i class="fas fa-user"></i> @if($user->email == null && $user->phone == null) Social--}}
                            {{--                            user @else Normal user @endif</li>--}}
                            <li><i class="fal ico-badge"></i>{{ $user->currentSubscription->name }} </li>
                            @if($user->custombadge)
                                <li><i class="fal ico-badge"></i>{{ $user->custombadge->name }} </li>
                            @endif
                            <li><i class="fas fa-envelope"></i> {{ $user->email ?? 'Not Provided'}} </i> </li>
                            <li><i class="fas fa-phone"></i> {{ $user->phone ?? 'Not Provided'}} </i> </li>
                            {{--                        <li><i class="fas fa-life-saver"></i> {{ $user->dob ?? 'N/A'}} </i> </li>--}}
                            <li><i class="fas fa-search"></i> Searching For
                                @foreach ($genders as $gender)
                                    @if($user->interested_in == $gender->id)  {{ $gender->name }} @endif
                                @endforeach
                               ({{ $user->filter_date_range }} years)</li>
                            <li><i class="fas fa-map-marker-alt"></i>{{ $user->country->name }}</li>
                            <li><i class="fas fa-wifi"></i> IP: {{ $user->ip }}</li>
                            <li><i class="fas fa-calendar-alt"></i> Member
                                since: {{$user->created_at->toDayDateTimeString() }}</li>

                        </ul>
                    </div>
                    <div class="tab-content overflow-hidden mt-4 ">
                        <div class="tab" id="Profile">
                            <form class="m-1" id="">
                                {{--                            updateUserProfile--}}
                                <div class="col-md-12">
                                    <div class="content-box p-3">
                                        <div class="header mb-3 text-yellow">
                                            Profile
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>First Name:</label>
                                                <input type="text" readonly name="name" class="form-control"
                                                       value="{{ $user->name }}">
                                                <input type="hidden" readonly name="id" class="form-control"
                                                       value="{{ $user->id }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Last Name:</label>
                                                <input type="text" readonly name="name" class="form-control"
                                                       value="{{ $user->lastname }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Gender:</label>
                                                <select disabled class="form-select" readonly name="gender_id">
                                                    @foreach ($genders as $gender)
                                                        <option value="{{ $gender->id }}"
                                                                @if($user->gender_id == $gender->id) selected @endif>{{ $gender->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Date Of Birth:</label>
                                                <input type="text" class="form-control" name="dob"
                                                       value="{{ $user->dob }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Country:</label>
                                                <select disabled class="form-select" readonly name="country_id">
                                                    @foreach ($countries as $country)
                                                        <option value="{{ $country->id }}"
                                                                @if($user->country_id == $country->id) selected @endif>{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Language:</label>
                                                <select disabled class="form-select" readonly name="language_id">
                                                    @foreach ($languages as $language)
                                                        <option value="{{ $language->id }}"
                                                                @if($user->language_id == $language->id) selected @endif>{{ $language->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        {{--                                    <div class="row">--}}
                                        {{--                                        <div class="form-group col-md-6">--}}
                                        {{--                                            <label>Phone:</label>--}}
                                        {{--                                            <input type="text" readonly name="phone" value="{{ $user->phone }}">--}}
                                        {{--                                        </div>--}}
                                        {{--                                        <div class="form-group col-md-6">--}}
                                        {{--                                            <label>Email:</label>--}}
                                        {{--                                            <input type="email" readonly name="email" class="form-control"--}}
                                        {{--                                                   value="{{ $user->email }}">--}}
                                        {{--                                        </div>--}}

                                        {{--                                    </div>--}}
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label> Religion:</label>
                                                <select disabled class="form-select" readonly name="religion_id">
                                                    <option value="">No Religion Selected</option>
                                                    @foreach ($religions as $religion)
                                                        <option value="{{ $religion->id }}"
                                                                @if($user->religion_id == $religion->id) selected @endif>{{ $religion->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label>About:</label>
                                                <textarea type="text" readonly name="bio">{{ $user->bio }}</textarea>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label>Do You Have Children: &nbsp;</label>
                                                <input type="radio" readonly name="have_children"
                                                       @if($user->have_children == 1) checked @endif value="1">
                                                Yes &nbsp;
                                                <input type="radio" readonly name="have_children"
                                                       @if($user->have_children == 0) checked
                                                       @endif value="0"> No
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label>Are You Smoker: &nbsp;</label>
                                                <input type="radio" readonly name="is_smoker"
                                                       @if($user->is_smoker == 1) checked @endif value="1">
                                                Yes &nbsp;
                                                <input type="radio" readonly name="is_smoker"
                                                       @if($user->is_smoker == 0) checked
                                                       @endif value="0"> No
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label>Do You have Animal: &nbsp;</label>
                                                <input type="radio" readonly name="have_animal"
                                                       @if($user->have_animals == 1) checked @endif value="1">
                                                Yes &nbsp;
                                                <input type="radio" readonly name="have_animal"
                                                       @if($user->have_animals == 0) checked
                                                       @endif value="0"> No
                                            </div>
                                            <div class="form-group col-md-12 mb-0">
                                                @if(count($user->hobbies) > 0)

                                                    <label>Hobbies</label>
                                                    <div class="tag-list" id="tag-list">
                                                        @foreach($user->hobbies as $hobby)
                                                            <span class="tag bg-purple ">{{$hobby->name}}<a
                                                                    id="{{$hobby->id}}"></a> </span>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        {{--                                    <div class="row">--}}

                                        {{--                                        <div class="form-group col-md-6">--}}
                                        {{--                                            <label>Profile Picture:</label>--}}
                                        {{--                                            <input type="file" id="addUserImage" readonly name="file" value="{{ $user->bio }}">--}}
                                        {{--                                        </div>--}}
                                        {{--                                    </div>--}}
                                        <div class="header mb-3 text-yellow">
                                            Search Preferences (Show me results based on following)
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>Interested In:</label>
                                                <select disabled class="form-select" readonly name="interested_in">
                                                    @foreach ($genders as $gender)
                                                        <option value="{{ $gender->id }}"
                                                                @if($user->interested_in == $gender->id) selected @endif>{{ $gender->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Radius (km):</label>
                                                <input type="number" readonly name="filter_radius" class="form-control"
                                                       value="{{ $user->filter_radius }}">
                                            </div>
                                            {{--                                        <div class="form-group col-md-6">--}}
                                            {{--                                            <label>Gender:</label>--}}
                                            {{--                                            <select class="form-select" readonly name="filter_gender">--}}
                                            {{--                                                @foreach ($genders as $gender)--}}
                                            {{--                                                    <option value="{{ $gender->id }}"--}}
                                            {{--                                                            @if($user->filter_gender == $gender->id) selected @endif>{{ $gender->name }}</option>--}}
                                            {{--                                                @endforeach--}}
                                            {{--                                            </select>--}}
                                            {{--                                        </div>--}}
                                        </div>
                                        {{--                                    <div class="row">--}}
                                        {{--                                        @php--}}
                                        {{--                                            $date_range = explode('-', $user->filter_date_range)--}}
                                        {{--                                        @endphp--}}
                                        {{--                                        <div class="form-group col-md-6">--}}
                                        {{--                                            <label>Date From:</label>--}}
                                        {{--                                            <input type="number" readonly name="data1" class="form-control"--}}
                                        {{--                                                   value="{{ $date_range[0] }}">--}}
                                        {{--                                        </div>--}}
                                        {{--                                        <div class="form-group col-md-6">--}}
                                        {{--                                            <label>Date to:</label>--}}
                                        {{--                                            <input type="number" readonly name="data2" class="form-control"--}}
                                        {{--                                                   value="{{ $date_range[1] }}">--}}
                                        {{--                                        </div>--}}
                                        {{--                                    </div>--}}
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>Show all over the world:</label>
                                                <input type="checkbox" readonly name="filter_all_world"
                                                       @if($user->filter_all_world == 1) checked @endif value="1">
                                            </div>
                                            <div class="form-group col-md-12 mb-0">
                                                @if(count($user->looking) > 0)
                                                    <label>Looking For</label>
                                                    <div class="tag-list" id="tag-list">
                                                        @foreach($user->looking as $look)
                                                            <span class="tag bg-purple ">{{$look->name}}<a
                                                                    id="{{$look->id}}"></a> </span>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>Same religion:</label>
                                                <input type="checkbox" readonly name="filter_religion"
                                                       @if($user->filter_religion == 1) checked @endif value="1">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Same country:</label>
                                                <input type="checkbox" readonly name="filter_my_country"
                                                       @if($user->filter_my_country == 1) checked @endif value="1">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>Same language:</label>
                                                <input type="checkbox" readonly name="filter_same_languge"
                                                       @if($user->filter_same_languge == 1) checked @endif value="1">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Have children:</label>
                                                <input type="checkbox" readonly name="filter_have_children"
                                                       @if($user->filter_have_children == 1) checked @endif value="1">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Have animals:</label>
                                                <input type="checkbox" readonly name="filter_have_animal"
                                                       @if($user->filter_have_animals == 1) checked @endif value="1">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Are Smoker:</label>
                                                <input type="checkbox" readonly name="filter_is_smoker"
                                                       @if($user->filter_is_smoker == 1) checked @endif value="1">
                                            </div>
                                        </div>


                                        <div class="header mb-3 text-yellow">
                                            Discovery Preferences (Others can discover me based on following)
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>My language:</label>
                                                <input type="checkbox" readonly name="discovery_my_language"
                                                       @if($user->discovery_my_language == 1) checked @endif value="1">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Be invisible:</label>
                                                <input type="checkbox" readonly name="discovery_be_invisible"
                                                       @if($user->discovery_be_invisible == 1) checked @endif value="1">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Hide my age:</label>
                                                <input type="checkbox" readonly name="setting_hide_age"
                                                       @if($user->setting_hide_age == 1) checked @endif value="1">
                                            </div>

                                        </div>
                                        <div class="row">

                                            <div class="form-group col-md-12">
                                                <label>Discovery radius (km):</label>
                                                <input type="number" readonly name="discovery_boost_radius"
                                                       class="form-control"
                                                       value="{{ $user->discover_boost_radius }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>All over the world:</label>
                                                <input type="checkbox" readonly name="discovery_world_wide_boost"
                                                       @if($user->discovery_world_wide_boost == 1) checked
                                                       @endif value="1">
                                            </div>

                                        </div>
                                        <div class="header mb-3 text-yellow">
                                            Other Preferences
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>Chat Read Receipt:</label>
                                                <input type="checkbox" readonly name="chat_read_receipt"
                                                       @if($user->privacy_read_receipt == 1) checked
                                                       @endif value="1">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Last Active Status:</label>
                                                <input type="checkbox" readonly name="chat_read_receipt"
                                                       @if($user->privacy_last_active_status == 0) checked
                                                       @endif value="1">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Sound:</label>
                                                <input type="checkbox" readonly name="setting_sound"
                                                       @if($user->setting_sound == 0) checked @endif value="1">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Vibration:</label>
                                                <input type="checkbox" readonly name="setting_vibration"
                                                       @if($user->setting_vibration == 0) checked @endif value="1">
                                            </div>
                                        </div>
                                        <div class="row">
                                            {{--                                        <div class="form-group col-md-6">--}}
                                            {{--                                            <label>Light Mode:</label>--}}
                                            {{--                                            <input type="checkbox" readonly name="setting_light_mode"--}}
                                            {{--                                                   @if($user->setting_light_mode == 1) checked @endif value="1">--}}
                                            {{--                                        </div>--}}
                                            {{--                                        <div class="form-group col-md-6">--}}
                                            {{--                                            <label>Is Profile Paused:</label>--}}
                                            {{--                                            <input type="checkbox" readonly name="setting_is_paused"--}}
                                            {{--                                                   @if($user->setting_is_paused == 1) checked @endif value="1">--}}
                                            {{--                                        </div>--}}
                                            {{--                                        <div class="form-group col-md-6">--}}
                                            {{--                                            <label>Sound on notification:</label>--}}
                                            {{--                                            <input type="checkbox" readonly name="setting_sound_on_notification"--}}
                                            {{--                                                   @if($user->setting_sound_on_notification == 1) checked--}}
                                            {{--                                                   @endif value="1">--}}
                                            {{--                                        </div>--}}

                                        </div>
                                        <div class="text-right pt-3">
                                            {{--                                        <button class="btn" type="submit" id="" style="min-width: 150px">Save</button>--}}
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                        @can('app-user-assets-read')
                        <div class="tab" id="assets">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="content-box p-3 text-center radius-0">
                                        <div>Likes</div>
                                        <h3 class="mb-0">{{ $user->available_likes }}</h3>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="content-box p-3 text-center radius-0">
                                        <div>Super Likes</div>
                                        <h3 class="mb-0">{{ $user->available_super_likes }}</h3>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="content-box p-3 text-center radius-0">
                                        <div>Favorites</div>
                                        <h3 class="mb-0">{{ $user->available_favorite }}</h3>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="content-box p-3 text-center radius-0">
                                        <div>Call Minutes</div>
                                        <h3 class="mb-0">{{ $user->available_call_min }}</h3>
                                    </div>
                                </div>

                            </div>

                        </div>
                        @endcan
                        @can('app-user-chat-read')
                        <div class="tab" id="ChatHistory">
                            <div class="content-box p-3">


                                <div class="container-fluid">
                                    <section class="section">
                                        <div class="">
                                            {{--                                        <div class="search-form">--}}
                                            {{--                                            <div class="form-group">--}}
                                            {{--                                                <input type="search" class="form-control" placeholder="Search">--}}
                                            {{--                                                <button type="submit" class="btn"><i class="fal ico-search"></i>--}}
                                            {{--                                                </button>--}}
                                            {{--                                            </div>--}}
                                            {{--                                        </div>--}}
                                            <div class=" content-box">
                                                <ul class="tabset">
                                                    <li class="active"><a href="#Messages">Messages</a></li>
                                                    <li><a href="#Calls">Calls</a></li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div id="Messages">
                                                        <div class="scrollar">
                                                            <div class="scrollbar-content">
                                                                <ul class="icon-list message"
                                                                    id="userMessagesConversations">
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="Calls">
                                                        <div class="scrollar">
                                                            <div class="scrollbar-content">
                                                                <ul class="icon-list message" id="userCallsHistory">

                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                            @endcan

                            {{--                    <div class="tab" id="Activity">--}}
                        {{--                        --}}{{--                        <div class="content-box p-3">--}}
                        {{--                        <ul class="icon-list large" id="user-activities-list">--}}

                        {{--                            @foreach($activities as $activity)--}}

                        {{--                                @dd($activity)--}}
                        {{--                                <li>--}}
                        {{--                                    <div class="user-img">--}}
                        {{--                                        <img class="transactions-image"--}}
                        {{--                                             src="{{ $urlProfile}}{{ $user->profile_pic }}">--}}
                        {{--                                    </div>--}}
                        {{--                                    <div class="description">--}}
                        {{--                                        <div class="text">--}}
                        {{--                                            <div--}}
                        {{--                                                class="title @if($transaction->type == 'CREDIT') text-green @else text-red @endif">--}}
                        {{--                                                {{ $transaction->type == 'CREDIT' ? 'Received' : 'Spent' }} {{ $transaction->amount }} {{ $transaction->coin }}--}}
                        {{--                                                Coins--}}
                        {{--                                            </div>--}}
                        {{--                                            <p class="text-gray font-12">{{ $transaction->source }}</p>--}}
                        {{--                                        </div>--}}
                        {{--                                        <div class="info text-gray">--}}
                        {{--                                            {{ $transaction->created_at }}--}}
                        {{--                                        </div>--}}
                        {{--                                    </div>--}}
                        {{--                                </li>--}}
                        {{--                            @endforeach--}}
                        {{--                        </ul>--}}

                        {{--                        --}}{{--                        </div>--}}
                        {{--                    </div>--}}

                        @can('app-user-media-read')
                        <div class="tab" id="Media">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="content-box p-3 text-center radius-0">
                                        <div>Private Photos</div>
                                        <h3 class="mb-0">{{ $user->available_photo_count }}</h3>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="content-box p-3 text-center radius-0">
                                        <div> Photo Gallery Likes</div>
                                        <h3 class="mb-0">{{ $user->photo_gallery_likes }}</h3>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="content-box p-3 text-center radius-0">
                                        <div>Photo Gallery Dislikes</div>
                                        <h3 class="mb-0">{{ $user->photo_gallery_dislikes }}</h3>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="content-box p-3 text-center radius-0">
                                        <div>Private Videos</div>
                                        <h3 class="mb-0">{{ $user->available_video_count }}</h3>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="content-box p-3 text-center radius-0">
                                        <div>Video Gallery Likes</div>
                                        <h3 class="mb-0">{{ $user->video_gallery_likes }}</h3>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="content-box p-3 text-center radius-0">
                                        <div>Video Gallery Dislikes</div>
                                        <h3 class="mb-0">{{ $user->video_gallery_dislikes }}</h3>
                                    </div>
                                </div>

                            </div>

                            <div class="content-box p-3">
                                <form class="mb-5">
                                    {{--                                <input type="hidden" readonly name="user" value="{{$user->id}}">--}}
                                    {{--                                <div class="text-right mb-3">--}}
                                    {{--                                    <a href="#" class="btn"><i class="fas fa-redo"></i> Reset</a>--}}
                                    {{--                                </div>--}}
                                    <div class="row" data-user="{{$user->id}}">
                                        <div class="col-md-6 form-group">
                                            <label>Type</label>
                                            <select class="form-select media_search" id="media_type">
                                                <option value="">All</option>
                                                <option value="photo">Public Photos</option>
                                                <option value="private_photo">Private Photos</option>
                                                <option value="video">Videos</option>
                                                {{--                                            <option value="story">Story</option>--}}
                                            </select>
                                        </div>
                                        {{--                                    <div class="col-md-4 form-group">--}}
                                        {{--                                        <label> Visible</label>--}}
                                        {{--                                        <select class="form-select media_search" id="is_private">--}}
                                        {{--                                            <option value="">All</option>--}}
                                        {{--                                            <option value="0">Public</option>--}}
                                        {{--                                            <option value="1">Private</option>--}}
                                        {{--                                        </select>--}}
                                        {{--                                    </div>--}}
                                        <div class="col-md-6 form-group">
                                            <label>Status</label>
                                            <select class="form-select media_search" id="media_status">
                                                <option value="">All</option>
                                                <option value="0">Live</option>
                                                <option value="1">Deleted by user</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                                <div class="table-responsive">
                                    <table class="table yajra-datatable">
                                        <thead>
                                        <tr>

                                            <th>Media</th>
                                            <th>Media Type</th>
                                            <th>Date</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="user_media">
                                        @forelse ($user->media as $key=>$media)
                                            <tr>
                                                <td>

                                                        @if($media->media_type == 'Photo')
                                                        <div class="img-box radius-10">
                                                            <a href="{{ $urlProfile }}{{ $media->name }}"
                                                               target="_blank"><img
                                                                    src="{{ $urlProfile }}{{ $media->name }}"></a>
                                                        </div>
                                                        @elseif ($media->media_type == 'Video')
                                                            {{--                                                        <a target="_blank" href="{{ $urlProfile }}{{ $media->name }}">--}}
                                                        <div class="img-box radius-10" onclick="lightbox_open('{{ $urlProfile }}{{ $media->name }}')">
                                                            <div class="icon-box">
                                                                <i class="fas fa-play-circle"></i>
                                                            </div>
                                                            <video width="100"  height="100"
                                                                   preload="metadata">
                                                                <source src="{{ $urlProfile }}{{ $media->name }}"
                                                                        type="video/mp4">
                                                                <source src="{{ $urlProfile }}{{ $media->name }}"
                                                                        type="video/ogg">
                                                                Your browser does not support the video tag.
                                                            </video>
                                                        </div>
                                                            {{--                                                        </a>--}}
                                                        @endif
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">{{ $media->media_type }}</span>
                                                </td>
                                                <td> {{ $media->created_at->diffForHumans() }} </td>
                                                <td>{{ $media->is_private == 1 ? 'Private' : 'Public' }}</td>
                                                <td class="media_status">{{ $media->deleted_at == null ? 'Live' : 'Deleted' }}</td>
                                                <td class="action">
                                                    <div class="dropdown">
                                                        <button class="btn dropdown-toggle" type="button"
                                                                data-bs-toggle="dropdown">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                @if($media->deleted_at == null)
                                                                    <a href="#" class="delete_media"
                                                                       data-media="{{ $media->id }}">Delete media</a>
                                                                @else
                                                                    <a href="#" class="restore_media"
                                                                       data-media="{{ $media->id }}">Restore media</a>
                                                                @endif
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            No Media Found
                                        @endforelse

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endcan
                        @can('app-user-credit-read')
                        <div class="tab" id="Credits">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="content-box p-3 text-center radius-0">
                                        <div>Gold Coins</div>
                                        <h1 class="mb-0">{{ $user->gold_coin }}</h1>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="content-box p-3 text-center radius-0">
                                        <div>Silver Coins</div>
                                        <h1 class="mb-0">{{ $user->silver_coin }}</h1>
                                    </div>
                                </div>
                            </div>
                            <ul class="tabset tab-btn full text-uppercase no-space">
                                <li class="active"><a href="#all">All</a></li>
                                {{--                            <li><a href="#referral" id="referral_tab">Referral</a></li>--}}
                                <li><a href="#goldCoins" id="goldCoins_tab">Gold Coins</a></li>
                                <li><a href="#silverCoins" id="silverCoins_tab">Silver Coins</a></li>
                                <li><a href="#referGoldCoins" id="goldCoins_tab">Refer Gold Coins</a></li>
                                <li><a href="#referSilverCoins" id="silverCoins_tab">Refer Silver Coins</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab" id="all">
                                    <ul class="icon-list large list2 scroll-color" id="coin-transaction-list">
                                        @foreach($user->transactions as $transaction)
                                            <li>
                                                {{--                                            <div class="user-img">--}}
                                                {{--                                                <img class="transactions-image"--}}
                                                {{--                                                     src="{{ $urlProfile}}{{ $user->profile_pic }}">--}}
                                                {{--                                            </div>--}}
                                                <div class="description">
                                                    <div class="text">
                                                        <div
                                                            class="title @if($transaction->type == 'CREDIT') text-green @else text-red @endif">
                                                            {{ $transaction->type == 'CREDIT' ? 'Received' : 'Spent' }} {{ $transaction->amount }} {{ $transaction->coin }}
                                                            Coins
                                                        </div>
                                                        <p class="text-gray font-12">{{ $transaction->source }}</p>
                                                    </div>
                                                    <div class="info text-gray w-auto">
                                                        {{ $transaction->created_at }}
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="text-center">
                                        <input type="button" class="btn small w-100" id="getMoreTransactions"
                                               data-user="{{ $user->id }}"
                                               data-offset="2"
                                               value="@if(count($user->transactions) > 4) Load More @else No More Data @endif">
                                    </div>
                                </div>
                                <div class="tab" id="goldCoins">
                                    <ul class="icon-list large list2 scroll-color" id="gold-coin-transaction-list">
                                        @foreach ($goldCoinsTransaction as $transaction)
                                            <li>
                                                {{--                                            <div class="user-img">--}}
                                                {{--                                                <img class="transactions-image"--}}
                                                {{--                                                     src="{{ $urlProfile}}{{ $user->profile_pic }}">--}}
                                                {{--                                            </div>--}}
                                                <div class="description">
                                                    <div class="text">
                                                        <div
                                                            class="title @if($transaction->type == 'CREDIT') text-green @else text-red @endif">
                                                            {{ $transaction->type == 'CREDIT' ? 'Received' : 'Spent' }} {{ $transaction->amount }} {{ $transaction->coin }}
                                                            Coins
                                                        </div>
                                                        <p class="text-gray font-12">{{ $transaction->source }}</p>
                                                    </div>
                                                    <div class="info text-gray  w-auto">
                                                        {{ $transaction->created_at }}
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="text-center">
                                        <input type="button" class="btn small w-100" id="getMoreGoldCoinTransactions"
                                               data-user="{{ $user->id }}"
                                               data-offset="2"
                                               value="@if(count($goldCoinsTransaction) > 4) Load More @else No More Data @endif">
                                    </div>
                                </div>
                                <div class="tab" id="silverCoins">
                                    <ul class="icon-list large list2 scroll-color" id="silver-coin-transaction-list">

                                        @foreach ($silverCoinsTransaction as $transaction)
                                            <li>
                                                {{--                                            <div class="user-img">--}}
                                                {{--                                                <img class="transactions-image"--}}
                                                {{--                                                     src="{{ $urlProfile}}{{ $user->profile_pic }}">--}}
                                                {{--                                            </div>--}}
                                                <div class="description">
                                                    <div class="text">
                                                        <div
                                                            class="title @if($transaction->type == 'CREDIT') text-green @else text-red @endif">
                                                            {{ $transaction->type == 'CREDIT' ? 'Received' : 'Spent' }} {{ $transaction->amount }} {{ $transaction->coin }}
                                                            Coins
                                                        </div>
                                                        <p class="text-gray font-12">{{ $transaction->source }}</p>
                                                    </div>
                                                    <div class="info text-gray  w-auto">
                                                        {{ $transaction->created_at }}
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="text-center">
                                        <input type="button" class="btn small w-100 " id="getMoreSilverCoinTransactions"
                                               data-user="{{ $user->id }}"
                                               data-offset="2"
                                               value="@if(count($silverCoinsTransaction) > 4) Load More @else No More Data @endif">
                                    </div>
                                </div>
                                <div class="tab" id="referGoldCoins">
                                    <ul class="icon-list large list2 scroll-color" id="refer-gold-coin-transaction-list">
                                        @foreach ($referralGoldCoinsTransaction as $transaction)

                                            <li>
                                                {{--                                            <div class="user-img">--}}
                                                {{--                                                <img class="transactions-image"--}}
                                                {{--                                                     src="{{ $urlProfile}}{{ $user->profile_pic }}">--}}
                                                {{--                                            </div>--}}
                                                <div class="description">
                                                    <div class="text">
                                                        <div
                                                            class="title @if($transaction->type == 'CREDIT') text-green @else text-red @endif">
                                                            {{ $transaction->type == 'CREDIT' ? 'Received' : 'Spent' }} {{ $transaction->amount }} {{ $transaction->coin }}
                                                            Coins
                                                        </div>
                                                        <p class="text-gray font-12">{{ $transaction->source }}</p>
                                                    </div>
                                                    <div class="info text-gray  w-auto">
                                                        {{ $transaction->created_at }}
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="text-center">
                                        <input type="button" class="btn small w-100"
                                               id="getMoreReferGoldCoinTransactions"
                                               data-user="{{ $user->id }}"
                                               data-offset="2"
                                               value="@if(count($referralGoldCoinsTransaction) > 4) Load More @else No More Data @endif">
                                    </div>
                                </div>
                                <div class="tab" id="referSilverCoins">
                                    <ul class="icon-list large list2 scroll-color" id="refer-silver-coin-transaction-list">

                                        @foreach ($referralSilverCoinsTransaction as $transaction)
                                            <li>
                                                {{--                                            <div class="user-img">--}}
                                                {{--                                                <img class="transactions-image"--}}
                                                {{--                                                     src="{{ $urlProfile}}{{ $user->profile_pic }}">--}}
                                                {{--                                            </div>--}}
                                                <div class="description">
                                                    <div class="text">
                                                        <div
                                                            class="title @if($transaction->type == 'CREDIT') text-green @else text-red @endif">
                                                            {{ $transaction->type == 'CREDIT' ? 'Received' : 'Spent' }} {{ $transaction->amount }} {{ $transaction->coin }}
                                                            Coins
                                                        </div>
                                                        <p class="text-gray font-12">{{ $transaction->source }}</p>
                                                    </div>
                                                    <div class="info text-gray  w-auto">
                                                        {{ $transaction->created_at }}
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="text-center">
                                        <input type="button" class="btn small w-100"
                                               id="getMoreReferSilverCoinTransactions"
                                               data-user="{{ $user->id }}"
                                               data-offset="2"
                                               value="@if(count($referralSilverCoinsTransaction) > 4) Load More @else No More Data @endif">
                                    </div>

                                </div>
                            </div>
                        </div>
                        @endcan
                    </div>
                </div>

            </section>
        </div>
    </div>


    <div class="modal fade" id="addpremium" tabindex="-1">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fal ico-cross-circle"></i></button>
                <div class="modal-header">
                    Assign Badge to User
                </div>
                <div class="modal-body">
                    <form method="POST" id="addCreditToUser" action="{{route('admin.manage.users.assign.badge')}}">
                        @csrf
                        <input type="hidden" readonly name="userId" value="{{$user->id}}">
                        <div class="form-group">
                            <label>Select Badge Type</label>
                            <select class="form-control" readonly name="type" id="type" required>
                                @foreach($subscriptions as $subscription)
                                    <option value="{{$subscription->shortcode}}"> {{$subscription->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Select Months</label>
                            <select class="form-control" readonly name="quantity" id="quantity">
                                <option value="1">1 Month</option>
                                <option value="3">3 Months</option>
                                <option value="6">6 Months</option>
                                <option value="12">12 Months</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Start Date</label>
                            <input class="form-control" type="datetime-local" readonly name="start_date" required
                                   value="">
                        </div>
                        <div class="modal-footer justify-content-between">
                            <a href="javascript:void(0)" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
                            <input type="submit" class="btn btn-green" value="Assign">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="cutomNotification" tabindex="-1">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fal ico-cross-circle"></i></button>
                <div class="modal-header">
                    Send notification to this user
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.custom.notification.send')}}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" readonly name="userId" value="{{$user->id}}">

                        <div class="form-group">
                            <label>Type</label>
                            <select class="form-select" name="type">
                                <option value="CUSTOM">2Again Notification (To all users)</option>
                                <option value="NewsUpdate">NEWS</option>
                                <option value="Promotions">PROMOTION</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Short Message (For Locked Screen)</label>
                            <input type="text" name="body" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <textarea name="data" class="form-control" required
                                      style="height: 100%"></textarea>
                        </div>
                        <button class="btn btn-primary text-right">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="custombadgeassgin" tabindex="-1">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fal ico-cross-circle"></i></button>
                <div class="modal-header">
                    Assign Custom Badge to User
                </div>
                <div class="modal-body">
                    <form method="POST" id="addCreditToUser" action="{{route('admin.manage.users.assign.badge')}}">
                        @csrf
                        <input type="hidden" readonly name="userId" value="{{$user->id}}">
                        <div class="form-group">
                            <label>Select Badge Type</label>
                            <select class="form-control" name="type" id="type" required>
                                @foreach($subscriptionsCustom as $subscription)
                                    <option value="{{$subscription->shortcode}}"> {{$subscription->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Start Date</label>
                            <input class="form-control" type="datetime-local" name="start_date" required value="">
                        </div>
                        <div class="form-group">
                            <label>End Date</label>
                            <input class="form-control" type="datetime-local" name="valid_till" required value="">
                        </div>
                        <div class="modal-footer justify-content-between">
                            <a href="javascript:void(0)" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
                            <input type="submit" class="btn btn-green" value="Assign">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addcredits" tabindex="-1">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fal ico-cross-circle"></i></button>
                <div class="modal-header">
                    Add credits to this user
                </div>
                <div class="modal-body">
                    <form method="POST" id="addCreditToUser" action="{{route('admin.manage.users.add.credit')}}">
                        @csrf
                        <input type="hidden" name="userId" value="{{$user->id}}">
                        <div class="form-group">
                            <label>Select Coin Type</label>
                            <select class="form-control" name="coinsType" id="coinsType">
                                <option value="goldCoins"> Gold Coins</option>
                                <option value="silverCoins"> Silver Coins</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Coins</label>
                            <input type="number" onKeyPress="if(this.value.length==7) return false;"
                                   class="form-control" name="coins"

                                   required>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <a href="javascript:void(0)" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
                            <input type="submit" class="btn btn-green" value="Add">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
                        able to
                        login with old password</p>
                    <form>
                        <div class="form-group">
                            <label>Enter Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Enter Password">
                        </div>
                        <div class="form-group">
                            <label>Re-enter Password</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                   placeholder="Enter Password Again">
                        </div>
                        <div class="modal-footer justify-content-between">
                            <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
                            <a href="#" class="btn btn-green" data-user="{{ $user->id }}"
                               id="passwordChangeBtn">Change</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="bannUser" tabindex="-1">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fal ico-cross-circle"></i></button>
                <form action="{{route('admin.manage.users.ban')}}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{$user->id}}">
                    <input type="hidden" name="action" value="1">
                    <div class="modal-header">
                        Select Banned Time
                    </div>
                    <div class="modal-body">
                        <p><span class="text-yellow">Warning!: </span> User will be automatically unbanned after the
                            time
                            selected</p>


                            <div class="form-group">
                                <label>Ban Till</label>
                                    <input class="form-control" id="ban_for_time" type="datetime-local" name="time" required
                                       value="">
                            </div>
                            <div class="form-group">
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
                            <button type="submit" class="btn btn-green">Ban</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteAccount" tabindex="-1">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fal ico-cross-circle"></i></button>
                <form action="{{route('admin.manage.users.delete')}}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{$user->id}}">
                    <div class="modal-header">
                        Are you sure you want to delete this user?
                    </div>
                    <div class="modal-body">
                        <p><span class="text-yellow">Warning!: </span> If you delete this account, user will not be able
                            to
                            access this account but it will still be exist in 2Aagain database</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
                        <button type="submit" class="btn btn-green">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="recoverUser" tabindex="-1">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fal ico-cross-circle"></i></button>
                <form action="{{route('admin.manage.users.recover')}}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{$user->id}}">
                    <div class="modal-header">
                        Are you sure you want to recover this user?
                    </div>
                    <div class="modal-body">
                        <p><span class="text-yellow">Warning!: </span> If you recover this account, user will be able to
                            access this account</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
                        <button type="submit" class="btn btn-green">Recover</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editUserAccount" tabindex="-1">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fal ico-cross-circle"></i></button>
                <div class="modal-header">
                    Are you sure you want to Update this user Information?
                </div>
                {{--            <div class="modal-body">--}}
                {{--                <p><span class="text-yellow">Warning!: </span> If you update this account, user will not be able to--}}
                {{--                    access this account but it will still be exist in 2Aagain database</p>--}}
                {{--            </div>--}}
                <div class="modal-footer justify-content-between">
                    <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
                    <a href="#" class="btn btn-green" id="updateUserProfileBtn">Update</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="UnbannUser" tabindex="-1">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fal ico-cross-circle"></i></button>
                <form action="{{route('admin.manage.users.ban')}}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{$user->id}}">
                    <input type="hidden" name="action" value="0">
                    <input type="hidden" name="time" value="0">
                    <div class="modal-header">
                        Are you sure you want to Unban this user?
                    </div>
                    <div class="modal-body">
                        <p><span class="text-yellow">Warning!: </span> If you Unban, user will be able to access this
                            account
                        </p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
                        <button type="submit" class="btn btn-green">Unban</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="PermanentDelete" tabindex="-1">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fal ico-cross-circle"></i></button>
                <div class="modal-header">
                    Are you sure you want to delete this user From database?
                </div>
                <form method="POST" action="{{route('admin.manage.users.delete.profile')}}">
                    @csrf
                    <div class="modal-body">
                        <p><span class="text-yellow">Warning!: </span> This user will be permanently removed from
                            the system</p>
                    </div>
                    <input type="hidden" readonly name="userId" id="userId" value="{{$user->id}}">
                    <div class="modal-footer justify-content-between">
                        <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
                        <input type="submit" class="btn btn-green" value="Delete">
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--    <form id="user_live_profile" method="post" action="{{ route('visitProfile') }}">--}}
    {{--        @csrf--}}
    {{--        <input type="hidden" readonly name="id" value="{{ $user->id }}">--}}
    {{--    </form>--}}
    <div class="modal fade" id="chatMessagesModal" tabindex="-1">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fal ico-cross-circle"></i></button>
                <div class="modal-body">
                    <div class="content">
                        <div class="chat-box" id="chat_box">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var CSRF_TOKEN = $('meta[name="csrf_token"]').attr('content');
        var mediaUrl = '{{env('MEDIA_URL')}}';
        var messageUrl = '{{env('AUDIO_MESSAGE_URL')}}'
        var currentUserId;
        var userId = '{{$user->id}}'
        var messages;
        var messageContent;
        var messageType = 'Text';
        var audioMessage;
        var ConversationsList;
        var ConversationsListShow;
        var ConversationsMessages;
        var connectionId;
        var User;
        var uniqId;
        var attachment;
        var isSeen;
        var messageTime;
        var messageObject;
        // let chunks = [];
        var timeout;
        var lastSeen;
        var current_page = 1;
        var last_page;
        var profile_pic;
        var userName;
        var call_type;

        $(document).ready(function () {

            // $('#loader-show').show();
            ConversationsListShow = '#userMessagesConversations';
            getConversationsList();
            getCallHistory()
        });

        function getConversationsList() {


            $.ajax({
                url: window.location.origin + '/admin/manage/users/chat/conversation/list/' + userId,
                method: 'GET',
                // data:{_token:CSRF_TOKEN,},
                success: function (response) {
                    ConversationsList = response.data.conversations;
                    // $('#loader-show').hide();
                    // console.log(ConversationsList);
                    ShowConversationsList();
                },
                error: function (e) {
                    // $('#loader-show').hide();
                    // toastr.error(e.responseJSON.error['0']);
                }
            })
        }

        function ShowConversationsList() {

            ConversationsList.forEach(UserList);

            function UserList(value, index) {
                if (value.user !== null) {
                    if (value.user.profile_pic !== null) {
                        profile_pic = value.user.profile_pic;
                    } else {
                        profile_pic = '{{env('DEFAULT_USER')}}';
                    }
                    userName = value.user.name + ' ' + value.user.lastname;
                } else {
                    return;
                }
                if (value.message.status === 0) {
                    lastSeen = $('<i/>', {'class': 'fal fa-check mx-1'})
                }
                if (value.message.status === 1) {
                    lastSeen = $('<i/>', {'class': 'fal fa-check-double mx-1'})
                }
                if (value.message.status === 2) {
                    lastSeen = $('<i/>', {'class': 'fal text-blue fa-check-double mx-1'})
                }
                $(ConversationsListShow).append(
                    $('<li/>').append(
                        $('<div/>', {
                            'class': 'user-img',
                            onclick: 'connection(this.id)',
                            id: value.conversation_id
                        }).append(
                            $('<img/>', {
                                src: mediaUrl + profile_pic,
                                'style': 'height:45px; width:200px; object-fit:cover;'
                            }),
                            // $('<span/>', {'class': 'active-status bg-green'})
                        ),
                        $('<div/>', {
                            'class': 'description',
                            onclick: 'connection(this.id)',
                            id: value.conversation_id
                        }).append(
                            $('<div/>', {'class': 'text'}).append(
                                $('<div/>', {'class': 'title'}).append(
                                    $('<a/>',).append(
                                        userName,
                                    )
                                ),
                                $('<p/>', {'class': 'text-gray font-12', id: 'message_' + value.user.id}).append(
                                    value.message.text,
                                )
                            ),
                            $('<div/>', {'class': 'text-right', id: 'status_' + value.user.id}).append(
                                $('<small/>').append(
                                    new Date(value.message.time).toLocaleTimeString([], {
                                        hour: '2-digit',
                                        minute: "2-digit"
                                    }),
                                    lastSeen,
                                ),
                            )
                        )
                    )
                )
            }
        }

        function connection(id) {
            connectionId = id;
            current_page = 1
            $('#chat_box').empty();
            $('#chatMessagesModal').modal('show');
            $('#chatConversation').empty();
            $('#chat_box').append(
                $('<div/>', {'class': 'header-bar align'}).append(
                    $('<div/>', {'class': 'user-profile'}).append(
                        $('<div/>', {'class': 'user-img'}).append(
                            $('<a/>', {id: 'SendUserImg'}).append(
                                {{--$('<img/>', {src: '@if($user) {{env('MEDIA_URL')}}/{{$user->profile_pic ?? env('DEFAULT_USER')}} @endif'}),--}}
                            )
                        ),
                        $('<div/>', {'class': 'overflow-hidden'}).append(
                            $('<div/>', {'class': 'user-title mb-2', id: 'SenderUserName'}).append(
                                {{--'@if($user) {{$user->name}} @endif'--}}
                            ),
                        ),
                    ),
                ),
                $('<div/>', {'class': 'scrollar', id: 'MessagesScrolledTop'}).append(
                    $('<div/>', {'class': 'text-center', id: 'loadMoreMessages'}).append(
                        $('<button/>', {'class': 'btn small', onclick: 'loadMore()'}).append('load more'),
                    ),
                    $('<ul/>', {'class': 'chat-list', id: 'chatConversation'})
                ),
            )
            getConversationMessages();
        }

        function loadMore() {
            current_page++;
            getConversationMessages()
        }

        function getConversationMessages() {
            // $('#loader-show').show();

            $.ajax({
                {{--            url: '{{route('admin.conversation.messages')}}'+'/?'+ current_page,--}}
                url: window.location.origin + '/admin/manage/users/chat/conversation/messages?page=' + current_page,
                method: 'POST',
                data: {_token: CSRF_TOKEN, connection_id: connectionId, sender_id: userId},
                success: function (response) {
                    console.log(response)
                    // $('#loader-show').hide();
                    // console.log('user messages is')
                    ConversationsMessages = response.data.conversation.data;
                    last_page = response.data.conversation.last_page;
                    User = response.data.sender;
                    // console.log(ConversationsMessages);
                    currentUserId = User.id;
                    if (User.profile_pic) {
                        profile_pic = User.profile_pic;
                    } else {
                        profile_pic = '2AgainLogo_1646725849.png';
                    }
                    $('#SendUserImg').empty();
                    $('#SendUserImg').append(
                        $('<img/>', {src: mediaUrl + profile_pic}),
                    );
                    $('#SenderUserName').empty();
                    $('#SenderUserName').append(
                        User.name + ' ' + User.lastname,
                    );
                    if (last_page >= current_page) {
                        if(last_page == current_page){
                            $('#loadMoreMessages').empty();
                            $('#loadMoreMessages').append(
                                $('<button/>', {'class': 'btn small'}).append('no more data')
                            );
                        }
                        ConversationMessagesShow();
                    } else {
                        $('#loadMoreMessages').empty();
                        $('#loadMoreMessages').append(
                            $('<button/>', {'class': 'btn small'}).append('no more data')
                        );
                    }
                },
                error: function (e) {
                    // $('#loader-show').hide();

                    // console.log(e)

                    toastr.error(e.responseJSON.error['0']);
                    // window.location.reload();

                }
            })

        }

        function ConversationMessagesShow() {

            ConversationsMessages.forEach(Messages);

            function Messages(value, index) {

                attachment = value.text
                if (value.attachment !== null) {
                    attachment = $('<audio/>', {'controls': 'controls'}).append(
                        $('<source/>', {src: messageUrl + '/' + value.attachment, type: 'audio/mpeg'})
                    )
                }
                if (value.status === 0) {
                    isSeen = $('<i/>', {'class': 'fal fa-check m-1'})
                }
                if (value.status === 1) {
                    isSeen = $('<i/>', {'class': 'fal fa-check-double m-1'})
                }
                if (value.status === 2) {
                    isSeen = $('<i/>', {'class': 'fal text-blue fa-check-double m-1'})
                }
                if ('{{$user->id}}' === value.send_from) {
                    $('#chatConversation').prepend(
                        $('<li/>', {'class': 'sender'}).append(
                            $('<div/>', {'class': 'message'}).append(
                                attachment,
                                $('<div/>', {'class': 'text-right'}).append(
                                    $('<small/>').append(
                                        new Date(value.created_at).toLocaleTimeString([], {
                                            hour: '2-digit',
                                            minute: "2-digit"
                                        }),
                                    ),
                                    isSeen,
                                )
                            ),
                            // $('<i/>',{'class':'fal fa-clock'}),
                        )
                    )
                } else {

                    $('#chatConversation').prepend(
                        $('<li/>', {'class': 'receiver'}).append(
                            $('<div/>', {'class': 'message'}).append(
                                attachment,
                                $('<div/>', {'class': 'text-right'}).append(
                                    $('<small/>').append(
                                        new Date(value.created_at).toLocaleTimeString([], {
                                            hour: '2-digit',
                                            minute: "2-digit"
                                        }),
                                    ),
                                )
                            ),
                        )
                    )
                }
            }

            $('.scrollar').slimScroll({
                //height: '250px'
                animate: true,
                start: 'bottom'

            });
        }

        function getCallHistory() {
            $.ajax({
                url: window.location.origin + '/admin/manage/users/chat/call/history/' + userId,
                method: 'GET',
                // data:{_token:CSRF_TOKEN,},
                success: function (response) {
                    response.data.forEach(Messages);

                    function Messages(value, index) {
                        if (value.is_outgoing == 1) {
                            if (value.is_picked_up == 1) {
                                callPick = $('<p/>', {'class': 'text-gray font-12'}).append(
                                    $('<i/>', {
                                        'class': 'far fa-long-arrow-up text-green  p-1',
                                        style: 'transform: rotate(45deg);'
                                    }),

                                    new Date(value.created_at).toLocaleTimeString([], {
                                        hour: '2-digit',
                                        minute: "2-digit"
                                    }),
                                    // value.call_time
                                )
                            } else {
                                callPick = $('<p/>', {'class': 'text-gray font-12'}).append(
                                    $('<i/>', {
                                        'class': 'far fa-long-arrow-up text-red p-1',
                                        style: 'transform: rotate(45deg);'
                                    }),

                                    new Date(value.created_at).toLocaleTimeString([], {
                                        hour: '2-digit',
                                        minute: "2-digit"
                                    }),
                                )
                            }

                        } else {
                            if (value.is_picked_up == 1) {
                                callPick = $('<p/>', {'class': 'text-gray font-12'}).append(
                                    $('<i/>', {
                                        'class': 'far fa-long-arrow-down text-green p-1',
                                        style: 'transform: rotate(45deg);'
                                    }),

                                    new Date(value.created_at).toLocaleTimeString([], {
                                        hour: '2-digit',
                                        minute: "2-digit"
                                    }),
                                    // value.call_time
                                )
                            } else {
                                callPick = $('<p/>', {'class': 'text-gray font-12'}).append(
                                    $('<i/>', {
                                        'class': 'far fa-long-arrow-down text-red p-1',
                                        style: 'transform: rotate(45deg);'
                                    }),

                                    new Date(value.created_at).toLocaleTimeString([], {
                                        hour: '2-digit',
                                        minute: "2-digit"
                                    }),
                                )
                            }
                        }
                        if (value.call_type == 'AUDIO') {
                            call_type = $('<div>', {'class': 'info'}).append(
                                $('<a/>', {href: 'javascript:void(0)', 'class': 'btn transparent'}).append(
                                    $('<i/>', {'class': 'fal ico-phone-alt'})
                                )
                            )
                        } else {
                            call_type = $('<div>', {'class': 'info'}).append(
                                $('<a/>', {href: 'javascript:void(0)', 'class': 'btn transparent'}).append(
                                    $('<i/>', {'class': 'fal ico-video-camera-alt'})
                                )
                            )
                        }

                        if (userId === value.call_from) {
                            $('#userCallsHistory').append(
                                $('<li/>').append(
                                    $('<div/>', {'class': 'user-img'}).append(
                                        $('<img/>', {src: mediaUrl + value.receiver.profile_pic}),
                                    ),
                                    $('<div/>', {'class': 'description'}).append(
                                        $('<div/>', {'class': 'text'}).append(
                                            $('<div/>', {'class': 'title'}).append(
                                                $('<a/>', {href: 'javascript:void(0)'}).append(
                                                    value.receiver.name + ' ' + value.receiver.lastname
                                                ),
                                            ),
                                            callPick,
                                        ),
                                        call_type
                                    )
                                )
                            )
                        } else {
                            $('#userCallsHistory').append(
                                $('<li/>').append(
                                    $('<div/>', {'class': 'user-img'}).append(
                                        $('<img/>', {src: mediaUrl + value.caller.profile_pic}),
                                    ),
                                    $('<div/>', {'class': 'description'}).append(
                                        $('<div/>', {'class': 'text'}).append(
                                            $('<div/>', {'class': 'title'}).append(
                                                $('<a/>', {href: 'javascript:void(0)'}).append(
                                                    value.caller.name + ' ' + value.caller.lastname
                                                ),
                                            ),
                                            callPick
                                        ),
                                        call_type
                                    )
                                )
                            )
                        }
                    }
                },
                error: function (e) {
                    // $('#loader-show').hide();
                    toastr.error(e.responseJSON.error['0']);
                }
            })
        }


        // video photos

        window.document.onkeydown = function (e) {
            if (!e) {
                e = event;
            }
            if (e.keyCode == 27) {
                lightbox_close();
            }
        }

        function lightbox_open(src) {

            $('#light').empty();
            $('#light').append(
                $('<a/>', {'class': 'boxclose', id: 'boxclose', onclick: 'lightbox_close()'}),
                $('<video/>', {id: 'VisaChipCardVideo', controls: 'controls'}).append(
                    $('<source>', {src: src, type: 'video/mp4'}),
                )
            )
            var lightBoxVideo = document.getElementById("VisaChipCardVideo");
            window.scrollTo(0, 0);
            document.getElementById('light').style.display = 'block';
            document.getElementById('fade').style.display = 'block';
            lightBoxVideo.play();
        }

        function lightbox_close() {
            var lightBoxVideo = document.getElementById("VisaChipCardVideo");
            document.getElementById('light').style.display = 'none';
            document.getElementById('fade').style.display = 'none';
            lightBoxVideo.empty();

        }

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
