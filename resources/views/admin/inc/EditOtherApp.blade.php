<div class="modal-content">
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
            class="fal ico-cross-circle"></i></button>
    <div class="modal-header">
        Edit Other App
    </div>
    <form action="{{ route('admin.otherApps.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
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
                    <label for="bigSpender">Active </label>
                    <div class="row">

                        <div class="col-md-12 d-flex ">
                            <div class="form-check checkbox mx-3">
                                <input class="form-check-input" @if($otherApp->is_active==1) checked @endif value="1" name="is_active" type="radio" id="edit_active_yes">
                                <label class="form-check-label" for="edit_active_yes">
                                    Yes
                                </label>
                            </div>
                            <div class="form-check checkbox mx-3">
                                <input class="form-check-input" @if($otherApp->is_active==0) checked @endif value="0" name="is_active" type="radio" id="edit_active_no">
                                <label class="form-check-label" for="edit_active_no">
                                    No
                                </label>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
            <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
            <input type="submit" class="btn btn-green" value="Update">
        </div>
    </form>
</div>
