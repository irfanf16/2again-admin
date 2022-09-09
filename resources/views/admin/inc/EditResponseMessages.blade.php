<div class="modal-content">
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
            class="fal ico-cross-circle"></i></button>
    <div class="modal-header">
      Edit Response Message
    </div>
    <form action="{{ route('admin.response.messages.update',$responseMessage->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
            <div class="row">
                <div class="form-group col-md-12">
                    <label>Edit Key</label>
                    <input type="text" disabled style="background-color: #9ea7ac!important;" name="key_string" oninput="this.value = this.value.replace(/[^a-z _  A-Z ()]/g, '').replace(/(\..*)\./g, '$1');" value="{{$responseMessage->key_string}}" class="form-control" placeholder="Enter Name" required>
                </div>
                <div class="form-group col-md-12">
                    <label>Edit Translation</label>
                    <input type="text" name="key_translation"  value="{{$responseMessage->key_translation}}" class="form-control" placeholder="Enter Short Code"
                           required/>
                </div>

            </div>
        </div>
        <div class="modal-footer justify-content-between">
            <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
            <input type="submit" class="btn btn-green" value="Update">
        </div>
    </form>
</div>
