@extends('admin.layouts.app')
@section('content')
@section('page_title','Gift Detail')

<div id="content">
    <div class="container-fluid">
        <section class="section">
            <form @can('giftInvitation-edit') action="{{ route('admin.gifts.translation.update',$gift->id) }}" @endcan method="POST"
                  enctype="multipart/form-data">
                @csrf
                <div class="content-box p-3">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label>Gift Name</label>
                            <input type="text" disabled  value="{{$gift->name}}"
                                   class="form-control" placeholder="Add first name">
                        </div>
                    </div>
                    <div class="text-center">
                        <h3>Translations</h3>
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
                    @can('giftInvitation-edit')
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
