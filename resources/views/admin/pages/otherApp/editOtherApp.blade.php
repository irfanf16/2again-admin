@extends('admin.layouts.app')

@section('content')
@section('page_title','Add Other Apps')

<div id="content">
    <div class="container-fluid">
        <section class="section">
            <form action="{{ route('admin.otherApps.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="content-box p-3">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <input type="hidden" value="{{$otherApp->id}}" name="OtherApp">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Name"
                                   value="{{$otherApp->name}}" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Icon</label>
                            <input type="file" name="file" class="form-control"
                                   value="{{$otherApp->icon}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Url Android</label>
                            <input type="text" name="url_android" class="form-control" placeholder="Enter Android Url"
                                   value="{{$otherApp->url_android}}"  required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Url Ios</label>
                            <input type="text" name="url_ios" class="form-control" placeholder="Enter Ios Url"
                                   value="{{$otherApp->url_ios}}" required>
                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Uri Android</label>
                            <input type="text" name="uri_android" class="form-control" placeholder="Enter Android Uri"
                                   value="{{$otherApp->uri_android}}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Uri Ios</label>
                            <input type="text" name="uri_ios" class="form-control" placeholder="Enter Ios Uri"
                                   value="{{$otherApp->uri_ios}}"  required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Bundle Id Android</label>
                            <input type="text" name="bundle_id_android" class="form-control" placeholder="Enter Bundle Id Android"
                                   value="{{$otherApp->bundle_id_android}}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Bundle Id Ios</label>
                            <input type="text" name="bundle_id_ios" class="form-control" placeholder="Enter Bundle Id Ios"
                                   value="{{$otherApp->bundle_id_ios}}"  required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Company</label>
                            <select class="form-select" name="other_app_company_id" id="other_app_company_id">
                                <option value="">Select Company</option>
                                @foreach ($companies as $company)
                                    @if($otherApp->other_app_company_id==$company->id)
                                        <option selected value="{{ $company->id }}">{{ $company->name }}</option>
                                    @else
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>

                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="bigSpender">WorldWide</label>
                            <div class="row">
                                <div class="col-md-12 d-flex ">
                                    <div class="form-check checkbox mx-3">
                                        <input class="form-check-input all_over_world" @if($otherApp->all_over_world==1) checked @endif value="1" name="all_over_world"
                                               type="radio" id="worldwide_yes">
                                        <label class="form-check-label" for="worldwide_yes">
                                            Yes
                                        </label>
                                    </div>
                                    <div class="form-check checkbox mx-3">
                                        <input class="form-check-input all_over_world" @if($otherApp->all_over_world==0) checked @endif value="0"
                                               name="all_over_world" type="radio"
                                               id="worldwide_no">
                                        <label class="form-check-label" for="worldwide_no">
                                            No
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 form-group">
                        <label>Countries</label>
                        <select class="js-example-basic-multiple" name="countries[]" id="multiple" multiple="multiple">
                            <option value="">Select Countries</option>
                            @foreach($otherApp->country as $count)
                                <option selected value="{{ $count->id }}">{{ $count->name }}</option>
                            @endforeach
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="bigSpender">Active </label>
                        <div class="row">
                            <div class="col-md-12 d-flex ">
                                <div class="form-check checkbox mx-3">
                                    <input class="form-check-input" @if($otherApp->is_active==1) checked @endif value="1" name="is_active" type="radio"
                                           id="active">
                                    <label class="form-check-label" for="active">
                                        Yes
                                    </label>
                                </div>
                                <div class="form-check checkbox mx-3">
                                    <input class="form-check-input" @if($otherApp->is_active==0) checked @endif  value="0" name="is_active" type="radio" id="no">
                                    <label class="form-check-label" for="no">
                                        No
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-green text-right">Update</button>
                </div>
            </form>
        </section>
    </div>
</div>


{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#multiple").select2({
            placeholder: "Select Countries",
            allowClear: true
        });
        var worldwide=$('input[name="all_over_world"]:checked').val();
        console.log('worldwide is: '+worldwide)
        if (worldwide == 1) {
            $("#multiple").prop('disabled', true); //disable
        } else {
            $("#multiple").prop('disabled', false); //disable
        }
        $('.all_over_world').on('click', function () {
            var val = $(this).val();

            if (val == 1) {
                $("#multiple").prop('disabled', true); //disable
            } else {
                $("#multiple").prop('disabled', false); //disable
            }
        });

    })
</script>

@endsection
