@extends('admin.layouts.app')

@section('content')
@section('page_title','Other Apps')

    <div id="content">
        <div class="container-fluid">
            <section class="section">
                @can('otherApp-add')
                <div class="mb-3">
                    <a href="{{route('admin.otherApps.add')}}" class="btn"> Add New</a>
                </div>
                @endcan
                <div class="table-responsive">
                    <table class="table yajra-datatable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Icon</th>
                            <th>Name</th>
                            <th>Company Name</th>
                            <th>Downloads</th>
                            <th>Clicks</th>
                            <th>Worldwide</th>
                            <th>Countries</th>
{{--                            <th>Url Android</th>--}}
{{--                            <th>Uri Android</th>--}}
{{--                            <th>Bundle ID Android</th>--}}
{{--                            <th>Url Ios</th>--}}
{{--                            <th>Uri Ios</th>--}}
{{--                            <th>Bundle Ios Android</th>--}}
                            <th>Active</th>
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




    <div class="modal fade" id="EditOtherApp" tabindex="-1">
        <div class="modal-dialog  modal-xl" id="OtherAppModelEdit">

        </div>
    </div>
    <div class="modal fade" id="deleteOtherApp" tabindex="-1">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fal ico-cross-circle"></i></button>
                <div class="modal-header">
                    Are you sure you want to delete this Other App?
                </div>
                <form method="POST" action="{{route('admin.otherApps.delete')}}">
                    @csrf
                    <div class="modal-body">
                        <p><span class="text-yellow">Warning!: </span> This OtherApp will be permanently removed from the
                            system</p>
                    </div>
                    <input type="hidden" name="OtherApp" id="OtherApp" value="">
                    <div class="modal-footer justify-content-between">
                        <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
                        <input type="submit" class="btn btn-green" value="Delete">
                    </div>
                </form>
            </div>
        </div>
    </div>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script type="text/javascript">
        $(function () {
            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.otherApps.list') }}",
                    type: 'GET',
                    data: function (d) {
                        d.Faq_types = $('#Faq_types').val()
                    }
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
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'company',
                        name: 'company',
                    },
                    {
                        data: 'downloads',
                        name: 'downloads',
                    },
                    {
                        data: 'clicks',
                        name: 'clicks',
                    },
                    {
                        data: 'all_over_world',
                        name: 'all_over_world',
                    },
                    {
                        data: 'country',
                        name: 'country',
                    },
                    // {
                    //     data: 'url_android',
                    //     name: 'url android',
                    // },
                    // {
                    //     data: 'uri_android',
                    //     name: 'uri android',
                    // },
                    //
                    // {
                    //     data: 'bundle_id_android',
                    //     name: 'bundle id android',
                    // },
                    // {
                    //     data: 'url_ios',
                    //     name: 'url ios',
                    // },
                    // {
                    //     data: 'uri_ios',
                    //     name: 'uri ios',
                    // },
                    // {
                    //     data: 'bundle_id_ios',
                    //     name: 'bundle id ios',
                    // },


                    {
                        data: 'active',
                        name: 'active',
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
        $(document).ready(function (){
            $("#multiple").select2({
                placeholder: "Select countries",
                allowClear: true
            });

        })

    </script>

@endsection
