@extends('admin.layouts.app')
@section('content')
@section('page_title','Offers')
<div id="content">
    <div class="container-fluid">
        <section class="section">
            @can('offers-edit')
                <div class="mb-3">
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#addoffers" class="btn">Add
                        New</a>
                </div>
            @endcan
            <div class="table-responsive">
                <table class="table yajra-datatable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Icon</th>
                        <th>Title</th>
                        <th>Cost (Gold Coins)</th>
                        <th>Start Date & Time</th>
                        <th>End Date & Time</th>
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


<script type="text/javascript">
    $(function () {

        var table = $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.offers.list') }}",

            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {
                    data: 'image',
                    name: 'image',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'title',
                    name: 'title',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'cost',
                    name: 'cost',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'start_date',
                    name: 'start_date',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'valid_till',
                    name: 'valid_till',
                    orderable: true,
                    searchable: true
                },
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
<div class="modal fade" id="addoffers" tabindex="-1">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                    class="fal ico-cross-circle"></i></button>
            <div class="modal-header">
                Add New
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('admin.offers.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Offer Title</label>
                        <input type="text" class="form-control" name="title" id="exampleFormControlInput1"
                               placeholder="Enter offer title" required>
                    </div>
                    <div class="form-group">
                        <label for="cost">Offer Cost (Gold Coins)</label>
                        <input type="number" min="0" class="form-control" name="cost" id="cost"
                               placeholder="Enter offer cost" required>
                    </div>
                    <div class="form-group">
                        <label for="validity">Offer Start Date & Time</label>
                        <input type="datetime-local" class="form-control" name="start_date" id="validity"
                               placeholder="Enter offer start date & time" required>
                    </div>
                    <div class="form-group">
                        <label for="validity">Offer End Date & Time</label>
                        <input type="datetime-local" class="form-control" name="valid_till" id="validity"
                               placeholder="Enter offer end date & time" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Offer Description</label>
                        <textarea class="form-control" style="height: 100px;" name="description"
                                  id="exampleFormControlTextarea1" rows="5" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlFile1">Select Offer Icon</label>
                        <input type="file" class="form-control" name="file" id="exampleFormControlFile1" required>
                    </div>
                    <input type="submit" class="btn" value="Save">
                </form>

            </div>
        </div>
    </div>
</div>

@endsection
