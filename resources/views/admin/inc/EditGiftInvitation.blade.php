<div class="modal-content">
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
            class="fal ico-cross-circle"></i></button>
    <div class="modal-header">
        Edit {{$giftInvitation->type}}
    </div>
    <form action="{{ route('admin.giftInvitation.update',$giftInvitation->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
            <div class="modal-body">
                <div class="form-group">
                    <label>Enter Name</label>
                    <input type="text" name="name" value="{{$giftInvitation->name}}" class="form-control" placeholder="Enter Name" required>
                </div>
                <div class="form-group">
                    <label>Deduct Gold Coins</label>
                    <input type="number" onKeyPress="if(this.value.length==7) return false;" min="0" name="price" value="{{$giftInvitation->price}}" class="form-control" placeholder="Enter Gold Coins" required>
                </div>
                <div class="form-group">
                    <label>Earn Silver Coins</label>
                    <input type="number" onKeyPress="if(this.value.length==7) return false;" min="0" name="silver_coin" value="{{$giftInvitation->silver_coin}}" class="form-control" placeholder="Enter Silver Coins" required>
                </div>
                <div class="form-group">
                    <label>Select Icon</label>
                    <input type="file" id="file" name="file" class="form-control">
                </div>
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
    $('input[type=number]').on('keypress', function (event) {

        var regex = new RegExp("^[0-9]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });
</script>
