<div class="modal-content">
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fal ico-cross-circle"></i> </button>
    <div class="modal-header">
        Edit Faq
    </div>
    <form action="{{ route('admin.faqs.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="faq" value="{{$faq->id}}">
        <div class="modal-body">
            <div class=" form-group">
                <label>Faq Types</label>
                <select class="form-select" name="faq_type_id" id="faq_type_id" required>
                    @foreach($faqsTypes as $faqsType)
                        @if($faqsType->id == $faq->faq_type_id)
                        <option selected value="{{$faqsType->id}}">{{$faqsType->name}}</option>
                        @else
                        <option value="{{$faqsType->id}}">{{$faqsType->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Question</label>
                <input type="text" name="question" class="form-control"  value="{{$faq->question}}" placeholder="Enter Question" required>
            </div>
            <div class="form-group">
                <label>Answer</label>
                <textarea  name="answer" class="form-control" placeholder="Enter Answer" required style="height: 100%"> {{$faq->answer}}</textarea>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
            <a href="#" class="btn btn-red" data-bs-dismiss="modal">Cancel</a>
            <input type="submit" class="btn btn-green" value="Update">
        </div>
    </form>
</div>
