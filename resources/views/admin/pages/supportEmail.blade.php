@extends('admin.layouts.app')

@section('content')
@section('page_title','Support Email')

        <div id="content">
            <div class="container-fluid">
                <section class="section">
                    <div class="table-responsive">
                        <table class="table yajra-datatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Country</th>
                                <th>Email</th>
                                <th>Message</th>
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
    </div>

    <script type="text/javascript">
        $(function () {

          var table = $('.yajra-datatable').DataTable({
              processing: true,
              serverSide: true,
              ajax: "{{ route('admin.support.list') }}",
              columns: [
                  {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                  {
                      data: 'image',
                      name: 'user',
                      orderable: true,
                      searchable: true
                  },
                  {
                      data: 'country',
                      name: 'country',
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
                      data: 'issue',
                      name: 'issue',
                      orderable: true,
                      searchable: true
                  },
                  {
                      data: 'created_at',
                      name: 'date',
                      orderable: true,
                      searchable: true
                  },

              ]
          });
        });
    </script>
@endsection
