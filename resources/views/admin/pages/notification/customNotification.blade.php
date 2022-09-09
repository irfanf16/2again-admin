@extends('admin.layouts.app')

@section('content')
@section('page_title','Custom Notification')

<div id="content">
    <div class="container-fluid">
        <section class="section">
            @can('send-custom-notification')
            <div class="mb-3">
                <a href="#" data-bs-toggle="modal" data-bs-target="#customNotification" class="btn">Send Notification</a>
            </div>
            @endcan
            <div class="table-responsive">
                <table class="table yajra-datatable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Sent By</th>
                        <th>Title</th>
                        <th>Body</th>
                        <th>Sent To</th>
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



<div class="modal fade" id="customNotification" tabindex="-1">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fal ico-cross-circle"></i> </button>
            <div class="modal-header">
                Send Notification
            </div>
            <form action="{{route('admin.custom.notification.send')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Type</label>
                        <select class="form-select" name="type">
                            <option value="CUSTOM">2Again Notification (To all users)</option>
                            <option value="NewsUpdate">NEWS</option>
                            <option value="Promotions">PROMOTION</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control"  required>
                    </div>
                    <div class="form-group">
                        <label>Short Message (For Locked Screen)</label>
                        <input type="text" name="body" class="form-control"  required>
                    </div>
                    <div class="form-group">
                        <label>Message</label>
                        <textarea name="data" class="form-control"  required
                                  style="height: 100%"></textarea>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
                    <input type="submit" class="btn btn-green" value="Send">
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
            ajax: {
                url: "{{ route('admin.custom.notification.list') }}",
                type: 'GET',
                data: function (d) {
                    d.Faq_types=$('#Faq_types').val()
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},

                {
                    data: 'sent_by_admin',
                    name: 'sent_by_admin',
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
                    data: 'user',
                    name: 'user',
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
