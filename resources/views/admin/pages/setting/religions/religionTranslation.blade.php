@extends('admin.layouts.app')
@section('content')
@section('page_title','Religion Detail')

<div id="content">
    <div class="container-fluid">
        <section class="section">
            <form @can('religion-edit') action="{{ route('admin.religions.translation.update',$religion->id) }}" @endcan method="POST"
                  enctype="multipart/form-data">
                @csrf
                <div class="content-box p-3">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label>English</label>
                            <input type="text" disabled  value="{{$religion->name}}"
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
                    @can('religion-edit')
                    <div class="text-right m-1 p-1">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                    @endcan
                </div>
            </form>
        </section>
    </div>
</div>


@endsection
