<div class="modal-content">
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
            class="fal ico-cross-circle"></i></button>
    <div class="modal-header">
        Edit Company
    </div>
    <form action="{{ route('admin.companies.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6 form-group">
                    <input type="hidden" name="companyId" value="{{$company->id}}">
                    <label>Name</label>
                    <input type="text" name="name" value="{{$company->name}}" class="form-control"
                           placeholder="Enter Name" required>
                </div>
                <div class="col-md-6 form-group">
                    <label>Site Url</label>
                    <input type="text" name="site_url" value="{{$company->site_url}}" class="form-control"
                           placeholder="Enter site url"
                           required>
                </div>
                <div class="col-md-6 form-group">
                    <label>Country</label>
                    <select class="form-select" name="country_id" id="country_id">
                        <option value="">Select Country</option>
                        @foreach ($countries as $country)
                            @if($country->id==$company->country_id)
                                <option selected value="{{ $country->id }}">{{ $country->name }}</option
                            @else
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 form-group">
                    <label>Language</label>
                    <select class="form-select" name="language_id" id="language_id">
                        <option value="">Select Language</option>
                        @foreach ($languages as $language)
                            @if($language->id==$company->language_id)
                                <option selected value="{{ $language->id }}">{{ $language->name }}</option>
                            @else
                                <option value="{{ $language->id }}">{{ $language->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 form-group">
                    <label> Audience</label>
                    <input type="text" name="audience" value="{{$company->audience}}" class="form-control"
                           placeholder="Enter  Audience"
                           required>
                </div>
                <div class="col-md-6 form-group">
                    <label> Fee</label>
                    <input type="text" name="fee" value="{{$company->fee}}" class="form-control"
                           placeholder="Enter  Fee" required>
                </div>
            </div>

        </div>
        <div class="modal-footer justify-content-between">
            <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
            <input type="submit" class="btn btn-green" value="Update">
        </div>
    </form>
</div>
