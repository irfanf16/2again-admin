@extends('admin.layouts.app')
@section('content')
@section('page_title','Profile')
<div id="content">
        <div class="container-fluid">
            <section class="section profile-section">
                <div class="content-box">
                    <div class="text-yellow mb-3">Personal Information  (Your Role Is: {{auth()->user()->roles()->first()->name}}) </div>
                    <form class="setting-form"  method="POST" action="{{route('admin.profile.update')}}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-md-6 form-group">
                                <label>First Name</label>
                                <input type="text" name="name" value="{{auth()->user()->name}}" class="form-control"
                                       placeholder="Add first name">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Last Name</label>
                                <input type="text" name="lastname" value="{{auth()->user()->lastname}}" class="form-control"
                                       placeholder="Add last name ">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Email</label>
                                <input type="Email" name="" disabled value="{{auth()->user()->email}}" class="form-control"
                                       placeholder="Add Email">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Gender</label>
                                <select class="form-select" name="gender_id">

                                    <option @if(auth()->user()->gender_id==2) selected @endif value="2">Male</option>
                                    <option @if(auth()->user()->gender_id==3) selected @endif value="3">Female</option>
                                </select>

                            </div>
                            <div class="col-md-6 form-group">
                                <label>Profile Pic</label>
                                <input type="file" class="form-control" name="file" placeholder="add image" >
                            </div>
                        </div>
                        <div class="text-right pt-3">
                            <button class="btn" type="submit" style="min-width: 150px">Save</button>
                        </div>
                    </form>
                </div>
            </section>

        </div>
    </div>
@endsection
