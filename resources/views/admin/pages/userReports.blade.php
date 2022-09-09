@extends('admin.layouts.app')

@section('content')
@section('page_title','Reported Users')

        <div id="content">
            <div class="container-fluid">
                <section class="section">
{{--                    <form class="search-form large mb-5">--}}
{{--                        <div class="form-group">--}}
{{--                            <input type="search" class="form-control" placeholder="Search">--}}
{{--                            <button type="submit" class="btn"><i class="fal ico-search"></i> </button>--}}
{{--                        </div>--}}
{{--                    </form>--}}
                    <div class="table-responsive">
                        <table class="table yajra-datatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Reported User</th>
                                <th>Reason</th>
                                <th>Message</th>
                                <th>Reported Date</th>
                                <th>Reported By</th>
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
              ajax: "{{ route('admin.manage.users.reports.list') }}",
              columns: [
                  {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                  {
                      data: 'reported_user',
                      name: 'reported_user',
                      orderable: true,
                      searchable: true
                  },
                  {
                      data: 'reported_reason',
                      name: 'reported_reason',
                      orderable: true,
                      searchable: true
                  },
                  {
                      data: 'message',
                      name: 'message',
                      orderable: true,
                      searchable: true
                  },
                  {
                      data: 'reported_date',
                      name: 'reported_date',
                      orderable: true,
                      searchable: true
                  },
                  {
                      data: 'reported_by',
                      name: 'reported_by',
                      orderable: true,
                      searchable: true
                  },

              ]
          });

        });
    </script>

@endsection
