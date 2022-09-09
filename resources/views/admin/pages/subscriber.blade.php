@extends('admin.layouts.app')

@section('content')
@section('page_title','Pre-launching Registration')

        <div id="content">
            <div class="container-fluid">
                <section class="section">
                    <div class="table-responsive">
                        <table class="table yajra-datatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Email</th>
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
              ajax: "{{ route('admin.subscribers.list') }}",
              columns: [
                  {data: 'DT_RowIndex', name: 'DT_RowIndex'},

                  {
                      data: 'email',
                      name: 'email',
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
