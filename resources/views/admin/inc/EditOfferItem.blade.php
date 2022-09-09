<div class="modal-content">
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fal ico-cross-circle"></i> </button>
    <div class="modal-header">
        Edit Offer Item
    </div>
    <form action="{{ route('admin.offers.update.item') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="item_id" value="{{$item->id}}">
        <div class="modal-body">
            <div class="form-group">
                <label>Quantity</label>
                <input type="number" min="0" name="quantity" class="form-control"  value="{{$item->quantity}}" placeholder="Enter quantity" required>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
            <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
            <input type="submit" class="btn btn-green" value="Update">
        </div>
    </form>
</div>
