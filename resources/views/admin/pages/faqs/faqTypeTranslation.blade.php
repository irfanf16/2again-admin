@extends('admin.layouts.app')
@section('content')
@section('page_title','FAQ Type Detail')

<div id="content">
    <div class="container-fluid">
        <section class="section">
            <form @can('faqs-edit') action="{{ route('admin.faqsType.translation.update',$faqtype->id) }}" @endcan method="POST"
                  enctype="multipart/form-data">
                @csrf
                <div class="content-box p-3">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label>English</label>
                            <input type="text" disabled  value="{{$faqtype->name}}"
                                   class="form-control" placeholder="Add name">
                        </div>
                    </div>
                    <div class="text-center">
                        <h3>Other Translations</h3>
                    </div>
                    <div class="row">
                        @foreach($translations as $translate)

                            <div class="col-md-6 form-group">
                                <label>{{$translate->language->name}}</label>
                                <input type="text" hidden name="language_id[]" value="{{$translate->language->id}}"
                                       class="form-control" placeholder="Add first name">
                                <input type="text" name="translation[]" value="{{$translate->translation}}"
                                       class="form-control"
                                       placeholder="Add Translation">
                            </div>
                        @endforeach
                        @foreach($languages as $language)
                            <div class="col-md-6 form-group">
                                <label>{{$language->languages->name}}</label>
                                <input type="text" hidden name="language_id[]" value="{{$language->languages->id}}">
                                <input type="text" name="translation[]" value="" class="form-control"
                                       placeholder="Add Translation">
                            </div>
                        @endforeach
                    </div>
                    @can('faqs-edit')
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                    @endcan

                </div>
            </form>
        </section>
    </div>
</div>


@endsection
