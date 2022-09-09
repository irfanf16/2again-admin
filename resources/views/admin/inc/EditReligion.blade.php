<div class="modal-content">
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
            class="fal ico-cross-circle"></i></button>
    <div class="modal-header">
        Edit Religion
    </div>
    <form action="{{ route('admin.religions.update',$religion->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
            <div class="row">
                <div class="form-group col-md-12">
                    <label>Enter Name</label>
                    <input type="text" name="name" oninput="this.value = this.value.replace(/[^a-z A-Z ()]/g, '').replace(/(\..*)\./g, '$1');" value="{{$religion->name}}" class="form-control" placeholder="Enter Name" required>
                </div>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
            <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
            <input type="submit" class="btn btn-green" value="Update">
        </div>
    </form>
</div>
