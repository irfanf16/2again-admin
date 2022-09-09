<div class="modal-content">
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
            class="fal ico-cross-circle"></i></button>
    <div class="modal-header">
        Edit Company
    </div>
    <form action="{{ route('admin.otherApps.companies.update') }}" method="POST" enctype="multipart/form-data">
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
                    <label>Email</label>
                    <input type="email" name="email" value="{{$company->email}}" class="form-control" placeholder="Enter company email"
                           required>
                </div>
                <div class="col-md-6 form-group">
                    <label>Phone</label>
                    <input type="number" name="phone" value="{{$company->phone}}" class="form-control" placeholder="Enter company contact number"
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
            </div>

        </div>
        <div class="modal-footer justify-content-between">
            <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
            <input type="submit" class="btn btn-green" value="Update">
        </div>
    </form>
</div>
