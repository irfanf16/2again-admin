@extends('admin.layouts.app')

@section('content')
@section('page_title','Reporting')

        <div id="content">
            <div class="container-fluid">
                <section class="section">
                    <div class="table-responsive">
                        <table class="table yajra-datatable">
                            <thead>
                            <tr>
                                <th>Daily Report Draft</th>
                                <th>IOS</th>
                                <th>Android</th>
                                <th>Web</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody >

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
                  url: "{{ route('admin.badges.list') }}",
                  type: 'GET',
                  data: function (d) {
                      d.Faq_types=$('#Faq_types').val()
                  }
              },
              columns: [
                  {data: 'DT_RowIndex', name: 'DT_RowIndex'},

                  {
                      data: 'image',
                      name: 'name',
                      orderable: true,
                      searchable: true
                  },
                  {
                      data: 'name',
                      name: 'name',
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
@endsection
