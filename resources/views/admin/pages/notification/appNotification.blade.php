@extends('admin.layouts.app')

@section('content')
@section('page_title','Abusive Notification')

<div id="content">
    <div class="container-fluid">
        <section class="section">
            <div class="table-responsive">
                <table class="table yajra-datatable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Title</th>
                        <th>Body</th>
                        <th>Date</th>
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
                url: "{{ route('admin.custom.notification.app.list') }}",
                type: 'GET',
                data: function (d) {
                    d.Faq_types=$('#Faq_types').val()
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},

                {
                    data: 'user',
                    name: 'user',
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
                    data: 'body',
                    name: 'body',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    orderable: true,
                    searchable: true
                },
            ]
        });
        // $('#Faq_types').on('change', function () {
        //     table.draw();
        // });

    });


</script>

@endsection
