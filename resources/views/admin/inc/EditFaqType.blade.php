<div class="modal-content">
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fal ico-cross-circle"></i> </button>
    <div class="modal-header">
        Edit Faq Type
    </div>
    <form action="{{ route('admin.faqsType.update',$faqType->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="modal-body">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control"  value="{{$faqType->name}}" placeholder="Enter Name" required>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
            <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
            <input type="submit" class="btn btn-green" value="Update">
        </div>
    </form>
</div>
