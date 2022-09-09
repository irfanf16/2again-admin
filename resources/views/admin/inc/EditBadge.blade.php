<div class="modal-content">
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fal ico-cross-circle"></i> </button>
    <div class="modal-header">
        Edit badge
    </div>
    <form action="{{ route('admin.badges.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
            <div class="form-group">
                <input type="hidden" name="badgeId" value="{{$badge->id}}" id="badge">

                <label>Name</label>
                <input type="text" name="name" value="{{$badge->name}}" @if($badge->shortcode !='CUSTOM') disabled style="background-color: #9ea7ac!important;" @endif class="form-control" placeholder="Enter badge name" required>
            </div>
            <div class="form-group">
                <label>Badge Icon</label>
                <input type="file" name="file" class="form-control">
            </div>
        </div>
        <div class="modal-footer justify-content-between">
            <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
            <input type="submit" class="btn btn-green" value="Update">
        </div>
    </form>
</div>
<script>
    $('input[type=file]').on('change', function (event) {

        console.log('file upload');
        const file = this.files[0];
        const  fileType = file['type'];
        const validImageTypes = ['image/png', 'image/jpeg',];
        if (!validImageTypes.includes(fileType)) {
            this.value=''
            toastr.error('Only png/jpeg images are acceptable')
        }
    });
</script>
