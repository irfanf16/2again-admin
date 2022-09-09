<div class="modal-content">
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
            class="fal ico-cross-circle"></i></button>
    <div class="modal-header">
        Edit Country
    </div>
    <form action="{{ route('admin.countries.update',$country->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
            <div class="row">
                <div class="form-group col-md-12">
                    <label>Enter Name</label>
                    <input type="text" name="name" oninput="this.value = this.value.replace(/[^a-z A-Z ()]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" value="{{$country->name}}" placeholder="Enter Name" required>
                </div>
{{--                <div class="form-group col-md-6">--}}
{{--                    <label>Short Code</label>--}}
{{--                    <input type="text" name="iso2" value="{{$country->iso2}}" class="form-control" placeholder="Enter Short Code"--}}
{{--                           required/>--}}
{{--                </div>--}}
{{--                <div class="form-group col-md-6">--}}
{{--                    <label>Phone Code</label>--}}
{{--                    <input type="text" name="phonecode" value="{{$country->phonecode}}" class="form-control" placeholder="Enter Phone Code"--}}
{{--                           required/>--}}
{{--                </div>--}}
{{--                <div class="form-group col-md-6">--}}
{{--                    <label>Capital</label>--}}
{{--                    <input type="text" name="capital" value="{{$country->capital}}" class="form-control" placeholder="Enter Capital"--}}
{{--                           required/>--}}
{{--                </div>--}}
{{--                <div class="form-group col-md-6">--}}
{{--                    <label>Currency</label>--}}
{{--                    <input type="text" name="currency" value="{{$country->currency}}" class="form-control" placeholder="Enter Currency"--}}
{{--                           required/>--}}
{{--                </div>--}}
{{--                <div class="form-group col-md-6">--}}
{{--                    <label>Region</label>--}}
{{--                    <input type="text" name="region" value="{{$country->region}}" class="form-control" placeholder="Enter Region"--}}
{{--                           required/>--}}
{{--                </div>--}}
            </div>
        </div>
        <div class="modal-footer justify-content-between">
            <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
            <input type="submit" class="btn btn-green" value="Update">
        </div>
    </form>
</div>
