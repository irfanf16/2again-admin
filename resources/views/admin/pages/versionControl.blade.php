@extends('admin.layouts.app')

@section('content')
@section('page_title','App Version Control')

<div id="content">
    <div class="container-fluid">
        <form class="form">
            <ul class="accordion">
                <li class="active">
                    <a href="#" class="opener text-yellow">IOS Version</a>
                    <div class="slide">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>IOS App Version:</label>
                                <input type="text" min="0"
                                     id="AVA_IOS_value1"  name="AVA_IOS" class="form-control"
                                       value="{{ $appSettings['AVA_IOS']->value1 }}">
                            </div>

                            <div class="col-md-6 form-group">
                                <label>Show Update Popup In App</label>
                                <select class="form-select" name="AVA_IOS_status" id="AVA_IOS_value2">
                                    <option @if($appSettings['AVA_IOS']->value2==1) selected @endif value="1">Enable</option>
                                    <option @if($appSettings['AVA_IOS']->value2==0) selected @endif value="0">Disable</option>
                                </select>
                            </div>
                        </div>

                        <div class="text-right">
                            <input type="button" class="btn AVA_IOS" style="border-radius:25px" value="Save">
                        </div>

                    </div>
                </li>
                <li class="">
                    <a href="#" class="opener text-yellow">Android Version</a>
                    <div class="slide">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Android App Version:</label>
                                <input type="text" min="0"
                                    id="AVA_ANDROID_value1"   name="AVA_ANDROID" class="form-control"
                                       value="{{ $appSettings['AVA_ANDROID']->value1 }}">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Show Update Popup In App</label>
                                <select class="form-select" name="AVA_ANDROID_status" id="AVA_ANDROID_value2">
                                    <option @if($appSettings['AVA_ANDROID']->value2==1) selected @endif value="1">Enable</option>
                                    <option @if($appSettings['AVA_ANDROID']->value2==0) selected @endif value="0">Disable</option>
                                </select>
                            </div>
                        </div>

                        <div class="text-right">
                            <input type="button" class="btn AVA_ANDROID" style="border-radius:25px" value="Save">
                        </div>

                    </div>
                </li>
            </ul>
        </form>

    </div>
</div>

@endsection
