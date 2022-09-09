@extends('admin.layouts.app')

@section('content')
@section('page_title','Other App Companies')

<style>
    .table {
        text-align: center;
    }
</style>
<div id="content">
    <div class="container-fluid">

        <section class="section">
            @can('otherApp-add')
            <div class="mb-3">
                <a href="#" data-bs-toggle="modal" data-bs-target="#addCompany" class="btn"> Add New </a>
            </div>
            @endcan
            <div class="table-responsive">
                <table class="table yajra-datatable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Country</th>
                        @if(request()->user()->can('otherApp-edit') || request()->user()->can('otherApp-delete'))
                        <th>Action</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>


<div class="modal fade" id="addCompany" tabindex="-1">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                    class="fal ico-cross-circle"></i></button>
            <div class="modal-header">
                Add Company
            </div>
            <form action="{{ route('admin.otherApps.companies.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter company email"
                                   required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Phone</label>
                            <input type="number" min="0" name="phone" class="form-control" placeholder="Enter company contact number"
                                   required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Country</label>
                            <select class="form-select" name="country_id" id="country_id">
                                <option value="">Select Country</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
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
<div class="modal fade" id="editCompany" tabindex="-1">
    <div class="modal-dialog  modal-lg" id="editCompanyModal">

    </div>
</div>
<div class="modal fade" id="deleteCompany" tabindex="-1">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                    class="fal ico-cross-circle"></i></button>
            <div class="modal-header">
                Are you sure you want to delete this Company?
            </div>
            <form method="POST" action="{{ route('admin.otherApps.companies.delete') }}">
                @csrf
                <div class="modal-body">
                    <p><span class="text-yellow">Warning!: </span> This Company will be permanently removed from the
                        system</p>
                </div>
                <input type="hidden" name="company" id="company_id" value="">
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
            ajax: "{{ route('admin.otherApps.companies.list') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},

                {
                    data: 'name',
                    name: 'name',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'email',
                    name: 'email',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'phone',
                    name: 'phone',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'country',
                    name: 'country',
                    orderable: true,
                    searchable: true
                },
                    @if(request()->user()->can('otherApp-edit') || request()->user()->can('otherApp-delete'))

                {
                    data: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: true
                },
                @endif
            ]
        });

    });
</script>

@endsection
