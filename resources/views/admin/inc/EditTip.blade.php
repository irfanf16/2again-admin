<div class="modal-content">
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fal ico-cross-circle"></i> </button>
    <div class="modal-header">
        Edit Tip
    </div>
    <form action="{{ route('admin.safety.update',$tip->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
            <div class="form-group">
                <label>Enter title</label>
                <input type="text" name="title" value="{{$tip->title}}" class="form-control" placeholder="Enter Name" required>
            </div>
            <div class="form-group">
                <label>Enter Tip</label>
                <input type="text" name="tip" value="{{$tip->tip}}" class="form-control" placeholder="Enter Name" required>
            </div>
            <div class="form-group">
                <label>Select Icon (Only PNG)</label>
                <input type="file" name="file" class="form-control" accept="image/png"  />
            </div>
        </div>
        <div class="modal-footer justify-content-between">
            <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
            <input type="submit" class="btn btn-green" value="Update">
        </div>
    </form>
</div>
