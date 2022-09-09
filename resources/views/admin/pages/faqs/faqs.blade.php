@extends('admin.layouts.app')

@section('content')
@section('page_title','FAQs')

        <div id="content">
            <div class="container-fluid">

                <section class="section">
                    @can('faqs-add')
                    <div class="mb-3">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#addFaq" class="btn "> Add New</a>
                    </div>
                    @endcan
                    <div class="content-box p-3">
                        <form>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label>FaqTypes</label>
                                    <select class="form-select" id="Faq_types">
                                        <option value="">All</option>
                                        @foreach ($faqsTypes as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>

                <section class="section">
                    <div class="table-responsive">
                        <table class="table yajra-datatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Faq Type</th>
                                <th>Question</th>
                                <th>Answer</th>
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



    <div class="modal fade" id="addFaq" tabindex="-1">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fal ico-cross-circle"></i> </button>
                <div class="modal-header">
                    Add New Faq
                </div>
            <form action="{{ route('admin.faqs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class=" form-group">
                        <label>Faq Types</label>
                        <select class="form-select" name="faq_type_id" id="faq_type_id" required>
                            <option selected disabled >Select Faq Type</option>
                        @foreach($faqsTypes as $faqsType)
                            <option value="{{$faqsType->id}}">{{$faqsType->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Question</label>
                        <input type="text" name="question" class="form-control" placeholder="Enter Question" required>
                    </div>
                    <div class="form-group">
                        <label>Answer</label>
                        <textarea  name="answer" class="form-control" placeholder="Enter Answer" required style="height: 100%"></textarea>
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
    <div class="modal fade" id="EditFaq" tabindex="-1">
        <div class="modal-dialog  modal-dialog-centered" id="FaqModelEdit">

        </div>
    </div>
    <div class="modal fade" id="deleteFaq" tabindex="-1">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fal ico-cross-circle"></i> </button>
                <div class="modal-header">
                    Are you sure you want to delete this Faq?
                </div>
            <form method="POST" action="{{route('admin.faqs.delete')}}">
                @csrf
                <div class="modal-body">
                    <p><span class="text-yellow">Warning!: </span> This Faq will be permanently removed from the system</p>
                </div>
                <input type="hidden" name="faq" id="faq" value="" >
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
              ajax: {
                  url: "{{ route('admin.faqs.list') }}",
                  type: 'GET',
                  data: function (d) {
                      d.Faq_types=$('#Faq_types').val()
                  }
              },
              columns: [
                  {data: 'DT_RowIndex', name: 'DT_RowIndex'},

                  {
                      data: 'faqType',
                      name: 'faqType',
                      orderable: true,
                      searchable: true
                  },
                  {
                      data: 'question',
                      name: 'question',
                      orderable: true,
                      searchable: true
                  },
                  {
                      data: 'answer',
                      name: 'answer',
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
            $('#Faq_types').on('change', function () {
                table.draw();
            });

        });


    </script>

@endsection
