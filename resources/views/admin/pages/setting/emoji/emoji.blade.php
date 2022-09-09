@extends('admin.layouts.app')

@section('content')
@section('page_title','Daily Mood')


        <div id="content">
            <div class="container-fluid">
                <section class="section">
                    @can('emoji-add')
                    <div class="mb-3">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#addEmoji" class="btn">Add New</a>
                    </div>
                    @endcan
                    <div class="table-responsive">
                        <table class="table yajra-datatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Icon</th>
                                <th>Name</th>
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



    <div class="modal fade" id="addEmoji" tabindex="-1">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fal ico-cross-circle"></i> </button>
                <div class="modal-header">
                    Add New Emoji
                </div>
            <form action="{{ route('admin.emoji.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Enter Name</label>
                        <input type="text" name="name" oninput="this.value = this.value.replace(/[^a-z ()]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" placeholder="Enter Name" required>
                    </div>
                    <div class="form-group">
                        <label>Select Icon (Only PNG)</label>
                        <input type="file" name="file" class="form-control" accept="image/png" required />
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

    <div class="modal fade" id="editEmoji" tabindex="-1">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fal ico-cross-circle"></i> </button>
                <div class="modal-header">
                    Edit Emoji
                </div>
                <form action="{{ route('admin.emoji.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="emoji" id="emojiId" value="" >
                        <div class="form-group">
                            <label>Enter Name</label>
                            <input type="text" name="name" oninput="this.value = this.value.replace(/[^a-z ()]/g, '').replace(/(\..*)\./g, '$1');" id="emojiName" class="form-control" placeholder="Enter Name" required>
                        </div>
                        <div class="form-group">
                            <label>Select Icon (Only PNG)</label>
                            <input type="file" name="file" class="form-control" accept="image/png"  />
                            <img src="" id="emojiIcon" width="100" height="100">
                        </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
                        <input type="submit" class="btn btn-green" value="Update">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteEmoji" tabindex="-1">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fal ico-cross-circle"></i> </button>
                <div class="modal-header">
                    Are you sure you want to delete this Emoji?
                </div>
                <form method="POST" action="{{ route('admin.emoji.destroy') }}">
                    @csrf
                    <div class="modal-body">
                        <p><span class="text-yellow">Warning!: </span>If you delete this Emoji, users will be able to set this emoji</p>
                    </div>
                    <input type="hidden" name="emoji" id="emoji" value="" >
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
              ajax: "{{ route('admin.emoji.list') }}",
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
