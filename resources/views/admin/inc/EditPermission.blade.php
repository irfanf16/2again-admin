<div class="modal-content">
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fal ico-cross-circle"></i> </button>
    <div class="modal-header">
        Edit Permission
    </div>
    <form action="{{ route('admin.permissions.update',$permission->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
            <div class="form-group">
                <label>Name</label>
                <input type="text"  value="{{$permission->name}}"  disabled style="background-color: #9ea7ac!important;"  class="form-control" placeholder="" required>
            </div>
            <div class="form-group">
                <label>Slug</label>
                <input type="text"  value="{{$permission->slug}}"  disabled style="background-color: #9ea7ac!important;"  class="form-control" placeholder="" required>
            </div>
            <div class="form-group">
                <label>Display Name</label>
                <input type="text" name="display_name" value="{{$permission->display_name}}"    class="form-control" placeholder="Enter display Name" required>
            </div>

        </div>
        <div class="modal-footer justify-content-between">
            <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
            <input type="submit" class="btn btn-green" value="Update">
        </div>
    </form>
</div>

