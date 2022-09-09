@extends('admin.layouts.app')

@section('content')
@section('page_title','Countries')
<div id="content">
    <div class="container-fluid">
        <section class="section">
            @can('country-add')
            <div class="mb-3">
                <a href="#" data-bs-toggle="modal" data-bs-target="#addCountry" class="btn ">Add New</a>
            </div>
            @endcan
            <div class="table-responsive">
                <table class="table yajra-datatable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
{{--                        <th>Short Code</th>--}}
{{--                        <th>Phone Code</th>--}}
{{--                        <th>Capital</th>--}}
{{--                        <th>Currency</th>--}}
{{--                        <th>Region</th>--}}
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>


<div class="modal fade" id="addCountry" tabindex="-1">
    <div class="modal-dialog  modal-sm">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                    class="fal ico-cross-circle"></i></button>
            <div class="modal-header">
                Add New Country
            </div>
            <form action="{{ route('admin.countries.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Enter Name</label>
                            <input type="text" name="name" oninput="this.value = this.value.replace(/[^a-z A-Z ()]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" placeholder="Enter Name" required>
                        </div>
{{--                        <div class="form-group col-md-6">--}}
{{--                            <label>Short Code</label>--}}
{{--                            <input type="text" name="iso2" class="form-control" placeholder="Enter Short Code"--}}
{{--                                   required/>--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-md-6">--}}
{{--                            <label>Phone Code</label>--}}
{{--                            <input type="text" name="phonecode" class="form-control" placeholder="Enter Phone Code"--}}
{{--                                   required/>--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-md-6">--}}
{{--                            <label>Capital</label>--}}
{{--                            <input type="text" name="capital" class="form-control" placeholder="Enter Capital"--}}
{{--                                   required/>--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-md-6">--}}
{{--                            <label>Currency</label>--}}
{{--                            <input type="text" name="currency" class="form-control" placeholder="Enter Currency"--}}
{{--                                   required/>--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-md-6">--}}
{{--                            <label>Region</label>--}}
{{--                            <input type="text" name="region" class="form-control" placeholder="Enter Region"--}}
{{--                                   required/>--}}
{{--                        </div>--}}
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
                    <input type="submit" class="btn btn-green" value="Add">
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editCountryModal" tabindex="-1">
    <div class="modal-dialog  modal-sm" id="editCountry">

    </div>
</div>
<div class="modal fade" id="deleteCountry" tabindex="-1">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fal ico-cross-circle"></i> </button>
            <div class="modal-header">
                Are you sure you want to delete this country.?
            </div>
            <form method="POST" action="{{ route('admin.countries.delete') }}">
                @csrf
                <div class="modal-body">
                    <p><span class="text-yellow">Warning!: </span>If you delete this country, users will be able to see this country in country section</p>
                </div>
                <input type="hidden" name="country" id="country" value="" >
                <div class="modal-footer justify-content-between">
                    <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
                    <input type="submit" class="btn btn-green" value="Delete">
                </div>
            </form>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(function () {

        var table = $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.countries.list') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {
                    data: 'name',
                    name: 'name',
                    orderable: true,
                    searchable: true
                },
                // {
                //     data: 'iso2',
                //     name: 'short code',
                //     orderable: true,
                //     searchable: true
                // },
                // {
                //     data: 'phonecode',
                //     name: 'phone code',
                //     orderable: true,
                //     searchable: true
                // },
                // {
                //     data: 'capital',
                //     name: 'capital',
                //     orderable: true,
                //     searchable: true
                // },
                // {
                //     data: 'currency',
                //     name: 'currency',
                //     orderable: true,
                //     searchable: true
                // },
                // {
                //     data: 'region',
                //     name: 'region',
                //     orderable: true,
                //     searchable: true
                // },
                {
                    data: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: true
                },
            ]
        });

    });
</script>

@endsection
