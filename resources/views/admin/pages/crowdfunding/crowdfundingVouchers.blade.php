@extends('admin.layouts.app')

@section('content')
@section('page_title','Crowd Funding Vouchers')

<style>
    .table {
        text-align: center;
    }
</style>
<div id="content">
    <div class="container-fluid">
        <section class="section">
            @can('crowdfunding-add')
            <div class="mb-3">
                <a href="#" data-bs-toggle="modal" data-bs-target="#addCompany" class="btn"> Add New</a>
            </div>
            @endcan
            <div class="content-box p-3">
                <form action="{{route('admin.vouchers.export')}}" method="Post">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>Companies</label>
                            <select class="form-select" name="company_id" id="company_id">
{{--                                <option value="">Select Company</option>--}}
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Subscription Type</label>
                            <select class="form-select" name="subscription_type" id="subscription_type">
                                <option value="">Select subscription Type</option>
                                <option value="vip">VIP</option>
                                <option value="bs">BS</option>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Subscription Month</label>
                            <select class="form-select" name="subscription_month" id="subscription_month">
                                <option value="">Select subscription Month</option>
                                <option value="3">3</option>
                                <option value="6">6</option>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Associate Product Credit </label>
                            <select class="form-select" name="associate" id="associate">
                                <option value="">Select Associate</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Is Used</label>
                            <select class="form-select" name="used" id="used">
                                <option value="">Select Used</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-green">Excel Sheet </button>
                </form>
            </div>
        </section>

        <section class="section">

            <div class="table-responsive">

                <table class="table yajra-datatable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Company</th>
                        <th>Subscription Type</th>
                        <th>Subscription Month</th>
                        <th>Voucher Code</th>
                        <th>Associate Product Credit</th>
                        <th>Is Used</th>
                        @if(request()->user()->can('crowdfunding-delete'))
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
                Add Company Vouchers
            </div>
            <form action="{{ route('admin.vouchers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Companies</label>
                            <select class="form-select" name="company_id" id="country_id">
                                <option value="">Select Company</option>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Subscription Type</label>
                            <select class="form-select" name="subscription_type" id="country_id">
                                <option value="">Select subscription Type</option>
                                    <option value="vip">VIP</option>
                                    <option value="bs">BS</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Subscription Month</label>
                            <select class="form-select" name="subscription_month" id="country_id">
                                <option value="">Select subscription Month</option>
                                <option value="3">3</option>
                                <option value="6">6</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Quantity</label>
                            <input name="quantity"
                                   class="form-control"
                                   oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                   type = "number"
                                   maxlength = "4"
                            />
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="Onlinenow">Associate Product Credit </label>
                            <div class="form-check checkbox">
                                <input class="form-check-input" value="1" name="associate_product_credit" type="checkbox"  id="associate_product_credit">
                                <label class="form-check-label" for="associate_product_credit">
                                    Yes
                                </label>
                            </div>
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

<div class="modal fade" id="deleteCompanyVoucher" tabindex="-1">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                    class="fal ico-cross-circle"></i></button>
            <div class="modal-header">
                Are you sure you want to delete this Company voucher?
            </div>
            <form method="POST" action="{{ route('admin.vouchers.delete') }}">
                @csrf
                <div class="modal-body">
                    <p><span class="text-yellow">Warning!: </span> This Company voucher will be permanently removed from the
                        system</p>
                </div>
                <input type="hidden" name="voucher" id="voucher_id" value="">
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
            responsive      : true,
            dom             : 'Blfrtip',
            autoWidth       : true,
            paging          : true,
            pagingTypeSince : 'numbers',
            pagingType      : 'full_numbers',
            processing      : true,
            serverSide      : true,
            ajax: {
                url: "{{ route('admin.vouchers.list') }}",
                type: 'GET',
                data: function (d) {
                    d.company_id=$('#company_id').val()
                    d.subscription_type=$('#subscription_type').val()
                    d.subscription_month=$('#subscription_month').val()
                    d.associate=$('#associate').val()
                    d.used=$('#used').val()
                }
            },
            columns: [

                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {
                    data: 'company',
                    name: 'company',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'subscription_type',
                    name: 'Subscription_type',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'subscription_month',
                    name: 'subscription_month',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'voucher_code',
                    name: 'voucher_code',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'associate_product_credit',
                    name: 'associate_product_credit',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'used',
                    name: 'used',
                    orderable: true,
                    searchable: true
                },
                    @if(request()->user()->can('crowdfunding-delete'))

                {
                    data: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: true
                },
                @endif
            ],


        });



        $('#company_id').on('change', function () {
            table.draw();
        });
        $('#subscription_type').on('change', function () {
            table.draw();
        });
        $('#subscription_month').on('change', function () {
            table.draw();
        });
        $('#associate').on('change', function () {
            table.draw();
        });
        $('#used').on('change', function () {
            table.draw();
        });
    });
</script>

@endsection
